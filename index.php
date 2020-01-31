<?php
require 'vendor/autoload.php';
session_start();

$session = new SpotifyWebAPI\Session(
    'd0233e3bddf647c3821fac68bb2d4aa5',
    '899917c0583a471f8cf524aba161daf0',
    'https://minhaplaylist.azurewebsites.net/app.php'
);
//$_SESSION["accessToken"] = $accessToken;

$options = [
    'scope' => [
        'playlist-read-private',
        'playlist-modify-private',
        'user-read-private',
        'playlist-modify-public',
        'ugc-image-upload'
    ],
];

header('Location: ' . $session->getAuthorizeUrl($options));
die();

?>
