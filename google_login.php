<?php
session_start();
$config = require 'oauth_config.php';
$google = $config['google'];
$state = base64_encode('google|' . bin2hex(random_bytes(12)));
$_SESSION['oauth_state'] = $state;
$params = [
    'response_type' => 'code',
    'client_id' => $google['client_id'],
    'redirect_uri' => $google['redirect_uri'],
    'scope' => $google['scope'],
    'state' => $state,
    'access_type' => 'online',
    'include_granted_scopes' => 'true',
    'prompt' => 'select_account',
];
header('Location: https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
exit();
