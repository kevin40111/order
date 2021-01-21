<?$this->load->helper("form"); ?>
<!DOCTYPE html>
<html>
<head>
<?= meta('Content-type', 'text/html; charset=utf-8', 'equiv') ?>
<script src='/static/js/jquery-1.9.1.js'></script>
<script src='/static/js/bootstrap.min.js'></script>
<script src='/static/js/jquery-ui-1.10.2.custom.min.js'></script>
<script src='/static/js/snowstorm.js'></script>
<?= link_tag('/static/css/smoothness/jquery-ui-1.10.2.custom.min.css') ?>
<?= link_tag('/static/css/bootstrap.min.css') ?>

<style>
#container {
	width: 220px;
	border: 1px solid #CCC;
	padding: 10px 15px 8px 15px;
	border-radius: 2px;
	box-shadow:0px 2px 15px #CCC;
  	height: 250px;
    position: relative;
	top: 50%;
	margin: auto;
}

#bg {
  margin: auto;
  width: 1024px;
  height: 768px;
  background-repeat: no-repeat;
  }

.alert-red {
	color:#ff0000;
	padding-left: 10px;
	position: relative;
	top: -5px;
}

#download {
  width: 30px;
  height: 30px;
  display: block;
  position: fixed;
  bottom: 10px;
  right: 10px;
}
#download2 {
  width: 30px;
  height: 30px;
  display: block;
  position: fixed;
  bottom: 10px;
  right: 50px;
}
#download3 {
  display: block;
  position: fixed;
  bottom: 15px;
  right: 80px;
}
.modal
{
	left:37%;
}
.modal-body{
	/* max-height:343px; */
	max-height:650px;
}
</style>
<title>登入</title>
</head>
<body>
  <div id='bg'>
	<div id="container">
		<h3>還迎來到點餐系統</h3>
		<?= form_open('/login/checkID')?>
			<p>
				<label>帳號：</label>
				<?= form_input(array(
					'name'	=> 'user',
					'maxlength' => '16',
                    'autofocus' => 'true'
				))?>
			</p>
			<p>
				<label>密碼：</label>
				<?= form_password(array(
					'id' => 'pwd',
					'name'	=> 'pwd',
					'maxlength' => '16'
				))?>
			</p>
			<p>
		    <a id="register" class="btn btn-primary" >註冊</a>
		   	<a id="btnlogin" class="btn btn-primary" style="margin-left:110px;" >登入</a>
	   	</p>
	   	<!--<a href="/login/googledown" >GoogleChrome Download</a>-->
		<?= form_close()?>

	</div>
	<div id="dialog" title="帳號註冊" style="display: none;">
	 <form name="register" method="post" action="/member/add">
	 	<span class="alert-red">*代表必填欄位</span>
			<table>
				<tr>
					<td>姓名：</td>
					<td><input name="name" maxlength="5" type="text" title="請輸入正確的姓名，之後不能修改姓名"/><span class="alert-red">*</span></td>
				</tr>

				<tr>
					<td>暱稱：</td>
					<td><input name="nickname" maxlength="30" type="text"/></td>
				</tr>
				<tr>
					<td>生日：</td>
					<td><input class="date_bri" name="birth" type="text"/></td>
				</tr>
				<tr>
					<td>計畫</td>
					<td>
						<select id='dep_id' name='dep_id' >
							<option class="selectindex" value="-1" >請選擇計畫</option>
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
					<td>帳號：</td>
					<td><input name="username" maxlength="16" type="text"/><span id="account_check" class="alert-red">*</span></td>
				</tr>
				<tr>
					<td>設定密碼：</td>
					<td><input name="password" maxlength="16" type="password"/><span class="alert-red">*</span></td>
				</tr>
				<tr>
					<td>確認密碼：</td>
					<td><input name="chkpwd" maxlength="16" type="password"/><span class="alert-red">*</span></td>
				</tr>
			</table>
	 </form>
  </div>
    </div>
</body>
<script>

$('#btnlogin').click(function(){
	$('#container form').submit();
});

$('#pwd').keyup(function(e){
	if(e.which == 13 || e.keyCode == 13) {
		$('#container form').submit();
	}
});

$("#register").click(function( event ) {
	clear();
	$( "#dialog" ).dialog( "open" );
	event.preventDefault();
});

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

function clear(){
	$('#dialog input').val("");
	$('.selectindex').attr('selected','selected')
}

//新增人員
function check_input(){
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

	if(dep_id == -1){
		alert("請選擇計畫");
		return false;
	}
	if(username == ""){
		alert("請輸入帳號");
		return false;
	}
	if($('input[name="username"]').hasClass('error')){
		alert("帳號重複");
		return false;
	}
	if(password == ""){
		alert("請輸入密碼");
		return false;
	}
	if(chkpwd == ""){
		alert("請輸入確認密碼")
		return false;
	}
	if(password != chkpwd){
		alert("請再確認密碼是否輸入正確")
		return false;
	}

	return true;
} //新增人員

$( "#dialog" ).dialog({
			autoOpen: false,
			width: 400,
			buttons: [
				{
					text: "送出",
					click: function() {
						var obj = $('form[name="register"]').serializeArray();
						var $this = $(this);
						if(check_input()){
							$.post('/member/add',obj,function(data){
								if(data == 1){
									alert('帳號已申請成功，請等待管理員審核');
								}
								clear();
								$this.dialog( "close" );
							});
						}
					}
				},
				{
					text: "取消",
					click: function() {
						//clear();
						$( this ).dialog( "close" );
					}
				}
			]
});

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
</script>
</html>
<?= isset($message) ? $message : "" ?>
