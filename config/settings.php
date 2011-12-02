<?php
class AkismetSettings extends BlogmillSettings {
    var $configurable;
    
    function __construct() {
        $this->configurable = array(
            'key' => array(
                'label' => __('Akismet API key', true),
                'longdesc' => __('Get an Akismet <a href="http://akismet.com/get">API key</a>', true)
            )
        );
    }
}