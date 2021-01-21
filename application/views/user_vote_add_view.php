		<div class='row-fluid'>
			<div class='span12'>	
				<div id="right_view">
					<h1>投票專案新增</h1>
					<span style="font-size:15pt;">
						投票專案名稱：<input name="vote_project" type="text"  maxlength="30" placeholder="例：本周電影投票">
					</span>
					<span style="font-size:15pt;">
						投票專案截止日：<input class='sel_date' name="project_enddate" type="text">
					</span>
					<p style="font-size:15pt;">最多可投票數：
						<select name="vote_num" style="width: 4em;">
							<?for($i = 1;$i<=5;$i++){?>
								<option value="<?=$i?>"><?= $i?></option>
							<?}?>
						</select>
					</p>
					<p>
						<a id="btnAdd" class="btn btn-primary" ><i class="icon-plus icon-white"></i> 新增投票選項</a>
					</p>
					<hr>
					<div>
						<table class="table">
							<thead>
								<tr>
									<th style="width: 12em;">選項名稱</th><th>選項內容</th><th></th>
								</tr>
							</thead>
							<tbody class='item_list'>				
							</tbody>
						</table>	
						<div style="text-align: right;">
					 		<a id="btnOK" class="btn btn-primary" ><i class="icon-ok icon-white"></i> 確認送出</a>
					 	</div>	
					</div>					
				</div>
					 <div id="dialog" title="選項新增" style="display: none;">
						<table>
							<tr>
								<td>選項名稱：</td>
								<td><input name="name" type="text" maxlength="15" /><small></small></td>
							</tr>
							<tr>
								<td>選項描述：</td>
								<td><textarea name="description" style="width: 550px;height: 250px;" ></textarea></td>
							</tr>
						</table>
					 </div>	
				</div>
			</div>
		</div>
<script>
var bool = true;
$("#btnAdd").click(function(event) {
	if(bool){
		$("#dialog").dialog( "open" );
		bool = false;
	} else {
		$("#dialog").dialog( "close" );
		bool = true;
	}
	event.preventDefault();
});

function clear(){
	$('input[name="name"]').val("");
	$('textarea[name="description"]').val("");
}

$( "#dialog" ).dialog({
			autoOpen: false,
			width: 700,
			buttons: [
				{
					text: "新增",
					click: function() {
						var name = $('input[name="name"]');
						var description = $('textarea[name="description"]');
						if(name.val() == ""){
							alert('選項名稱未填！');
							return false;
						}
						
						if(description.val() == ""){
							alert('選項描述未填！');
							return false;
						}
						//建立TR
						var tr = $('<tr>') ;
						var td_name = $('<td>').text(name.val());
						var td_des = $('<td>').text(description.val());
						var td_btn = $('<td>').html('<a class="btn btn-danger del">刪除</a>');
						tr.append(td_name,td_des,td_btn).appendTo($(".table tbody"));
						
						$(this).dialog("close");
						bool = true;
						clear();
					}
				},
				{
					text: "取消",
					click: function() {
						$(this).dialog("close");
					}
				}
			]
});

$("#btnOK").click(function(event) {
	event.preventDefault();
	if(!confirm('請確定是否送出')){
		return false;
	}
	
	var vote_name = $('input[name="vote_project"]');
	var vote_num = $('select[name="vote_num"]');
	var end_date = $('input[name="project_enddate"]');
	var pass = false;
	if(vote_name.val() == ""){
		alert('專案名稱未填！');
		return false;
	}
	
	var item_num = 0;
	var item_data = new Array();
	var item_temp = new Array();
 	$('.item_list tr').each(function(){
 		item_num++;
 		var name = $('td:eq(0)',this).text();
    var description = $('td:eq(1)',this).text();
      
  	if($.inArray(name,item_temp) > -1) {
  		alert('選項名稱重複請刪除選項。');
  		pass = true;
  		return false;
  	}
  	
    item_temp.push(name);
 		item_data.push({name:name,description:description});
 
 	});	
 	
	if(item_num < parseInt(vote_num.val())){
		alert('票數比選項還多，請減少票數或新增選項');
		return false;
	}
	
	$.post("/vote/vote_create",{
			vote_project: vote_name.val(),
			vote_num: vote_num.val(),
			vote_end_date:end_date.val(),
			item_data: item_data
			},function(data){	
					if(data != 0){
						window.onbeforeunload = null;
						alert('投票專案新增成功！將離開此畫面');
						location.href = "/vote" ;
					}
				}
	);
});

$('.table').delegate(".del","click",function(){	
	 $(this).parents('tr').remove();
});

$('.sel_date').datepicker({
	changeMonth: true,
  changeYear: true,
  minDate: 0, 
  maxDate: "+1M",
  dateFormat: 'yy-mm-dd',
  dayNames: ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
  dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
  dayNamesShort: ['日', '一', '二', '三', '四', '五', '六'],
  monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
  monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"]
});

window.onbeforeunload = function(e){
	return "請確認是否已經編輯完成，如還沒有完成請按取消按鈕！";
}
</script>