		<div class='row-fluid'>
			<div class='span10'>
				<h1>新增人員</h1>
				<hr>
				<form id='member_form' method="post" action='/member/add' >
					<span class="alert-red">*代表必填欄位</span>
					<table>
						<tr>
							<td>姓名：</td>
							<td><input name="name" maxlength="5" type="text"/><span class="alert-red">*</span></td>
						</tr>
						<tr>
							<td>位階：</td>
							<td>
								<select id="rank_id" name="rank_id">
								<option value="-1">請選擇位階</option>
									<?foreach($rank as $row):?>
										<option value="<?= $row->id?>"><?= $row->name?></option>
									<?endforeach;?>
								</select><span class="alert-red">*</span>
							</td>
						</tr>
						<tr>
							<td>狀態：</td>
							<td><input name="nickname" maxlength="10" type="text"/></td>
						</tr>
						<tr>
							<td>生日：</td>
							<td><input class="date_bri" name="birth" type="text"/></td>
						</tr>
						<tr>
							<td>處室：</td>
							<td>
								<select id='dep_id' name='dep_id' >
								<option value="-1">請選擇處室</option>
									<?foreach ($dep as $row) : ?>
										<option value="<?= $row->id?>"><?= $row->name?></option>
									<?endforeach; ?>
								</select><span class="alert-red">*</span>
							</td>
						</tr>
						<tr>
							<td>手機：</td>
							<td><input name="phone" maxlength="15" type="text"/></td>
						</tr>
						<tr>
							<td>住家地址：</td>
							<td><input name="address" type="text"/></td>
						</tr>
						<tr>
							<td>帳號：</td>
							<td><input name="username" maxlength="10" type="text"/><span id="account_check" class="alert-red">*</span></td>
						</tr>
						<tr>
							<td>設定密碼：</td>
							<td><input name="password" maxlength="10" type="password"/><span class="alert-red">*</span></td>
						</tr>
						<tr>
							<td>確認密碼：</td>
							<td><input name="chkpwd" maxlength="10" type="password"/><span class="alert-red">*</span></td>
						</tr>
						<tr>
							<td colspan="2" class='tdright'>
								<button id="member_submit" type="submit" class="btn btn-primary" >確認</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
<script>
$('.date_selesct').datepicker({
	changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',
  dayNames: ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
  dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
  dayNamesShort: ['日', '一', '二', '三', '四', '五', '六'],
  monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
  monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"]
});


$('.date_bri').datepicker({
	changeMonth: true,
  changeYear: true,
  yearRange: "-50:-16",
  dateFormat: 'yy-mm-dd',
  dayNames: ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
  dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
  dayNamesShort: ['日', '一', '二', '三', '四', '五', '六'],
  monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
  monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"]
});

//檢查帳號
$('input[name="username"]').keyup(function(){
	var username = $(this);
	$.get('/member/check_username',{username:username.val()},function(data){
		if(data != 0){
			username.next().text("帳號重複");
			username.addClass('error');
		}else	{
			username.next().text("*");
			username.removeClass('error');
		}
	});
});

//新增人員
$("#member_form").submit(function(){
	var name = $('input[name="name"]').val(),
			nickname = $('input[name="nickname"]').val(),
			birth = $('input[name="birth"]').val(),
			dep_id = $('select[name="dep_id"]').val(),
			username = $('input[name="username"]').val(),
			password = $('input[name="password"]').val(),
			chkpwd = $('input[name="chkpwd"]').val(),
			start_date = $('input[name="start_date"]').val(),
			end_date = $('input[name="end_date"]').val(),
			rank_id = $('select[name="rank_id"]').val();

//檢查欄位
	if	(name == ""){
		alert("姓名不得為空");
		return false;
	}
	else if(rank_id == -1){
		alert("請選擇位階");
		return false;
	}
	else if	(dep_id == -1){
		alert("請選擇處室");
		return false;
	}
	else if	(username == ""){
		alert("請輸入帳號");
		return false;
	}
	else if($('input[name="username"]').hasClass('error')){
		alert("帳號重複");
		return false;
	}
	else if	(password == ""){
		alert("請輸入密碼");
		return false;
	}
	else if	(chkpwd == ""){
		alert("請輸入確認密碼")
		return false;
	}
	else if	(password != chkpwd){
		alert("請再確認密碼是否輸入正確")
		return false;
	}

}); //新增人員

</script>
<style>
.alert-red {
	color:#ff0000;
	padding-left: 10px;
	position: relative;
	top: -5px;
}

.tdright {
text-align:right;
}
</style>
