<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained\ODTextarea;

/**
 * Class ODTinyMCE
 * @package ZF3_GOT\OObjects\ODContained
 *
 * addPlugin($plugin)
 * setPlugins($plugins)
 * rmPlugin($plugin)
 * getPlugins()
 * addtoolbarItem($toolbarItem)
 * setToolbar($toolbar)
 * rmToolbarItme($toolbarItem)
 * getToolbar()
 * setImageListUrl(string $imageLisrtUrl)
 * getImageListUrl()
 * setLinkListUrl(string $linkListUrl)
 * getLinkListUrl()
 */
class ODTinyMCE extends ODTextarea
{
    const PLUGIN_ADVLIST        = 'advlist';
    const PLUGIN_ANCHOR         = 'anchor';
    const PLUGIN_AUTOLINK       = 'autolink';
    const PLUGIN_AUTOSAVE       = 'autosave';
    const PLUGIN_CHARMAP        = 'charmap';
    const PLUGIN_CODESAMPLE     = 'codesample';
    const PLUGIN_CONTEXTMENU    = 'contextmenu';
    const PLUGIN_EMOTICONS      = 'emoticons';
    const PLUGIN_FULLSCREEN     = 'fullscreen';
    const PLUGIN_HR             = 'hr';
    const PLUGIN_IMAGETOOLS     = 'imagetools';
    const PLUGIN_INSERTDATETIME = 'insertdatetime';
    const PLUGIN_LINK           = 'link';
    const PLUGIN_MEDIA          = 'media';
    const PLUGIN_NONEDITABLE    = 'noneditable';
    const PLUGIN_PASTE          = 'paste';
    const PLUGIN_PRINT          = 'print';
    const PLUGIN_SAVE           = 'save';
    const PLUGIN_SPELLCHECKER   = 'spellchecker';
    const PLUGIN_TABLE          = 'table';
    const PLUGIN_TEXTCOLOR      = 'textcolor';
    const PLUGIN_TOC            = 'toc';
    const PLUGIN_VISUALCHARS    = 'visualchars';
    const PLUGIN_AUTORESIZE     = 'autoresize';
    const PLUGIN_BBCODE         = 'bbcode';
    const PLUGIN_CODE           = 'code';
    const PLUGIN_COLORPICKER    = 'colorpicker';
    const PLUGIN_DIRECTIONALITY = 'directionality';
    const PLUGIN_FULLPAGE       = 'fullpage';
    const PLUGIN_HELP           = 'help';
    const PLUGIN_IMAGE          = 'image';
    const PLUGIN_IMPORTCSS      = 'importcss';
    const PLUGIN_LEGACYOUTPUT   = 'legacyoutput';
    const PLUGIN_LISTS          = 'lists';
    const PLUGIN_NONBREAKING    = 'nonbreaking';
    const PLUGIN_PAGEBREAK      = 'pagebreak';
    const PLUGIN_PREVIEW        = 'preview';
    const PLUGIN_QUICKBARS      = 'quickbars';
    const PLUGIN_SEARCHREPLACE  = 'searchreplace';
    const PLUGIN_TABFOCUS       = 'tabfocus';
    const PLUGIN_TEMPLATE       = 'template';
    const PLUGIN_TEXTPATTERN    = 'textpattern';
    const PLUGIN_VISUALBLOCKS   = 'visualblocks';
    const PLUGIN_WORDCOUNT      = 'wordcount';

    const TOOLBAR_INSERTFILE    = "insertfile";
    const TOOLBAR_UNDO          = "undo";
    const TOOLBAR_REDO          = "redo";
    const TOOLBAR_SEPARATOR     = " | ";
    const TOOLBAR_STYLESELECT   = "styleselect";
    const TOOLBAR_BOLD          = "bold";
    const TOOLBAR_ITALIC        = "italic";
    const TOOLBAR_FORCOLOR      = "forecolor";
    const TOOLBAR_BACKCOLOR     = "backcolor";
    const TOOLBAR_ALIGNLEFT     = "alignleft";
    const TOOLBAR_ALIGNCENTER   = "aligncenter";
    const TOOLBAR_ALIGNRIGHT    = "alignright";
    const TOOLBAR_ALIGNJUSTIFY  = "alignjustify";
    const TOOLBAR_LINK          = "link";
    const TOOLBAR_IMAGE         = "image";
    const TOOLBAR_MEDIA         = "media";
    const TOOLBAR_TABLE         = "table";
    const TOOLBAR_NUMLIST       = "numlist";
    const TOOLBAR_BULLLIST      = "bullist";
    const TOOLBAR_OUTDENT       = "outdent";
    const TOOLBAR_IDENT         = "indent";
    const TOOLBAR_REMOVEFORMAT  = "removeformat";

    private $const_plugin;
    private $const_toolbar;

    /**
     * ODTinyMCE constructor.
     * @param $id
     * @throws \ReflectionException
     */
    public function __construct(string $id, array $pathObjArray = []) {
        parent::__construct($id, $pathObjArray);

        $properties = $this->getProperties();
        $properties['wysiwyg'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $plugin
     * @return bool|ODTinyMCE
     * @throws \ReflectionException
     */
    public function addPlugin(string $plugin)
    {
        $properties = $this->getProperties();
        $plugins    = $properties['plugins'];
        $pluginsCte = $this->getPluginsConstants();
        if (strpos($plugin, ' ') === false || in_array($plugin, $pluginsCte)) {
            if (!strpos($plugins, $plugin)) {
                $plugins .= $plugin." ";
                $properties['plugins'] = $plugins;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param string|array $plugins
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function setPlugins($plugins)
    {
        if (is_string($plugins)) {
            $pluginsTab = explode(' ', $plugins);
        } elseif (is_array($plugins)) {
            $pluginsTab = $plugins;
            $plugins    = implode(' ', $plugins);
        } else { return false; }
        if (count(array_unique($pluginsTab))<count($pluginsTab)) { return false; }

        $pluginsCte = $this->getPluginsConstants();
        foreach ($pluginsTab as $plugin) {
            if (!in_array($plugin, $pluginsCte)) { return false; }
        }
        $properties = $this->getProperties();
        $properties['plugins'] = $plugins;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $plugin
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function rmPlugin(string $plugin)
    {
        $pluginsCte = $this->getPluginsConstants();
        if (in_array($plugin, $pluginsCte)) {
            $properties = $this->getProperties();
            $plugins    = $properties['plugins'];
            $posPlugin  = strpos($plugins, $plugin);
            if ($posPlugin !== false) {
                $plugins                =
                    substr($plugins, 0, $posPlugin).substr($plugins, $posPlugin + strlen($plugin) + 1);
                $properties['plugins']  = $plugins;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getPlugins()
    {
        $properties                = $this->getProperties();
        return ((!empty($properties['plugins'])) ? $properties['plugins'] : false) ;
    }

    /**
     * @param string $toolbarItem
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function addtoolbarItem(string $toolbarItem)
    {
        $properties = $this->getProperties();
        $toolbar    = $properties['toolbar'];
        $toolbarCte = $this->getToolbarConstants();
        if (strpos($toolbar, ' ') === false || in_array($toolbar, $toolbarCte)) {
            if (!strpos($toolbar, $toolbar)) {
                $toolbar .= $toolbarItem." ";
                $properties['toolbar'] = $toolbar;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param string|array $plugins
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function setToolbar($toolbar)
    {
        if (is_string($toolbar)) {
            $toolbarTab = explode(' ', $toolbar);
        } elseif (is_array($toolbar)) {
            $toolbarTab = $toolbar;
            $toolbar    = implode(' ', $toolbar);
        } else { return false; }
        $countToolbarItme   = count(array_unique($toolbarTab)) + substr_count($toolbar, '|') - 1;
        $countToolbar       = count($toolbarTab);
        if ($countToolbarItme < $countToolbar) { return false; }

        $toolbarCte = $this->getToolbarConstants();
        foreach ($toolbarTab as $toolbarItem) {
            if (!in_array($toolbarItem, $toolbarCte)) { return false; }
        }
        $properties = $this->getProperties();
        $properties['toolbar'] = $toolbar;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $toolbar
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function rmToolbar(string $toolbarItem)
    {
        $toolbarCte = $this->getPluginsConstants();
        if (in_array($toolbarItem, $toolbarCte)) {
            $properties = $this->getProperties();
            $toolbar    = $properties['toolbar'];
            $posToolbar  = strpos($toolbar, $toolbarItem);
            if ($posToolbar !== false) {
                $plugins                =
                    substr($toolbar, 0, $posToolbar).substr($toolbar, $posToolbar+ strlen($toolbarItem) + 1);
                $properties['toolbar']  = $toolbar;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getToolbar()
    {
        $properties                = $this->getProperties();
        return ((!empty($properties['toolbar'])) ? $properties['toolbar'] : false) ;
    }

    /**
     * @param string $imageListUrl
     * @return $this
     */
    public function setImageListUrl(string $imageListUrl)
    {
        $properties                 = $this->getProperties();
        $properties['imgListUrl']   = $imageListUrl;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getImageListUrl()
    {
        $properties                = $this->getProperties();
        return ((!empty($properties['imgListUrl'])) ? $properties['imgListUrl'] : false) ;
    }

    /**
     * @param string $linkListUrl
     * @return $this
     */
    public function setLinkListUrl(string $linkListUrl)
    {
        $properties                 = $this->getProperties();
        $properties['lnkListUrl']   = $linkListUrl;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getLinkListUrl()
    {
        $properties                = $this->getProperties();
        return ((!empty($properties['lnkListUrl'])) ? $properties['lnkListUrl'] : false) ;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getPluginsConstants()
    {
        $retour = [];
        if (empty($this->const_plugin)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'PLUGIN_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_plugin = $retour;
        } else {
            $retour = $this->const_plugin;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getToolbarConstants()
    {
        $retour = [];
        if (empty($this->const_toolbar)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'TOOLBAR_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_toolbar= $retour;
        } else {
            $retour = $this->const_toolbar;
        }
        return $retour;
    }
}