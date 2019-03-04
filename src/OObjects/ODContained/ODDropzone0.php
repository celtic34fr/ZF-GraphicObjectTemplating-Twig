<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODDropzone
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * getUploadFiles()
 * getFiles()
 */
class ODDropzone0 extends ODContained
{
    /**
     * ODDropzone constructor.
     * @param $id
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/oddropzone0/oddropzone0.config.php");
        $this->setDisplay();
    }

    /**
     * méthode getUploadFiles()
     * getFiles restitue l'objet files (type Config) contenu dans Properties
     * contenant le fichier téléchargé
     * @return |null
     */
    public function getUploadFiles()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['files'])) ? $properties['files'] : null);
    }

    /**
     * méthode getFiles()
     * getFiles restitue l'objet loadedFiles (type Config) contenu dans Properties
     * contenant les fichiers ayant été téléchargés et validés
     * @return array
     */
    public function getFiles()
    {
        $properties = $this->getProperties();
        $loadedFiles = $properties['loadedFiles'];
        if (empty($loadedFiles)) $loadedFiles = [];
        return $loadedFiles;
    }

    /**
     * méthode addFile($name, $idBlob)
     * ajout d'un fichier à la liste des fichier chargés
     * on part du principe que le dit fichier a été transféré dans le répertoire
     * public/data
     *
     * @param $name : nom du fichier
     * @param $idBlob
     * @return ODDropzone0
     */
    public function addFile($name, $idBlob)
    {
        $properties = $this->getProperties();

        $helper = $this->getServiceLocator()->get('ViewHelperManager')->get('ServerUrl');
        $url = $helper("/gestionStock/Index/loadBlob/" . $idBlob . '?r=1');
        $arFile = [];

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $linuxBlob = $em->getRepository("Application\Entity\LinuxBlob")->find($idBlob);
        $size = strlen($linuxBlob->getBinaryBlob());
        $ext = $linuxBlob->getExtension();
        $mine = "mime_" . $ext;

        $type = defined("Application\Entity\LinuxBlob::$mine") ? constant('Application\Entity\LinuxBlob::' . $mine) : "text/plain";

        $arFile[] = array(
            "idBlob" => "$idBlob",
            "blob" => "$idBlob",//utile ?? à virer
            "name" => "$name",
            "type" => $type,
            "size" => $size,
            "url" => $url);
        $loadedFiles = $properties['loadedFiles'];
        if (empty($loadedFiles)) {
            $properties['loadedFiles'] = $arFile;
        } else {
            $pro['loadedFiles'] = array_merge($properties['loadedFiles'], $arFile);
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode addUploadFiles()
     * méthode d'ajout direct en base des ou du fichier upload
     *
     * @return array
     * @throws \Exception
     */
    public function addUploadFiles()
    {
        $uploadedFiles = $this->getUploadFiles();

        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $helper = $this->getServiceLocator()->get('ViewHelperManager')->get('ServerUrl');
        $addedFile = [];

        $properties = $this->getProperties();
        foreach ($uploadedFiles as $key => $uploadedFile) {
            $nom = $uploadedFile['name'];
            $path = $uploadedFile['tmp_name'];
            var_dump($nom, $path);
            $size = $uploadedFile['size'];
            $type = $uploadedFile['type'];
            $error = $uploadedFile['error'];

            if ($error == "0") {
                if ($key != 'fileName') {
                    // var_dump($uploadedFile);
                    $fileContent = file_get_contents($path);

                    $ext = "extention_" . strtolower(pathinfo($nom, PATHINFO_EXTENSION));
                    $ext = constant("Application\Entity\LinuxBlob::" . $ext);

                    $blob = new LinuxBlob();
                    $blob->setExtension($ext);
                    $blob->setCompression(LinuxBlob::compress_none);
                    $blob->setBinaryBlob($fileContent);
                    $blob->setMd5(md5($fileContent));
                    $dateInsert = new \DateTime("now");
                    $blob->setDateInsert($dateInsert);
                    $em->persist($blob);
                    $em->flush();
//                var_dump($blob);

                    $idBlob = $blob->getId();
                    $url = $helper("/gestionStock/Index/loadBlob/" . $idBlob . '?r=1');
                    $item = [];
                    $item['name'] = $nom;
                    $item['size'] = $size;
                    $item['type'] = $type;
                    $item['idBlob'] = $idBlob;
                    $item['url'] = $url;
                    $addedFile[] = $item;

                    unset($properties['files'][$key]);
                }
            }
        }

        $properties['loadedFiles'] = array_merge($properties['loadedFiles'], $addedFile);
        $this->setProperties($properties);
        $this->toSession();
        return $addedFile;
    }

    /**
     * méthode setFiles(array $loadedFiles)
     * méthode faisant l'affectation des fichiers déjà sur le serveur à présenter à l'écran
     *
     * @param array $loadedFiles
     * @return ODDropzone0
     */
    public function setFiles(array $loadedFiles)
    {
        $properties = $this->getProperties();
        $properties['loadedFiles'] = $loadedFiles;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode clearFiles()
     * méthode supprimant toute référence à un fichier déjà présent sur le serveur
     *
     * @return $this
     */
    public function clearFiles()
    {
        $properties = $this->getProperties();
        $properties['loadedFiles'] = [];
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode FileSizeConvert($filename)
     * méthode visant à réstituer dans un format exploitable
     *
     * @param $filename
     * @return float|string
     */
    public function FileSizeConvert($filename)
    {
        $bytes = filesize($filename);
        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

    /**
     * filtre pour le choix des fichier à uploader avec DROPZONE
     *
     * name : nom donné au filtre et clé d'accès de la valeur de ce dernier dans le tableau filters
     * filter : valeur du filtre par lui-même
     *      on peut avoir comme valeurs des estensions : .PDF, .JPG, ...
     *      ou directement des types de fichiers : application/pdf, image/* (toutes les images)
     */

    /**
     * méthode getFilters()
     * méthode restituant l'ensemble des filtres (fichiers autorisés)
     *
     * @return array (filters)
     */
    public function getFilters()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['filters'])) ? $properties['filters'] : array());
    }

    /**
     * méthode getFilter($name)
     * méthode récupérant la valeur de filtre ayant pour clé $name
     *
     * @param $name nom du filtre
     * @return bool/string : faux/valeur du filtre trouvée
     */
    public function getFilter(string $name)
    {
        $properties = $this->getProperties();
        $filters = $properties['filters'];
        if (array_key_exists($name, $filters)) {
            return $filters[$name];
        }
        return false;
    }

    /**
     * méthode addFilter($name, $filter)
     * méthode d'ajout de filtre ayant pour clé d'accès $name, et valeur $filter
     *
     * @param $name     nom du filtre
     * @param $filter   valeur du filtre
     * @return bool     VRAI (jaout fait) / FAUX (valeur existante erreur)
     */
    public function addFilter($name, $filter)
    {
        $name = (string)$name;
        $filter = (string)$filter;

        $properties = $this->getProperties();
        $filters = $properties['filters'];

        if (!array_key_exists($name, $filters)) {
            $filters[$name] = $filter;

            $properties['filters'] = $filters;
            $this->setProperties($properties);
            return true;
        }
        return false;
    }

    /**
     * méthode rmFilter($name)
     * méthode visant à supprimer de l'ensemble des filtres celui dont la clé d'accès est $name
     *
     * @param $name     nom du filtre à supprimer
     * @return bool     VRAI (suppression réalisée) / FAUX (name inexistant)
     */
    public function rmFilter($name)
    {
        $name = (string)$name;

        $properties = $this->getProperties();
        $filters = $properties['filters'];
        if (array_key_exists($name, $filters)) {
            unset($filters[$name]);

            $properties['filters'] = $filters;
            $this->setProperties($properties);
            return true;
        }
        return false;
    }

    /**
     * méthode setFilters(array $filters)
     * méthode d'affectation globale des filtres actif via un tableau $filters
     *
     * @param array $filters (tableau forme clé (nom filtre) => valeur (filtre)
     * @return ODDropzone0
     */
    public function setFilters(array $filters)
    {
        $properties = $this->getProperties();
        $properties['filters'] = $filters;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode setFilter($name, $filter)
     * méthode visant à créer ou modifier le filtre de clé d'accès $name avec la valeur $filter
     *
     * @param $name     nom du filtre
     * @param $filter   valeur du filtre
     *
     * si le filtre n'existe pas, il est obligatoirement ajouté
     * @return ODDropzone0
     */
    public function setFilter($name, $filter)
    {
        $name = (string)$name;
        $filter = (string)$filter;

        $properties = $this->getProperties();
        $filters = $properties['filters'];

        $filters[$name] = $filter;

        $properties['filters'] = $filters;
        $this->setProperties($properties);

        return $this;
    }

    /**
     * méthode getSelected()
     * méthode visant à restituer le fichier choisi sur l'interface dans le cadre de sa suppression
     * via la méthode delFile($name)
     *
     * @return mixed
     */
    public function getSelected()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['selected'])) ? $properties['selected'] : null);
    }

    /**
     * @return $this
     */
    public function enableView()
    {
        $properties = $this->getProperties();
        $properties['view'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disableView()
    {
        $properties = $this->getProperties();
        $properties['view'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function enableDownload()
    {
        $properties = $this->getProperties();
        $properties['download'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disableDownload()
    {
        $properties = $this->getProperties();
        $properties['download'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function enableRemove()
    {
        $properties = $this->getProperties();
        $properties['remove'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disableRemove()
    {
        $properties = $this->getProperties();
        $properties['remove'] = false;
        $this->setProperties($properties);
        return $this;
    }
}