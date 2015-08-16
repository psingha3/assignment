<?php
/**
 * This file use to create zip file for only one album.
 * @author Pankaj kumar
 */
include_once 'config.php';
$fb->setDefaultAccessToken($_SESSION['access_token']);
$response = $fb->get("/".$_REQUEST['id']."/photos?fields=images");
$albumsPhotos = $response->getGraphEdge();
$response = array();
$zip = new ZipArchive;
$albumName = str_replace(' ','_',$_REQUEST['name']);
$albumName = $albumName.'.zip';
$res = $zip->open($albumName, ZipArchive::CREATE);
if($res){
	 foreach($albumsPhotos as &$value){
	 	$photosDetail =  json_decode($value);
	 	$download_file = file_get_contents($photosDetail->images[0]->source);
		 #add it to the zip
	 	$zip->addFromString(basename($photosDetail->images[0]->source),$download_file);
	 }
	 $zip->close();
	$response = array('code'=>200,'message'=>'created','file'=>$albumName);
}
else{
	$response = array('code'=>500,'message'=>'error','file'=>$albumName);
	
}
echo json_encode($response);