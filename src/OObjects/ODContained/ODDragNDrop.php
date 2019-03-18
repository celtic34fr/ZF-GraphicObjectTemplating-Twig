<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Exception;
use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\Service\ZF3GotServices;
use phpDocumentor\Reflection\Types\Self_;
use ReflectionClass;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ODDragNDrop
 * @package Application\OEObjects\ODContained
 *
 * setMaxFileCount(int $maxFileCount)       : fixe le nombre maximal de fichiers à télécharger
 * getMaxFileCount()                        : restitue le nombre maximum de fichiers à télécharger
 * disMaxFileCount()                        : supprime toute limite de nombre de fichiers à télécharger
 * setMinFileSize(int $minFileSize)         : fixe la taille minimale des fichiers à télécharger
 * getMinFileSize()                         : restitue la taille minimale des fichiers à télécharger
 * disMinFileSize()                         : supprime toute limite de taille minimale des fichiers à télécharger
 * setMaxFileSize(int $maxFileSize)         : fixe la taille maximale des fichiers à télécharger
 * getMaxFileSize()                         : restitue la taille maximale des fichiers à télécharger
 * disMaxFileSize()                         : supprime tout limite de taille maximale des fichiers à télécharger
 * setMessage(string $message)              : fixe le texte à afficher, dans la zone du Glisser/Déposer
 * getMessage()                             : restitue le texte à afficher, dans la zone du Glisser/Déposer
 * enaImageFiles()                          : autorise les fichiers image au téléchargement
 * enaWordFiles()                           : autorise les fichiers texte au téléchargement
 * enaExcelFiles()                          : autorise les feuilles de calcul au téléchargement
 * enaPresentationFiles()                   : autorise les fichiers diaporama au téléchargement
 * enaSoundFiles()                          : autorise les fichiers son au téléchargement
 * enaVideoFiles()                          : autorise les fichiers vidéo au téléchargement
 * enaDocumentFiles()                       : autorise les fichiier Document au téléchargement
 * enaArchiveFiles()                        : autorise les fichiers archive compressée au téléchargement
 * enaAllTypeFiles()                        : autorise tout type de fichiers (relativement aux extensions paramétrées)
 * setAcceptedFiles(string $acceptedFiles)  : fixe avec le tableau $acceptedFiles les fichiers téléchargeables
 * addAccepetdFile(string $acceptedFile)    : ajoute une extension $acceptedFile à la liste des fichiers téléchageables
 * rmAcceptedFile(string $acceptedFile)     : supprime une extension $acceptedFile de la liste des fichiers autorisés
 * disImageFiles()                          : interdit les fichiers image au téléchargement
 * disWordFiles()                           : interdit les fichiers texte au téléchargement
 * disExcelFiles()                          : interdit les feuilles de calcul au téléchargement
 * disPresentationFiles()                   : interdit les fichiers diaporama au téléchargement
 * disSoundFiles()                          : interdit les fichiers son au téléchargement
 * disVideoFiles()                          : interdit les fichiers vidéo au téléchargement
 * disDocumentFiles()                       : interidt les fichiers Document au téléchargement
 * disArchiveFiles()                        : interdit les fichiers archive compressée au téléchargement
 * clearAcceptedFiles()                     : supprime tout paramétrage de fichiers autorisés au téléchargement
 *                                              autorise de fait le téléchargement de n'importe quel fichier
 * setLineHeightDND(int $lineHeight, string $unit = 'px')
 *                                          : fixe la hauteur de ligne et indirectyement la hauteur de la zone
 *                                              glisser-déposer
 * getLineHeightDND()                       : restitue la hauteur de ligne dans la zone de glisser-déposer
 * setHeightDND(int $heightDND, string $unit = 'px')
 *                                          : fixe la hauteur de la zone de glisser-déposer et indirectement la hateur
 *                                              de ligne
 * getHeightDND()                           : restitue la hateur de la zone de glisser-déposer
 * setTempFolder(string $tempFolder)        : affecte après vérification le chemin $tempFolder comme répertoire de
 *                                              sauvegarde temporaire (de travail) des fichiers téléchargés
 * getTempFolder()                          : restitue le chemin du répertoire de sauvegarde temporaire des fichiers
 * addLoadedFile(string $name, string $pathFile)
 *                                          : ajoute un fichier stocké sur disque à la liste des fichiers chargés
 * rmLoadedFile(string $name)               : supprime un fichier stocké sur disque de la liste des fichiers chargés
 * setLoadedFile(string $name, string $pathFile)
 *                                          : réaffecte au fichier de nom $name dans la liste des fichiers chargés le
 *                                              le chemin $pathFile
 * getLoadedFile(string $name)              : restitue le chemin physique d'accès au fichier de nom $name dans la liste
 *                                              des fichiers chargés
 * setLoadedFiles(array loadedFiles)        : affecte le contenu du tableau $loadedFiles à la liste des fichiers chargés
 * getLoadedFiles()                         : restitue le tableau des fichiers chargés
 * setThumbWidth(int $thumbWidth)           : fixe la largeur de la miniature à créer pour le fichier téléchargé, si 0 :
 *                                              pas pris en compte dans la création de la miniature
 * getThumbWidth()                          : restitue la largeur de la miniature à créer pour le fichier téléchargé
 * setThumbHeight(int $thumbHeight)         : fixe la hauteur de la miniature à créer pour le fichier téléchargé, si 0 :
 *                                              pas pris en comptes dans la création de la miniature
 * getThumbHeight()                         : restitue la hauteur de la miniature à créer pour le fichier téléchargé
 * enaThumbView()                           : active la présentation d'une icône pour délencher la vue du fichier dans
 *                                              un autre onglet
 * disThumbView()                           : désactive la présentation d'une icône pour délencher la vue du fichier
 *                                              dans un autre onglet
 * enaThumbDload()                          : active la présentation d'une icône pour délencher le téléchargement du
 *                                              fichier
 * disThumbDload()                          : désactive la présentation d'une icône pour délencher le téléchargement du
 *                                              fichier
 * enaThumbRmove()                          : active la présentation d'une icône pour délencher la suppression du
 *                                              fichier des fichiers téléchargés
 * disThumbRmove()                          : désactive la présentation d'une icône pour délencher la suppression du
 *                                              fichier des fichiers téléchargés
 * enaThumbFileName()                       : déclenche l'affichage du nom de fichier sous sa miniature
 * disThumbFileName()                       : interdit l'affichage du nom de fichier sous sa miniature
 *
 * méthodes de gestion de retour de callback
 * -----------------------------------------
 * dispatchEvents(ServiceManager $sm, $params)
 *                                          : méthode permettant la distribution des évènement gérés par l'objet
 * evtAddFile(ServiceManager $sm, array $params)
 *                                          : méthode traitant l'évènement de l'ajout d'un fichier à la lise des
 *                                              fichiers chargés (avec les différents impacts sur l'objet)
 * evtRmFile(ServiceManager $sm, array $params)
 *                                          : méthode traitant de la suppression d'un fichier à la liste des fichiers
 *                                              chargés (avec les différents impacts sur l'objet)
 * returnSetData()                          : alimentation pour retour de callbacjk visant à réaffecter le contenu de
 *                                              l'objet
 *
 * méthodes privées de la classe
 * ------------------------------
 * getAllExtensionConstant()                : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier autorisées au téléchargement
 * getImageExtensionConstant()              : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier image autorisées au téléchargement
 * getWordExtensionConstant()               : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier texte autorisées au téléchargement
 * getExcelExtensionConstant()              : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier feuilles de calcul autorisées au téléchargement
 * getPresentationExtensionConstant()       : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier diaporama autorisées au téléchargement
 * getSoundExtensionConstant()              : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier son autorisées au téléchargement
 * getVideoExtensionConstant()              : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier vidéo autorisées au téléchargement
 * getDocumentExtensionConstant()           : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier Document autorisées au téléchargement
 * getArchiveExtensionConstant()            : récupération de l'ensemble des constantes de définition des extensions de
 *                                              fichier archive compressée autorisées au téléchargement
 * rmAcceptedFiles(array $acceptedFiles, array $exts)
 *                                          : suppression dans la liste des extensions autorisées $acceptedFiles des
 *                                              extensions listées dans le tableau $exts
 * getMimeString($ext)                      : restitue la chaîne de caractère nature de fichier MIME en fonction de
 *                                              l'extension $ext fournie
 */
class ODDragNDrop extends ODContained
{

    const   EXT_IMAG_JPG    = 'jpg';
    const   EXT_IMAG_JPEG   = 'jpeg';
    const   EXT_IMAG_PNG    = 'png';
    const   EXT_IMAG_BMP    = 'bmp';
    const   EXT_IMAG_GIF    = 'gif';
    const   EXT_IMAG_SVG    = 'svg';

    const   EXT_WORD_DOC    = 'doc';
    const   EXT_WORD_DOCX   = 'docx';
    const   EXT_WORD_ODT    = 'odt';
    const   EXT_WORD_RTF    = 'rtf';
    const   EXT_WORD_TXT    = 'txt';

    const   EXT_EXCL_XLS    = 'xls';
    const   EXT_EXCL_XLSX   = 'xlsx';
    const   EXT_EXCL_ODS    = 'ods';
    const   EXT_EXCL_CSV    = 'csv';

    const   EXT_PPTS_PPT    = 'ppt';
    const   EXT_PPTS_PPTX   = 'pptx';
    const   EXT_PPTS_ODP    = 'odp';

    const   EXT_SNDS_MP3    = 'mp3';
    const   EXT_SNDS_WAV    = 'wav';
    const   EXT_SNDS_OGG    = 'ogg';

    const   EXT_VDEO_MP4    = 'mp4';
    const   EXT_VDEO_MKV    = 'mkv';
    const   EXT_VDEO_OGV    = 'ogv';

    const   EXT_DOCS_PDF    = 'pdf';
    const   EXT_DOCS_EPUB   = 'epub';

    const   EXT_ARCH_GZ     = 'gz';
    const   EXT_ARCH_ZIP    = 'zip';
    const   EXT_ARCH_TAR    = 'tar';

    private static $const_allExt;
    private $const_imagExt;
    private $const_wordExt;
    private $const_exclExt;
    private $const_pptsExt;
    private $const_sndsExt;

    /**
     * ODDragNDrop constructor.
     * @param $id                       : identifiant de l'objet pour GOT
     * @throws \ReflectionException
     * @throws Exception
     */
    public function __construct($id, $core = true)
    {
        parent::__construct($id, "oobjects/odcontained/oddragndrop/oddragndrop.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            if (!$this->getWidthBT() || empty($this->getWidthBT())) {
                $this->setWidthBT(12);
            }
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
            $this->setClassName(self::class);
        }

        if ($core){ $this->saveProperties(); }
        return $this;
    }

    /**
     * fixe le nombre maximal de fichiers à télécharger
     * @param int $maxFileCount         : nombre de fichier à télécharger (>0)
     * @return ODDragNDrop|bool        : (false si $maxFileCount est valorisé à 0)
     */
    public function setMaxFileCount(int $maxFileCount)
    {
        if ($maxFileCount > 0) {
            $properties = $this->getProperties();
            $properties['maxFileCount'] = $maxFileCount;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue le nombre maximum de fichiers à télécharger
     * @return bool|int                 : ((int) $properties['maxFileCount'] ou false si la propriété n'existe pas)
     */
    public function getMaxFileCount()
    {
        $properties = $this->getProperties();
        return (int) $properties['maxFileCount'] ?? false;
    }

    /**
     * supprime toute limite de nombre de fichiers à télécharger
     * @return ODDragNDrop
     */
    public function disMaxFileCount()
    {
        $properties = $this->getProperties();
        $properties['maxFileCount'] = 0;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * fixe la taille minimale des fichiers  à télécharger
     * @param int $minFileSize          : taille minimale des fichiers
     * @return ODDragNDrop|bool        : (false si $minFileSize est valorisé à 0)
     */
    public function setMinFileSize(int $minFileSize)
    {
        if ($minFileSize > 0) {
            $properties = $this->getProperties();
            $properties['minFileSize'] = $minFileSize;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue la taille minimale des fichiers à télécharger
     * @return bool|int                 : ((int) $properties['minFileSize'] ou false si la propriété n'existe pas)
     */
    public function getMinFileSize()
    {
        $properties = $this->getProperties();
        return (int) $properties['minFileSize'] ?? false;
    }

    /**
     * supprime toute limite de taille minimale des fichiers
     * @return ODDragNDrop
     */
    public function disMinFileSize()
    {
        $properties = $this->getProperties();
        $properties['minFileSize'] = 0;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * fixe la taille maximale des fichiers à télécharger
     * @param int $maxFileSize          : taille maximal des fichiers
     * @return ODDragNDrop|bool        : (false si $minFileSize est valorisé à 0)
     */
    public function setMaxFileSize(int $maxFileSize)
    {
        if ($maxFileSize > 0) {
            $properties = $this->getProperties();
            $properties['maxFileSize'] = $maxFileSize;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue la taille maximale des fichiers à télécharger
     * @return bool|int                 : ((int) $properties['maxFileSize'] ou false si la propriété n'existe pas)
     */
    public function getMaxFileSize()
    {
        $properties = $this->getProperties();
        return (int) $properties['maxFileSize'] ?? false;
    }

    /**
     * supprime tout limite de taille maximale des fichiers à télécharger
     * @return ODDragNDrop
     */
    public function disMaxFileSize()
    {
        $properties = $this->getProperties();
        $properties['maxFileSize'] = 0;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * fixe le texte à afficher, dans la zone du Glisser/Déposer
     * @param string $message
     * @return ODDragNDrop|bool        : (false si $message est vide)
     */
    public function setMessage(string $message)
    {
        if (strlen($message) > 0) {
            $properties = $this->getProperties();
            $properties['message'] = $message;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue le texte à afficher, dans la zone du Glisser/Déposer
     * @return bool|int                 : ((int) $properties['maessage'] ou false si la propriété n'existe pas)
     */
    public function getMessage()
    {
        $properties = $this->getProperties();
        return (int) $properties['message'] ?? false;
    }

    /**
     * autorise les fichiers image au téléchargement
     * @return ODDragNDrop
     * @throws \ReflectionException
     */
    public function enaImageFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : '';
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
     * autorise les fichiers texte au téléchargement
     * @return ODDragNDrop
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
     * autorise les feuilles de calcul au téléchargement
     * @return ODDragNDrop
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
     * autorise les fichiers diaporama au téléchargement
     * @return ODDragNDrop
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
     * autorise les fichiers son au téléchargement
     * @return ODDragNDrop
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
     * autorise les fichiers vidéo au téléchargement
     * @return ODDragNDrop
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
     * autorise les fichiier Document au téléchargement
     * @return ODDragNDrop
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
     * autorise les fichiers archive compressé au téléchargement
     * @return ODDragNDrop
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
     * autorise tout type de fichiers (relativement aux extensions paramétrées)
     * @return ODDragNDrop
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
     * fixe avec le tableau $acceptedFiles les fichiers téléchargeables
     * @param string $acceptedFiles
     * @return ODDragNDrop|bool        : (false si une extension de $acceptedFiles n'est pas valide)
     * @throws \ReflectionException
     */
    public function setAcceptedFiles(array $acceptedFiles)
    {
        $allExt                         = $this->getAllExtensionConstant();
        foreach ($acceptedFiles as $file) {
            if (!in_array($file, $allExt)) { return false; }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $acceptedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * ajoute une extension $acceptedFile à la liste des fichiers téléchageables
     * @param string $acceptedFile
     * @return ODDragNDrop|bool        : (false si l'extension de $acceptedFile n'est pas valide)
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
     * supprime une extension $acceptedFile de la liste des fichiers autorisés
     * @param string $acceptedFile
     * @return ODDragNDrop|bool        : (false si l'extension de $acceptedFile n'est pas valide ou n'est pas présente)
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
     * interdit les fichiers image au téléchargement
     * @return ODDragNDrop
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
     * interdit les fichiers texte au téléchargement
     * @return ODDragNDrop
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
     * interdit les feuilles de calcul au téléchargement
     * @return ODDragNDrop
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
     * interdit les fichiers diaporama au téléchargement
     * @return ODDragNDrop
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
     * interdit les fichiers son au téléchargement
     * @return ODDragNDrop
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
     * interdit les fichiers vidéo au téléchargement
     * @return ODDragNDrop
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
     * interidt les fichiers Document au téléchargement
     * @return ODDragNDrop
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
     * interdit les fichiers archive compressé au téléchargement
     * @return ODDragNDrop
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
     * supprime tout paramétrage de fichiers autorisés au téléchargement autorise de fait le téléchargement de n'importe
     * quel fichier
     * @return ODDragNDrop
     */
    public function clearAcceptedFiles()
    {
        $properties     = $this->getProperties();
        $properties['acceptedFiles']    = '';
        $this->setProperties($properties);
        return $this;
    }

    /**
     * fixe la hauteur de ligne et indirectement la hauteur de la zone glisser-déposer
     * @param int $lineHeight       : hauteur de ligne (valeur unmérique)
     * @param string $unit          : unité de la largeur, point (px) par défaut
     * @return ODDragNDrop|bool
     */
    public function setLineHeightDND(int $lineHeight, string $unit = 'px')
    {
        if ($lineHeight > 0) {
            $properties = $this->getProperties();
            $properties['lineHeightDND'] = $lineHeight.$unit;
            $height     = round(1.2 * $lineHeight, 1);
            $properties['heightDND'] = $height.$unit;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue la hauteur de ligne dans la zone de glisser-déposer
     * @return bool|int
     */
    public function getLineHeightDND()
    {
        $properties = $this->getProperties();
        return (int) $properties['lineHeightDND'] ?? false;
    }

    /**
     * fixe la hauteur de la zone de glisser-déposer et indirectement la hateur de ligne
     * @param int $heightDND        : hauteur de la zone de glisser-déposer
     * @param string $unit          : unité de la hauteur, point (px) par défault
     * @return ODDragNDrop|bool
     */
    public function setHeightDND(int $heightDND, string $unit = 'px')
    {
        if ($heightDND > 0) {
            $properties = $this->getProperties();
            $properties['heightDND'] = $heightDND.$unit;
            $lineHeight = round($heightDND * 0.8, 1);
            $properties['lineHeightDND'] = $lineHeight.$unit;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue la hateur de la zone de glisser-déposer
     * @return bool|int
     */
    public function getHeightDND()
    {
        $properties = $this->getProperties();
        return (int) $properties['heightDND'] ?? false;
    }

    /**
     * affecte après vérification le chemin $tempFolder comme répertoire de sauvegarde temporaire (de travail) des
     * fichiers téléchargés
     * @param string $tempFolder        : chemin du répertoire de sauvegarde temporaire
     * @return ODDragNDrop|bool        : false si le chemin n'exoiste pas
     */
    public function setTempFolder(string $tempFolder)
    {
        if (file_exists($tempFolder)) {
            $properties = $this->getProperties();
            $properties['tempFolder'] = $tempFolder;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue le chemin du répertoire de sauvegarde temporaire des fichiers
     * @return bool|string
     */
    public function getTempFolder()
    {
        $properties = $this->getProperties();
        return (string) $properties['tempFolder'] ?? false;
    }

    /**
     * ajoute un fichier stocké sur disque à la liste des fichiers chargés
     * @param string $name
     * @param string $pathFile
     * @return ODDragNDrop|bool
     */
    public function addLoadedFile(string $name, string $pathFile)
    {
        $properties                     = $this->getProperties();
        $loadedFiles                    = $properties['loadedFiles'];
        if (!array_key_exists($name, $loadedFiles)) {
            $loadedFiles[$name]         = $pathFile;
            $properties['loadedFiles']  = $loadedFiles;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * supprime un fichier stocké sur disque de la liste des fichiers chargés
     * @param string $name
     * @param string $pathFile
     * @return ODDragNDrop|bool
     */
    public function rmLoadedFile(string $name, string $pathFile)
    {
        $properties                     = $this->getProperties();
        $loadedFiles                    = $properties['loadedFiles'];
        if (file_exists($pathFile) && array_key_exists($name, $loadedFiles)) {
            unset($loadedFiles[$name]);
            $properties['loadedFiles']  = $loadedFiles;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * réaffecte au fichier de nom $name dans la liste des fichiers chargés le le chemin $pathFile
     * @param string $name
     * @param string $pathFile
     * @return ODDragNDrop|bool
     */
    public function setLoadedFile(string $name, string $pathFile)
    {
        $properties                     = $this->getProperties();
        $loadedFiles                    = $properties['loadedFiles'];
        if (file_exists($pathFile) && array_key_exists($name, $loadedFiles)) {
            $loadedFiles[$name]         = $pathFile;
            $properties['loadedFiles']  = $loadedFiles;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue le chemin physique d'accès au fichier de nom $name dans la liste des fichiers chargés
     * @param string $name
     * @return bool|string
     */
    public function getLoadedFile(string $name)
    {
        $properties                     = $this->getProperties();
        $loadedFiles                    = $properties['loadedFiles'];
        return $loadedFiles[$name] ?? false;
    }

    /**
     * affecte le contenu du tableau $loadedFiles à la liste des fichiers chargés
     * @param array $loadedFiles
     * @return ODDragNDrop|bool
     */
    public function setLoadedFiles(array $loadedFiles)
    {
        // validation du tableau
        foreach ($loadedFiles as $loadedFile) {
            if (!array_key_exists('name', $loadedFile) || !array_key_exists('pathFile', $loadedFile)) {
                return false;
            }
        }

        $properties                     = $this->getProperties();
        $properties['loadedFiles']      = $loadedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * restitue le tableau des fichiers chargés
     * @return bool|array
     */
    public function getLoadedFiles()
    {
        $properties = $this->getProperties();
        return $properties['loadedFiles'] ?? false;
    }

    /**
     * fixe la largeur de la miniature à créer pour le fichier téléchargé
     * si 0 : pas pris en comptes dans la création de la miniature
     * @param int $thumbWidth
     * @return ODDragNDrop
     */
    public function setThumbWidth(int $thumbWidth)
    {
        if ($thumbWidth == 0) { $thumbWidth = 150; }
        $properties                 = $this->getProperties();
        $properties['thumbWidth']   = $thumbWidth;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * restitue la largeur de la miniature à créer pour le fichier téléchargé
     * @return bool:int
     */
    public function getThumbWidth()
    {
        $properties = $this->getProperties();
        return $properties['thumbWidth'] ?? false;
    }

    /**
     * fixe la hauteur de la miniature à créer pour le fichier téléchargé
     * si 0 : pas pris en comptes dans la création de la miniature
     * @param int $thumbHeight
     * @return ODDragNDrop
     */
    public function setThumbHeight(int $thumbHeight)
    {
        if ($thumbHeight == 0) { $thumbHeight = 150; }
        $properties                 = $this->getProperties();
        $properties['thumbHeight']  = $thumbHeight;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * restitue la hauteur de la miniature à créer pour le fichier téléchargé
     * @return bool
     */
    public function getThumbHeight()
    {
        $properties = $this->getProperties();
        return $properties['thumbHeight'] ?? false;
    }

    /**
     * active la présentation d'une icône pour délencher la vue du fichier dans un autre onglet
     * @return ODDragNDrop
     */
    public function enaThumbView()
    {
        $properties = $this->getProperties();
        $properties['thumbView'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * désactive la présentation d'une icône pour délencher la vue du fichier dans un autre onglet
     * @return ODDragNDrop
     */
    public function disThumbView()
    {
        $properties = $this->getProperties();
        $properties['thumbView'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * active la présentation d'une icône pour délencher le téléchargement du fichier
     * @return ODDragNDrop
     */
    public function enaThumbDload()
    {
        $properties = $this->getProperties();
        $properties['thumbDload'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * désactive la présentation d'une icône pour délencher le téléchargement du fichier
     * @return ODDragNDrop
     */
    public function disThumbDload()
    {
        $properties = $this->getProperties();
        $properties['thumbDload'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * active la présentation d'une icône pour délencher la suppression du fichier des fichiers téléchargés
     * @return ODDragNDrop
     */
    public function enaThumbRmove()
    {
        $properties = $this->getProperties();
        $properties['thumbRmove'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * désactive la présentation d'une icône pour délencher la suppression du fichier des fichiers téléchargés
     * @return ODDragNDrop
     */
    public function disThumbRmove()
    {
        $properties = $this->getProperties();
        $properties['thumbRmove'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * déclenche l'affichage du nom de fichier sous sa miniature
     * @return ODDragNDrop
     */
    public function enaThumbFileName()
    {
        $properties = $this->getProperties();
        $properties['thumbFileName'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * interdit l'affichage du nom de fichier sous sa miniature
     * @return $this
     */
    public function disThumbFileName()
    {
        $properties = $this->getProperties();
        $properties['thumbFileName'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * ***************************************************************************************************
     */

    /**
     * méthode permettant la distribution des évènement gérés par l'objet
     * @param ServiceManager $sm
     * @param array $params
     * @return array
     * @throws Exception
     */

    public function dispatchEvents(ServiceManager $sm, $params)
    {
        switch ($params['event']) {
            case 'dropIn':
                return $this->evtAddFile($sm, $params);
                break;
            case 'dropOut':
                return $this->evtRmFile($sm, $params);
                break;
            default:
                throw new Exception("Une erreur est survenue, l'évènement ".$params['event'].' ne peut être traité');
        }
    }

    /**
     * méthode traitant l'évènement de l'ajout d'un fichier à la lise des fichiers chargés (vaec les différents impacts
     * sur l'objet)
     * @param ServiceManager $sm
     * @param array $params
     * @return array|bool
     * @throws Exception
     */
    public function evtAddFile(ServiceManager $sm, array $params)
    {
        /** @var ZF3GotServices $gs */
        $gs         = $sm->get('graphic.object.templating.services');
        $ret        = [];
        /** @var ODDragNDrop $objet */
        $sessionObj = self::validateSession();
        /** @var ODDragNDrop $objet */
        $objet      = self::buildObject($params['id'], $sessionObj);

        $maxCountFile   = $objet->getMaxFileCount();
        $loadedFiles    = $objet->getLoadedFiles();

        if ($maxCountFile === 0 || sizeof($loadedFiles) < $maxCountFile) {
            $tempFolder = $objet->getTempFolder();
            $pathPublic = $_SERVER['DOCUMENT_ROOT'];
            /** si tempFolder vide, voir de créer un répertoire uploadFile dans public */
            if (empty($tempFolder)) {
                if (!file_exists($pathPublic.'/uploadedFiles')) {
                    $returnCall  = shell_exec('cd '.$pathPublic.' 2>&1');

                    $returnCall .= shell_exec('mkdir public/uploadedFiles 2>&1');
                    $returnCall .= shell_exec('chmod 777 public/uploadedFiles/ 2>&1');
                    if (!empty($returnCall)) { throw new \Exception($returnCall); }
                }
                $tempFolder  = $pathPublic.'/uploadedFiles';
            }

            /**
             * traitement d'ajout d'un fichier
             */
            $fileName   = $params['name'];
            $fileExt    = pathinfo($fileName, PATHINFO_EXTENSION);
            $mimeType   = $this->getMimeString($fileExt);
            $imgSrc     = $params['file'];
            $imgFile    = base64_decode($imgSrc);
            $dest       = $tempFolder.'/'.$fileName;
            if ( $objet->addLoadedFile($params['name'], $dest) !== false ) {
                $file       = fopen($dest, 'wb');
                fwrite($file, $imgFile);
                fclose($file);

                $objet->setTempFolder($tempFolder);
                $objet->saveProperties();

                $mode   = 'addFile';
                $html   = ['name'=> $params['name'], 'mime'=> $mimeType];
                $ret[]  = $objet::formatRetour($objet->getId(), $objet->getId(), $mode, $html);
            } else {
                $alertMsg = 'alert("Nom de fichier '.$$params['name'].' existe dèjà, veuillez changer");';
                $ret[]  = $objet::formatRetour($objet->getId(), $objet->getId(), 'exec', $alertMsg);
            }
        } else if ($maxCountFile != 0) {
            $alertMsg = 'alert("Maximum de '.$maxCountFile.' fichier(s) atteint");';
            $ret[]  = $objet::formatRetour($objet->getId(), $objet->getId(), 'exec', $alertMsg);
        }

        return $ret;
    }

    /**
     * méthode traitant de la suppression d'un fichier à la liste des fichiers chargés (avec les différents impacts sur
     * l'objet)
     * @param ServiceManager $sm
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function evtRmFile(ServiceManager $sm, array $params)
    {
        /** @var ZF3GotServices $gs */
        $gs = $sm->get('graphic.object.templating.services');
        $ret    = [];
        /** @var ODDragNDrop $objet */
        $sessionObj = self::validateSession();
        $objet  = self::buildObject($params['id'], $sessionObj);

        /**
         * traitement de suppression d'un fichier
         */
        $properties     = $objet->getProperties();
        $loadedFiles    = $properties['loadedFiles'];
        $fileName       = $params['file'];
        if (array_key_exists($fileName, $loadedFiles)) {
            // suppression du fichier de la liste + suppression physique dans getTempFolder()
            $filePath = $loadedFiles[$fileName];
            if (file_exists($filePath)) {
                if( @unlink($filePath) !== true ) {
                    throw new Exception('impossible de supprimer le fichier: ' . $filePath .
                        ". Veuillez en avertir l'administrateur du site.");
                } else {
                    unset($loadedFiles[$fileName]);
                    $properties['loadedFiles']  = $loadedFiles;
                    $objet->setProperties($properties);
                    $objet->saveProperties();

                    $mode   = 'rmFile';
                    $name   = $params['name'];
                    $html   = ['name'=> $name, 'count'=> sizeof($loadedFiles)];
                    $ret[]  = $objet::formatRetour($objet->getId(), $objet->getId(), $mode, $html);
                }
            }
        }


        return $ret;
    }

    /**
     * alimentation pour retour de callbacjk visant à réaffecter le contenu de l'objet
     * @return array
     * @throws Exception
     */
    public function returnSetData()
     {
         $thisID        = $this->getId();
         $code          = [];
         $loadedFiles   = $this->getLoadedFiles();
         if (!empty($loadedFiles)) {
             /* récupération et préparation du répertoire des miniatures */
            $tempFolder = $this->getTempFolder();
            $pathPublic = $_SERVER['DOCUMENT_ROOT'];
            if (empty($tempFolder)) {
                if (!file_exists($pathPublic.'/uploadedFiles')) {
                    $returnCall  = shell_exec('cd '.$pathPublic.' 2>&1');

                    $returnCall .= shell_exec('mkdir public/uploadedFiles 2>&1');
                    $returnCall .= shell_exec('chmod 777 public/uploadedFiles/ 2>&1');
                    if (!empty($returnCall)) { throw new \Exception($returnCall); }
                }
                $tempFolderPath  = $pathPublic.'/uploadedFiles';
            }
            $tempFolderPath     .= 'thumbnails';
            if (!file_exists($tempFolderPath.'/thumbnails')) {
                $returnCall  = shell_exec('cd '.$tempFolder.' 2>&1');

                $returnCall .= shell_exec('mkdir '.$tempFolderPath.'/thumbnails 2>&1');
                $returnCall .= shell_exec('chmod 777 '.$tempFolderPath.'/thumbnails 2>&1');
                if (!empty($returnCall)) { throw new \Exception($returnCall); }
            }
            $tempFolderPath     .= '/thumbnails';

            foreach($loadedFiles as $fileName => $filePath) {
                $item   = [];
                $item['name']       = $fileName;
                if (strpos(\mime_content_type($filePath), 'image') === 0) {
                    $item['thumdURL']   = 'http://'.$_SERVER['SERVER_NAME'].'/graphicobjecttemplating/'.$tempFolder.'/'.$fileName;
                } else {
                    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                    $item['thumdURL']   = 'http://'.$_SERVER['SERVER_NAME'].'/graphicobjecttemplating/'.$tempFolder.'/'.$ext.'.svg';
                }
                $code[] = $item;
            }
         }
         return  [self::formatRetour($thisID, $thisID, 'setData', $code)];
     }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * ***************************************************************************************************/

    /**
     * récupération de l'ensemble des constantes de définition des extensions de fichier autorisées au téléchargement
     * @return array                    : tableau des extensions de fichier autorisées
     * @throws \ReflectionException
     */
    private static function getAllExtensionConstant()
    {
        $retour = [];
        if (empty(self::$const_allExt)) {
            $constants = self::getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'EXT_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            self::$const_allExt = $retour;
        } else {
            $retour = self::$const_allExt;
        }
        return $retour;
    }

    /**
     * récupération de l'ensemble des constantes de définition des extensions de fichier image autorisées au
     * téléchargement
     * @return array                    : tableau des extensions de fichier image autorisées
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
     * récupération de l'ensemble des constantes de définition des extensions de fichier texte autorisées au
     * téléchargement
     * @return array                    : tableau des extensions de fichier texte autorisées
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
     * récupération de l'ensemble des constantes de définition des extensions de fichier feuilles de calcul autorisées
     * au téléchargement
     * @return array                    : tableau des extensions de fichier feuilles de calcul autorisées
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
     * récupération de l'ensemble des constantes de définition des extensions de fichier diaporama autorisées au
     * téléchargement
     * @return array                    : tableau des extensions de fichier diaporama autorisées
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
     * récupération de l'ensemble des constantes de définition des extensions de fichier son autorisées au
     * téléchargement
     * @return array                    : tableau des extensions de fichier son autorisées
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
     * récupération de l'ensemble des constantes de définition des extensions de fichier vidéo autorisées au
     * téléchargement
     * @return array                    : tableau des extensions de fichier vidéo autorisées
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
     * récupération de l'ensemble des constantes de définition des extensions de fichier Document autorisées au
     * téléchargement
     * @return array                    : tableau des extensions de fichier Document autorisées
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
     * récupération de l'ensemble des constantes de définition des extensions de fichier archive compressée autorisées
     * au téléchargement
     * @return array                    : tableau des extensions de fichier archive compressée autorisées
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
     * suppression dans la liste des extensions autorisées $acceptedFiles des extensions listées dans le tableau $exts
     * @param array $acceptedFiles      : tableau des extensions autorisées
     * @param array $exts               : tableau des extension à supprimer
     * @return bool|array               : nouveau tableau des extensions autorisées ou false si une extension de $exts
     *                                      n'est pas présente dans $acceptedRFiles
     */
    private function rmAcceptedFiles(array $acceptedFiles, array $exts)
    {
        foreach ($exts as $ext) {
            $existsExt              = in_array($ext, $acceptedFiles);
            if ($existsExt !== false) {
                $key    = array_keys($acceptedFiles, $ext);
                $key    = $key[0];
                unset($acceptedFiles[$key]);
            }
        }
        return $acceptedFiles;
    }

    /**
     * restitue la chaîne de caractère nature de fichier MIME en fonction de l'extension $ext fournie
     * @param $ext                      : extension de fichier fournie
     * @return bool|string              : restitue la chaine de typde fichier MIME ou false si l'extension n'est pas
     *                                      valide et gérée par le système
     * @throws \ReflectionException
     */
    public static function getMimeString($ext)
    {
        $key            = "";
        $extConstants   = self::getAllExtensionConstant();
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
                    $mime   = "image/".$ext;
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

    private function getDir()
    {
        $rc = new ReflectionClass(get_class($this));
        return dirname($rc->getFileName());
    }
}
