<?php

namespace GraphicObjectTemplating\Controller;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\ODContained\ODDragNDrop;
use GraphicObjectTemplating\OObjects\OSContainer\OSForm;
use Zend\Http\Headers;
use Zend\Http\Request;
use Zend\Http\Response\Stream;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\Service\ZF3GotServices;

class MainController extends AbstractActionController
{
    const ModeGenHTML   = ['append', 'appendAfter', 'appendBefore', 'update', 'innerUpdate'];
    const ModeExecJS    = ['exec', 'execID', 'redirect'];

    /** @var ServiceManager $serviceManager */
    private $serviceManager;
    /** @var ZF3GotServices $gotServices */
    private $gotServices;

    /**
     * @param ServiceManager $serviceManager
     * @param ZF3GotServices $gotServices
     */
    public function __construct($serviceManager, $gotServices)
    {
        $this->serviceManager   = $serviceManager;
        $this->gotServices      = $gotServices;
    }

    /* méthode appelé pour l'exécution des demandes Ajax */
    /**
     * @return bool|ViewModel
     * @throws \Exception
     */
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
                $resources  = $sessionObj->resources;

                if (!$callingObj) {
                    // si retour false de la création d'objet => redirection sur la route home de l'application
                    $results = [OObject::formatRetour($params['id'], $params['id'], 'redirect', '/')];
                } else {
                    if ($callingObj->getProperty('dispatchEvents')) {
                        $results = call_user_func_array([$callingObj, 'dispatchEvents'], [$this->serviceManager, $params]);
                    } else {
                        if (method_exists($callingObj, 'dispatchEvents')) {
                            $results = call_user_func_array([$callingObj, 'dispatchEvents'], [$this->serviceManager, $params]);
                        } else {
                            $event      = $callingObj->getEvent($params['event']);
                            if ($event['class'] != $callingObj->getClassName()) {
                                $object     = $this->buildObject($event['class'], $sessionObj);
                            } else {
                                $object     = $callingObj;
                            }
                            $objMethod  = $event['method'];
    
                            // traitement en cas de formulaire
                            if (array_key_exists('form', $params) && strlen($params['form']) > 2) {
                                /** reformatage et mise à jour des données du formulaire niveau objets de la page */
                                list($params['form'], $objects) = $this->buildFormDatas($params['form'], $objects);
        
                                if ($callingObj instanceof ODContained && !empty($callingObj->getForm())) {
                                    /** @var OSForm $form */
                                    $form           =  OObject::buildObject($callingObj->getForm(), $sessionObj);
                                    $hiddens        = $form->getHiddenValues();
                                    $params['form'] = array_merge($params['form'], $hiddens);
                                }
        
                                $sessionObj->objects    = $objects;
                            }
                            // appel de la méthode de l'objet passée en paramètre
                            $results = call_user_func_array([$object, $objMethod], [$this->serviceManager, $params]);
                        }

                    }
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
                $updDatas[] = ['id'=>'', 'mode'=>'execID', 'code'=>'layoutScripts'];

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
//                    $key = substr($key, 0, strpos($key, 'Scripts'));
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
     * @return Stream
     * @throws \Exception
     */
    public function gotDownloadAction()
    {
        $sessionObjects = OObject::validateSession();
        $idDND          = (int)$this->params()->fromRoute('idDND', 0);
        $LoadedFileID   = (int)$this->params()->fromRoute('loadedFileID', 0);

        /** @var ODDragNDrop $objet */
        $objet          = $this->buildObject($idDND, $sessionObjects);
        $loadedFiles    = $objet->getLoadedFiles();

        $file           = $loadedFiles[$LoadedFileID]['pathFile'];
        $response       = new Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers        = new Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file),
            'Expires' => '@0', // @0, because zf2 parses date as string to \DateTime() object
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;
    }


    /**
     * méthodes privées de la classe
     */

    /**
     * méthode de création d'objet
     *
     * @param $objClass         nom de classe de l'objet à créer si $params vide
     * @param $sessionObjects   Objet Session contenant la déclarations des objets en cours de validité
     * @param null $params      tableau des paramétres pour créatiion de l'objet à travailler
     * @return mixed            un objet de type ZF3GraphicObjectTemplating ou à partir de $objClass
     * @throws \Exception
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

    /**
     * méthode de création et formatage du tableau des valeurs des champs d'un formulaire
     *
     * @param $form     chaîne de caractères transmise lors de l'appel Ajax des champs/valeurs du fortmulaire
     * @param $objects  tableau des déclaration des objets valides en sessions
     * @return array    tableau formé par :
     *                      le tableau des champs (clé d'accès) et valeurs du formulaire retravaillés
     *                      le tableau des déclarations des objets valides en session mis à jours avec les traitements
     */
    private function buildFormDatas($form, $objects) {
        $datas     = explode('|', $form);
        $formDatas = [];
        foreach ($datas as $data) {
            $data   = explode('§', $data);
            $idF    = '';
            $val    = '';
            $object = '';
            $files  = '';
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
                    case (strpos($item, 'files=') !== false):
                        $files  = $this->trimQuote(substr($item, 7), '*');
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
                case 'oddragndrop':
                    $formDatas[$idF] = $files;
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

    /**
     * méthode visant à supprimer les simple apostrophes (quote) dans une chaîne de caractères
     * placés au débuit et à la fin
     *
     * @param $var
     * @param string $char
     * @return bool|string
     */
    private function trimQuote($var, $char = "'") {
        if ($var[0] === $char) { $var = substr($var, 1); }
        if ($var[strlen($var) - 1] === $char) {
            $var = substr($var, 0, - 1);
        }
        return $var;
    }

    /**
     * méthode de mise à jour des définitions des champs valides en session avec les valeurs transmises dans la zone de
     * communication de l'appel Ajax pour validation du formulaire
     *
     * @param array $datas      tableau des champs/valeurs retravaillées du formulaire
     * @param array $objects    tableau des déclaration des objets valides en sessions
     * @return array            tableau des déclaration des objets valides en sessions MIS À JOUR
     */
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
