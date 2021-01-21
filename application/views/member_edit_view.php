		<div class='row-fluid'>
			<div class='span2'>
				<div id="left_view">
					<p>姓名：<?= $this->session->userdata('name') ?></P>
					<p>狀態：<?= ($this->session->userdata('nickname') != "" ) ? $this->session->userdata('nickname') : $this->session->userdata('name') ?></P>
					<p>處室：<?= $this->session->userdata('dep_name') ?></P>
					<a id='edit_pwd' class="btn btn-primary">密碼修改</a>
				</div>
			</div>
			<div class='span10'>
				<div id="right_view">
				<h1>個人資料修改</h1>
				<hr>
					<form id='member_edit_form' action='/member/edit_action' method='post' >
						<table>
							<tr>
								<td>狀態：</td>
								<td><input name="nickname" type="text" value='<?= $member->nickname ?>'/></td>
							</tr>
							<tr>
								<td>生日：</td>
								<td><input class="date_bri" name="birth" type="text" value="<?= $member->birth ?>"/></td>
							</tr>
							<tr>
								<td>手機：</td>
								<td><input name="phone" maxlength="15" type="text" value="<?= $member->phone ?>" /></td>
							</tr>
							<tr>
								<td>住家地址：</td>
								<td><input name="address" type="text" value="<?= $member->address ?>" /></td>
							</tr>
							<tr>
								<td colspan="2" class='tdright'>
								</td>
							</tr>
						</table>
						<a id="btn_edit_member" class="btn btn-primary" >修改確認</a>
					</form>
					<div id="dialog" style="display: none;">
						<form id="edit_pwd_form" method="post" action="/member/edit_pwd"  >
							<table>
								<tr>
									<td>舊密碼：</td>
									<td><input name="check_pwd" maxlength="16" type="password"></td>
								</tr>
								<tr>
									<td>重設密碼：</td>
									<td><input name="pwd" maxlength="16" type="password"></td>
								</tr>
								<tr>
									<td>確認密碼：</td>
									<td><input name="ckpwd" maxlength="16" type="password" disabled="disabled"></td>
								</tr>
							</table>
						</form>
					</div>
			</div>
		</div>
<div id='bg-container'></div>
<script>

$('input[name="pwd"]').keyup(function(){
	$('input[name="ckpwd"]').removeAttr('disabled',null);
});

$('#btn_edit_member').click(function(){

	if($('.date_bri').val() != "")
	{
		if(!checkdate($('.date_bri').val())){
		alert('生日格式錯誤');
		return false;
		}
	}
	/*
	if(!checkdate($('.startdate').val())){
		alert('入伍日期格式錯誤');
		return false;
	}

	if(!checkdate($('.enddate').val())){
		alert('退伍日期格式錯誤');
		return false;
	}*/
	/*else{
		$('.enddate').val($('.real_end_date').val());
	}*/
	$('#member_edit_form').submit();
});

var checkdate = function(strdate) {
	var re = new RegExp("^([0-9]{4})[.-]{1}([0-9]{1,2})[.-]{1}([0-9]{1,2})$");
	if(re.exec(strdate) != null) {
		newdate = re.exec(strdate);
		var bool = true ;
		if(!(newdate[1] > 1911 && newdate[1] < 2200))
		{
			bool = false ;
		}
		if(!(newdate[2] > 0 && newdate[2] <= 12))
		{
			bool = false ;
		}
		if(!(newdate[3] > 0 && newdate[2] <= 31))
		{
			bool = false ;
		}
	}
	return bool;
}

$("#dialog").dialog({
			autoOpen: false,
			title: "修改密碼",
			width: 400,
			hight: 300,
			buttons: [
				{
					text: "確認修改",
					click: function() {
						var check_pwd = $('input[name="check_pwd"]').val();
						var pwd = $('input[name="pwd"]').val();
						var ckpwd = $('input[name="ckpwd"]').val();
						$.post("/member/check_pwd",{check_pwd: check_pwd },function(message){
							if(message == 1) {
								if(pwd != "" && ckpwd != "" ) {
									if(pwd == ckpwd ) {
										$('#edit_pwd_form').submit();
										$(this).dialog("close");
									} else {
										alert('確認密碼錯誤');
									}
								} else {
									alert("修改密碼欄位不得為空");
								}
							} else {
								alert('舊密碼錯誤');
							}
						});
					}
				},
				{
					text: "取消修改",
					click: function() {
						var hpwd = $('input[name="hpwd"]');
						var pwd = $('input[name="pwd"]');
						var ckpwd = $('input[name="ckpwd"]');
						hpwd.val("");
						pwd.val("");
						ckpwd.val("");
						ckpwd.attr('disabled','disabled');
						$(this).dialog("close");
					}
				}
			]
});

$("#edit_pwd").click(function(event) {
			$("#dialog").dialog("open");
			event.preventDefault();
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

$('.sel_date').datepicker({
	changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',
  dayNames: ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
  dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
  dayNamesShort: ['日', '一', '二', '三', '四', '五', '六'],
  monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
  monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"]
});

$('.sel_date_end').datepicker({
	changeMonth: true,
  changeYear: true,
  dateFormat: 'yy-mm-dd',

  dayNames: ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
  dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
  dayNamesShort: ['日', '一', '二', '三', '四', '五', '六'],
  monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
  monthNamesShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"]
});

</script>
<style>
div#bg-container {
    width: 789px;
    height: 654px;
    z-index: -1;
    position: fixed;
    background-repeat: no-repeat;
    top: 180px;
    left: 450px;
  }
</style>
