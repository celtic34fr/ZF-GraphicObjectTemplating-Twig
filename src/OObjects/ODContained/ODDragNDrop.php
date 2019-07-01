<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Exception;
use GraphicObjectTemplating\Exception\GotException;
use GraphicObjectTemplating\OObjects\ODContained;
use ReflectionException;
use Zend\Mvc\Controller\Plugin\Url;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ODDragNDrop
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         : contructeur de l'objet
 * enaClose()               : active l'affichage du bouton de fermeture de la zone de drag & drop
 * disClose()               : désactive l'affichage du bouton de fermeture de la zone de drag & drop
 * enaBrowse()              : active l'affichage du bouton de parcours des fichies locaux
 * disBrowse()              : désactive l'affichage du bouton de parcours des fichies locaux
 * enaCaption()             :
 * disCaption()             :
 * enaPreview()             : active l'affichage du bouton de visualisation en fenêtre modale du fichier
 * disPreview()             : désactive l'affichage du bouton de visualisation en fenêtre modale du fichier
 * enaRemove()              : active l'affichage du bouton de suppression
 * disRemove()              : désactive l'affichage du bouton de suppression
 * enaUpload()              : active l'affichage du bouton de chargement sur serveur du fichier
 * disUpload()              : désactive l'affichage du bouton de chargement sur serveur du fichier
 * enaClickOnZone()         : active le choix de fichier par click dans la zone drag & drop
 * disClickOnZone()         : désactive le choix de fichier par click dans la zone drag & drop
 * enaMultiple()            : active la sélection possible de plusieurs fichier
 * enaSingle()              : active la sélection d'un seul fichier
 * enaOverwriteInitial()    : ne conserve pas les preview si vous ajoutez d'autres images
 * disOverwriteInitial()    : conserve les preview si vous ajoutez d'autres images
 * enaImageFiles()          : paramétrage des images comme type de fichiers autorisés
 * enaWordFiles()           : paramétrage des document type Word comme type de fichiers autorisés
 * enaExcelFiles()          : paramétrage des feuilles de calcul comme type de fichiers autorisés
 * enaPresentationFiles()   : paramétrage des présentations, diaporamas comme type de fichiers autorisés
 * enaSoundFiles()          : paramétrage des fichiers son comme type de fichiers autorisés
 * enaVideoFiles()          : paramétrage des fichiers vidéos comme type de fichiers autorisés
 * enaDocumentFiles()       : paramétrage des documents (autre type que Word) comme type de fichiers autorisés
 * enaArchiveFiles()        : paramétrage des fichiers archives compressés comme type de fichiers autorisés
 * enaAllTypeFiles()        : paramétrage de tout les types connus du système comme type de fichiers autorisés
 * setAcceptedFiles(array $acceptedFiles)
 *                          : fixe avec le tableau $acceptedFiles les fichiers téléchargeables si connue par le système,
 *                              sinon renvoi 'false'
 * addAccepetdFile(string $acceptedFile)
 *                          : ajoute une extension $acceptedFile à la liste des fichiers téléchageables si connue par le
 *                              système, sinon renvoi 'false'
 * rmAcceptedFile(string $acceptedFile)
 *                          : supprime une extension $acceptedFile de la liste des fichiers autorisés si connue par le
 *                              système et présente dans la liste paramétrée, sinon renvoi 'false'
 * disImageFiles()          : supprime du paramétrage les images des types de fichiers autorisés
 * disWordFiles()           : supprime du paramétrage les document type Word des types de fichiers autorisés
 * disExcelFiles()          : supprime du paramétrage les feuilles de calcul des types de fichiers autorisés
 * disPresentationFiles()   : supprime du paramétrage les présentations, diaporamas des types de fichiers autorisés
 * disSoundFiles()          : supprime du paramétrage les fichiers son des types de fichiers autorisés
 * disVideoFiles()          : supprime du paramétrage les fichiers vidéos des types de fichiers autorisés
 * disDocumentFiles()       : supprime du paramétrage les documents (autre que Word) des types de fichiers autorisés
 * disArchiveFiles()        : supprime du paramétrage des fichiers archives compressés des types de fichiers autorisés
 * clearAcceptedFiles()     : vide totalement la liste des types de fichiers autorisés
 * getAcceptedFiles()       : restitue sous forme de chaîne de caractères, l'ensemble des extension de fichiers acceptés
 *                              pour le téléchargement
 * addLoadedFile(string $name, string $pathFile, bool $initial = false, string $caption = '')
 *                          : ajoute un fichier stocké sur disque à la liste des fichiers chargés
 * rmLoadedFile(string $name)
 *                          : supprime un fichier stocké sur disque de la liste des fichiers chargés
 * setLoadedFile(string $name, string $pathFile)
 *                          : réaffecte au fichier de nom $name dans la liste des fichiers chargés avec le chemin
 *                              $pathFile
 * getLoadedFile(string $name)
 *                          : restitue le chemin physique d'accès au fichier de nom $name dans la liste des fichiers
 *                              chargés
 * setInitialLoadedFiles(array $loadedFiles)
 *                          : affecte le contenu du tableau $loadedFiles à la liste des fichiers chargés
 * getLoadedFiles()         : restitue le tableau des fichiers chargés
 * setuploadedFilesPath(string $tempFolder)
 *                          : affecte après vérification le chemin $tempFolder comme répertoire de sauvegarde temporaire
 *                              (de travail) des fichiers téléchargés
 * getuploadedFilesPath()   : restitue le chemin du répertoire de sauvegarde temporaire des fichiers
 * getCompleteUploadedFilesPath($filename = '')
 * evtUploadFile(string $class, string $method, bool $stopEvent = false)
 * getUploadFile()
 * disUploadFile()
 * evtDeleteFile(string $class, string $method, bool $stopEvent = false)
 * getDeleteFile()
 * disDeleteFile()
 *
 * méthodes de gestion de retour de callback
 * -----------------------------------------
 * dispatchEvents(ServiceManager $sm, $params)
 * evtAddFile(ServiceManager $sm, array $params)
 * evtRmFile(ServiceManager $sm, array $params)
 * returnAddUploadedFile(string $objId, array $previewPath, array $previewConfig)
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
    const OEDND_THEME_EXPLORER      = 'explorer';
    const OEDND_THEME_EXPLORER_FA   = 'explorer-fa';
    const OEDND_THEME_EXPLORER_FAS  = 'explorer-fas';
    const OEDND_THEME_FA            = 'fa';
    const OEDND_THEME_FAS           = 'fas';
    const OEDND_THEME_GLY           = 'gly';

    const EXT_IMAG_JPG    = 'jpg';
    const EXT_IMAG_JPEG   = 'jpeg';
    const EXT_IMAG_PNG    = 'png';
    const EXT_IMAG_BMP    = 'bmp';
    const EXT_IMAG_GIF    = 'gif';
    const EXT_IMAG_SVG    = 'svg';

    const EXT_WORD_DOC    = 'doc';
    const EXT_WORD_DOCX   = 'docx';
    const EXT_WORD_ODT    = 'odt';
    const EXT_WORD_RTF    = 'rtf';
    const EXT_WORD_TXT    = 'txt';

    const EXT_EXCL_XLS    = 'xls';
    const EXT_EXCL_XLSX   = 'xlsx';
    const EXT_EXCL_ODS    = 'ods';
    const EXT_EXCL_CSV    = 'csv';

    const EXT_PPTS_PPT    = 'ppt';
    const EXT_PPTS_PPTX   = 'pptx';
    const EXT_PPTS_ODP    = 'odp';

    const EXT_SNDS_MP3    = 'mp3';
    const EXT_SNDS_WAV    = 'wav';
    const EXT_SNDS_OGG    = 'ogg';

    const EXT_VDEO_MP4    = 'mp4';
    const EXT_VDEO_MKV    = 'mkv';
    const EXT_VDEO_OGV    = 'ogv';

    const EXT_DOCS_PDF    = 'pdf';
    const EXT_DOCS_EPUB   = 'epub';
    const EXT_DOCS_HTML   = 'html';

    const EXT_ARCH_GZ     = 'gz';
    const EXT_ARCH_ZIP    = 'zip';
    const EXT_ARCH_TAR    = 'tar';

    private static $const_allExt;

    /**
     * ODDragNDrop constructor.
     * @param $id
     * @throws ReflectionException
     */
    public function __construct($id)
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

        $this->saveProperties();
        return $this;
    }

    /**
     * active l'affichage du bouton de fermeture de la zone de drag & drop
     *
     * @return ODDragNDrop
     */
    public function enaClose()
    {
        $properties                 = $this->getProperties();
        $properties['showClose']    = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * désactive l'affichage du bouton de fermeture de la zone de drag & drop
     *
     * @return ODDragNDrop
     */
    public function disClose()
    {
        $properties                 = $this->getProperties();
        $properties['showClose']    = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * active l'affichage du bouton de fermeture de la zone de drag & drop
     *
     * @return ODDragNDrop
     */
    public function enaBrowse()
    {
        $properties                 = $this->getProperties();
        $properties['showBrowse']   = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * désactive l'affichage du bouton de fermeture de la zone de drag & drop
     *
     * @return ODDragNDrop
     */
    public function disBrowse()
    {
        $properties                 = $this->getProperties();
        $properties['showBrowse']   = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODDragNDrop
     */
    public function enaCaption()
    {
        $properties                 = $this->getProperties();
        $properties['showCaption']  = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODDragNDrop
     */
    public function disCaption()
    {
        $properties                 = $this->getProperties();
        $properties['showCaption']  = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODDragNDrop
     */
    public function enaPreview()
    {
        $properties                 = $this->getProperties();
        $properties['showPreview']  = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODDragNDrop
     */
    public function disPreview()
    {
        $properties                 = $this->getProperties();
        $properties['showPreview']  = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * active l'affichage du bouton de suppression
     *
     * @return ODDragNDrop
     */
    public function enaRemove()
    {
        $properties                 = $this->getProperties();
        $properties['showRemove']   = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * désactive l'affichage du bouton de suppression
     *
     * @return ODDragNDrop
     */
    public function disRemove()
    {
        $properties                 = $this->getProperties();
        $properties['showRemove']   = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * active l'affichage du bouton de chargement sur serveur du fichier
     *
     * @return ODDragNDrop
     */
    public function enaUpload()
    {
        $properties                 = $this->getProperties();
        $properties['showUpload']   = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * désactive l'affichage du bouton de chargement sur serveur du fichier
     *
     * @return ODDragNDrop
     */
    public function disUpload()
    {
        $properties                 = $this->getProperties();
        $properties['showUpload']   = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * active le choix de fichier par click dans la zone drag & drop
     *
     * @return ODDragNDrop
     */
    public function enaClickOnZone()
    {
        $properties                 = $this->getProperties();
        $properties['clickOnZone']   = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * désactive le choix de fichier par click dans la zone drag & drop
     *
     * @return ODDragNDrop
     */
    public function disClickOnZone()
    {
        $properties                 = $this->getProperties();
        $properties['clickOnZone']   = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * active la sélection possible de plusieurs fichier
     *
     * @return ODDragNDrop
     */
    public function enaMultiple()
    {
        $properties     		= $this->getProperties();
        $properties['multiple'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * active la sélection d'un seul fichier
     *
     * @return ODDragNDrop
     */
    public function enaSingle()
    {
        $properties             = $this->getProperties();
        $properties['multiple']	= false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * ne conserve pas les preview si vous ajoutez d'autres images
     *
     * @return ODDragNDrop
     */
    public function enaOverwriteInitial()
    {
        $properties             = $this->getProperties();
        $properties['overwriteInitial']	= true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * conserve les preview si vous ajoutez d'autres images
     *
     * @return ODDragNDrop
     */
    public function disOverwriteInitial()
    {
        $properties             = $this->getProperties();
        $properties['overwriteInitial']	= false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * autorise les fichiers image au téléchargement
     * @return ODDragNDrop
     * @throws ReflectionException
     */
    public function enaImageFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $imagExts   = $this->getImageExtensionConstant();
        foreach ($imagExts as $imagExt) {
            if (!in_array($imagExt, $extString)) {
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
     * @throws ReflectionException
     */
    public function enaWordFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $wordExts   = $this->getWordExtensionConstant();
        foreach ($wordExts as $wordExt) {
            if (!in_array($wordExt, $extString)) {
                $extString[] = $wordExt;
            }
        }
        $properties                 	= $this->getProperties();
        $properties['acceptedFiles']	= $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * autorise les feuilles de calcul au téléchargement
     * @return ODDragNDrop
     * @throws ReflectionException
     */
    public function enaExcelFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $exclExts   = $this->getExcelExtensionConstant();
        foreach ($exclExts as $exclExt) {
            if (!in_array($exclExt, $extString)) {
                $extString[] = $exclExt;
            }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * autorise les fichiers diaporama au téléchargement
     * @return ODDragNDrop
     * @throws ReflectionException
     */
    public function enaPresentationFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $pptsExts   = $this->getPresentationExtensionConstant();
        foreach ($pptsExts as $pptsExt) {
            if (!in_array($pptsExt, $extString)) {
                $extString[] = $pptsExt;
            }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * autorise les fichiers son au téléchargement
     * @return ODDragNDrop
     * @throws ReflectionException
     */
    public function enaSoundFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $sndsExts   = $this->getSoundExtensionConstant();
        foreach ($sndsExts as $sndsExt) {
            if (!in_array($sndsExt, $extString)) {
                $extString[] = $sndsExt;
            }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * autorise les fichiers vidéo au téléchargement
     * @return ODDragNDrop
     * @throws ReflectionException
     */
    public function enaVideoFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $vdeoExts   = $this->getVideoExtensionConstant();
        foreach ($vdeoExts as $vdeoExt) {
            if (!in_array($vdeoExt, $extString)) {
                $extString[] = $vdeoExt;
            }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * autorise les fichiier Document au téléchargement
     * @return ODDragNDrop
     * @throws ReflectionException
     */
    public function enaDocumentFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $docsExts   = $this->getDocumentExtensionConstant();
        foreach ($docsExts as $docsExt) {
            if (!in_array($docsExt, $extString)) {
                $extString[] = $docsExt;
            }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * autorise les fichiers archive compressé au téléchargement
     * @return ODDragNDrop
     * @throws ReflectionException
     */
    public function enaArchiveFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $archExts   = $this->getArchiveExtensionConstant();
        foreach ($archExts as $archExt) {
            if (!in_array($archExt, $extString)) {
                $extString[] = $archExt;
            }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * autorise tout type de fichiers (relativement aux extensions paramétrées)
     * @return ODDragNDrop
     * @throws ReflectionException
     */
    public function enaAllTypeFiles()
    {
        $properties = $this->getProperties();
        $extString  = (!empty($properties['acceptedFiles'])) ? $properties['acceptedFiles'] : [];
        $allExts    = $this->getAllExtensionConstant();
        foreach ($allExts as $allExt) {
            if (!in_array($allExt, $extString)) {
                $extString[] = $allExt;
            }
        }
        $properties                     = $this->getProperties();
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * fixe avec le tableau $acceptedFiles les fichiers téléchargeables
     * @param array $acceptedFiles
     * @return ODDragNDrop|bool        : (false si une extension de $acceptedFiles n'est pas valide)
     * @throws ReflectionException
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
     * @throws ReflectionException
     */
    public function addAcceptedFile(string $acceptedFile)
    {
        if (strpos($acceptedFile, '') !== false)   { return false; }
        $allExt                                            = $this->getAllExtensionConstant();
        if (!in_array($acceptedFile, $allExt))            { return false; }
        $properties                     = $this->getProperties();
        $extString                      = $properties['acceptedFiles'];
        if (!in_array($acceptedFile, $extString)) {
            $extString[] = $acceptedFile;
        }
        $properties['acceptedFiles']    = $extString;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * supprime une extension $acceptedFile de la liste des fichiers autorisés
     * @param string $acceptedFile
     * @return ODDragNDrop|bool        : (false si l'extension de $acceptedFile n'est pas valide ou n'est pas présente)
     * @throws ReflectionException
     */
    public function rmAcceptedFile(string $acceptedFile)
    {
        if (strpos($acceptedFile, '') !== false)   { return false; }
        $allExt                             = $this->getAllExtensionConstant();
        if (!in_array($acceptedFile, $allExt))            { return false; }
        $properties                         = $this->getProperties();
        $extString                          = $properties['acceptedFiles'];
        $key                                = array_search($acceptedFile, $extString);

        if ($key !== false) {
            unset($extString[$key]);
            $properties['acceptedFiles']    = $extString;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * interdit les fichiers image au téléchargement
     * @return ODDragNDrop
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
        $properties['acceptedFiles']    = [];
        $this->setProperties($properties);
        return $this;
    }

    /**
     * restitue sous forme de chaîne de caractères, l'ensemble des extension de fichiers acceptés pour le téléchargement
     *
     * @return bool|string
     */
    public function getAcceptedFiles()
    {
        $properties = $this->getProperties();
        return $properties['acceptedFiles'] ?? false;
    }

    /**
     * ajoute un fichier stocké sur disque à la liste des fichiers chargés
     * @param string $name
     * @param string $pathFile
     * @param bool $initial
     * @param string $caption
     * @return ODDragNDrop|bool
     * @throws GotException
     */
    public function addLoadedFile(string $name, string $pathFile, bool $initial = false, string $caption = '')
    {
        $properties     = $this->getProperties();
        $loadedFiles    = $properties['loadedFiles'] ?? [];
        $loadedPaths    = $properties['loadedPaths'] ?? [];
        $loadedPreview  = $properties['loadedPreview'] ?? [];

        if (file_exists($pathFile) && !in_array($name, $loadedFiles)) {
            list($destPath, $url, $internal_url) = $this->getCompleteUploadedFilesPath($name);
            if ($pathFile != $destPath) {
                error_clear_last();
                if ($initial) {
                    @copy($pathFile,$destPath);
                } else {
                    @move_uploaded_file($pathFile,$destPath);
                }
                if ($error = error_get_last()) {
                    throw new GotException('Impossible de deplacer le fichier dans le dossier des uploads', 0, $error);
                }
            }

            $mime = mime_content_type($destPath);
            $size = filesize($destPath);

            $item = [
                'key'           => $name,
                'pathFile'      => $destPath,
                'filetype'      => $mime,
                'size'          => $size,
                'caption'       => $caption ?: $name,
                'loaded'        => $initial,
                'fileName'      => $name,
                'internalUrl'   => $internal_url,
            ];
            $loadedFiles[$name] = $item;
            $loadedPaths[]      = $url;
            $type               = $this->getTypeFromMime($mime);
            $item           = [
                'caption'   => $caption ?: $name,
                'size'      => $size,
                'width'     => '2em',
                'key'       => $name,
                'filetype'  => $mime,
                'type'      => $type,
            ];
            $loadedPreview[]    = $item;

            $properties['loadedFiles']      = $loadedFiles;
            $properties['loadedPaths']      = $loadedPaths;
            $properties['loadedPreview']    = $loadedPreview;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * supprime un fichier stocké sur disque de la liste des fichiers chargés
     * @param string $name
     * @return ODDragNDrop|bool
     * @throws GotException
     */
    public function rmLoadedFile(string $name)
    {
        $properties     = $this->getProperties();
        $loadedFiles    = $properties['loadedFiles'] ?? [];
        $loadedPaths    = $properties['loadedPaths'] ?? [];
        $loadedPreview  = $properties['loadedPreview'] ?? [];

        if ($loadedFiles && array_key_exists($name, $loadedFiles)) {
            $infoFile   = $loadedFiles[$name];
            unset($loadedFiles[$name]);
            $key        = array_search('/files/'.$infoFile['fileName'].'?id='.$this->getId(), $loadedPaths);
            if ($key !== false) {
                unset($loadedPaths[$key]);
                unset($loadedPreview[$key]);
            }
            $filePath   = $infoFile['pathFile'];

            if(file_exists($filePath)) {
                // On efface le fichier
                unlink($filePath);

                $properties['loadedFiles']      = $loadedFiles;
                $properties['loadedPaths']      = $loadedPaths;
                $properties['loadedPreview']    = $loadedPreview;

                if (empty($loadedFiles)) {
                    $folder = substr($filePath, 0, strrpos($filePath, '/'));
                    if (!rmdir($folder)) {
                        throw new GotException('impossible de supprimer le répertoire '.$folder);
                    }
                }
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * réaffecte au fichier de nom $name dans la liste des fichiers chargés avec le chemin $pathFile
     * @param string $name
     * @param string $pathFile
     * @return ODDragNDrop|bool
     */
    public function setLoadedFile(string $name, string $pathFile)
    {
        $properties  = $this->getProperties();
        $loadedFiles = &$properties['loadedFiles'];
        if (file_exists($pathFile)) {
            $key = array_search($name, array_column($loadedFiles, 'name'));
            if ($key !== false) {
                $loadedFiles[$key]['pathFile'] = $pathFile;
                $this->setProperties($properties);
                return $this;
            }
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
        $properties  = $this->getProperties();
        $loadedFiles = $properties['loadedFiles'];
        $key = array_search($name, array_column($loadedFiles, 'name'));
        if ($key !== false) {
            return $loadedFiles[$key];
        }
        return false;
    }

    /**
     * affecte le contenu du tableau $loadedFiles à la liste des fichiers chargés
     * @param array $loadedFiles
     * @return ODDragNDrop|bool
     * @throws GotException
     */
    public function setInitialLoadedFiles(array $loadedFiles)
    {
        $properties = $propertiesOld = $this->getProperties();
        $properties['loadedFiles'] = [];
        $formatedLoadedFiles = [];
        $this->setProperties($properties);
        $valid = true;
        foreach ($loadedFiles as $loadedFile) {
            if (!array_key_exists('name', $loadedFile) || !array_key_exists('pathFile', $loadedFile)) {
                $valid = false;
            }
            if (!$valid) break;
            $valid &= (bool) $this->addLoadedFile($loadedFile['name'], $loadedFile['name'], true, $loadedFile['caption'] ?? '');
        }
        if (!$valid) {
            $this->setProperties($propertiesOld);
            return false;
        }

        $properties['loadedFiles'] = $formatedLoadedFiles;
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
     * affecte après vérification le chemin $tempFolder comme répertoire de sauvegarde temporaire (de travail) des
     * fichiers téléchargés
     * @param string $tempFolder        : chemin du répertoire de sauvegarde temporaire
     * @return ODDragNDrop|bool        : false si le chemin n'exoiste pas
     */
    public function setUploadedFilesPath(string $tempFolder)
    {
        if (file_exists($tempFolder)) {
            $properties = $this->getProperties();
            $properties['uploadedFilesPath'] = $tempFolder;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue le chemin du répertoire de sauvegarde temporaire des fichiers
     * @return bool|string
     */
    public function getUploadedFilesPath()
    {
        $properties = $this->getProperties();
        return (string) $properties['uploadedFilesPath'] ?? false;
    }

    /**
     * @param string $filename
     * @return array
     * @throws GotException
     */
    public function getCompleteUploadedFilesPath($filename = '') {
        $properties = $this->getProperties();
        $id = $this->getId();
        $folderSuffix = '/' . session_id() . '-' . $id . '/';
        $folder = $_SERVER['DOCUMENT_ROOT'].'/'.($properties['uploadedFilesPath'] ?? '') . $folderSuffix;
        error_clear_last();
        if (file_exists($folder)) {
            if (!is_dir($folder)) {
                throw new GotException('Impossible de créer le dossier des fichiers uploadés', 0,
                    (error_get_last() ?? 'Un fichier existe deja a son emplacement'));
            }
        } elseif (@!mkdir($folder, 0777,true)) {
            throw new GotException('Impossible de créer le dossier des fichiers uploadés', 0, error_get_last());
        }
        $completePath = $folder . $filename;
        $url = '/files/' . $filename. '?id='.$id;
        $internal_url = '/odnd_files/' . $folderSuffix . $filename;
        return [$completePath, $url, $internal_url];
    }

    /**
     * @param string $class
     * @param string $method
     * @param bool $stopEvent
     * @return bool|ODDragNDrop
     */
    public function evtUploadFile(string $class, string $method, bool $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('uploadFile', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool|array
     */
    public function getUploadFile()
    {
        return $this->getEvent('uploadFile');
    }

    /**
     * @return bool|ODDragNDrop
     */
    public function disUploadFile()
    {
        return $this->disEvent('uploadFile');

    }

    /**
     * @param string $class
     * @param string $method
     * @param bool $stopEvent
     * @return bool|ODDragNDrop
     */
    public function evtDeleteFile(string $class, string $method, bool $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('deleteFile', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getDeleteFile()
    {
        return $this->getEvent('deleteFile');
    }

    /**
     * @return bool|ODDragNDrop
     */
    public function disDeleteFile()
    {
        return $this->disEvent('deleteFile');

    }

    /**
     * @return array
     */
    public function getUploadedFiles()
    {
        $properties     = $this->getProperties();
        $loadedFiles    = $properties['loadedFiles'];
        $names          = [];

        foreach ($loadedFiles as $name => $infos) {
            if (!$infos['loaded']) { $names[]   = $name; }
        }

        return $names;
    }

    /**
     * @param array $names
     * @return ODDragNDrop|bool
     */
    public function updateLoadedFiles(array $names)
    {
        /** validation de l'existance de tous les noms */
        $properties     = $this->getProperties();
        $loadedFiles    = $properties['loadedFiles'];

        foreach ($names as $name) {
            if (!array_key_exists($name, $loadedFiles)) { return false; }
        }

        foreach ($names as $name) {
            $loadedFiles[$name]['loaded'] = true;
        }
        $properties['loadedFiles']  = $loadedFiles;
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
        $ret    = [];
        $event  = false;
        switch ($params['event']) {

            case 'upload':
                $ret    = array_merge($ret, $this->evtAddFile($sm, $params));
                break;
            case 'delete':
                $ret    = array_merge($ret, $this->evtRmFile($sm, $params));
                break;
            case 'uploadFile':
                $loaded = $this->getUploadedFiles();
                if ($loaded) { $event   = $this->getUploadFile(); }
                break;
            case 'deleteFile':
                $event  = $this->getDeleteFile();
                break;
            default:
                throw new Exception("Une erreur est survenue, l'évènement ".$params['event'].' ne peut être traité');
        }
        if ($event !== false) {
            $class      = (array_key_exists('class', $event)) ? $event['class'] : "";
            $method     = (array_key_exists('method', $event)) ? $event['method'] : "";
            if (!empty($class) && !empty($method)) {
                $callObj = new $class();
                $retCallObj = call_user_func_array([$callObj, $method], [$sm, $params]);
                foreach ($retCallObj as $item) {
                    array_push($ret, $item);
                }
            }
        }
        return $ret;
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
        $uploadInput    = $_FILES[$params['id'].'Input'];
        $uploadFiles    = [];
        $ret            = [];

        foreach ($uploadInput as $key => $inputs) {
            foreach ($inputs as $ind => $input) {
                if (!array_key_exists($ind, $uploadFiles)) { $uploadFiles[$ind] = []; }
                $uploadFiles[$ind][$key] = $input;
            }
        }
        if (!empty($uploadFiles)) {
            if ($this->controlsUploadFiles($uploadFiles)) {
                $loadedPath     = [];
                $loadedPreview  = [];

                /** @var Url $url */
                $url = $sm->get('ControllerPluginManager')->get(Url::class);
                $redirect = $url->fromRoute('gotDispatch');

                foreach ($uploadFiles as $uploadFile) {
                    $name = basename($uploadFile['name']);
                    $hash = sha1(serialize($uploadFile));
                    $fname = uniqid($hash, true).$name;
                    $this->addLoadedFile($fname, $uploadFile['tmp_name'], false, $name);

                    $properties         = $this->getProperties();
                    $loadedPath[]       = end($properties['loadedPaths']);
                    $loadedPreview[]    = end($properties['loadedPreview']);
                    foreach ($loadedPreview as $key => $item) {
                        $loadedPreview[$key]['url'] = $redirect;
                    }
                }
                $this->saveProperties();

                $ret[]  = $this->returnAddUploadedFile($params['id'], $loadedPath, $loadedPreview);
                $ret[]  = self::formatRetour($params['id'], $params['id'], 'nop');
            }
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
        $sessionObjects = self::validateSession();
        $ret            = [];

        /** @var ODDragNDrop $dragNDrop */
        $dragNDrop      = self::buildObject($params['id'], $sessionObjects);
        $fileToDelete   = $params['key'];
        if ($dragNDrop->rmLoadedFile($fileToDelete)) {
            $ret[]  = self::formatRetour($params['id'], $params['id'], 'json', [[]]);
            $ret[]  = self::formatRetour($params['id'], $params['id'], 'nop');
        } else {
            $ret[]  = self::formatRetour($params['id'], $params['id'], 'exec', "alert('Erreur'");
        }
        return $ret;
    }

    /**
     * @param string $objId
     * @param array $previewPath
     * @param array $previewConfig
     * @return array
     */
    public function returnAddUploadedFile(string $objId, array $previewPath, array $previewConfig)
    {
        $item                           = [];
        $item['initialPreview']         = $previewPath;
        $item['initialPreviewConfig']   = $previewConfig;
        $item['append']                 = true;
        return ['idSource'=>$objId, 'idCible'=>$objId, 'mode'=>'json', 'code'=> $item];
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * ***************************************************************************************************/

    /**
     * récupération de l'ensemble des constantes de définition des extensions de fichier autorisées au téléchargement
     * @return array                    : tableau des extensions de fichier autorisées
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
     * @throws ReflectionException
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
            $existsExt              = array_search($ext, $acceptedFiles);
            if ($existsExt !== false) {
                unset($acceptedFiles[$existsExt]);
            }
        }
        return $acceptedFiles;
    }

    /**
     * restitue la chaîne de caractères nature de fichier MIME en fonction de l'extension $ext fournie
     * @param $ext                      : extension de fichier fournie
     * @return bool|string              : restitue la chaine de typde fichier MIME ou false si l'extension n'est pas
     *                                      valide et gérée par le système
     * @throws ReflectionException
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

    /**
     * restitue à partir de la chaîne de caractères nature de fichier MIME l'extension $ext du fichier
     * @param string $mime
     * @return string
     * @throws Exception
     */
    public static function getExtString(string $mime)
    {
        switch ($mime) {
            case "image/svg+xml":
                $ext    = self::EXT_IMAG_SVG;
                break;
            case "text/plain":
                $ext    = self::EXT_WORD_TXT;
                break;
            case "application/msword":
                $ext    = self::EXT_WORD_DOC;
                break;
            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                $ext    = self::EXT_WORD_DOCX;
                break;
            case "application/rtf":
                $ext    = self::EXT_WORD_RTF;
                break;
            case "application/vnd.oasis.opendocument.text":
                $ext    = self::EXT_WORD_ODT;
                break;
            case "application/vnd.ms-excel":
                $ext    = self::EXT_EXCL_XLS;
                break;
            case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                $ext    = self::EXT_EXCL_XLSX;
                break;
            case "application/vnd.oasis.opendocument.spreadsheet":
                $ext    = self::EXT_EXCL_ODS;
                break;
            case "text/csv":
                $ext    = self::EXT_EXCL_CSV;
                break;
            case "application/vnd.ms-powerpoint":
                $ext    = self::EXT_PPTS_PPT;
                break;
            case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
                $ext    = self::EXT_PPTS_PPTX;
                break;
            case "application/vnd.oasis.opendocument.presentation":
                $ext    = self::EXT_PPTS_ODP;
                break;
            case "audio/mpeg":
                $ext    = self::EXT_SNDS_MP3;
                break;
            case "audio/ogg":
                $ext    = self::EXT_SNDS_OGG;
                break;
            case "audio/x-wav":
                $ext    = self::EXT_SNDS_WAV;
                break;
            case "video/mp4":
                $ext    = self::EXT_VDEO_MP4;
                break;
            case "video/x-matroska":
                $ext    = self::EXT_VDEO_MKV;
                break;
            case "video/ogg":
                $ext    = self::EXT_VDEO_OGV;
                break;
            case "application/pdf":
                $ext    = self::EXT_DOCS_PDF;
                break;
            case "application/epub+zip":
                $ext    = self::EXT_DOCS_EPUB;
                break;
            case "application/zip":
                $ext    = self::EXT_ARCH_ZIP;
                break;
            case "application/x-tar":
                $ext    = self::EXT_ARCH_TAR;
                break;
            case "application/octet-stream":
                $ext    = self::EXT_ARCH_GZ;
                break;
            default:
                if (strpos($mime, 'image/') === 0) {
                    $ext    = substr($mime, 6);
                } else {
                    throw new \Exception("chaîne MIME inconnue: $mime, veuillez en avertir l'administrateur");
                }
        }

        return $ext;
    }

    /**
     * @param array $uploadedFiles
     * @return bool
     * @throws Exception
     */
    private function controlsUploadFiles(array $uploadedFiles)
    {
        $check = true;
        $authorizedExt  = $this->getAcceptedFiles();

        foreach ($uploadedFiles as $uploadedFile) {
            $extFile    = self::getExtString($uploadedFile['type']);
            if (!in_array($extFile, $authorizedExt)) {
                $check  = false;
                break;
            }
        }

        return $check;
    }

    private function getTypeFromMime(string $mime)
    {
        $type   = '';
        $videos = $this->getVideoExtensionConstant();
        $texts  = [self::EXT_WORD_TXT, self::EXT_WORD_RTF];
        $office = array_merge($this->getWordExtensionConstant(), $this->getExcelExtensionConstant(),
            $this->getPresentationExtensionConstant());
        $archiv = $this->getArchiveExtensionConstant();
        $sounds = $this->getSoundExtensionConstant();
        switch (true) {
            case (strpos($mime, 'image') === 0):
                $type   = 'image';
                break;
            case (strtolower(self::getExtString($mime)) === self::EXT_DOCS_PDF):
                $type   = 'pdf';
                break;
            case (strtolower(self::getExtString($mime)) === self::EXT_DOCS_EPUB):
                $type   = 'epub';
                break;
            case (strtolower(self::getExtString($mime)) === self::EXT_DOCS_HTML):
                $type   = 'html';
                break;
            case (in_array(self::getExtString($mime), $texts)):
                $type = 'text';
                break;
            case (in_array(self::getExtString($mime), $office)):
                $type = 'office';
                break;
            case (in_array(self::getExtString($mime), $videos)):
                $type = 'video';
                break;
            case (in_array(self::getExtString($mime), $archiv)):
                $type = 'zip';
                break;
            case (in_array(self::getExtString($mime), $sounds)):
                $type = 'sound';
                break;
        }
        return $type;
    }
}