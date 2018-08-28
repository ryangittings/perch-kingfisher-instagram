<?php

use Vinkla\Instagram\Instagram;

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
    $instagram = new Instagram($CurrentSettings->settingInstagramToken());

    $a = $KingfisherInstagram_Posts->get_post_ids();

    $posts = $instagram->media();
    $found = 0;

    if (PerchUtil::count($posts)) {
			foreach($posts as $post) {
			    //loop through all retrieved Tweets
			    
				if(!in_array($post->id,$a)) {
            $data = array();
				    $data['postInstagramID']    = $post->id;
				    $data['postImageStandard'] = $post->images->standard_resolution->url;
            $data['postImageThumbnail'] = $post->images->thumbnail->url;
				    $data['postImageLow'] = $post->images->low_resolution->url;
				    $data['caption'] = $post->caption->text;
            $data['likes'] = $post->likes->count;
            $data['postDate'] = date('Y-m-d H:i:s', $post->created_time);;
            
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
}
