<?php
// Get Twitter Information
function getTwitter($access_token, $access_token_secret, $request_method, $request_api, $options) {
	global $consumer_key, $consumer_secret;
	
	// Create Twitter User Object
	$tw_obj = new TwitterOAuth (
		$consumer_key,
		$consumer_secret,
		$access_token,
		$access_token_secret
	);
	// REST API List
	switch($request_api) {
		case 'home_timeline':		$tw_rest_api = 'https://api.twitter.com/1.1/statuses/home_timeline.json'; break;
		case 'search_tweet':		$tw_rest_api = 'https://api.twitter.com/1.1/search/tweets.json'; break;
		case 'statuses_update':		$tw_rest_api = 'https://api.twitter.com/1.1/statuses/update.json'; break;
		case 'statuses_retweet':	$tw_rest_api = 'https://api.twitter.com/1.1/statuses/retweet/'; $tmp=(object)$options; $tmp=$tmp->id; $tw_rest_api.=$tmp.'.json'; break;
		case 'friendships_create':	$tw_rest_api = 'https://api.twitter.com/1.1/friendships/create.json'; break;
		case 'followers_list':		$tw_rest_api = 'https://api.twitter.com/1.1/followers/list.json'; break;
		case 'favorites_create':	$tw_rest_api = 'https://api.twitter.com/1.1/favorites/create.json'; break;
	}
	// Request Information from Twitter
	$tw_obj_request = $tw_obj->OAuthRequest (
		$tw_rest_api,
		$request_method,
		$options
	);
	// Return results
	return json_decode($tw_obj_request, true);
}
?>