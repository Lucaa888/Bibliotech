<?php

return [
  'db' => [
    'host' => getenv('DB_HOST') ?: 'db',
    'name' => getenv('DB_NAME') ?: 'bibliotech',
    'user' => getenv('DB_USER') ?: 'bibliotech_user',
    'pass' => getenv('DB_PASS') ?: 'bibliotech_pass',
    'charset' => 'utf8mb4',
  ]
];