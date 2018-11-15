<?php
	
	$API  = new PerchAPI(1.0, 'kingfisher_instagram');

	if (!class_exists('KingfisherInstagram_Settings')) {
		include('KingfisherInstagram_Settings.class.php');
		include('KingfisherInstagram_Setting.class.php');
	}

	$InstagramSettings = new KingfisherInstagram_Settings($API);
	$CurrentSettings = $InstagramSettings->find();

	if ((int)$CurrentSettings->settingUpdateInterval()!=0) {
    $interval = (int)$CurrentSettings->settingUpdateInterval();
    
		PerchScheduledTasks::register_task('kingfisher_instagram', 'update_posts', $interval, 'scheduled_get_posts');
	}


	function scheduled_get_posts($last_run)
	{
		$count = kingfisher_instagram_update_posts();

		if ($count == 1) {
			$posts = 'post';
		}else{
			$posts = 'posts';
		}

		return array(
				'result'=>'OK',
				'message'=>$count.' new '.$posts.' fetched.'
			);
	}