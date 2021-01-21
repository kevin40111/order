<script>
var members = <?= $members?>,
		totalDays = <?= intval(date('t', mktime(0, 0, 0, $month, 1, $year)))?>,
		leaveDays = <?= $leaveDays?>,
		month = <?= $month?>,
		year = <?= $year?>,
		graduate = <?= json_encode($graduate)?>;
</script>
<div class='row-fluid'>
	<div class='span12'>
		<h1>排假系統</h1>
	</div>
	<? if ($this->session->userdata('dep_id') == 2):?>
	<div class='span12'>
		<p style='text-align: right;'>
			<a href='/callleave' class='btn btn-success'><i class='icon-chevron-left icon-white'></i> 返回我的</a>
		</p>
	</div>
	<? endif;?>
	<div class='span12'>
		<table class='table table-hover table-bordered'>
			<caption><span id='year'>海岸巡防總局通資大隊第三中隊一區隊 <?= $year - 1911 ?></span> 年 <span id='month'><?= $month >= 10 ? $month : '0' . $month?></span> 月休假實施計畫表</caption>
			<thead>
				<tr>
					<th rowspan='2'>處室</th>
					<th rowspan='2'>級職</th>
					<th>日期</th>
					<? for ($i = 1, $l = intval(date('t', mktime(0, 0, 0, $month, 1, $year))) + 1; $i < $l; $i ++):?>
					<th><?= $i?></th>
					<? endfor;?>
					<th rowspan='2'>應休例假</th>
					<th rowspan='2'>剩餘積休</th>
				</tr>
				<tr id='week'>
					<th>星期</th>
					<? for ($i = 1, $l = intval(date('t', mktime(0, 0, 0, $month, 1, $year))) + 1; $i < $l; $i ++):?>
					<? $day = date("w", mktime(0, 0, 0, $month, $i, $year)); 
						if ($day == 6 || $day == 0):?>
						<th class='holiday head'><?= $week[$day]?></th>
						<? else:?>
						<th><?= $week[$day]?></th>
						<? endif;?>
					<? endfor;?>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<div class='span12'>
		<p style='text-align: center'>
			<a href='/callleave/all/<?= date("Y", mktime(0, 0, 0, $month, 0, $year)) . '-' . date("m", mktime(0, 0, 0, $month, 0, $year))?>' id='prevMonth' class='btn btn-info change_month'><i class='icon-chevron-left icon-white'></i> <?= date("Y", mktime(0, 0, 0, $month, 0, $year)) - 1911 . '-' . date("m", mktime(0, 0, 0, $month, 0, $year))?></a>
			<a href='/callleave/all/<?= date("Y", mktime(0, 0, 0, $month + 2, 0, $year)) . '-' . date("m", mktime(0, 0, 0, $month + 2, 0, $year))?>' id='nextMonth' class='btn btn-info change_month'><?= date("Y", mktime(0, 0, 0, $month + 2, 0, $year)) - 1911 . '-' . date("m", mktime(0, 0, 0, $month + 2, 0, $year))?> <i class='icon-chevron-right icon-white'></i></a>
		</p>
	</div>
    <div id='bg-container'></div>
</div>
<link rel='stylesheet' href='/static/css/show_callleave.css' />
<script src='/static/js/underscore-min.js'></script>
<script src='/static/js/callleave_all.js'></script>
<style>
div#bg-container {
  width: 789px;
  height: 564px;
  z-index: -1;
  position: fixed;
  background-image: url(/static/images/callleave1.png);
  background-repeat: no-repeat;
  top: 200px;
  left: 200px;
}
</style>