<?php

namespace GraphicObjectTemplating\TwigExtensions;

use Exception;
use Traversable;
use Twig\Error\RuntimeError as Twig_Error_Runtime;
use Twig\TwigFunction as Twig_Function;
use Twig\TwigTest as Twig_Test;
use Twig\Extension\AbstractExtension as Twig_Extension;
use Twig\TwigFilter as Twig_Filter;

/**
 * Class LayoutExtension
 * @package GraphicObjectTemplating\TwigExtensions
 *
 * fonctions :
 * -----------
 * getclass         : retourne la classe associé à l'objet
 * gettype          : retourne le type de variable
 * arrayexception   : restitue le tableau d'exception Php généré par une erreur
 * substr           : sous découpage d'une chaîne de caractères
 * strpos           : restitue la position d'uncaractère ou sous chaîne dans chaîne de caractères
 * instring         : précise l'existance d'un caractère ou sous chaîne ou non dans une chaîne de caractères
 * arraykeyexist    : recherche l'existance d'une clé d'accès dans un tableau
 * implode          : génération d'une chaîne de caractères à partir d'un tableau lié par un délimiteur
 *
 * tests :
 * -------
 * instanceof       : valide ou non que l'obvjet est une instance d'une classe
 * typeof           : valide ou non que l'objet (variable) est d'un type précis
 *
 * filtres :
 * ---------
 * update           : met à jour ou complète un tableau
 * ksort            : réalise un ksort sur un tableau avant de le restituer
 */
class LayoutExtension extends Twig_Extension
{

    /**
     * @return array|Twig_Function[]
     */
    public function getFunctions()
    {
        return array(
            new Twig_Function('getclass', array($this, 'twigFunction_getClass'), array('is_safe' => array('html'))),
            new Twig_Function('gettype', array($this, 'twigFunction_getType'), array('is_safe' => array('html'))),
            new Twig_Function('arrayexception', array($this, 'twigFunction_arrayException'), array('is_safe' => array('html'))),
            new Twig_Function('substr', array($this, 'twigFunction_subString'), array('is_safe' => array('html'))),
            new Twig_Function('strpos', array($this, 'twigFunction_strPos'), array('is_safe' => array('html'))),
            new Twig_Function('instring', array($this, 'twigFunction_inString'), array('is_safe' => array('html'))),
            new Twig_Function('arraykeyexists', [$this, 'twigFunction_arrayKeyExists']),
            new Twig_Function('implode', array($this, 'twigFunction_implode'), array('is_safe' => array('html'))),
            new Twig_Function('explode', array($this, 'twigFunction_explode'), array('is_safe' => array('html'))),
        );
    }


    /**
     * @return array
     */
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

    /**
     * @return array|Twig_Test[]
     */
    public function getTests()
    {
        return array(
            new Twig_Test('instanceof', [$this, 'twigTest_instanceOf']),
            new Twig_Test('typeof', [$this, 'twigTest_typeOf']),
        );
    }

    /**
     * @return array|Twig_Filter[]
     */
    public function getFilters()
    {
        return array(
            new Twig_Filter('update', [$this, 'twigFilter_array_update']),
            new Twig_Filter('ksort', [$this, 'twigFilter_array_ksort']),
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


    /**
     * @param $object
     * @param $class
     * @return bool
     * @throws \ReflectionException
     */
    public function twigTest_instanceOf($object, $class)
    {
        $reflectionClass = new \ReflectionClass($class);
        return $reflectionClass->isInstance($object);
    }

    /**
     * @param $var1
     * @param $var2
     * @return bool
     */
    public function twigFunction_inString($var1, $var2)
    { // is var1 in var2
        $var1 = (string) $var1;
        $var2 = (string) $var2;
        return (strpos($var2, $var1) !== false) ? true : false;
    }

    /**
     * @param null $object
     * @return string
     */
    public function twigFunction_getType($object = NULL)
    {
        return gettype($object);
    }

    /**
     * @param null $object
     * @return string
     */
    public function twigFunction_getClass($object = NULL)
    {
        if (gettype($object) == "object") {
            return get_class($object);
        } else {
            return "noClass";
        }
    }

    /**
     * @param Exception $exception
     * @return array
     */
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

    /**
     * @param $str
     * @param $start
     * @param null $len
     * @return bool|string
     */
    public function twigFunction_subString($str, $start, $len = null)
    {
        if (intval($len) > 0) {
            return substr($str, $start, $len);
        } else {
            return substr($str, $start);
        }
    }

    /**
     * @param $str
     * @param $search
     * @param null $offset
     * @return bool|int
     */
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
     * syntax :
     * <pre>
     *  {% set items = { 'apple': 'fruit', 'orange': 'fruit' } %}
     *  {% set items = items|update({ 'apple': 'granny' }) %}
     *
     *  {# items now contains { 'apple': 'granny', 'orange': 'fruit' } #}
     * </pre>
     *
     * @param array|Traversable $arr1 An array
     * @param array|Traversable $arr2 An array (of keys / value)
     *
     * @return array The replace values in array by array of keys / values
     * @throws Twig_Error_Runtime
     */
    public function twigFilter_array_update($arr1, $arr2)
    {
        if ($arr1 instanceof Traversable) {
            $arr1 = iterator_to_array($arr1);
        } elseif (!is_array($arr1)) {
            throw new Twig_Error_Runtime(sprintf('The update filter only works with arrays or "Traversable", got "%s" as first argument.', gettype($arr1)));
        }

        if ($arr2 instanceof Traversable) {
            $arr2 = iterator_to_array($arr2);
        } elseif (!is_array($arr2)) {
            throw new Twig_Error_Runtime(sprintf('The update filter only works with arrays or "Traversable", got "%s" as second argument.', gettype($arr2)));
        }

        foreach ($arr2 as $key => $value) {
            if (array_key_exists($key, $arr1)) $arr1[$key] = $value;
        }
        return $arr1;
    }

    /**
     * Search in an array if a key exist
     * syntax :
     *      {% if arraykeyexists('key', array) %} ... {% endif %}
     *      {% if arraykeyexists(key, array) %} ... {% endif %}
     *
     * @param $key
     * @param $array
     * @return bool
     */
    public function twigFunction_arrayKeyExists($key, $array)
    {
        return array_key_exists($key, $array);
    }

    /**
     * Generate string from an array glue by a delimiter
     * syntax:
     *      {{ implode('delimiter', array) }}
     *      {{ implode(delimiter, array) }}
     *
     * @param string $delimiter
     * @param array $array
     * @return string
     */
    public function twigFunction_implode(string $delimiter, array $array)
    {
        return implode($delimiter, $array);
    }

    /**
     * Generate an array from a string, each member separate by a delimiter
     * syntax:
     *      {{ explode('delimiter', string) }}
     *      {{ explode(delimiter, string) }}
     *
     * @param string $delimiter
     * @param array $array
     * @return string
     */
    public function twigFunction_explode(string $delimiter, string $string)
    {
        return explode($delimiter, $string);
    }
}