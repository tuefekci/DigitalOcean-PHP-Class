<?php
class ApiConnector {
	function connectToApi($uri) {
		if (function_exists('file_get_contents')) {
			$content = file_get_contents($uri);
			return $content;
		} elseif (function_exists('fopen')) {
			$fp = fopen($uri, 'r');
			$content = '';

			if ($fp) {
				while (!feof($fp)) {
					$content .= fgets($fp);
				}
				fclose($fp);
				return $content;
			}
			return $content;
		} else {
			throw new RuntimeException('Error: DigitalOcean class cannot connect to api!');
		}
	}
}
