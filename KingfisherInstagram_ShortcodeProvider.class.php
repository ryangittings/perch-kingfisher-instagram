<?php

class KingfisherInstagram_ShortcodeProvider extends PerchShortcode_Provider
{
	public $shortcodes = ['tweet'];

	public function get_shortcode_replacement($Sortcode, $Tag)
	{
		$id = $Sortcode->arg(0);

		$API = new PerchAPI(1.0, 'kingfisher_instagram');
		$HTTP = $API->get('HTTPClient');

		$response = $HTTP->get('https://publish.twitter.com/oembed?url=https://twitter.com/Interior/status/'.$id);

		if ($response) {
			$data = json_decode($response, true);
			if (isset($data['html'])) return $data['html'];
		}

		return '';
	}
}