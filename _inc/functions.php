<?php
// https://stackoverflow.com/a/19858404
function swiftpic_encodeURI($uri) {
	return preg_replace_callback("{[^0-9a-z_.!~*'();,/?:@&=+$#-]}i", function ($m) {
		return sprintf('%%%02X', ord($m[0]));
	}, $uri);
}

function swiftpic_settings() {
	$settings = array_fill_keys(['username', 'secret_key', 'site_url'], '');

	// Look for defined constant
	// or else saved option in the dashboard
	foreach ($settings as $key => $_) {
		$const = 'SWIFTPIC_' . strtoupper($key);
		if (defined($const) && ($val = constant($const))) {
			$settings[$key] = $val;
		} else {
			$options = (array) get_option('swiftpic_settings');
			if (array_key_exists($key, $options) && ($val = $options[$key])) {
				$settings[$key] = $val;
			}
		}
	}

	return apply_filters('swiftpic_settings', $settings);
}

function swiftPic($imageKey, $command = '') {
	$settings = swiftpic_settings();
	$username = $settings['username'];
	$secretKey = $settings['secret_key'];
	$siteUrl = rtrim($settings['site_url'], '/');

	// Disable SwiftPic if keys are not set
	if (!$username || !$secretKey) {
		return $imageKey;
	}

	// Encode certain characters to become UTF-8
	$imageKey = swiftpic_encodeURI($imageKey);

	// Expand relative URLs
	if (substr($imageKey, 0, 1) === '/') {
		$imageKey = get_site_url() . $imageKey;
	}

	// If site URL is different (e.g. CDN) then use that instead
	if ($siteUrl) {
		$imageKey = str_replace(get_site_url(), $siteUrl, $imageKey);
	}

	// Calculate the signature
	$signature = base64_encode(hash_hmac('sha256', $command . '/' . $imageKey, $secretKey, true));
	// Calculate the domain
	preg_match('/\d/', "$signature 0", $matches);
	$domain = 'https://i' . $matches[0] . '.swiftpic.io';
	// Return the absolute URL to the image on SwiftPic
	return sprintf('%s/%s/%s/%s/%s', $domain, $username, $signature, $command, $imageKey);
}
