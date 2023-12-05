<?php

$accessToken = 'YOUR_ACCESS_TOKEN';
$postId = 'POST_ID_TO_FETCH';

$url = "https://graph.facebook.com/v13.0/{$postId}?fields=id,from,message,created_time,attachments,comments,likes&access_token={$accessToken}";

$response = file_get_contents($url);
$data = json_decode($response, true);

// Access the post data in $data
print_r($data);
