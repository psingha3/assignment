<?php
include_once 'config.php';
$permissions = array('user_photos'); // Optional permissions
$loginUrl = $helper->getLoginUrl('http://firststepitsolution.com/demo/facebook/callback.php', $permissions);
//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
header('Location:'.$loginUrl);