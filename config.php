<?php
session_start();
define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/lib/facebook-php-sdk-v4-5.0-dev/src/Facebook/');
define('APP_ID','1689214944633196');
define('APP_SECRET','2729df30eb8b799135564f3c79685d02');
//echo FACEBOOK_SDK_V4_SRC_DIR;
require_once FACEBOOK_SDK_V4_SRC_DIR.'autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => APP_ID,
  'app_secret' => APP_SECRET,
  'default_graph_version' => 'v2.4',
  ]);
$helper = $fb->getRedirectLoginHelper();