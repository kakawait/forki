<?php

interface ResolverInterface
{
    public function resolve($result = null);
    public function reject($rease = null);
    public function progress($update = null);
}