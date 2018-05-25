<?php

namespace Alex\QrCode\Basic;

abstract class BasicRender
{
    abstract public function render();

    abstract public function setData(array $array);
}