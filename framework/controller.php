<?php

// not used in our codebase, our team was not able to find the time and knowledge to implement this class

abstract class Controller
{
    function __construct()
    {
        header('location: ?' . $this->run());
        exit;
    }

    abstract protected function run();
}