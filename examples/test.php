<?php

require_once dirname(__FILE__) . '/../src/Autoloader.php';

$t = new \Forki\Forki(
    new \Forki\Adapter\PCNTL()
);

$t->run();