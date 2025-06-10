<?php

abstract class Controller
{
    function __construct()
    {
        header('location: ?' . $this->run());
        exit;
    }
}