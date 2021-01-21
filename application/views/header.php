<!DOCTYPE html>
<html>
<head>
<?=meta('Content-type', 'text/html; charset=utf-8', 'equiv')?>
<script src='/static/js/jquery-1.9.1.js'></script>
<script src='/static/js/bootstrap.min.js'></script>
<script src='/static/js/jquery-ui-1.10.2.custom.min.js'></script>
<?=link_tag('/static/css/smoothness/jquery-ui-1.10.2.custom.min.css')?>

<?=link_tag('/static/css/bootstrap.min.css')?>

<?=link_tag('/static/css/style.css')?>
<script>
$(function(){
	$('#forum').click(function(){
		if(navigator.userAgent.match("MSIE")){
			alert("聊天室不支援IE瀏覽器，推薦使用Google Chrome瀏覽器開啟，Google Chrome瀏覽器可於登入頁右下角圖示進行下載。");
		}else{
			window.open("/forum/pop_forum","member_list","location=0,menubar=0,titlebar=0,status=0,width=1000,top=150,height=650,scrollbars=1");
		}
	});
});
</script>
<title>點餐系統</title>
<style>
.footer .span12 {
	text-align: center;
	color: #777;
	position: fixed;
	bottom: 0;
	width: 100%;
}
    #register-bubble {
        position: absolute;
        top: 11px;
        left: 650px;
    }
#topLine {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%
}
#topLine > .progress-field {
    background: #08C;
    display: block;
    height: 2px
}
</style>
</head>
<body>
<?if (! in_array('block', $this->event_model->get_done_event($this->session->userdata('uid')))): ?>
<style>
#block {
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #000;
  z-index: 999;
  position: fixed;
}
#block-txt {
  top: 45%;
  line-height: 2em;
}
#block-txt2 {
  top: 55%;
  line-height: 2em;
}
#block-txt3 {
  top: 70%;
  right: -35%;
  font-size: 1.5em;
}
.txt {
  position: relative;
  color: #FFF;
  font-size: 3.5em;
  font-family: 微軟正黑體;
  text-align: center;
  display: none;
}
</style>

<?endif;?>
  <div id='topLine'>
    <div class='progress-field' style='width: <?=(($this->session->userdata('start_date') == "") || ($this->session->userdata('end_date') == "")) ? "" : round(((time() - strtotime($this->session->userdata('start_date'))) / (strtotime($this->session->userdata('end_date') . ' 18:00:00') - strtotime($this->session->userdata('start_date'))) * 100), 2) . "%";?>'></div>
  </div>
	<div class="container" style="width: 1000px;">
		<div class="row-fluid" style='margin-top: 10px;'>
			<div class='span12'>
				<div class="navbar">
					<div class='navbar-inner'>
						<a href='/' class='brand'>點餐系統</a>
						<ul class='nav'>
              <li <?=$page == 'member' ? "class='active'" : ''?>>
								<a href="/member"><i class='icon-user'></i> 人員</a>
							</li>
							<li <?=$page == 'order' ? "class='active'" : ''?>>
								<a href="/order"><i class='icon-shopping-cart'></i> 點餐</a>
							</li>
							<li <?=$page == 'vote' ? "class='active'" : ''?>>
								<a href="/vote"><i class='icon-th-list'></i> 投票
                    <?if (isset($count) && $count > 0): ?>
                       <span class="badge badge-info"><?=$count?></span>
                    <?endif;?>
                </a>
							</li>
							<li <?=$page == 'member_edit' ? "class='active'" : ''?>>
								<a href="/member/edit"><i class='icon-info-sign'></i> 個人資料修改</a>
							</li>
							<?if ($this->session->userdata('dep_id') == 1) {?>
								<li <?=$page == 'manage' ? "class='active'" : ''?> style='width: 125px;'>
                                    <?$this->load->model('member_model');?>
									<a href="/manage"><i class='icon-cog'></i> 管理介面</a>
								</li>
							<?}?>
							<li>
								<a href="/login/logout"><i class='icon-off'></i> 登出</a>
							</li>
						</ul>
					</div>
					<div>
						<h4>Welecome Back : <?=$this->session->userdata('name')?></h4>
					</div>
				</div>
			</div>
		</div>
