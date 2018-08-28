<?php

	return function(){

		$API    = new PerchAPI(1.0, 'kingfisher_instagram');
	    $Lang   = $API->get('Lang');
	    $HTML  = $API->get('HTML');
	    $Tweets = new KingfisherInstagram_Tweets($API);

	    $Paging = $API->get('Paging');
	    $Paging->set_per_page(5);

	    $tweets = $Tweets->get_all($Paging);

	    $header  = $HTML->wrap('header h2', $Lang->get('Instagram'));

	    $body = '';

		if (PerchUtil::count($tweets)) {
			$items = [];
			
			foreach($tweets as $Tweet) {
				$s = '';
				$s .= '<a href="'.$HTML->encode(PERCH_LOGINPATH.'/addons/apps/kingfisher_instagram/', true).'">';
					$s .= $HTML->encode($Tweet->tweetText());
				$s .= '</a>';
				
				$items[] = $HTML->wrap('li', $s);
			}

			$body .= $HTML->wrap('ul.dash-list', implode('', $items));
		}
		return $HTML->wrap('div.widget div.dash-content', $header.$body);
	};
	

