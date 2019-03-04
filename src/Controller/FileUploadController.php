<?php

namespace GraphicObjectTemplating\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FileUploadController extends AbstractActionController
{

    /**
     * @return false|string|ViewModel
     */
//    public function indexAction()
//    {
//        $ds          = DIRECTORY_SEPARATOR;
//        $storeFolder = 'uploads';
//
//        if (!empty($_FILES)) {
//            $tempFile = $_FILES['file']['tmp_name'];
//            $targetPath = __DIR__ . '/../../../../public' . $ds. $storeFolder . $ds;
//            $targetFile =  $targetPath. $_FILES['file']['name'];
//            move_uploaded_file($tempFile,$targetFile);
//        } else {
//            $result  = array();
//
//            $files = scandir($storeFolder);
//            if ( false!==$files ) {
//                foreach ( $files as $file ) {
//                    if ( '.'!=$file && '..'!=$file) {
//                        $obj['name'] = $file;
//                        $obj['size'] = filesize($storeFolder.$ds.$file);
//                        $result[] = $obj;
//                    }
//                }
//            }
//
//            header('Content-type: text/json');
//            header('Content-type: application/json');
//            return json_encode($result);
//        }
//
//        $view   = new ViewModel();
//        $view->setTemplate('zf3-graphic-object-templating/dropzone/index.twig');
//
//        return $view;
//    }

    public function viewAction()
    {

    }

    public function downloadAction()
    {

    }
}