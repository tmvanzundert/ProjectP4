<?php

abstract class View {
    abstract public function show();

    public function __construct() {
        $this->show();
    }

}
