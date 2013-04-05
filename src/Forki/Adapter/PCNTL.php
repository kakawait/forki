<?php

namespace Forki\Adapter;

class PCNTL extends AdapterAbstract implements AdapterInterface
{
    private static $_phpExtensions = array('pcntl');

    /**
     * checks if threading is supported by the current
     * PHP configuration
     *
     * @return boolean
     */
    public static function available()
    {
        $phpExtensions = self::$_phpExtensions;

        foreach ($phpExtensions as $phpExtension) {
            if (!extension_loaded($phpExtension)) {
                return false;
            }
        }

        return true;
    }

    /**
     * checks if the child thread is alive
     *
     * @return boolean
     */
    public function isAlive()
    {
        $pid = pcntl_waitpid($this->_pid, $status, WNOHANG);
        return $pid === 0;
    }

    /**
     * starts the thread, all the parameters are
     * passed to the callback function
     *
     * @throws Exception
     * @return void
     */
    public function start()
    {
        $pid = pcntl_fork();
        if ($pid == -1) {
            throw new Exception('pcntl_fork() returned a status of -1. No new process was created');
        }
        if ($pid) {
            // parent 
            $this->_pid = $pid;
        } else {
            // child
            //ob_start();
            pcntl_signal(SIGTERM, array($this, 'signalHandler'));
            $arguments = func_get_args();
            $this->_call($arguments);

            exit(0);
        }
    }

    /**
     * attempts to stop the thread
     * returns true on success and false otherwise
     *
     * @param integer $signal - SIGKILL/SIGTERM
     * @param boolean $wait
     *
     * @return mixed|void
     */
    public function stop($signal = SIGKILL, $wait = false)
    {
        if ($this->isAlive()) {
            $this->_kill($this->_pid, $signal);
            if ($wait) {
                pcntl_waitpid($this->_pid, $status = 0);
            }
        }
    }

    /**
     * alias of stop();
     *
     * @param int $signal
     * @param bool $wait
     *
     * @return boolean
     */
    public function kill($signal = SIGKILL, $wait = false)
    {
        return $this->stop($signal, $wait);
    }

    /**
     * signal handler
     *
     * @param integer $signal
     */
    protected function signalHandler($signal)
    {
        switch ($signal) {
            case SIGTERM:
                exit(0);
                break;
        }
    }

}

?>
