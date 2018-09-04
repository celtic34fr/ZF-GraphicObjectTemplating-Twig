<?php

namespace GraphicObjectTemplating\TwigExtensions;

use GraphicObjectTemplating\TwigExtensions\TokenParser\TokenParserSwitch;

class SwitchExtension extends \Twig_Extension
{

    public function getTokenParsers()
    {
        return array(
            new TokenParserSwitch(), // unaccepted token (fabpot) update maxgalbu to work with Twig >= 1.12
        );
    }

    public function getName()
    {
        return 'switch_extension';
    }
}