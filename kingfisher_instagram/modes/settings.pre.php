<?php

require '../vendor/autoload.php';

  $Form = $API->get('Form');

  $InstagramSettings = new KingfisherInstagram_Settings($API);
  $KingfisherInstagram = new KingfisherInstagram($API);
  $message = false;

  $CurrentSettings = $InstagramSettings->find();

    if(!is_object($CurrentSettings)) {
      $InstagramSettings->attempt_install();
      $CurrentSettings = $InstagramSettings->find();
  }

  $details = array('settingInstagramToken'=>'', 'settingUpdateInterval'=>'');
  if (is_object($CurrentSettings)) $details = $CurrentSettings->to_array();

  $Form->require_field('settingInstagramToken', 'Required');
  $Form->require_field('settingUpdateInterval', 'Required');

  $message = $HTML->success_message('First you need to generate an access token using Pixel Unions access token generator or by creating an Instagram application: <a href="%s">here</a>', 'http://instagram.pixelunion.net/');  

  if ($Form->submitted()) {
      $postvars = array('settingUpdateInterval', 'settingInstagramToken',);
      $data = $Form->receive($postvars);

    $result = $CurrentSettings->update($data);  
    
      if ($result) {
        if (!isset($_GET['code'])) {
          $message = $HTML->success_message('Settings updated.');  
        }
      }else{
          $message = $HTML->failure_message('Sorry, your settings could not be updated.');
      }

      $CurrentSettings = $InstagramSettings->find();
    $details = $CurrentSettings->to_array();
       
  }