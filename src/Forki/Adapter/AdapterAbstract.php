<?php

namespace Forki\Adapter;

/**
 * Class AdapterAbstract
 *
 * @package Forki\Adapter
 */
abstract class AdapterAbstract implements AdapterInterface
{
    /**
     * callback for the function that should
     * run as a separate thread
     *
     * @var callback
     */
    protected $_runnable;

    /**
     * @var int
     */
    protected $_parentPid;

    /**
     * holds the current process id
     *
     * @var integer
     */
    protected $_pid;

    /**
     * class constructor - you can pass
     * the callback function as an argument
     *
     * @param callback $runnable
     */
    public function __construct($runnable = null)
    {
        if ($runnable !== null) {
            $this->setRunnable($runnable);
        }

        $this->_parentPid = getmypid();
    }

    /**
     * sets the runnable
     *
     * @param $runnable
     *
     * @return mixed|void
     * @throws \Forki\Exception
     */
    public function setRunnable($runnable)
    {
        /*if ((function_exists($runnable) && is_callable($runnable))
            || (is_object($runnable) && $runnable instanceof \Closure)
            || (is_array($runnable) && method_exists($runnable[0], $runnable[1]))
        ) {*/
        if (is_callable($runnable)) {
            $this->_runnable = $runnable;
        } else {
            throw new \Forki\Exception('You must specify a valid function name that can be called for the current scope.');
        }
    }

    /**
     * gets the runnable
     *
     * @return mixed
     */
    public function getRunnable()
    {
        return $this->_runnable;
    }

    /**
     * returns the process id (pid) of the simulated thread
     *
     * @return int
     */
    public function getPid()
    {
        return $this->_pid;
    }

    /**
     * @param array $arguments
     */
    protected function _call(array $arguments = array())
    {
        switch (gettype($this->_runnable)) {
            case 'string':
            case 'array':
            case 'object':
                call_user_func_array($this->_runnable, $arguments);
                break;
        }
    }

    protected  function _kill($pid, $signal)
    {
        return posix_kill($pid, signal);
    }
}