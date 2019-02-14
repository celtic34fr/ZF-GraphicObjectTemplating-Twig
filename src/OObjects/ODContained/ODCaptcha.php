<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

class ODCaptcha extends ODContained
{
    const BASE_CARACTERS_ALPHAUP    = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const BASE_CARACTERS_ALPAHDW    = 'abcdefghijklmnopqrstuvwxyz';
    const BASE_CARACTERS_NUMERIC    = '0123456789';
//    const BASE_CARACTERS_SIGNES     = "?!§!&#@£$";

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
        $imgWidth   = (int) $imgWidth;
        if ($imgWidth > 0 ) {
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
        $imgHeight  = (int) $imgHeight;
        if ($imgHeight > 0 ) {
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

    public function setCharSize($charSize)
    {
        $charSize  = (string) $charSize;
        if ((int) $charSize > 0 ) {
            $properties = $this->getProperties();
            $properties['charSize']   = $charSize;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getCharSize()
    {
        $properties = $this->getProperties();
        return array_key_exists('charSize', $properties) ? $properties['charSize'] : false;
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

    public function getFont($name)
    {
        $name       = (string) $name;
        $properties = $this->getProperties();
        $fonts      = $properties['fonts'];
        if (array_key_exists($name, $fonts)) {
            return $fonts[$name];
        }
        return false;
    }

    public function initFonts()
    {
        $properties = $this->getProperties();

        $fonts      = [];
        $fonts      = [ 'Cookie'                => __DIR__.'/../../../public/fonts/Cookie-Regular.ttf',
                        'EuropeanTypewriter'    => __DIR__.'/../../../public/fonts/EuropeanTypewriter.ttf'
                      ];

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
        $size   = $this->getCharSize();
        $fonts  = $this->getFonts();

        $image  = imagecreatetruecolor($width, $height);
        imageantialias($image, true);

        $colors = [];
        $red    = rand(100, 200);
        $green  = rand(100, 200);
        $blue   = rand(100, 200);
        for ($ind = 0; $ind < 5; $ind++) {
            $colors[]   = imagecolorallocate($image, $red - 20*$ind, $green - 20*$ind, $blue - 20*$ind);
        }
        imagefill($image, 0,0, $colors[0]);
        for ($ind = 0; $ind < 10; $ind++) {
            imagesetthickness($image, rand(2, 10));
            $rect_color = $colors[rand(1, 4)];
            imagerectangle($image, rand(-10, $width - 10), rand(-10, 10), rand(-10, $width - 10), rand($height - 10, $height + 10), $rect_color);
        }

        $blackImg   = imagecolorallocate($image, 0,0, 0);
        $whiteImg   = imagecolorallocate($image, 255,255, 255);
        $redImg     = imagecolorallocate($image, 96,16, 16);
        $greenImg   = imagecolorallocate($image, 16,96, 16);
        $blueImg    = imagecolorallocate($image, 16,16, 96);
        $textColors = [$blackImg, $redImg, $greenImg, $blueImg, $whiteImg];

        $captcha_string = $this->getGeneratedString();
        $letter_space   = ($width - $size) / strlen($captcha_string);
        $initial        = 15;

        for ($ind = 0; $ind < strlen($captcha_string); $ind++) {
            $angle      = rand(-15, 15);
            $x          = $initial + $ind*$letter_space;
            $y          = rand($height - 30, $height - 10);
            $color      = $textColors[rand(0, sizeof($textColors) - 1)];
            $fontfile   = $fonts[array_rand($fonts)];
            $text       = $captcha_string[$ind];
            $ret        = imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);

            $angle      = rand(-15, 15);
            $y          = rand($height - 30, $height - 10);
            $color      = $textColors[rand(0, sizeof($textColors) - 1)];
            $fontfile   = $fonts[array_rand($fonts)];
            $ret        = imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
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