<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

class ODCaptcha extends ODContained
{
    const BASE_CARACTERS_ALPHAUP    = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const BASE_CARACTERS_ALPAHDW    = 'abcdefghijklmnopqrstuvwxyz';
    const BASE_CARACTERS_NUMERIC    = '0123456789';
    const BASE_CARACTERS_SIGNES     = "?!§!&#@£$";

    private $const_baseCaracters;

    /**
     * ODCaptcha constructor.
     * @param $id
     * @throws \ReflectionException
     */
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/odcaptcha/odcaptcha.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            if (!$this->getWidthBT() || empty($this->getWidthBT())) {
                $this->setWidthBT(12);
            }
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

    /**
     * @param $baseLength
     * @return $this|bool
     */
    public function setBaseLength($baseLength)
    {
        $baseLength = (int) $baseLength;
        if ($baseLength > 0) {
            $properties = $this->getProperties();
            $properties['baseLength']   = $baseLength;

            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getBaseLength()
    {
        $properties = $this->getProperties();
        return array_key_exists('baseLength', $properties) ? $properties['baseLength'] : false;
    }

    /**
     * @param string $baseCaracters
     * @return $this
     * @throws \ReflectionException
     */
    public function setBaseCaracters($baseCaracters = self::BASE_CARACTERS_ALPHAUP)
    {
        $baseCaracters  = (string) $baseCaracters;
        $basesCaracters = $this->getBaseCaractersConstants();
        if (!in_array($baseCaracters, $basesCaracters)) { $baseCaracters = self::BASE_CARACTERS_ALPHAUP; }

        $properties = $this->getProperties();
        $properties['baseCaracters']   = $baseCaracters;

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $baseCaracters
     * @return $this|bool
     * @throws \ReflectionException
     */
    public function addBaseCaracters($baseCaracters = self::BASE_CARACTERS_ALPHAUP)
    {
        $baseCaracters  = (string) $baseCaracters;
        $basesCaracters = $this->getBaseCaractersConstants();
        if (!in_array($baseCaracters, $basesCaracters)) { $baseCaracters = self::BASE_CARACTERS_ALPHAUP; }

        $properties = $this->getProperties();
        $saveBaseCaracters  = $properties['baseCaracters'];
        if (!strpos($saveBaseCaracters, $baseCaracters)) {
            $baseCaracters .= $saveBaseCaracters;
            $properties['baseCaracters']   = $baseCaracters;

            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getBaseCaracters()
    {
        $properties = $this->getProperties();
        return array_key_exists('baseCaracters', $properties) ? $properties['baseCaracters'] : false;
    }

    /**
     * @param null $generatedString
     * @return $this
     */
    public function setGeneratedString($generatedString = null)
    {
        if (empty($generatedString)) {
            $generatedString = $this->generateString();
        } else {
            $properties = $this->getProperties();
            $properties['generatedString']   = $generatedString;
            $this->setProperties($properties);
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getGeneratedString()
    {
        $properties = $this->getProperties();
        return array_key_exists('generatedString', $properties) ? $properties['generatedString'] : false;
    }

    /**
     * @param $imgWidth
     * @return $this|bool
     */
    public function setImgWidth($imgWidth)
    {
        $imgWidth   = (string) $imgWidth;
        if ((int) $imgWidth > 0 ) {
            $properties = $this->getProperties();
            $properties['imgWidth']   = $imgWidth;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getImgWidth()
    {
        $properties = $this->getProperties();
        return array_key_exists('imgWidth', $properties) ? $properties['imgWidth'] : false;
    }

    /**
     * @param $imgHeight
     * @return $this|bool
     */
    public function setImgHeight($imgHeight)
    {
        $imgHeight  = (string) $imgHeight;
        if ((int) $imgHeight > 0 ) {
            $properties = $this->getProperties();
            $properties['imgHeight']   = $imgHeight;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getImgHeight()
    {
        $properties = $this->getProperties();
        return array_key_exists('imgHeight', $properties) ? $properties['imgHeight'] : false;
    }

    /**
     * @param array $fonts
     * @return $this
     */
    public function setFonts(array $fonts)
    {
        $properties = $this->getProperties();
        $properties['fonts']   = $fonts;
        $this->setProperties($properties);
        return $this;
    }

    public function getFonts()
    {
        $properties = $this->getProperties();
        return array_key_exists('fonts', $properties) ? $properties['fonts'] : false;
    }

    /**
     * @param $name
     * @param $pathAbs
     * @return $this|bool
     */
    public function setFont($name, $pathAbs)
    {
        $name       = (string) $name;
        $pathAbs    = (string) $pathAbs;
        if (file_exists($pathAbs)) {
            $properties = $this->getProperties();
            $fonts      = $properties['fonts'];
            if (array_key_exists($name, $fonts)) {
                $fonts[$name] = $pathAbs;
                $properties['fonts']   = $fonts;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param $name
     * @param $pathAbs
     * @return $this|bool
     */
    public function addFont($name, $pathAbs)
    {
        $name       = (string) $name;
        $pathAbs    = (string) $pathAbs;
        if (file_exists($pathAbs)) {
            $properties = $this->getProperties();
            $fonts      = $properties['fonts'];
            if (!array_key_exists($name, $fonts)) {
                $fonts[$name] = $pathAbs;
                $properties['fonts']   = $fonts;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function initFonts()
    {
        $properties = $this->getProperties();

        $fonts      = [];
        $fonts['icomoon']       = __DIR__.'/../../../public/fonts/icomoon.ttf';
        $fonts['fontawesome']   = __DIR__.'/../../../public/fonts/fontawesome-webfont.ttf';
        $properties['fonts']    = $fonts;

        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getBaseCaractersConstants()
    {
        $retour = [];
        if (empty($this->const_baseCaracters)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'BASE_CARACTERS_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_baseCaracters = $retour;
        } else {
            $retour = $this->const_baseCaracters;
        }
        return $retour;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    public function generateString()
    {
        $strRet = "";
        $baseCaracters          = $this->getBaseCaracters();
        $baseCaractersLength    = strlen($baseCaracters);
        $baseLength             = (int) $this->getBaseLength();

        for ($ind = 0; $ind < $baseLength; $ind++) {
            $rndCar = $baseCaracters[mt_rand(0, $baseCaractersLength - 1)];
            $strRet .= $rndCar;
        }

        $properties = $this->getProperties();
        $properties['generatedString']   = $strRet;
        $this->setProperties($properties);

        return $strRet;
    }

    /**
     * @return string
     */
    public function generateCaptcha()
    {
        $width  = $this->getImgWidth();
        $height = $this->getImgHeight();

        $image  = imagecreatetruecolor((int)$width, (int)$height);
        imageantialias($image, true);

        $colors = [];
        $red    = rand(125, 175);
        $green  = rand(125, 175);
        $blue   = rand(125, 175);
        for ($ind = 0; $ind < 5; $ind++) {
            $colors[]   = imagecolorallocate($image, $red - 20*$ind, $green - 20*$ind, $blue - 20*$ind);
        }
        imagefill($image, 0,0, $colors[0]);
        for ($ind = 0; $ind < 10; $ind++) {
            imagesetthickness($image, rand(2, 10));
            $rect_color = $colors[rand(1, 4)];
            imagerectangle($image, rand(-10, 190), rand(-10, 10), rand(-10, 190), rand(40, 60), $rect_color);
        }

        $black      = imagecolorallocate($image, 0,0, 0);
        $white      = imagecolorallocate($image, 255,255, 255);
        $textColors = [$black, $white];
        $fonts      = $this->getFonts();

        $captcha_string = $this->getGeneratedString();
        $letter_space   = 170 / strlen($captcha_string);
        $initial        = 15;

        for ($ind = 0; $ind < strlen($captcha_string); $ind++) {
            imagettftext($image, 20, rand(-15, 15), $initial + $ind*$letter_space, rand(20, 40),
                $textColors[rand(0, 1)], $fonts[array_rand($fonts)], $captcha_string[$ind]);
        }

        ob_start();
        imagepng($image);
        $image_data = "data:image/png;base64," . base64_encode(ob_get_clean());
        imagedestroy($image);

        $properties = $this->getProperties();
        $properties['generatedCaptcha']   = $image_data;
        $this->setProperties($properties);

        return $image_data;
    }
}