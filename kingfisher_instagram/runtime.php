<?php
  require 'vendor/autoload.php';
  
	spl_autoload_register(function($class_name){
        if (strpos($class_name, 'KingfisherInstagram')===0) {
            include(__DIR__.'/'.$class_name.'.class.php');
            return true;
        }
        if (strpos($class_name, 'tmh')===0) {
            include(PERCH_PATH.'/addons/apps/kingfisher_instagram/tmhOAuth/'.$class_name.'.php');
            return true;
        }
        return false;
    });

    PerchSystem::register_shortcode_provider('KingfisherInstagram_ShortcodeProvider');

	/**
	 * 
	 * function called by scripts (eg:a cron job or scheduled task) to upate the Tweets.
	 */
	function kingfisher_instagram_update_posts()
	{
		$found = 0;
	    
		$API  = new PerchAPI(1.0, 'kingfisher_instagram');
		
		PerchUtil::debug('Updating');
	
		$InstagramSettings = new KingfisherInstagram_Settings($API);
    $CurrentSettings = $InstagramSettings->find();
    
		if(is_object($CurrentSettings)) {
			$details = $CurrentSettings->to_array();
		
			$KingfisherInstagram = new KingfisherInstagram();	
      return $KingfisherInstagram->get_posts(); 
		}
  }
  
  function kingfisher_instagram_get_latest($opts=array(), $return=false)
	{
		if (!is_array($opts)) $opts = array();

		$twitter_id = false;
		$type		= 'mine';

		$defaults = array(
      'count'=>3,
      'template' => 'post.html'
    );

		$opts = array_merge($defaults, $opts);
		
		$API  	= new PerchAPI(1.0, 'kingfisher_instagram');
		$Posts = new KingfisherInstagram_Posts($API);
		
    $r = $Posts->all();
    
    $Template = $API->get('Template');
    $Template->set('instagram/'.$opts['template'], 'instagram');
    $html = $Template->render_group($r);
    $html = $Template->apply_runtime_post_processing($html);

    if ($return) return $html;
    echo $html;
	}