<style type="text/css">
	.flow {
		margin: auto;
		width: 500px;
		
	}
	.title_text{
		padding:0px;
		width: 486px;

	}

	.content_text{
		width: 486px;
		height: 70px;
		resize: none;
	}

	.content {

		height: 340px;
		
	}

	label > input
	{
		display: none;

	}	

	.btn_position_div{
		width: 500px;
		text-align: right;
		margin-top: 15px;

	}

	#preview_img{
		box-shadow: 0 0 10px 3px grey;
		display: none;
	}

	div#bg-contaier{
		background-image: url(/static/images/member_list_2.jpg);
		height: 750px;
		background-repeat:no-repeat;
		background-position-y: 45px;

	}


</style>

<h1>娛樂版</h1>
<div id = "bg-contaier" >
	<div class='flow' >    
		<div class = "img_upload">
			<form action="/funbord/upload" method="post" enctype="multipart/form-data" >
					<input id = "title_input" name="title" class = "title_text" type="text" placeholder="Title" >
				    <textarea id ="content_input" name="content" class = "content_text" type="text" placeholder="Content"></textarea>

					<label for = "file-input"><img  class = "icon-camera" >
						<input 	id = "file-input" name="file-input" type="file"  onchange="readURL(this)">
					</label>

					<img class="preview_img" src="" id = "preview_img" >
					<div class = "btn_position_div">
						<input type="text" style="display:none" name = "ext" id= "ext">
						<input type="button" class="control-btn btn btn-warning" id="preview" value="瀏覽">
						<input type="submit" class="control-btn btn btn-primary" name="submit" value="上傳">
					</div>
			</form>			
		</div>
	</div>
</div>

<script type="text/javascript" >
<?echo isset($message) ? $message: $message="";?>
var img_address="";//locoal img temp address
function readURL(input){
	try
	{	
		var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.')+1).toLowerCase();
		$('#ext').val(ext);
		if(input.files&&(ext == "gif" || ext == "png" || ext =="jpeg" || ext == "jpg")){
			
			var reader = new FileReader();
			reader.onload = function(e){
				img_address=e.target.result;
				$('#preview_img').attr('src',img_address);
				$('#preview_img').show();	
			};
			reader.readAsDataURL(input.files[0]);
		
		}
		

		else{
			alert("無法顯示");
		}
	}
	catch(err)
	{	
		img_address="";
		$('#preview_img').hide();
			
	}
}

/*preview board*/
$(function() {
  $('#preview').on('click', function(event) {
    event.preventDefault(); 
    
    var title = $('#title_input').val();
   	var content = $('#content_input').val();
   	var writer = "<?= $this->session->userdata('name');?>";
  	
   	$('#title').text(title);
   	$('#modal-content').text(content);
   	$('#modal-writer').text(writer);
   //	$('#modal-footer').text("by "+writer);
   		if(img_address!=="" ){
   			$('#model_img').attr("src",img_address);
   			$('#model_img').show();
		}
		else{
			$('#model_img').hide();	
		}  	
    $("#fun_modal").modal("show");
  });
});

</script>


