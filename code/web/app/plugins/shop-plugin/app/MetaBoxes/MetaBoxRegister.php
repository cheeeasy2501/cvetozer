<?php

namespace Shop\MetaBoxes;

use Shop\MetaBoxes\Gallery;

class MetaBoxRegister
{
    public function __construct() {
        Gallery::register();
    }
}