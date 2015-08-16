function donwloadAlbum(albumId,albumName){
		$('#downloadlink_'+albumId).html('<img title="img/ajax-loaders/ajax-loader-3.gif" src="img/ajax-loaders/ajax-loader-3.gif">');
		var formUrl = '/demo/facebook/album_zip.php';
	 	 $.ajax({
	        type: 'POST',
	        url: formUrl,
	        data: {
					id : albumId,
					name : albumName
		        },
	        datatype: "json",
	        success: function(data,textStatus,xhr){
		         var data = $.parseJSON(data);
			     //   alert(data.code);
			      if(data.code==200){
			    	  $('#downloadlink_'+albumId).html("<a href="+data.file+">"+data.file+"</a>");
				  }
	        },
	        error: function(xhr,textStatus,error){
	        }
	      }); 
	        return false;
}
function donwloadSelectedAlbum(action){
	var checkboxValues = [];
	var albumname=[];
	if(action=='selected'){
		$('input[name=album_id]:checked').map(function() {
		            checkboxValues.push($(this).val());
		            albumname.push($(this).attr('album'));
		});
		if(checkboxValues==""){
			alert('Select atleast one record.');
			return false;
		}
	}else {
		$("input:checkbox:not(:checked)").map(function() {
			checkboxValues.push($(this).val());
	        albumname.push($(this).attr('album'));
		});
    }
	var formUrl = '/demo/facebook/selected_album_zip.php';
 	 $.ajax({
        type: 'POST',
        url: formUrl,
        data: {
				ids : checkboxValues,
				names : albumname
	        },
        datatype: "json",
        success: function(data,textStatus,xhr){
	         var data = $.parseJSON(data);
		     //   alert(data.code);
		      if(data.code==200){
		    	  
			  }
        },
        error: function(xhr,textStatus,error){
        }
      }); 
        return false;
}