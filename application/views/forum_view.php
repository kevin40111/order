		<div class='row-fluid'>
			<div class='span2'>
				<div id='member_view' style="border:1px solid rgb(211, 209, 209);">
					
				</div>
				<p>目前線上人數<span id='member_num'>0</span>位</p>
			</div>
			<div class='span10'>	
				<div>
					<div id='text_view' style="border:1px solid rgb(211, 209, 209);height:500px;overflow-y:auto;overflow-x:hidden;word-wrap:break-word;word-break:normal;font-size: 15px;">
					</div>
					<div>
					 	<input id="text" type="text" style="width: 700px;" />
				 		<a id="submit_btn" class="btn btn-primary">發話</a>
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
	
	/*$(window).focus(function(){
		windowFocus = true;
		newmsg = 0 ;
		title.text('通資作業系統');
	});
	
	$(window).blur(function(){
		windowFocus = false;
	});	*/
	
	
	
	$.getJSON('/forum/get_txt',function(data){
		parse(data.msg,$('#text_view'));
		online(data.member_num,$('#member_view'),$('#member_num'));
		line = data.msg[data.msg.length -1].id ;
		long_poll();
	});	
	
	$('.span2').delegate('p','click',function(){
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
					parse(data.msg,$('#text_view'))
					online(data.member_num,$('#member_view'),$('#member_num'));
					if(!windowFocus) {
						newmsg++;
						title.text('您有新訊息'+newmsg);
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
					location.href = "/login";
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
					location.href = "/login";
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
	
	function parse(data,view) {
		var str ="";
		for(i in data){
			if(data[i].tomember == -1) {
				str += "<p data-name='"+data[i].name+"'>["+data[i].talk_date.substring(5,data[i].talk_date.length)+"] "+data[i].name+" 說："+data[i].talk_text+"</p>";	
			} else {
					if(data[i].name == data[i].toname){
						str += "<p class='text-info' data-name='"+data[i].name+"'>["+data[i].talk_date.substring(5,data[i].talk_date.length)+"] "+"你自言自語："+data[i].talk_text+"</p>";					
					}else if(data[i].tomember == myid) {
						str += "<p class='text-info' data-name='"+data[i].name+"'>["+data[i].talk_date.substring(5,data[i].talk_date.length)+"] "+data[i].name+" 悄悄的對你說："+data[i].talk_text+"</p>";
					} else {
							str += "<p class='text-info' data-name='"+data[i].toname+"'>["+data[i].talk_date.substring(5,data[i].talk_date.length)+"] 你對 "+data[i].toname+" 悄悄的說："+data[i].talk_text+"</p>";
					}
			}
		}
		view.append(str);
		view[0].scrollTop = view[0].scrollHeight;
	}	
	
	
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

