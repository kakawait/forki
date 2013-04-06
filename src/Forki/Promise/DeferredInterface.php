<?php

interface DeferredInterface
{
    public function resolve($result = null);
    public function promise();
}