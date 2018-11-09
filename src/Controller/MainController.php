<?php

namespace GraphicObjectTemplating\Controller;

use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer\OSForm;
use GraphicObjectTemplating\Service\ZF3GotServices;

class MainController extends AbstractActionController
{
    const ModeGenHTML   = ['append', 'appendAfter', 'appendBefore', 'update', 'innerUpdate'];
    const ModeExecJS    = ['exec', 'execID', 'redirect'];

    /** @var ServiceManager $serviceManager */
    private $serviceManager;
    /** @var ZF3GotServices $gotServices */
    private $gotServices;

    /** @param ServiceManager $serviceManager */
    public function __construct($serviceManager, $gotServices)
    {
        $this->serviceManager   = $serviceManager;
        $this->gotServices      = $gotServices;
    }
    /* méthode appelé pour l'exécution des demandes Ajax */
    public function gotDispatchAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        /** @var ZF3GotServices $gs */
        $gs      = $this->serviceManager->get('graphic.object.templating.services');

        if ($request->isPost()) { // récupération des paramètres d'appel
            $paramsPost = $request->getPost()->toArray();
            $params     = [];
            foreach ($paramsPost as $cle => $value) {
                // alimentation du tableau $params avec les paramètres d'appel
                $value = $this->trimQuote($value);
                $params[$cle] = $value;
            }

            if (!empty($params['id']) && (null !== $params['id'])) {
                $sessionObj = OObject::validateSession();
                /** @var OObject $callingObj */
                $callingObj = OObject::buildObject($params['id'], $sessionObj);
                $objects    = $sessionObj->objects;

                switch ($callingObj->getObject()) {
                    case 'odcheckbox':
                    case 'odmessage':
                        // appel de la méthode de l'objet passée en paramètre
                        $results = call_user_func_array([$callingObj, 'dispatchEvents'], [$this->serviceManager, $params]);
                        break;
                    default:
                        $event      = $callingObj->getEvent($params['event']);
                        $object     = $this->buildObject($event['class'], $sessionObj);
                        $objMethod  = $event['method'];

                        // traitement en cas de formulaire
                        if (array_key_exists('form', $params) && strlen($params['form']) > 2) {
                            /** reformatage et mise à jour des données du formulaire niveau objets de la page */
                            list($params['form'], $objects) = $this->buildFormDatas($params['form'], $objects);
                            $sessionObj->objects    = $objects;
                        }
                        // appel de la méthode de l'objet passée en paramètre
                        $results = call_user_func_array([$object, $objMethod], [$this->serviceManager, $params]);
                        break;
                }
                $result     = [];
                $rscs       = [];
                $updDatas   = [];
                foreach ($results as $rlst) {
                    $html       = "";
                    switch (true) {
                        case (in_array($rlst['mode'], self::ModeGenHTML)):
                            $html       = !empty($rlst['code']) ? $rlst['code'] : $gs->render($rlst['idSource']);
                            $rscs       = $gs->rscs($rlst['idSource']);
                            break;
                        case (in_array($rlst['mode'], self::ModeExecJS)):
                            $html       = !empty($rlst['code']) ? $rlst['code'] : '';
                            break;
                        default:
                            $html       = !empty($rlst['code']) ? $rlst['code'] : '';
                            break;
                    }
                    $updDatas[]  = ['id'=>$rlst['idCible'], 'mode'=>$rlst['mode'], 'code'=>$html];
                }

                // traitement des ressources pour injection de fichiers sans doublons
                $rscsObjs = [];
                foreach ($rscs as $key => $files) {
                    foreach ($files as $file) {
                        if (!array_key_exists($file, $rscsObjs)) {
                            $rscsObjs[$file] = $key.'|'.$file;
                        }
                    }
                }
                foreach ($rscsObjs as $item) {
/*                    $id  = '';*/
                    $key = substr($item, 0, strpos($item, '|'));
                    $key = substr($key, 0, strpos($key, 'Scripts'));
/*                    if ($key == 'cssScripts') { $id = 'css'; }
                    if ($key == 'jsScripts')  { $id = 'js'; }*/
                    $result[]   = ['id'=>$key, 'mode'=>'rscs', 'code'=>substr($item, strpos($item, '|') + 1)];
                }

                $viewModel = (new ViewModel([ 'content' => [array_merge($result, $updDatas)], ]))
                    ->setTemplate("zf3-graphic-object-templating/main/got-dispatch.twig")
                    ->setTerminal(TRUE);
                return $viewModel;
            }
        }
        return false;
    }


    /**
     * méthodes privées de la classe
     */

    private function buildObject($objClass, $sessionObjects, $params = null) {
        if (NULL === $params) {
            $object = new $objClass();
        } else {
            if (isset($params['obj']) && $params['obj'] == 'OUI') {
                $object = OObject::buildObject($params['id'], $sessionObjects);
            } else {
                $object = new $objClass($params);
            }
        }
        return $object;
    }

    private function buildFormDatas($form, $objects) {
        $datas     = explode('|', $form);
        $formDatas = [];
        foreach ($datas as $data) {
            $data   = explode('§', $data);
            $idF    = '';
            $val    = '';
            foreach ($data as $item) {
                switch (true) {
                    case (strpos($item, 'id=') !== false):
                        $idF = substr($item, 3);
                        break;
                    case (strpos($item, 'value=') !== false):
                        $val = $this->trimQuote(substr($item, 6), '*');
                        break;
                    case (strpos($item, 'object=') !== false):
                        $object = $this->trimQuote(substr($item, 7), '*');
                        break;
                }
            }
            // formatage en sortie en tableau idObj => valeur
            switch ($object) {
                case 'odcheckbox':
                case 'odtreeview':
                    $val = explode('$', $val);
                    if (empty($val)) { $val = []; }
                    if (!is_array($val)) { $val[] = $val; }
                    $formDatas[$idF] = $val;
                    break;
                default:
                    $formDatas[$idF] = $val;
                    break;
            }
            // mise à jour avec la valeur récupérée de chaque objet champ du formulaire
            $objects = $this->updateFieldObject($formDatas, $objects);
        }
        return [$formDatas, $objects];
    }

    private function trimQuote($var, $char = "'") {
        if ($var[0] === $char) { $var = substr($var, 1); }
        if ($var[strlen($var) - 1] === $char) {
            $var = substr($var, 0, - 1);
        }
        return $var;
    }

    private function updateFieldObject(array $datas, array $objects)
    {
        foreach ($datas as $id => $data) {
            if (array_key_exists($id, $objects)) {
                $properties = unserialize($objects[$id]);
                switch ($properties['object']) {
                    case 'odcheckbox':
                        if (empty($data)) {$data = []; }
                        if (!is_array($data)) { $data[] = $data; }
                        $options    = $properties['options'];
                        foreach ($data as $value) {
                            if (array_key_exists($value, $options)) {
                                $options[$value]['check'] = true;
                            }
                        }
                        $properties['options'] = $options;
                        break;
                    case 'odtreeview':
                        $properties['dataSelected'] = $data;
                        break;
                    default:
                        $properties['value'] = $data;
                        break;
                }
                $objects[$id] = serialize($properties);
                return $objects;
            }
        }
    }
}