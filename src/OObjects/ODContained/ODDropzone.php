<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ODDropzone
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setMaxFiles(int $maxFiles)
 * getMaxFiles()
 *
 * enaImageFiles()
 * enaWordFiles()
 * enaExcelFiles()
 * enaPresentationFiles()
 * enaSoundFiles()
 * enaVideoFiles()
 * enaDocumentFiles()
 * enaArchiveFiles()
 * enaAllTypeFiles()
 * setAcceptedFiles(string $acceptedFiles)
 * addAccepetdFile(string $acceptedFile)
 * rmAcceptedFile(string $acceptedFile)
 * disImageFiles()
 * disWordFiles()
 * disExcelFiles()
 * disPresentationFiles()
 * disSoundFiles()
 * disVideoFiles()
 * disDocumentFiles()
 * disArchiveFiles()
 * clearAcceptedFiles()
 *
 * enaView()
 * disView()
 * enaDownload()
 * disDownload()
 * enaRemove()
 * disRemove()
 * evtDropInt($class, $method, $stopEvent = false)
 * evtDropOut($class, $method, $stopEvent = false)
 *
 * setMessage(string $message)
 * getMessage()
 * getLoadedFiles()
 * addLoadedFileHDD(string $fileName, string $path)
 * addLoadedFileDB(object $fileObject)
 * setLoadedFiles(array $loadedFiles)
 */
class ODDropzone extends ODContained
{


    const   EXT_IMAG_JPG    = '.jpg';
    const   EXT_IMAG_JPEG   = '.jpeg';
    const   EXT_IMAG_PNG    = '.png';
    const   EXT_IMAG_BMP    = '.bmp';
    const   EXT_IMAG_GIF    = '.gif';
    const   EXT_IMAG_SVG    = '.svg';

    const   EXT_WORD_DOC    = '.doc';
    const   EXT_WORD_DOCX   = '.docx';
    const   EXT_WORD_ODT    = '.odt';
    const   EXT_WORD_RTF    = '.rtf';
    const   EXT_WORD_TXT    = '.txt';

    const   EXT_EXCL_XLS    = '.xls';
    const   EXT_EXCL_XLSX   = '.xlsx';
    const   EXT_EXCL_ODS    = '.ods';
    const   EXT_EXCL_CSV    = '.csv';

    const   EXT_PPTS_PPT    = '.ppt';
    const   EXT_PPTS_PPTX   = '.pptx';
    const   EXT_PPTS_ODP    = '.odp';

    const   EXT_SNDS_MP3    = '.mp3';
    const   EXT_SNDS_WAV    = '.wav';
    const   EXT_SNDS_OGG    = '.ogg';

    const   EXT_VDEO_MP4    = '.mp4';
    const   EXT_VDEO_MKV    = '.mkv';
    const   EXT_VDEO_OGV    = '.ogv';

    const   EXT_DOCS_PDF    = '.pdf';
    const   EXT_DOCS_EPUB   = '.epub';

    const   EXT_ARCH_GZ     = '.gz';
    const   EXT_ARCH_ZIP    = '.zip';
    const   EXT_ARCH_TAR    = '.tar';

    private $const_allExt;
    private $const_imagExt;
    private $const_wordExt;
    private $const_exclExt;
    private $const_pptsExt;
    private $const_sndsExt;

    /**
     * ODDropzone constructor.
     * @param $id
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/oddropzone/oddropzone.config.php");
        $this->setDisplay();
    }

    /**
     * @param int $maxFiles
     * @return $this|bool
     */
    public function setMaxFiles(int $maxFiles)
    {
        if ($maxFiles > 0) {
            $properties             = $this->getProperties();
            $properties['maxFiles'] = $maxFiles;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getMaxFiles()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['maxFiles'])) ? $properties['maxFiles'] : array());
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaImageFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $imagExts   = $this->getImageExtensionConstant();
        foreach ($imagExts as $imagExt) {
            if (strpos($extString, $imagExt) === false) {
                $extString .= ','.$imagExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaWordFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $wordExts   = $this->getWordExtensionConstant();
        foreach ($wordExts as $wordExt) {
            if (strpos($extString, $wordExt) === false) {
                $extString .= ','.$wordExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaExcelFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $exclExts   = $this->getExcelExtensionConstant();
        foreach ($exclExts as $exclExt) {
            if (strpos($extString, $exclExt) === false) {
                $extString .= ','.$exclExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaPresentationFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $pptsExts   = $this->getPresentationExtensionConstant();
        foreach ($pptsExts as $pptsExt) {
            if (strpos($extString, $pptsExt) === false) {
                $extString .= ','.$pptsExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaSoundFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $sndsExts   = $this->getSoundExtensionConstant();
        foreach ($sndsExts as $sndsExt) {
            if (strpos($extString, $sndsExt) === false) {
                $extString .= ','.$sndsExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaVideoFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $vdeoExts   = $this->getVideoExtensionConstant();
        foreach ($vdeoExts as $vdeoExt) {
            if (strpos($extString, $vdeoExt) === false) {
                $extString .= ','.$vdeoExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaDocumentFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $docsExts   = $this->getDocumentExtensionConstant();
        foreach ($docsExts as $docsExt) {
            if (strpos($extString, $docsExt) === false) {
                $extString .= ','.$docsExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaArchiveFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $archExts   = $this->getArchiveExtensionConstant();
        foreach ($archExts as $archExt) {
            if (strpos($extString, $archExt) === false) {
                $extString .= ','.$archExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaAllTypeFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
        $allExts    = $this->getAllExtensionConstant();
        foreach ($allExts as $allExt) {
            if (strpos($extString, $allExt) === false) {
                $extString .= ','.$allExt;
            }
        }
        $extString                      = substr($extString, 1);
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $acceptedFiles
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function setAcceptedFiles(string $acceptedFiles)
    {
        $allExt                         = $this->getAllExtensionConstant();
        $arrayFiles                     = explode(',', $acceptedFiles);
        foreach ($arrayFiles as $file) {
            if (!in_array($file, $allExt)) { return false; }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $acceptedFile
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function addAccepetdFile(string $acceptedFile)
    {
        if (strpos($acceptedFile, '') !== false)   { return false; }
        $allExt                                            = $this->getAllExtensionConstant();
        if (!in_array($acceptedFile, $allExt))            { return false; }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    .= ((empty($properties['acceptedFiles'])) ? '' : ',') .$acceptedFile;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $acceptedFile
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function rmAcceptedFile(string $acceptedFile)
    {
        if (strpos($acceptedFile, '') !== false)   { return false; }
        $allExt                                            = $this->getAllExtensionConstant();
        if (!in_array($acceptedFile, $allExt))            { return false; }
        $properties                     = $this->getProperties();
        $acceptedFiles                  = $properties['acceptedFiles'];
        $posExt                         = strpos($acceptedFiles, $acceptedFile);
        if ($posExt !== false) {
            $nextExt    = strpos($acceptedFiles, ',', $posExt + 1);
            if ($nextExt) {
                $acceptedFiles = substr($acceptedFiles, 0, $posExt).substr($acceptedFiles, $nextExt + 1);
            } else {
                $acceptedFiles = substr($acceptedFiles, 0, $posExt);
            }
            $properties['acceptedFiles']    = $acceptedFiles;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function disImageFiles()
    {
        $properties     = $this->getProperties();
        $acceptedFiles  = $properties['acceptedFiles'];
        $imagExt        = $this->getImageExtensionConstant();
        $acceptedFiles  = $this->rmAcceptedFiles($acceptedFiles, $imagExt);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function disWordFiles()
    {
        $properties     = $this->getProperties();
        $acceptedFiles  = $properties['acceptedFiles'];
        $wordExt        = $this->getWordExtensionConstant();
        $acceptedFiles  = $this->rmAcceptedFiles($acceptedFiles, $wordExt);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function disExcelFiles()
    {
        $properties     = $this->getProperties();
        $acceptedFiles  = $properties['acceptedFiles'];
        $exclExt        = $this->getExcelExtensionConstant();
        $acceptedFiles  = $this->rmAcceptedFiles($acceptedFiles, $exclExt);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function disPresentationFiles()
    {
        $properties     = $this->getProperties();
        $acceptedFiles  = $properties['acceptedFiles'];
        $pptsExt        = $this->getPresentationExtensionConstant();
        $acceptedFiles  = $this->rmAcceptedFiles($acceptedFiles, $pptsExt);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function disSoundFiles()
    {
        $properties     = $this->getProperties();
        $acceptedFiles  = $properties['acceptedFiles'];
        $sndsExt        = $this->getSoundExtensionConstant();
        $acceptedFiles  = $this->rmAcceptedFiles($acceptedFiles, $sndsExt);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function disVideoFiles()
    {
        $properties     = $this->getProperties();
        $acceptedFiles  = $properties['acceptedFiles'];
        $vdeoExt        = $this->getVideoExtensionConstant();
        $acceptedFiles  = $this->rmAcceptedFiles($acceptedFiles, $vdeoExt);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function disDocumentFiles()
    {
        $properties     = $this->getProperties();
        $acceptedFiles  = $properties['acceptedFiles'];
        $docsExt        = $this->getDocumentExtensionConstant();
        $acceptedFiles  = $this->rmAcceptedFiles($acceptedFiles, $docsExt);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function disArchiveFiles()
    {
        $properties     = $this->getProperties();
        $acceptedFiles  = $properties['acceptedFiles'];
        $archExt        = $this->getArchiveExtensionConstant();
        $acceptedFiles  = $this->rmAcceptedFiles($acceptedFiles, $archExt);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function clearAcceptedFiles()
    {
        $properties     = $this->getProperties();
        $properties['acceptedFiles']    = '';
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return bool|ODDropzone
     */
    public function evtViewClick($class, $method, $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('clickView', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool|ODDropzone
     */
    public function disView()
    {
        return $this->disEvent('clickView');
    }

    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return bool|ODDropzone
     */
    public function evtDownloadClick($class, $method, $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('clickDownload', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool|ODDropzone
     */
    public function disDownload()
    {
        return $this->disEvent('clickDownload');
    }

    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return bool|ODDropzone
     */
    public function evtRemoveClick($class, $method, $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('clickRemove', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool|ODDropzone
     */
    public function disRemove()
    {
        return $this->disEvent('clickRemove');
    }

    /**
     * @param string $message
     * @return $this|bool
     */
    public function setMessage(string $message)
    {
        if (!empty($message)) {
            $properties             = $this->getProperties();
            $properties['message']  = $message;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getMessage()
    {
        $properties = $this->getProperties();
        return array_key_exists('message', $properties) ? $properties['message'] : false;
    }

    /**
     * getLoadedFiles restitue l'attribut loadedFiles (array) contenu dans Properties
     * contenant les fichiers ayant été téléchargés et validés
     * @return array
     */
    public function getLoadedFiles()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['loadedFiles'])) ? $properties['loadedFiles'] : array());
    }

    /**
     * @param string $fileName
     * @param string $path
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function addLoadedFileHDD(string $fileName, string $path)
    {
        $filesPath  = $path.'/'.$fileName;
        if (file_exists($filesPath)) {
            $fileContent    = file_get_contents($filesPath);
            $size           = strlen($fileContent);
            $path_info      = pathinfo($filesPath);
            $name           = $path_info['filename'];
            $ext            = $path_info['extension'];
            $mime           = $this->getMimeString($ext);

            $addFiles       = [
                "name"  => $name,
                "type"  => $mime,
                "size"  => $size,
                "src"   => "file:".$filesPath
            ];
            $properties                     = $this->getProperties();
            $properties['loadedFiles'][]    = $addFiles;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param object $fileObject
     * @return $this
     * @throws \ReflectionException
     */
    public function addLoadedFileDB(object $fileObject)
    {
        if (!empty($fileObject)) {
            $fileContent        = "";
            $name               = "";
            $ext                = "";

            if (method_exists($fileObject, 'getContent')) {
                $fileContent    = $fileObject->getContent();
            }
            if (method_exists($fileObject, 'getName')) {
                $name           = $fileObject->getName();
            }
            if (method_exists($fileObject, 'getExtension')) {
                $ext            = $fileObject->getExtension();
            }
            if (!empty($fileContent) && !empty($name) && !empty($ext)) {
                $size           = strlen($fileContent);
                $mime           = $this->getMimeString($ext);

                $addFiles       = [
                    "name"  => $name,
                    "type"  => $mime,
                    "size"  => $size,
                    "src"   => "db:id=".$fileObject->getId(),
                ];
                $properties                     = $this->getProperties();
                $properties['loadedFiles'][]    = $addFiles;
                $this->setProperties($properties);
                return $this;
            }
        }
    }

    /**
     * @param array $loadedFiles
     * @return $this
     */
    public function setLoadedFiles(array $loadedFiles)
    {
        $properties                 = $this->getProperties();
        $properties['loadedFiles']  = $loadedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    public function dispatchEvents(ServiceManager $sm, $params)
    {
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * ***************************************************************************************************/

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getAllExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_allExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_allExt = $retour;
        } else {
            $retour = $this->const_allExt;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getImageExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_imagExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_IMAG');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_imagExt = $retour;
        } else {
            $retour = $this->const_imagExt;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getWordExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_wordExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_WORD');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_wordExt = $retour;
        } else {
            $retour = $this->const_wordExt;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getExcelExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_exclExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_EXCL');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_exclExt = $retour;
        } else {
            $retour = $this->const_exclExt;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getPresentationExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_pptsExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_PPTS');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_pptsExt = $retour;
        } else {
            $retour = $this->const_pptsExt;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getSoundExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_sndsExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_SNDS');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_sndsExt = $retour;
        } else {
            $retour = $this->const_sndsExt;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getVideoExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_vdeoExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_VDEO');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_vdeoExt = $retour;
        } else {
            $retour = $this->const_vdeoExt;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getDocumentExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_docsExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_DOCS');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_docsExt = $retour;
        } else {
            $retour = $this->const_docsExt;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getArchiveExtensionConstant()
    {
        $retour = [];
        if (empty($this->const_archExt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_ARCH');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_archExt = $retour;
        } else {
            $retour = $this->const_archExt;
        }
        return $retour;
    }

    /**
     * @param string $acceptedFiles
     * @param array $exts
     * @return bool|string
     */
    private function rmAcceptedFiles(string $acceptedFiles, array $exts)
    {
        foreach ($exts as $ext) {
            $posExt                         = strpos($acceptedFiles, $ext);
            if ($posExt !== false) {
                $nextExt    = strpos($acceptedFiles, ',', $posExt + 1);
                if ($nextExt) {
                    $acceptedFiles = substr($acceptedFiles, 0, $posExt).substr($acceptedFiles, $nextExt + 1);
                } else {
                    $acceptedFiles = substr($acceptedFiles, 0, $posExt);
                }
            }
        }
        return $acceptedFiles;
    }

    /**
     * @param $ext
     * @return bool
     * @throws \ReflectionException
     */
    private function getMimeString($ext)
    {
        $key            = "";
        $extConstants   = $this->getAllExtensionConstant();
        foreach ($extConstants as $extKey => $extConstant) {
            if ($ext == $extConstant) {
                $key = $extKey;
                break;
            }
        }
        if (!empty($key)) {
            switch (true) {
                // gestion des images
                case ($ext == self::EXT_IMAG_SVG):
                    $mime   = "image/svg+xml";
                    break;
                case (strpos($key, 'IMAG') !== false) :
                    $mime   = "image/".substr($ext, 1);
                    break;
                // gestion des textes
                case ($ext == self::EXT_WORD_TXT):
                    $mime   = "text/plain";
                    break;
                case ($ext == self::EXT_WORD_DOC):
                    $mime   = "application/msword";
                    break;
                case ($ext == self::EXT_WORD_DOCX):
                    $mime   = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
                    break;
                case ($ext == self::EXT_WORD_RTF):
                    $mime   = "application/rtf";
                    break;
                case ($ext == self::EXT_WORD_ODT):
                    $mime   = "application/vnd.oasis.opendocument.text";
                    break;
                // gestion des feuilles de calculs
                case ($ext == self::EXT_EXCL_XLS):
                    $mime   = "application/vnd.ms-excel";
                    break;
                case ($ext == self::EXT_EXCL_XLSX):
                    $mime   = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
                    break;
                case ($ext == self::EXT_EXCL_ODS):
                    $mime   = "application/vnd.oasis.opendocument.spreadsheet";
                    break;
                case ($ext == self::EXT_EXCL_CSV):
                    $mime   = "text/csv";
                    break;
                // gestion des présentations
                case ($ext == self::EXT_PPTS_PPT):
                    $mime   = "application/vnd.ms-powerpoint";
                    break;
                case ($ext == self::EXT_PPTS_PPTX):
                    $mime   = "application/vnd.openxmlformats-officedocument.presentationml.presentation";
                    break;
                case ($ext == self::EXT_PPTS_ODP):
                    $mime   = "application/vnd.oasis.opendocument.presentation";
                    break;
                // gestion des sons
                case ($ext == self::EXT_SNDS_MP3):
                    $mime   = "audio/mpeg";
                    break;
                case ($ext == self::EXT_SNDS_OGG):
                    $mime   = "audio/ogg";
                    break;
                case ($ext == self::EXT_SNDS_WAV):
                    $mime   = "audio/x-wav";
                    break;
                // gestion des vidéos
                case ($ext == self::EXT_VDEO_MP4):
                    $mime   = "video/mp4";
                    break;
                case ($ext == self::EXT_VDEO_MKV):
                    $mime   = "video/x-matroska";
                    break;
                case ($ext == self::EXT_VDEO_OGV):
                    $mime   = "video/ogg";
                    break;
                // gestion des documents
                case ($ext == self::EXT_DOCS_PDF):
                    $mime   = "application/pdf";
                    break;
                case ($ext == self::EXT_DOCS_EPUB):
                    $mime   = "application/epub+zip";
                    break;
                // gestion des archives
                case ($ext == self::EXT_ARCH_ZIP):
                    $mime   = "application/zip";
                    break;
                case ($ext == self::EXT_ARCH_TAR):
                    $mime   = "application/x-tar";
                    break;
                case ($ext == self::EXT_ARCH_GZ):
                    $mime   = "application/octet-stream";
                    break;
            }
            return $mime;
        }
        return false;
    }
}