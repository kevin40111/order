		<div id='text'>
          <p>什麼都是假的</p>
          <p>只有退伍令是真的</p>
        </div>
        <div id='bg'>
        </div>
        <div class='row-fluid'>
			  <div class='span12'>
				<h1>人員列表</h1>
				<a id='orderSum' href='/member/memberlistSum' class='btn'>order by Money</a>
				<div id="my_view">
				</div>
				<hr>
				<table class="member-table table table-striped">
					<thead>
						<tr>
							<th style="width: 4em;">頭像</th>
							<th style="width: 4em;">姓名</th>
							<th>狀態</th>
							<th style="width: 6em;">生日</th>
							<th style="width: 5em;">計畫</th>
							<th style="width: 5em;">點餐貢獻</th>
						</tr>
					</thead>
					<tbody id='member_body'>
						<?foreach ($members as $row): ?>
                            <?
$mobile = str_replace('-', '', $row->phone);
if (strlen($mobile) == 10) {
    $mobile = substr($mobile, 0, 4) . '-' . substr($mobile, 4, 3) . '-' . substr($mobile, 7, 3);
} else {
    $mobile = '';
}
?>
								<tr data-uid='<?=$row->id?>' class='<?=date('m-d', strtotime($row->birth)) == date('m-d') ? 'birth-tr' : ''?>'>
									<td>
										<?if ($row->head_portrait != null): ?>
										<img src="/static/images/head/<?=$row->head_portrait?>" style="width:100px">
										<?endif;?>
									</td>
									<td><a href="/member/btl/<?=$row->id?>" ></a><?=$row->name?></td>
									<td><?=$row->nickname?></td>
									<td>
                                      <?if (date('m-d', strtotime($row->birth)) == date('m-d')): ?>
                                      <span class='label label-important'><i class='icon-white icon-exclamation-sign'></i>生日</span>
                                      <?else: ?>
                                      <?=$row->birth;?>
                                      <?endif;?>
									 <?if ($row->name == '王小明'): ?>
									  <span class='label label-info'><i class='icon-white icon-exclamation-sign'></i>嗶嗶人</span>
									 <?endif;?>
                                    </td>
									<td><?=$row->dep_name?></td>
									<td>$ <?=$row->SUM;?></td>
								</tr>
						<?endforeach;?>
					</tbody>
				</table>
			</div>

		</div>
<script>

var funbord_data;
var count=0;
var choice=0;

$(function() {
  $('.show_modal').on('click', function(event) {
    event.preventDefault();
    showbord(choice);
    choice == count-1 ? choice=0 : choice++;
  });
});


$(function(){
	var member_id = <?=$this->session->userdata('uid')?> ;
	$('#member_body tr').each(function()
  {
		var $this = $(this);
		if($this.data('uid') == member_id ){
			$this.addClass('mydata');
	}

		if($this.data('uid') == '-1' )
  {
			$this.addClass('bebeman');
	}
	});
});

</script>
<style>
td {
	vertical-align:middle !important;
}

.container {
  -webkit-perspective: 1000;
}
.table-striped tbody > tr:nth-child(odd) > td, .table-striped tbody > tr:nth-child(odd) > th {
  background-color:transparent;
}

@-webkit-keyframes bg {
  0% {
    color: #CCC;
    -webkit-transform: translate3d(0, 0, 500px) rotateZ(0deg) rotateX(-3deg) rotateY(18deg);
  }
  50% {
    color: rgba(58, 135, 173, 0.7);
    -webkit-transform: translate3d(0, 0, 100px) rotateZ(0deg) rotateX(-3deg) rotateY(198deg);
  }
  100% {
    color: #CCC;
    -webkit-transform: translate3d(0, 0, 500px) rotateZ(0deg) rotateX(-3deg) rotateY(378deg);
  }
}

#text {
  -webkit-animation: bg 8s infinite linear;
  position: fixed;
  font-size: 5em;
  line-height: 1.3em;
  font-weight: bold;
  text-align: center;
  -webkit-transform: translate3d(0, 0, 500px) rotateZ(10deg) rotateX(-3deg) rotateY(18deg);
  z-index: -1;
  color: #ccc;
  margin: 350px 0 0 200px;
  display: none;
}

#bg {
  display: block;
  width: 774px;
  height: 605px;
  filter: alpha(opacity = 50);
  //background: url(/static/images/member_list.jpg);
  opacity: 0.5;
  position: fixed;
  top: 205px;
  z-index: -1;
  left: 75px;
  margin: 0 auto;
  margin-left: 200px \9;
}

.mydata {
  background: rgba(217, 237, 247, 0.7) !important;
  color: #3A87AD !important;
}
.birth-tr {
  background: #F2DEDE !important;
  color: #B94a48 !important;
}

.bebeman {
  background: #F2DEDE !important;
  color: #B94a48 !important;
}
</style>
