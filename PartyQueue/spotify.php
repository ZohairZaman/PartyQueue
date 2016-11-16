<?php 

	class Spotify {

		const API_URL = 'https://api.spotify.com'

		public static function searchArtist($name) {
			return self::_makeCall('/v1/search', array('q' => $name, 'type' => 'artist'));
		}

		public static function searchAlbum($name) {
			return self::_makeCall('/v1/search', array('q' => $name, 'type' => 'album'));
		}

		public static function searchTrack($name) {
			return self::_makeCall('/v1/search', array('q'=>$name, 'type'=>'track'));
		}

		private static function _makeCall($function, $params) {
			$params = '.json?' . utf8_encode(http_build_query($params));
			$apiCall = self::API_URL.$function.$params;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $apiCall);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

			$jsonData = curl_exec($ch);
			curl_close($ch);
			return json_decode($jsonData);
		}


	}
?>