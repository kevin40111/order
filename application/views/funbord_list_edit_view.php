<style type="text/css">
	.img_show{
		box-shadow: 0px 0px 10px 0.5px;

	}

	tr:nth-child(even){
		background-color: rgba(128, 128, 128, 0.15);
	}



</style>		
		<div class='row-fluid'>
			<div class='span10'>	
				<h1>娛樂版管理</h1>
				<hr>
				<table class="table">
					<thead>
						<tr>
							<th>作者</th>
							<th>標題</th>
							<th>內容</th>
							<th>圖片</th>

						</tr>
					</thead>
					<tbody id='bord_data'>			
						<?foreach ($funbord_data as $row ): ?>
								<tr data-uid='<?=$row->bord_id;?>'>
									<td width="80px"><?=$row->writer;?></td>
									<td width="150"><?=$row->title;?></td>
									<td width="300px"><?=$row->content;?></td>
									<td>					
										 	<a class="img_button icon-zoom-in"></a>																		
											<img class="img_show" src='<?=$row->path;?>' id='<?=$row->id;?>' style="display:none;width:200px;">
									</td>

									<td width="60px;">
										<a class="delete_button btn btn-danger">
    									<i class="icon-remove icon-white"></i>刪除</a>
    								</td>
								</tr>
						<?endforeach;?>	
					
					</tbody>
				</table>
			</div>
		</div>
<script>

$(function() {
 	$("#bord_data").on('click', ".img_button", function(e){
 		var img_button = $(this);
 		var img_show = $(this).parent("td").find('.img_show');
 		$(img_show).css("display","block");	 
 		$(img_button).css("display","none");

 	}); 
 });

$(function(){
	$(".delete_button").click(function(){
		var row = $(this).parent().parent("tr");
		var data_uid=row.data("uid");

		$.post("/manage/delete_funbord",
		{
			"bord_id": data_uid 
		},
		function(data,status){
			if(status == "success"){
				alert("刪除成功");
				row.remove();
			}
		});
		
	});
});

</script>
<style>
</style>