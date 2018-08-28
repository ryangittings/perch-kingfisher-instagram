<?php
	if ($CurrentUser->logged_in()) {
    	$this->register_app('kingfisher_instagram', 'Instagram', 10, 'App to display and post Tweets', '4.0');
    	$this->require_version('kingfisher_instagram', '3.0.11');
    }

    spl_autoload_register(function($class_name){
        if (strpos($class_name, 'KingfisherInstagram')===0) {
            include(PERCH_PATH.'/addons/apps/kingfisher_instagram/'.$class_name.'.class.php');
            return true;
        }

        return false;
    });

    // Fieldtypes
    include_once(__DIR__.'/fieldtypes.php');
    require 'vendor/autoload.php';

    PerchSystem::register_shortcode_provider('KingfisherInstagram_ShortcodeProvider');