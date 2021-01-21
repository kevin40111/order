		<div class='row-fluid'>

			<div class='span10'>
				<div id="right_view">
					<h1>投票管理</h1>
					<hr>
						<table class="table" >
							<thead>
							<tr>
								<th style="width: 20%;">投票專案名稱</th><th>限制票數</th><th>專案建立日期</th><th>專案建立人</th><th>投票狀態</th><th></th>
							</tr>
							</thead>
							<tbody>
								<?foreach($vote_list as $row):?>
									<tr>
										<td><?=$row->name ?></td>
										<td><?=$row->limit ?></td>
										<td><?=$row->create_time ?></td>
										<td><?=$row->member ?></td>
										<td><?=$row->status ?></td>
										<td>
											<button data-voteid="<?=$row->id ?>" type="button" class="btn btn-primary stop" >截止投票</button>
											<button data-voteid="<?=$row->id ?>" type="button" class="btn btn-danger del" >刪除</button>
										</td>
									</tr>
								<?endforeach ;?>
							</tbody>
						</table>
			</div>
		</div>
          <div id='bg-container'></div>
<script>

$(".table").delegate(".stop","click",function(){
	if(!confirm("是否截止投票！"))
		return false ;

	var $this = $(this);
	$.post('/vote/vote_close',{voteid:$this.data('voteid')},function(data){
		if(data == 1){
			alert('投票截止');
			$this.parents('tr').remove();
		}
	});


});

$(".table").delegate(".del","click",function(){
	if(!confirm("是否刪除此投票專案！"))
		return false ;

	var $this = $(this);
	$.post('/vote/vote_del',{voteid:$this.data('voteid')},function(data){
		if(data == 1){
			alert('刪除成功');
			$this.parents('tr').remove();
		}
	});

});

</script>
          <style>

  td, th {
    background-color: rgba(255, 255, 255, .85) !important;
  }
          div#bg-container {
    width: 789px;
    height: 564px;
    z-index: -1;
    position: fixed;
    background-repeat: no-repeat;
    top: 200px;
    left: 200px;
  }
          </style>
