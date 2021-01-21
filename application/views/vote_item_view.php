<div class='row-fluid'>
    <div class='span12'>
        <div id="right_view">
        <h2>投票列表</h2>
        <?= $type == "open" ? "<a href='/vote' class='btn btn-success'><i class='icon-chevron-left icon-white'></i> 回上頁</a>" : "<a href='/vote/history' class='btn btn-success'><i class='icon-chevron-left icon-white'></i> 回上頁</a>" ?>
        <div style="text-align:right;">
        	<span style="font-size: 20px;background-color:rgb(194, 255, 253);">可投票數：<span  class='num' data-num='<?= $maxvote[0]->num ?>'><?= $maxvote[0]->num ?></span> / <?= $maxvote[0]->num ?> 票</span>
        </div>
        <hr>
        <table class="table" data-num='<?= $maxvote[0]->num ?>'>
            <thead>
                <tr>
                    <th style="width: 7em;">選項名稱</th>
                    <th>選項內容</th>
                    <th style="width: 3em;">票數</th>
                    <? if($type == "open"):?>
                    <th style="width: 4em;">投票</th>
                    <? endif ;?>
                </tr>
            </thead>
            <tbody>
                <?foreach( $item_list as $row):?>
                    <tr data-bool="<?=$row->bool?>" >
                        <th><?= $row->name ?></th>
                        <td><?= $row->description ?></td>
                        <td><?= $row->vote_total ?></td>
                        <? if($type == "open"):?>
                        <td>
                            <?if($row->bool == 0 ){?>
                             <a data-item='<?=$row->id ?>' class='vote btn btn-success' >投票</a>
                            <?}else{ ?>
                             <a data-item='<?=$row->id ?>' class='cl btn btn-danger' >取消</a>
                            <?}?>
                        </td>
                        <? endif ;?>
                    </tr>
                <?endforeach;?>
            </tbody>
        </table>
        </div>
    </div>
</div>
<div class='row-fluid'>
    <div class='span12'>
        <h3>評論留言</h3>
    </div>
    <div class='span12'>
        <ul id='comments'>
            <? foreach ($comments as $comment):?>
            <li data-id='<?= $comment->id?>'>
                <div class='avatar'></div>
                <div class='content'>
                    <h4><?= $comment->member?></h4>
                    <p><?= $comment->comment?></p>
                </div>
                <? if ($comment->member_id == $this->session->userdata('uid')):?>
                <div class="remover"><i class="icon-remove"></i></div>
                <? endif;?>
                <div class='clearfix'></div>
            </li>
            <? endforeach;?>
            <li id='commenter'>
                <div class='avatar'></div>
                <div class='content'>
                    <h4><?= $this->session->userdata('name')?></h4>
                    <input type='text' placeholder="請輸入留言內容" class='comment-input' />
                </div>
                <div class='clearfix'></div>
            </li>
            <div class='clearfix'></div>
        </ul>
    </div>
</div>
<div id='bg-container'></div>
<li class='tmpl'>
    <div class='avatar'></div>
    <div class='content'>
        <h4></h4>
        <p></p>
    </div>
    <div class="remover"><i class="icon-remove"></i></div>
    <div class='clearfix'></div>
</li>
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
.tmpl {
    display: none;
}
.remover {
    float: right;
    position: relative;
    right: 4px;
    top: 2px;
    display: none;
    cursor: pointer;
}
#comments {
    border: 1px solid #CCC;
    margin: 0;
    list-style: none;
    padding: 0;
    margin-top: 20px;
    margin-bottom: 4em;
    padding: 8px 6px;
    width: 403px;
}
#comments > li {
    width: 400px;
    background: #E2E2E2;
    border: 1px solid #627AAD;
    margin: 0 0 6px 0;
    border-radius: 2px;
}
#comments > li:hover .remover{
    display: block;
}
.avatar, .content {
    float: left;
}
.avatar {
    margin: 5px;
    width: 50px;
    height: 50px;
    background: #FEFEFE;
    border: 1px solid #CCC;
    display: block;
}
.content h4 {
    margin: 6px 0 0 4px;
}
.content p {
    margin: 4px 0 0 4px;
    width: 330px;
}
#commenter {
    background: #F2F2F2 !important;
    border: 1px solid #E2E2E2 !important;
    margin: 0 !important;
}
#commenter.focus {
    border: 1px solid #3D5998 !important;
}
.content .comment-input {
    margin: 4px 0 8px 4px;
    width: 310px;
}
.content .comment-input:focus {
    border: 1px solid #CCC !important;
    box-shadow: none;
}

thead th {
	font-size: 16px;
}
</style>
<script>
(function(){
// Comment
	$("#commenter").delegate("input", 'focus', function(e) {
	    $("#commenter").addClass('focus');
	});
	$("#commenter").delegate("input", 'blur', function(e) {
	    $("#commenter").removeClass('focus');
	});
	$("#commenter input").keyup(function (e) {
	    var $this = $(this),
	        key = e.which || e.keyCode,
	        val = $this.val();

	    if (key == 13 && val != '' && !$this.hasClass('disabled')) {
	        e.preventDefault();
	        $this.prop('disabled', true);
	        $this.addClass('disabled');
	        $.post('/vote/add_comment/<?= $voteID?>', {comment: val}, function (insertID){
	            var commenter = $("#commenter"),
	                newComment = $(".tmpl").clone();

	            newComment
	                .removeClass('tmpl')
	                .data('id', insertID)
	                .find('h4')
	                .text('<?= $this->session->userdata('name')?>')
	                .end()
	                .find('p')
	                .text(val);

	            commenter.before(newComment);
	            $this.parents('#commenter').removeClass('active');
	            $this.val('').blur();
	            $this.removeClass('disabled');
	            $this.removeProp('disabled');
	        });
	    }
	});
	$("#comments").delegate('.remover', 'click', function (e) {
	    var $this = $(this),
	        li = $this.parents('li'),
	        commentID = li.data('id');

	    $.getJSON('/vote/remove_comment/' + commentID, {}, function (json){
	        li.fadeOut(function(){
	            li.remove();
	        });
	    });
	});

	var initcount = 0 ;
	$("tbody tr").each(function(){
		var $this = $(this);
		if($this.data('bool')){
			initcount++;
		}
	});
	$(".num").text($(".num").text() - initcount);
	// Vote
	$("tbody").delegate(".vote","click",function(){
	  var $btn = $(this);
	  $.post("/vote/action_vote",{itemid:$btn.data('item')},function(data){
	    if(data == -1 ) {
	      alert("大哥，投超過票數囉");
	    }
	    if(data >= 1 ) {
	    var item_id = $btn.data('item');
	    $btn.parent("td").prev().text(data);
	    $btn.parent("td").html("<button data-item='"+item_id+"' class='cl btn btn-danger' >取消</button>");
	    $(".num").text(parseInt($(".num").text(),10) - 1);
	    }
	  });
	});

	$("tbody").delegate(".cl","click",function(){
	  var $btn = $(this);
	  $.post("/vote/action_cl",{itemid:$btn.data('item')},function(data){
	   var item_id = $btn.data('item');
	   $btn.parent("td").prev().text(data);
	   $btn.parent("td").html("<button data-item='"+item_id+"' class='vote btn btn-success' >投票</button>");
	   $(".num").text(parseInt($(".num").text(),10) + 1);
	  });
	});

})();
</script>
