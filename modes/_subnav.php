<?php

	PerchUI::set_subnav([
			[
				'page'=>[
							'kingfisher_instagram'
						], 
				'label'=>'Posts'
			],
			[
				'page'=>[
							'kingfisher_instagram/settings'
						], 
				'label'=>'Settings', 
				'priv'=>'kingfisher_instagram.settings'
			]
		], $CurrentUser);

