<?php
include_once 'config.php';
// Sets the default fallback access token so we don't have to pass it to each request
$fb->setDefaultAccessToken($_SESSION['access_token']);
try {
  $response = $fb->get('/me/albums?fields=name,link,picture,id');
  $albums = $response->getGraphEdge();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
    <title>Assignment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
    <meta name="author" content="Muhammad Usman">

    <!-- The styles -->
    <link id="bs-css" href="css/bootstrap-cerulean.min.css" rel="stylesheet">

    <link href="css/charisma-app.css" rel="stylesheet">
    <link href='bower_components/fullcalendar/dist/fullcalendar.css' rel='stylesheet'>
    <link href='bower_components/fullcalendar/dist/fullcalendar.print.css' rel='stylesheet' media='print'>
    <link href='bower_components/chosen/chosen.min.css' rel='stylesheet'>
    <link href='bower_components/colorbox/example3/colorbox.css' rel='stylesheet'>
    <link href='bower_components/responsive-tables/responsive-tables.css' rel='stylesheet'>
    <link href='bower_components/bootstrap-tour/build/css/bootstrap-tour.min.css' rel='stylesheet'>
    <link href='css/jquery.noty.css' rel='stylesheet'>
    <link href='css/noty_theme_default.css' rel='stylesheet'>
    <link href='css/elfinder.min.css' rel='stylesheet'>
    <link href='css/elfinder.theme.css' rel='stylesheet'>
    <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
    <link href='css/uploadify.css' rel='stylesheet'>
    <link href='css/animate.min.css' rel='stylesheet'>

    <!-- jQuery -->
    <script src="bower_components/jquery/jquery.min.js"></script>

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The fav icon -->
    <link rel="shortcut icon" href="img/favicon.ico">
 
</head>

<body>
    <!-- topbar starts -->
    <div class="navbar navbar-default" role="navigation">

        <div class="navbar-inner">
            <button type="button" class="navbar-toggle pull-left animated flip">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
      </div>
    </div>
    <!-- topbar ends -->
<div class="ch-container">
    <div class="row">
       <!-- left menu starts -->
        <div class="col-sm-2 col-lg-2">
            <div class="sidebar-nav">
                <div class="nav-canvas">
                    <div class="nav-sm nav nav-stacked">
                  </div>
                    <ul class="nav nav-pills nav-stacked main-menu">
                        <li class="nav-header">Main</li>
                        <li><a class="ajax-link" href="album_detail.php"><i class="glyphicon glyphicon-home"></i><span> Dashboard</span></a>
                        </li>
                    </ul>
               </div>
            </div>
        </div>
        <!--/span-->
        <!-- left menu ends -->
       <div id="content" class="col-lg-10 col-sm-10">
            <!-- content starts -->
 
    <div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
   
    <div class="box-content">
    
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
    <thead>
    <tr>
    	<th></th>
        <th>Album Name</th>
        <th>Thumbnail</th>
         <th><span id="downloadlink_<?php echo $albumDecodeData->id;?>"><a class="btn btn-success"  onClick="donwloadSelectedAlbum('selected')">
                <i class="glyphicon glyphicon glyphicon-download"></i>
                Download Selected Album
            </a></span> &nbsp;<span id="downloadlinkall_<?php echo $albumDecodeData->id;?>"><a class="btn btn-success"  onClick="donwloadSelectedAlbum('all')">
                <i class="glyphicon glyphicon glyphicon-download"></i>
                Download All
            </a></span></th>
    </tr>
    </thead>
    <tbody>
    <?php 
    foreach ($albums as &$value) {
    	$albumDecodeData =  json_decode($value);
    	$albumCover = $albumDecodeData->picture->url;
    ?>
    <tr>
    	<td><input album="<?php echo $albumDecodeData->name;?>" type="checkbox" id="album_id_<?php echo $albumDecodeData->id;?>" name="album_id" value="<?php echo $albumDecodeData->id;?>"></td>
        <td><?php echo $albumDecodeData->name?></td>
       <td class="thumbnails gallery thumbnail">
       <?php 
        $response = $fb->get("/".$albumDecodeData->id."/photos?fields=images");
		$albumsPhotos = $response->getGraphEdge();
      ?>
        <a  href="<?php echo $albumCover;?>"><img
                                        class="grayscale" src="<?php echo $albumCover;?>"
                                        alt="Sample Image 1" height='50px' width='50px'></a>
      <?php 
      foreach($albumsPhotos as &$value){
		 	$photosDetail =  json_decode($value);
      ?> 
      				<ul class="thumbnails gallery" >
                         <li id="image-1" class="thumbnail" style="display:none;">
                                <a style="background:url('<?php echo $photosDetail->images[0]->source;?>')"
                                   title="Sample Image 1" href="<?php echo $photosDetail->images[0]->source;?>">
                                  </a>
                          </li>
                      </ul>
      <?php }?>         
       </td>
        <td class="center">
            <span id="downloadlink_<?php echo $albumDecodeData->id;?>"><a class="btn btn-success"  onClick="donwloadAlbum('<?php echo $albumDecodeData->id;?>','<?php echo $albumDecodeData->name;?>')">
                <i class="glyphicon glyphicon glyphicon-download"></i>
                Download This Album
            </a></span>
            
        </td>
    </tr>
    <?php }?>
   </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->

    <!-- content ends -->
    </div><!--/#content.col-md-0-->
</div><!--/fluid-row-->
</div><!--/.fluid-container-->

<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>
<script src="js/album_detail.js"></script>
</body>
</html>


