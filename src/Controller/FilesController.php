<?php

namespace GraphicObjectTemplating\Controller;

use GraphicObjectTemplating\OObjects\ODContained\ODDragNDrop;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class FilesController
 * @package Application\Controller
 */
class FilesController extends AbstractActionController
{
    /**
     * @return Response
     * @throws \Exception
     */
    public function filesAction()
    {
        $httpCode = 200;
        /** @var Response $response */
        $response = $this->getResponse();
        /** @var Request $request */
        $request = $this->getRequest();
        $fileName = $this->params()->fromRoute('filename');
        if ($fileName) {
            $id = $request->getQuery('id');
            if ($id) {
                $dragNDrop = ODDragNDrop::buildObject($id, ODDragNDrop::validateSession());
                if ($dragNDrop instanceof ODDragNDrop) {
                    $filesUploaded = $dragNDrop->getLoadedFiles();
                    if (array_key_exists($fileName, $filesUploaded)) {
                        $fileInfo = $filesUploaded[$fileName];
                        $mime = $fileInfo['filetype'];
                        $url = $fileInfo['internalUrl'];
                        $response->getHeaders()
                            ->addHeaderLine('Content-Type', $mime)
                            ->addHeaderLine('X-Accel-Redirect',  $url);
                    } else {
                        $httpCode = 403;
                    }
                } else {
                    $httpCode = 403;
                }
            } else {
                $httpCode = 404;
            }
        } else {
            $httpCode = 404;
        }
        $response->setStatusCode($httpCode);
        return $response;
    }
}