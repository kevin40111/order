		<div class='row-fluid'>
			<div class='span12'>
				<div id="right_view">
				<h1>投票列表</h1>
					<div>
						<a href="/vote/user_vote" class="btn btn-primary"><i class="icon-pencil icon-white"></i> 新增投票專案</a>
						<a href="/vote/history" class="btn btn-success"><i class="icon-list-alt icon-white"></i> 歷史紀錄</a>
					</div>
				<hr>
				<table class="table">
					<thead>
						<tr>
							<th style="width: 25em;">投票名稱</th><th>投票發起人</th><th>投票建立時間</th><th>參與人數</th><th></th>
						</tr>
					</thead>
					<tbody>
						<?foreach( $list as $row):?>
							<tr>
								<td><?= $row->name ?></td>
								<td><?= $row->member ?></td>
								<td><?= $row->create_time ?></td>
								<td><?= $row->member_num ?></td>
								<td>
									<a href="/vote/item_view/<?=$row->id ?>/open" class="btn btn-success" >投票</a>
									<?= ($row->creator_id == $userid) ? "<a data-voteid='$row->id' class='btn btn-primary stop'>截止</a>": ""?>
									<?= ($row->creator_id == $userid) ? "<a data-voteid='$row->id' class='btn btn-danger del'>刪除</a>": ""?>
								</td>
							</tr>
						<?endforeach;?>
					</tbody>
				</table>
				</div>
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



$('.table').delegate('.del','click',function(){
	var $this = $(this);
	if(!confirm('確認刪除?'))
	 return false ;
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
