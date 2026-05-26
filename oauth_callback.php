<?php
session_start();
include 'connect.php';
$config = require 'oauth_config.php';

function httpRequest($url, $postFields = null, $headers = []) {
    if(function_exists('curl_version')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        if ($postFields !== null) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        }
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) {
            return false;
        }
        return $result;
    }

    if ($postFields !== null) {
        $options = [
            'http' => [
                'header' => implode("\r\n", $headers) . "\r\n",
                'method' => 'POST',
                'content' => http_build_query($postFields),
            ],
        ];
        $context = stream_context_create($options);
    } else {
        $context = stream_context_create(['http' => ['header' => implode("\r\n", $headers) . "\r\n"]]);
    }

    return file_get_contents($url, false, $context);
}

function handleSocialUser($conn, $firstName, $lastName, $email) {
    $email = trim($email);
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Valid email is required from the social provider.');
    }

    $stmt = $conn->prepare('SELECT email, is_verified FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $verification_code = strval(rand(100000, 999999));

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['is_verified']) {
            $_SESSION['email'] = $email;
            header('Location: homepage.php');
            exit();
        }

        $update = $conn->prepare('UPDATE users SET verification_code = ? WHERE email = ?');
        $update->bind_param('ss', $verification_code, $email);
        $update->execute();

        $_SESSION['pending_email'] = $email;
        $_SESSION['verification_code'] = $verification_code;
        header('Location: verify.php');
        exit();
    }

    $password = md5(uniqid('social_', true));
    $insert = $conn->prepare('INSERT INTO users(firstName, lastName, email, password, is_verified, verification_code) VALUES (?, ?, ?, ?, 0, ?)');
    $insert->bind_param('sssss', $firstName, $lastName, $email, $password, $verification_code);
    if ($insert->execute()) {
        $_SESSION['pending_email'] = $email;
        $_SESSION['verification_code'] = $verification_code;
        header('Location: verify.php');
        exit();
    }

    die('Unable to create user account: ' . $conn->error);
}

if (isset($_GET['error'])) {
    die('Authentication error: ' . htmlspecialchars($_GET['error']));
}

if (empty($_GET['state']) || empty($_SESSION['oauth_state']) || $_GET['state'] !== $_SESSION['oauth_state']) {
    die('Invalid OAuth state. Please try again.');
}

$stateParts = explode('|', base64_decode($_GET['state']), 2);
if (count($stateParts) !== 2) {
    die('Invalid OAuth response.');
}

$provider = $stateParts[0];

if ($provider === 'google') {
    if (empty($_GET['code'])) {
        die('Missing authorization code from Google.');
    }

    $google = $config['google'];
    $tokenResponse = httpRequest('https://oauth2.googleapis.com/token', [
        'code' => $_GET['code'],
        'client_id' => $google['client_id'],
        'client_secret' => $google['client_secret'],
        'redirect_uri' => $google['redirect_uri'],
        'grant_type' => 'authorization_code',
    ]);

    if ($tokenResponse === false) {
        die('Unable to retrieve Google access token.');
    }

    $tokenData = json_decode($tokenResponse, true);
    if (empty($tokenData['access_token'])) {
        die('Google token exchange failed.');
    }

    $userInfoJson = httpRequest('https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . urlencode($tokenData['access_token']));
    if ($userInfoJson === false) {
        die('Unable to retrieve Google user info.');
    }

    $profile = json_decode($userInfoJson, true);
    handleSocialUser($conn, $profile['given_name'] ?? '', $profile['family_name'] ?? '', $profile['email'] ?? '');
} else {
    die('Unknown OAuth provider: ' . htmlspecialchars($provider));
}
