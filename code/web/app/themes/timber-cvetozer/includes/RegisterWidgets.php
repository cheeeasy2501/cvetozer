<?php

namespace Cvetozer;

use Cvetozer\Widgets\PhoneWidget;

class RegisterWidgets{
    public function __construct() {
        PhoneWidget::register();
    }
    public static function registerWidgets(){
       new self;
    }
}