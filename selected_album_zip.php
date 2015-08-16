<?php
/**
 * This file use to create zip for multiple selected album
 * @author Pankaj kumar
 */
include_once 'config.php';
$fb->setDefaultAccessToken($_SESSION['access_token']);
$ids = $_REQUEST['ids'];
$names= $_REQUEST['names'];
foreach($ids as $key=>$value){
	$response = $fb->get("/".$value."/photos?fields=images");
	$albumsPhotos = $response->getGraphEdge();
	$response = array();
	$zip = new ZipArchive;
	$albumName = str_replace(' ','_',$names[$key]);
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
		
	}
	
}
$response = array('code'=>200,'message'=>'created');
echo json_encode($response);