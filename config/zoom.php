<?php

return [
    'api_key' => env('ZOOM_CLIENT_KEY', 'ucs0ABFQS6imUEFQLqeesQCopy'),
    'api_secret' => env('ZOOM_CLIENT_SECRET', 'CH4lcFJ3ZJn8TEeKoiKRWZKNk4C0CTeH1PxK'),
    'base_url' => 'https://api.zoom.us/v2/',
    'token_life' => 60 * 60 * 24 * 7, // In seconds, default 1 week
    'authentication_method' => 'jwt', // Only jwt compatible at present but will add OAuth2
    'max_api_calls_per_request' => '5' // how many times can we hit the api to return results for an all() request
];
