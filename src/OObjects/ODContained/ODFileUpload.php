<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODFileUpload
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setLocale(string $locale = self::LOCALE_FRANCAIS)
 * getLocale()
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
 * getLoadedFiles()
 * addLoadedFileHDD(string $fileName, string $path)
 * addLoadedFileDB(object $fileObject)
 * setLoadedFiles(array $loadedFiles)
 * setInitialCaption($initialCaption)
 *                          fixe le texte affiché dans la zone label du téléchargement
 * getInitialCaption()
 * showCaption()
 * hideCaption()
 * showDropZone()
 * hideDropZone()
 */
class ODFileUpload extends ODContained
{
    const   LOCALE_FRANCAIS               = 'fr';
    const   LOCALE_ESPANOL                = 'es';
    const   LOCALE_DEUTSCH                = 'de';
    const   LOCALE_ITALIANO               = 'it';

    const   LOCALE_AZERBAYCAN             = 'ar';
    const   LOCALE_BULGARIAN              = 'bg';
    const   LOCALE_CATALA                 = 'ca';
    const   LOCALE_HRVATSKI               = 'cr';
    const   LOCALE_CESKY                  = 'cs';
    const   LOCALE_DANSK                  = 'da';
    const   LOCALE_GREEK                  = 'el';
    const   LOCALE_EESTI                  = 'et';
    const   LOCALE_PERSAN                 = 'fa';
    const   LOCALE_SUOMALAINEN            = 'fi';
    const   LOCALE_GALEGO                 = 'gl';
    const   LOCALE_HEBREW                 = 'he';
    const   LOCALE_MAGYAR                 = 'hu';
    const   LOCALE_INDONESIA              = 'id';
    const   LOCALE_JAPANESE               = 'ja';
    const   LOCALE_GEORGIAN               = 'ka';
    const   LOCALE_KOREAN                 = 'kr';
    const   LOCALE_KAZAKH                 = 'kz';
    const   LOCALE_LIETUVOS               = 'lt';
    const   LOCALE_NEDERLANDS             = 'nl';
    const   LOCALE_NORSK                  = 'no';
    const   LOCALE_POLSKI                 = 'pl';
    const   LOCALE_PORTUGUES              = 'pt';
    const   LOCALE_PORTUGUES_BRASIL       = 'pt-BR';
    const   LOCALE_RONANESC               = 'ro';
    const   LOCALE_RUSSIAN                = 'ru';
    const   LOCALE_SLOVENSKY              = 'sk';
    const   LOCALE_SLOVENSKI              = 'sl';
    const   LOCALE_SVENSKA                = 'sv';
    const   LOCALE_THAI                   = 'th';
    const   LOCALE_TURK                   = 'tr';
    const   LOCALE_UKRAINIAN              = 'uk';
    const   LOCALE_O_ZBEKISTON            = 'uz';
    const   LOCALE_TIENG_VIET             = 'vi';
    const   LOCALE_CHINESE                = 'zh';
    const   LOCALE_CHINESE_TRADITIONAL    = 'zh-TW';

    const   EXT_IMAG_JPG                  = 'jpg';
    const   EXT_IMAG_JPEG                 = 'jpeg';
    const   EXT_IMAG_PNG                  = 'png';
    const   EXT_IMAG_BMP                  = 'bmp';
    const   EXT_IMAG_GIF                  = 'gif';
    const   EXT_IMAG_SVG                  = 'svg';

    const   EXT_WORD_DOC                  = 'doc';
    const   EXT_WORD_DOCX                 = 'docx';
    const   EXT_WORD_ODT                  = 'odt';
    const   EXT_WORD_RTF                  = 'rtf';
    const   EXT_WORD_TXT                  = 'txt';

    const   EXT_EXCL_XLS                  = 'xls';
    const   EXT_EXCL_XLSX                 = 'xlsx';
    const   EXT_EXCL_ODS                  = 'ods';
    const   EXT_EXCL_CSV                  = 'csv';

    const   EXT_PPTS_PPT                  = 'ppt';
    const   EXT_PPTS_PPTX                 = 'pptx';
    const   EXT_PPTS_ODP                  = 'odp';

    const   EXT_SNDS_MP3                  = 'mp3';
    const   EXT_SNDS_WAV                  = 'wav';
    const   EXT_SNDS_OGG                  = 'ogg';

    const   EXT_VDEO_MP4                  = 'mp4';
    const   EXT_VDEO_MKV                  = 'mkv';
    const   EXT_VDEO_OGV                  = 'ogv';

    const   EXT_DOCS_PDF                  = 'pdf';
    const   EXT_DOCS_EPUB                 = 'epub';

    const   EXT_ARCH_GZ                   = 'gz';
    const   EXT_ARCH_ZIP                  = 'zip';
    const   EXT_ARCH_TAR                  = 'tar';

    private $const_locale;
    private $const_allExt;
    private $const_imagExt;
    private $const_wordExt;
    private $const_exclExt;
    private $const_pptsExt;
    private $const_sndsExt;

    /**
     * ODFileUpload constructor.
     * @param $id
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/odfileupload/odfileupload.config.php");
        $this->setDisplay();
    }

    /**
     * @param string $locale
     * @return $this
     * @throws \ReflectionException
     */
    public function setLocale(string $locale = self::LOCALE_FRANCAIS)
    {
        $locales                = $this->getLocaleConstants();
        if (!in_array($locale, $locales)) { $locale = self::LOCALE_FRANCAIS; }

        $properties             = $this->getProperties();
        $oldLocale              = $properties['locale'];
        if ($oldLocale != $locale) {
            $this->removeJsFile($oldLocale.'.js');
            $this->addJsFile($locale.'js', 'js/locale/'.$locale.'.js');
        }
        $properties             = $this->getProperties();
        $properties['locale']   = $locale;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getLocale()
    {
        $properties = $this->getProperties();
        return array_key_exists('locale', $properties) ? $properties['locale'] : false;
    }

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function enaImageFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $imagExts   = $this->getImageExtensionConstant();
        foreach ($imagExts as $imagExt) {
            if (in_array($imagExt, $extString) === false) {
                $extString[] = $imagExt;
            }
        }
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
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $wordExts   = $this->getWordExtensionConstant();
        foreach ($wordExts as $wordExt) {
            if (in_array($wordExt, $extString) === false) {
                $extString[] = $wordExt;
            }
        }
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
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $exclExts   = $this->getExcelExtensionConstant();
        foreach ($exclExts as $exclExt) {
            if (in_array($exclExt, $extString) === false) {
                $extString[] = $exclExt;
            }
        }
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
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $pptsExts   = $this->getPresentationExtensionConstant();
        foreach ($pptsExts as $pptsExt) {
            if (in_array($pptsExt, $extString) === false) {
                $extString[] = $pptsExt;
            }
        }
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
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $sndsExts   = $this->getSoundExtensionConstant();
        foreach ($sndsExts as $sndsExt) {
            if (in_array($sndsExt, $extString) === false) {
                $extString[] = $sndsExt;
            }
        }
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
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $vdeoExts   = $this->getVideoExtensionConstant();
        foreach ($vdeoExts as $vdeoExt) {
            if (in_array($vdeoExt, $extString) === false) {
                $extString[] = $vdeoExt;
            }
        }
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
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $docsExts   = $this->getDocumentExtensionConstant();
        foreach ($docsExts as $docsExt) {
            if (in_array($docsExt, $extString) === false) {
                $extString[] = $docsExt;
            }
        }
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
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $archExts   = $this->getArchiveExtensionConstant();
        foreach ($archExts as $archExt) {
            if (in_array($archExt, $extString) === false) {
                $extString[] = $archExt;
            }
        }
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
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $allExts    = $this->getAllExtensionConstant();
        foreach ($allExts as $allExt) {
            if (in_array($allExt, $extString) === false) {
                $extString[] = $allExt;
            }
        }
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
        $properties['acceptedFiles']    = $arrayFiles;
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
        if (strpos($acceptedFile, '') !== false)            { return false; }
        $allExt                         = $this->getAllExtensionConstant();
        if (!in_array($acceptedFile, $allExt))                      { return false; }
        $properties                     = $this->getProperties();
        if (in_array($acceptedFile, $properties['acceptedFiles']))  { return false; }
        $properties['acceptedFiles'][]  = $acceptedFile;
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
        if (strpos($acceptedFile, '') !== false)    { return false; }
        $allExt                         = $this->getAllExtensionConstant();
        if (!in_array($acceptedFile, $allExt))              { return false; }
        $properties                     = $this->getProperties();
        $acceptedFiles                  = $properties['acceptedFiles'];
        if (!in_array($acceptedFile, $acceptedFiles))       { return false; }
        $key                            = array_search($acceptedFile, $acceptedFiles);
        unset($acceptedFiles[$key]);
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
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
     * @param object $fileObject (instance de classe entité doctrine)
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

    /**
     * @param $initialCaption
     * @return $this
     */
    public function setInitialCaption(string $initialCaption)
    {
        $properties = $this->getProperties();
        $properties['initialCaption'] = $initialCaption;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getInitialCaption()
    {
        $properties = $this->getProperties();
        return array_key_exists('initialCaption', $properties) ? $properties['initialCaption'] : false;
    }

    /**
     * @return $this
     */
    public function showCaption()
    {
        $properties = $this->getProperties();
        $properties['caption'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function hideCaption()
    {
        $properties = $this->getProperties();
        $properties['caption'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function showDropZone()
    {
        $properties = $this->getProperties();
        $properties['dropZone'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function hideDropZone()
    {
        $properties = $this->getProperties();
        $properties['dropZone'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * ***************************************************************************************************
     */

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getLocaleConstants()
    {
        $retour = [];
        if (empty($this->const_locale)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'LOCALE_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_locale = $retour;
        } else {
            $retour = $this->const_locale;
        }
        return $retour;
    }

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
    private function rmAcceptedFiles(array $acceptedFiles, array $exts)
    {
        foreach ($exts as $ext) {
            $key    = array_search($ext, $acceptedFiles);
            if ($key) {
                unset($acceptedFiles[$key]);
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