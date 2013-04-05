<?php

namespace Forki\Adapter;

/**
 * Class AdapterInterface
 *
 * @package Forki\Adapter
 */
interface AdapterInterface
{
    /**
     * @return mixed
     */
    public static function available();

    /**
     * @param $runnable
     * @return mixed
     */
    public function setRunnable($runnable);

    /**
     * @return mixed
     */
    public function getRunnable();

    /**
     * @return mixed
     */
    public function getPid();

    /**
     * @return mixed
     */
    public function isAlive();

    /**
     * @return mixed
     */
    public function start();

    /**
     * @param int $signal
     * @param bool $wait
     * @return mixed
     */
    public function stop($signal = SIGKILL, $wait = false);

    /**
     * @param int $signal
     * @param bool $wait
     * @return mixed
     */
    public function kill($signal = SIGKILL, $wait = false);

}