<?php
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');


    
    // Try to update
    if (file_exists('update.php')) include('update.php');


    $Tweets = new KingfisherInstagram_Posts($API);

    $InstagramSettings = new KingfisherInstagram_Settings($API);
    $InstagramSettings->attempt_install();

    $CurrentSettings = $InstagramSettings->find();
    
    if(!is_object($CurrentSettings)) {
        $InstagramSettings->attempt_install();
        $CurrentSettings = $InstagramSettings->find();
    }
    
    $details = array();
    if ($CurrentSettings) {
        $details = $CurrentSettings->to_array();
    }else{
        $details = false;
    }

    
    $message = '';

    
    if ($Form->submitted()) {
        $postvars    = array('settingInstagramID');
    	$data        = $Form->receive($postvars);
    	$Instagram     = new KingfisherInstagram();	
      $Instagram->get_posts();        
		
		$message = $HTML->success_message('Posts updated.');  
    
    }


    if (!function_exists('curl_init')) {
        $Alert->set('error', $Lang->get('You need the <a href="http://www.php.net/manual/en/ref.curl.php" class="notification-link">PHP cURL functions</a> enabled in your hosting account to be able to use the Instagram app.'));
    }

    
    $Paging = $API->get('Paging');
    $Paging->set_per_page(20);


    $filter = 'all';

    if (isset($_GET['type']) && $_GET['type']=='mine') {
        $filter = 'type';
        $type = 'mine';
    }

    if (isset($_GET['type']) && $_GET['type']=='favorites') {
        $filter = 'type';
        $type = 'favorites';
    }

    switch($filter) {

        default:
            $posts = $Tweets->all($Paging);
            break;
    }



    if (!PerchUtil::count($posts)) {
        $Alert->set('warning', $Lang->get('No posts found. %sSet or check your Instagram username%s', '<a class="notification-link" href="'.$HTML->encode($API->app_path().'/settings/').'">','</a>')); 
    }
    