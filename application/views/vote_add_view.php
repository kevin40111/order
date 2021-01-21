		<div class='row-fluid'>
			<?= $manage_menu ?>
			<div class='span10'>	
				<div id="right_view">
					<h2>投票專案新增</h2>
					<span>專案名稱：</span><input name="vote_project" type="text"  maxlength="30" placeholder="例：本周電影投票">
					<span>限制票數：</span><input name="vote_num" type="text" maxlength="1" style="width: 20px;" >	
					<hr>	
						<table class="table">
							<thead>
								<tr>
									<th>選項名稱</th><th>選項內容</th><th></th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					<hr>								
					
				</div>
						<table>
							<tr>
								<td>選項名稱：</td>
								<td><input name="name" type="text" maxlength="15" /></td>
							</tr>
							<tr>
								<td>選項描述：</td>
								<td><textarea name="description" style="width: 550px;height: 250px;" ></textarea></td>
							</tr>
							<tr>
								<td colspan="2" style="text-align: right;">
									<a id="btnAdd" class="btn btn-primary" >新增投票選項</a>
								</td>	
							</tr>
						</table>	
						<input name="vote_id" type="hidden" >	
				</div>
			</div>
		</div>
<script>
$('#btnAdd').click(function(){
	var vote_name = $('input[name="vote_project"]');
	var vote_num = $('input[name="vote_num"]');
	var name = $('input[name="name"]');
	var description = $('textarea[name="description"]');
	var vote_id = $('input[name="vote_id"]');

	if(vote_name.val() == ""){
		alert('專案名稱未填！');
		return false;
	}
	
	if(isNaN(vote_num.val()) || vote_num.val() =="" || vote_num.val() == 0 ){
		alert('限制票數，填入數字，不得為0票！');
		return false;
	}
	
	if(name.val() == ""){
		alert('選項名稱未填！');
		return false;
	}
	if(description.val() == ""){
		alert('選項描述未填！');
		return false;
	}
	
	$.post("/vote/vote_add",{
		vote_name:vote_name.val(),
		vote_num:vote_num.val(),
		name:name.val(),
		description:description.val(),
		vote_id:vote_id.val()
	},
	function(data){
		vote_id.val(data.vote_id);
		var tr = $('<tr>') ;
		var td_name = $('<td>').text(name.val());
		var td_des = $('<td>').text(description.val().slice(0,35) + "...");
		var td_btn = $('<td>').html('<button class="btn btn-danger del" data-item="'+data.item_id+'">刪除</button>');
		tr.append(td_name,td_des,td_btn).appendTo($(".table tbody"));
		name.val("");
		description.val("");
	},"json"); // end Post ajax	
	vote_name.attr("disabled","disabled");
	vote_num.attr("disabled","disabled");

});

$('.table').delegate(".del","click",function(){	
	var $this = $(this);
	$.post("/vote/item_del",{itemid:$(this).data('item')},function(data){
		if(data == 1) {
			alert('刪除成功！');
			$this.parents('tr').remove();
		}
	});
});

window.onbeforeunload = function(e){
return "請確認是否已經編輯完成，如還沒有完成請按取消按鈕";
};
  
</script>