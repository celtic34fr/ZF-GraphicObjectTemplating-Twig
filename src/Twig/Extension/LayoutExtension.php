<?php

namespace GraphicObjectTemplating\Twig\Extension;

use Exception;
use Traversable;
use Twig_Error_Runtime;
use Twig_Filter;
use Twig_Function;
use Twig_Test;

class LayoutExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new Twig_Function('getclass', array($this, 'twigFunction_getClass'), array('is_safe' => array('html'))),
            new Twig_Function('gettype', array($this, 'twigFunction_getType'), array('is_safe' => array('html'))),
            new Twig_Function('arrayexception', array($this, 'twigFunction_arrayException'), array('is_safe' => array('html'))),
            new Twig_Function('checkBoolean', array($this, 'twigFunction_isBoolean'), array('is_safe' => array('html'))), // KALANTwigExtension @author LAURE
            new Twig_Function('substr', array($this, 'twigFunction_subString'), array('is_safe' => array('html'))),
            new Twig_Function('strpos', array($this, 'twigFunction_strPos'), array('is_safe' => array('html'))),
            new Twig_Function('instring', array($this, 'twigFunction_inString'), array('is_safe' => array('html'))),
        );
    }


    public function getGlobals()
    {
        return [
            'ERROR_CONTROLLER_CANNOT_DISPATCH' => 'error-controller-cannot-dispatch',
            'ERROR_CONTROLLER_NOT_FOUND' => 'error-controller-not-found',
            'ERROR_CONTROLLER_INVALID' => 'error-controller-invalid',
            'ERROR_EXCEPTION' => 'error-exception',
            'ERROR_ROUTER_NO_MATCH' => 'error-router-no-match',
            'ERROR_MIDDLEWARE_CANNOT_DISPATCH' => 'error-middleware-cannot-dispatch',
        ];
    }

    public function getTests()
    {
        return array(
            new Twig_Test('instanceof', [$this, 'twigTest_instanceOf']),
            new Twig_Test('typeof', [$this, 'twigTest_typeOf']),
        );
    }

    public function getFilters()
    {
        return array(
            new Twig_Filter('update', [$this, 'twigFilter_array_update']),
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'layout_extension';
    }


    public function twigTest_instanceOf($object, $class)
    {
        $reflectionClass = new \ReflectionClass($class);
        return $reflectionClass->isInstance($object);
    }

    public function twigFunction_inString($var1, $var2)
    { // is var1 in var2
        $var1 = (string)$var1;
        $var2 = (string)$var2;
        return (strpos($var2, $var1) !== false) ? true : false;
    }

    public function twigFunction_getType($object = NULL)
    {
        return gettype($object);
    }

    public function twigFunction_getClass($object = NULL)
    {
        if (gettype($object) == "object") {
            return get_class($object);
        } else {
            return "noClass";
        }
    }

    public function twigFunction_arrayException(Exception $exception)
    {
        $retArray = [];
        $retArray['File'] = $exception->getFile();
        $retArray['Line'] = $exception->getLine();
        $retArray['Message'] = $exception->getMessage();
        $retArray['TraceAsString'] = $exception->getTraceAsString();

        $tmpException = $exception->getPrevious();
        $arrayPrevious = [];
        while ($tmpException) {
            $item = [];
            $item['Class'] = get_class($tmpException);
            $item['File'] = $tmpException->getFile();
            $item['Line'] = $tmpException->getLine();
            $item['Message'] = $tmpException->getMessage();
            $item['TraceAsString'] = $tmpException->getTraceAsString();

            $arrayPrevious[] = $item;
            $tmpException = $tmpException->getPrevious();
        }

        $retArray['Previous'] = $arrayPrevious;

        return $retArray;
    }

    /**
     * Description of KALANTwigExtension
     * => permet le test sur le type d'un champs dans un template
     * @author LAURE
     */
    public function twigFunction_isBoolean($var)
    {
        return is_bool($var);
    }


    public function twigTest_typeOf($var, $type_test = null)
    {

        switch ($type_test) {
            default:
                return false;
                break;
            case 'array':
                return is_array($var);
                break;
            case 'bool':
                return is_bool($var);
                break;
            case 'float':
                return is_float($var);
                break;
            case 'int':
                return is_int($var);
                break;
            case 'numeric':
                return is_numeric($var);
                break;
            case 'object':
                return is_object($var);
                break;
            case 'scalar':
                return is_scalar($var);
                break;
            case 'string':
                return is_string($var);
                break;
            case 'datetime':
                return ($var instanceof \DateTime);
                break;
        }
    }

    public function twigFunction_subString($str, $start, $len = null)
    {
        if (intval($len) > 0) {
            return substr($str, $start, $len);
        } else {
            return substr($str, $start);
        }
    }

    public function twigFunction_strPos($str, $search, $offset = null)
    {
        if (intval($offset) > 0) {
            return strpos($str, $search, $offset);
        } else {
            return strpos($str, $search);
        }
    }

    /**
     * Merges an array with another one.
     *
     * <pre>
     *  {% set items = { 'apple': 'fruit', 'orange': 'fruit' } %}
     *
     *  {% set items = items|update({ 'apple': 'granny' }) %}
     *
     *  {# items now contains { 'apple': 'granny', 'orange': 'fruit' } #}
     * </pre>
     *
     * @param array|Traversable $arr1 An array
     * @param array|Traversable $arr2 An array (of keys / value)
     *
     * @return array The replace values in array by array of keys / values
     */
    public function twigFilter_array_update($arr1, $arr2)
    {
        if ($arr1 instanceof Traversable) {
            $arr1 = iterator_to_array($arr1);
        } elseif (!is_array($arr1)) {
            throw new Twig_Error_Runtime(sprintf('The merge filter only works with arrays or "Traversable", got "%s" as first argument.', gettype($arr1)));
        }

        if ($arr2 instanceof Traversable) {
            $arr2 = iterator_to_array($arr2);
        } elseif (!is_array($arr2)) {
            throw new Twig_Error_Runtime(sprintf('The merge filter only works with arrays or "Traversable", got "%s" as second argument.', gettype($arr2)));
        }

        foreach ($arr2 as $key => $value) {
            if (array_key_exists($key, $arr1)) $arr1[$key] = $value;
        }
        return $arr1;
    }
}