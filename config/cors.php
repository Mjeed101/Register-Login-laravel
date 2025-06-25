<?php
return [

    'paths' => ['*'], // Allow all paths (or you can specify like 'api/*', 'register', etc.)

    'allowed_methods' => ['*'], // Allow all HTTP methods

    'allowed_origins' => ['*'], // Allow all origins (for testing)

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
