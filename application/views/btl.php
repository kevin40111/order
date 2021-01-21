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
  height: 180px;
    position: relative;
    left: 575px;
      top: 220px;
}

#bg {
  margin: 0 auto;
  width: 1024px;
  height: 768px;
  background: url(/static/images/main20151228.jpg);
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
.modal
{
	left:50%;
}
.modal-body{
	max-height:800px;
}
</style>
<title>登入</title>
</head>
<body>

<div> <!-- width = 圖片寬度 + 30 -->
    <div class='modal-header'>
        <h3>施工中 <?= $this->session->userdata('enemy')?> & <?= $this->session->userdata('uid')?></h3>
		<? echo "Hello World"; ?>
    </div>
</div>

</body>

