<?php

namespace Forki;

class Forki
{
    /**
     * @var \Forki\AdapterInterface
     */
    private $_adapter;

    private $_communication;

    private $_runnables = array();

    private $_threads = array();

    public function __construct(\Forki\Adapter\AdapterInterface $adapter, \Forki\Communication $communication = null)
    {
        $this->_adapter = $adapter;
        $this->_communication = $communication;
    }

    public function addRunnable($runnable, array $arguments = array())
    {
        $this->_runnables[] = array($runnable, $arguments);
    }

    public function setRunnables(array $runnables)
    {
        $this->_runnables = $runnables;
    }

    public function getRunnables()
    {
        return $this->_runnables;
    }

    public function run()
    {
        foreach ($this->_runnables as $runnable)
        {
            $this->_adapter->setRunnable($runnable[0]);
            $this->_adapter->start($runnable[1]);
        }
    }
}