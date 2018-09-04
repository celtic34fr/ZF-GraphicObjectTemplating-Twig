<?php

namespace ZF3_GOT\TwigExtensions\Node;

//To be added under Twig/Node/Switch.php

/*
 * This file is part of Twig.
 *
 * (c) 2009 Fabien Potencier
 * (c) 2009 Armin Ronacher
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * refused in legal Twig version
 */
use Twig_Compiler;
use Twig_Node;

/**
 * Represents an if node.
 *
 * @package    twig
 * @author     Dsls
 * @author     maxgalbu
 */
class NodeSwitch extends Twig_Node
{
    public function __construct($value, Twig_Node $cases, $default = null, $lineno, $tag = null)
    {
        parent::__construct(array('value' => $value, 'cases' => $cases, 'default' => $default), array(), $lineno, $tag);
    }

    /**
     * Compiles the node to PHP.
     *
     * @param Twig_Compiler A Twig_Compiler instance
     */
    public function compile(Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);
        $compiler
            ->write("switch (")
            ->subcompile($this->getNode('value'))
            ->raw(") {\n")
//            ->indent
        ;
        for ($i = 0; $i < count($this->getNode('cases')); $i += 2) {
            $compiler
                ->write('case ')
                ->subcompile($this->getNode('cases')->getNode($i))
                ->raw(":\n")
                ->indent()
                ->subcompile($this->getNode('cases')->getNode($i + 1))
                ->indent()
                ->raw("break;\n")
            ;
        }

        if ($this->hasNode('default') && null !== $this->getNode('default')) {
            $compiler
                ->write("default:\n")
                ->indent()
                ->subcompile($this->getNode('default'))
                ->indent()
                ->raw("break;\n")
            ;
        }

        $compiler
            ->outdent()
            ->write("}\n");
    }
}