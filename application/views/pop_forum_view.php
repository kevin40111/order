<!DOCTYPE html>
<html>
<head>
<title>通資作業系統</title>
<?= meta('Content-type', 'text/html; charset=utf-8', 'equiv') ?>
<script src='/static/js/jquery-1.9.1.js'></script>
<script src='/static/js/bootstrap.min.js'></script>
<script src='/static/js/jquery-ui-1.10.2.custom.min.js'></script>
<?= link_tag('/static/css/smoothness/jquery-ui-1.10.2.custom.min.css') ?>
<?= link_tag('/static/css/bootstrap.min.css') ?>

<style>
  *{
    font-family: 微軟正黑體
  }
	.footer .span12 {
		text-align: center;
		color: #777;
		position: fixed;
		bottom: 0;
		width: 940px;
	}
  #register-bubble {
      position: absolute;
      top: 11px;
      left: 650px;
  }
  #member_view > p{
    margin: 8px 6px;
    padding: 6px 8px;
  }
  #member_view > p:hover {
    background: #08C;
    color: #FFF;
  }
  #member_view > p.self:hover {
    background: transparent;
    color: #000;
  }
  #speak-field {
    margin-top: 8px;
  }
  #text_view {
    padding-left: 8px;
  }
  .time {
    color: #AAA;
    font-size: 60%
  }
  #submit_btn {
    position: relative;
    top: -5px;
  }
  #pic_btn {
	position: relative;
    top: -5px;
  }
</style>
</head>
<body>
	<div class="container">
		<div>
			<p></p>
		</div>
				<div class='row-fluid'>
			<div class='span2'>
				<div id='member_view' style="border:1px solid rgb(211, 209, 209);">
					
				</div>
				<p>目前線上人數<span id='member_num'>0</span>位</p>
			</div>
			<div class='span10'>	
				<div>
					<div id='text_view' style="border:1px solid rgb(211, 209, 209);width:600px;height:490px;overflow-y:auto;overflow-x:hidden;word-wrap:break-word;word-break:normal;font-size: 15px;">
					</div>
					<div id='speak-field'>
					 	<input id="text" type="text" style="width:478px;" />
						<div class="btn-group">
							<button id="pic_btn" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								<i class='icon-picture icon-white'></i>
							</button>
							<table class="dropdown-menu">
								<tbody>
									<?$count = 0;?>
									<?foreach($stickers as $row):?>									   	   <? $count++; ?>										
										<?if($count%3 == 0):?>
												<td><img class="sticker" name="<?= $row->tag ?>" src="/static/images/sticker/<?= $row->path ?>" style="width: 50px"></img></td>
											</tr>
										<?endif?>
										<?if($count%3 == 1):?>
											<tr>
												<td><img class="sticker" name="<?= $row->tag ?>" src="/static/images/sticker/<?= $row->path ?>" style="width: 50px"></img></td>
										<?endif?>
										<?if($count%3 == 2):?>
												<td><img class="sticker" name="<?= $row->tag ?>" src="/static/images/sticker/<?= $row->path ?>" style="width: 50px"></img></td>							
										<?endif?>
									<?endforeach; ?>
								</tbody>
							</table>
						</div>
				 		<a id="submit_btn" class="btn btn-primary"><i class='icon-bullhorn icon-white'></i> 發話</a>
					</div>
				</div>
			</div>
		</div>
<script>
(function(){
	var windowFocus = true;
	var title= $('title');
	var line = "";
	var newmsg = 0;
	var myid = <?= $this->session->userdata('uid')?>;
	
	$(window).bind('focus',function(){
		windowFocus = true;
		newmsg = 0 ;
		document.title = '通資作業系統';
	});
	
	$(window).bind('blur',function(){
		windowFocus = false;
	});
	
	
	$.getJSON('/forum/get_txt',function(data){
		parse(data.msg,$('#text_view'),data.stickers);
		online(data.member_num,$('#member_view'),$('#member_num'));
		line = data.msg[data.msg.length -1].id ;
		long_poll();
	});	
	
	$('#member_view').delegate('p','click',function(){
		$('#text').val("/w "+$(this).text()+" ");
	});
	
	$('#text_view').delegate('p','click',function(){
		$('#text').val("/w "+$(this).data('name')+" ");
	});
	var long_poll = function long_poll(){
		$.getJSON('/longpoll',{line:line},function(data){
			  if(data.msg.length == 0) {
			  	online(data.member_num,$('#member_view'),$('#member_num'));
			  	long_poll();
			  }
			  else {
					parse(data.msg,$('#text_view'), data.stickers)
					online(data.member_num,$('#member_view'),$('#member_num'));
					if(!windowFocus) {
						newmsg++;
						document.title = '您有新訊息'+newmsg ;
					}
					
					line = data.msg[data.msg.length -1].id ;
				  long_poll();
			  }
		});
	}

	var submit = function (){
		var $this = $('#text');
		var txt = $.trim($this.val());
		if(txt == ""){
			return false;
		}
		
		var txtarr = txt.match(/\/w +([^ ]*) +(.*)/i);
		if( txtarr == null){
			$.post('/forum/set_txt',{text:txt},function(data){
				$this.val("");	
				if(data == 0)
				{
					alert('已經被登出，請重新登入');
				}
			});	
		} 
		else {
			$.post('/forum/set_to_txt',{member:txtarr[1],text:txtarr[2]},function(data){
				$this.val("");
				$this.val("/w "+txtarr[1]+" ");
				if(data == 0)
				{
					alert('已經被登出，請重新登入');
				}
			});
		}	
	}
	
	function online(data,view,num){
		var member_str ="";
		var member_num = 0;
		for(i in data){
			member_str += "<p>"+data[i].name+"</p>"
			member_num ++ ;
		}
		num.text(member_num);
		view.html(member_str);
	}
	
	function parse(data,view,stickers) {
		var str ="";
		for(i in data){
			if(data[i].talk_text.match(/\[(\w)*\]/)) {
				var tag = data[i].talk_text.match(/\[(\w)*\]/g);
				for(k in tag) {
					for(j in stickers) {
						if(stickers[j].tag == tag[k].substring(1, tag[k].length-1)) {
							data[i].talk_text = data[i].talk_text.replace(tag[k], "<img src='/static/images/sticker/"+stickers[j].path+"' style='width:50px;'></img>");
							break;
						}
					}
				}
			}

			if(data[i].tomember == -1) {
				str += "<p data-name='"+data[i].name+"'><span class='time'>[ "+data[i].talk_date.substring(5,data[i].talk_date.length - 3)+" ]</span> "+data[i].name+" 說："+data[i].talk_text+"</p>";	
			} else {
					if(data[i].name == data[i].toname){
						str += "<p class='text-info' data-name='"+data[i].name+"'><span class='time'>[ "+data[i].talk_date.substring(5,data[i].talk_date.length - 3)+" ]</span> 你自言自語："+data[i].talk_text+"</p>";
					}else if(data[i].tomember == myid) {
						str += "<p class='text-info' data-name='"+data[i].name+"'><span class='time'>[ "+data[i].talk_date.substring(5,data[i].talk_date.length - 3)+" ]</span> "+data[i].name+" 悄悄的對你說："+data[i].talk_text+"</p>";				
					} else {
						str += "<p class='text-info' data-name='"+data[i].toname+"'><span class='time'>[ "+data[i].talk_date.substring(5,data[i].talk_date.length - 3)+" ]</span> 你對 "+data[i].toname+" 悄悄的說："+data[i].talk_text+"</p>";
					}
			}
		}
		view.append(str);
		view[0].scrollTop = view[0].scrollHeight;
	}	
	
	$('.sticker').click(function(){
		$('#text').val($('#text').val()+"["+ $(this).attr("name") +"]");
	});

	$('#submit_btn').click(function(){
		submit();
	});
	
	$('#text').keyup(function(e){
		if(e.which == 13 || e.keyCode == 13 ) { 
			submit();
		}
	});
	
})();

</script>
<style>
.whisper{
	color: rgb(255,0,0);
}

#member_view p{
	cursor:pointer;
}

#text_view p{
	cursor:pointer;
}
</style>

		<!--<div class='footer row-fluid'>
			<div class='span12 text-center' data-a="2013 © 3rd Communication & Electronics Information Company of Coast Guard Administration"></div>
		</div>-->
	</div>
</body>
</html>	