<?php


namespace GraphicObjectTemplating\Exception;


use Throwable;

class GotException extends \Exception
{
    protected static $envMode = false;

    protected $debugInfo;
    public function __construct($message = "", $code = 0, $debugInfo = null,  Throwable $previous = null)
    {
        $this->debugInfo = $debugInfo;
        if (!self::$envMode) {
            self::$envMode = (strpos($_SERVER['HTTP_HOST'], '.test') === false) ? 'prod' : 'dev' ; // TODO : clean up dev env detection.
        }
        parent::__construct($message, $code, $previous);
    }

    public function getDebugInfo() {
        return $this->debugInfo;
    }
    public function __toString()
    {
        if (self::$envMode != 'dev') {
            return ['error' => $this->message, 'message' => $this->message,];
        }
        $ret = ['exception' => $this,'error' => $this->message, 'message' => $this->message, 'debugInfo' => $this->debugInfo];
        $previous = $this->getPrevious();
        if ($previous != null) {
            $ret['previous'] = (string) $previous;
        }
        return $ret;
    }

    public function setEvnMode(string $mode) {
        self::$envMode = $mode;
    }
}