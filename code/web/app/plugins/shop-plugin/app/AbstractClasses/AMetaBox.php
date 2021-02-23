<?php

namespace Shop\AbstractClasses;

abstract class AMetaBox
{
    protected function __construct() {
        add_action('add_meta_boxes', [$this, 'addMetaBox']);
        add_action('save_post', [$this, 'save']);
    }

    /**
     * Add metabox.
     *
     * @param $postType
     * @return mixed
     */
    abstract public function addMetaBox($postType);

    /**
     * Abstract save method
     *
     * @return mixed
     */
    abstract public function save();
}