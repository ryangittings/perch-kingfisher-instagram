<?php

class KingfisherInstagram
{
  protected $table     = 'instagram_settings';
	protected $pk        = 'settingID';
	protected $singular_classname = 'KingfisherInstagram_Setting';
	
	public function get_posts() 
	{
    $API    = new PerchAPI(1.0, 'kingfisher_instagram');
    $InstagramSettings = new KingfisherInstagram_Settings($API);
    $CurrentSettings = $InstagramSettings->find();

		$KingfisherInstagram_Posts  = new KingfisherInstagram_Posts();
    $a = $KingfisherInstagram_Posts->get_post_ids();

    $posts = $this->get_posts_from_feed();
    $found = 0;

    if (PerchUtil::count($posts["data"])) {
			foreach($posts["data"] as $post) {
          //loop through all retrieved Tweets
          
				if(!in_array($post["id"],$a)) {
            $data = array();
				    $data['postInstagramID']    = $post["id"];
				    $data['postImageStandard'] = $post["images"]["standard_resolution"]["url"];
            $data['postImageThumbnail'] = $post["images"]["thumbnail"]["url"];
				    $data['postImageLow'] = $post["images"]["low_resolution"]["url"];
            $data['postLink'] = $post["link"];
				    $data['caption'] = $post["caption"]["text"];
            $data['likes'] = $post["likes"]["count"];
            $data['postDate'] = date('Y-m-d H:i:s', $post["created_time"]);

				    $KingfisherInstagram_Posts->create($data);
				    $found++;
          }
        }
      }
      
      return $found;
  }
  
  static function full_url( $s, $use_forwarded_host = false )
  {
    $API    = new PerchAPI(1.0, 'kingfisher_instagram');
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host . $API->app_path() . '/settings';
  }

  private function get_posts_from_feed() {
    $API    = new PerchAPI(1.0, 'kingfisher_instagram');
    $InstagramSettings = new KingfisherInstagram_Settings($API);
    $CurrentSettings = $InstagramSettings->find();
    
    $access_token = $CurrentSettings->settingInstagramToken();
    $count_feed = 10;

    $requestURL = 'https://api.instagram.com/v1/users/self/media/recent?access_token='.$access_token.'&count='.$count_feed;
    $ch = curl_init();
    curl_setopt_array($ch, array(        
        CURLOPT_URL => $requestURL,
        CURLOPT_HEADER  => false,
        CURLOPT_RETURNTRANSFER => 1
    ));
    $json_response = curl_exec($ch);
    curl_close($ch);
    $insta_feeds = json_decode($json_response, true);

    return $insta_feeds;
  }
}
