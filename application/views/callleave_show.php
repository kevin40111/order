<div class='row-fluid'>
	<div class='span12'>
		<h1>排假系統</h1>
	</div>
	<div class='span12'>
		<p style='text-align: right;'>
			<a href='/callleave/all' class='btn btn-success'><i class='icon-list icon-white'></i> 檢視全部</a>
            <a href='#' data-toggle='modal' data-target='output' onclick='javascript:$("#output").modal("show");' class='btn btn-primary'><i class='icon-print icon-white'></i> 列印假單</a>
		</p>
	</div>
    <div class='span12'>
        <p class='muted'>有積休的弟兄請從開始積的那個月開始排就會有正確的應休天數。</p>
    </div>
	<div class='span12'>
		<table class='table table-hover table-bordered'>
			<caption><span id='year'><?= date("Y") - 1911 ?></span> 年 <span id='month'><?= date("m")?></span> 月休假實施計畫表</caption>
			<thead>
				<tr>
					<th rowspan='2'>級職</th>
					<th>日期</th>
					<? for ($i = 1, $l = intval(date('t')) + 1; $i < $l; $i ++):?>
					<th><?= $i?></th>
					<? endfor;?>
				</tr>
				<tr>
					<th>星期</th>
					<? for ($i = 1, $l = intval(date('t')) + 1; $i < $l; $i ++):?>
					<th><?= $week[date("w", mktime(0, 0, 0, date('m'), $i, date('y')))]?></th>
					<? endfor;?>
				</tr>
			</thead>
			<tbody>
				<tr id='checkField'>
					<td class='head' id='rank'><?= $this->session->userdata('rank')?></td>
					<td class='head' id='name'><?= $this->session->userdata('name')?></td>
					<?
					$endYear = explode('-', $profile->end_date);
					$endMonth = intval($endYear[1]);
					$endDate = intval($endYear[2]);
					$endYear = intval($endYear[0]);
					$leaveFixed = $leaveDays[date('n') - 1];
					if ($endYear == date("Y") && $endMonth == date('n')){
						$graduate = true;
					} else {
						$graduate = false;
					}
					$accu = intval($accuLeave);
					for ($i = 1, $l = intval(date('t')) + 1; $i < $l; $i++) {
						$nowDate = mktime(0, 0, 0, date('m'), $i, date('y'));
						if ($graduate && $i > $endDate) {
							$leaveFixed = round($i / date('t') * $leaveFixed);
							echo "<td colspan='" . (date('t') - $endDate) . "'>榮退</td>";
							break;
						}
						$check = false;
						for ($j = 0, $k = count($callleave); $j < $k; $j++) {
							if ($nowDate == strtotime($callleave[$j]->date))
								$check = true;
						}
						if ($check):?>
							<? if ($accu):?>
							<td class='check'>#</td>
							<? $accu--;?>
							<? else: ?>
							<td class='check'>v</td>
							<? endif;?>
						<? else: ?>
							<td></td>
						<? endif;
					}
					?>
				</tr>
				<tr>
					<td colspan='<?= date('t') + 2?>'>本月例休: <span id='leave-days'><?= $leaveFixed?></span> 天 - 上月積休: <span id='accuLeave'><?= $accuLeave?></span> 天 - 本月已休: <span id='checked'><?= count($callleave)?></span> 天 - 剩餘假日: <span id='unchecked'><?=  $leaveFixed + $accuLeave - count($callleave)?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class='span12'>
		<p style='text-align: center'>
			<button id='prevMonth' class='btn btn-info change_month'><i class='icon-chevron-left icon-white'></i> <?= date("Y", mktime(0, 0, 0, date("n"), 0, date("Y"))) - 1911 . '-' . date("m", mktime(0, 0, 0, date("n"), 0, date("Y")))?></button>
			<button id='submit' class='btn btn-primary'><i class='icon-ok icon-white'></i> 確認送出</button>
			<button id='nextMonth' class='btn btn-info change_month'><?= date("Y", mktime(0, 0, 0, date("n") + 2, 0, date("Y"))) - 1911 . '-' . date("m", mktime(0, 0, 0, date("n") + 2, 0, date("Y")))?> <i class='icon-chevron-right icon-white'></i></button>
		</p>
	</div>
    <div class='modal fade hide' id='output'>
        <div class='modal-header'>
            <button type='button' class="close" data-dismiss='modal' aria-hidden='true'>&times;</button>
            <h3>列印假單</h3>
        </div>
        <div class='modal-body'>
            <form class='form-horizontal'>
                <div class='control-group'>
                    <label class='control-label'>假別</label>
                    <div class='controls'>
                        <select class='input-xlarge' name='type'>
                            <option value='A'>出差</option>
                            <option value='B'>公出</option>
                            <option value='C'>公假</option>
                            <option value='D'>事假</option>
                            <option value='E'>病假</option>
                            <option value='F' selected>休假</option>
                            <option value='G'>婚假</option>
                            <option value='H'>娩假</option>
                            <option value='I'>喪假</option>
                            <option value='J'>天災假</option>
                            <option value='K'>補假</option>
                            <option value='L'>其他假</option>
                            <option value='N'>監考假</option>
                            <option value='O'>進修假</option>
                            <option value='P'>產前假</option>
                            <option value='Q'>陪產假</option>
                        </select>
                    </div>
                </div>
                <div class='control-group'>
                    <label class='control-label'>地址</label>
                    <div class='controls'>
                        <input type='text' name='address' class='input-xlarge' placeholder="請輸入地址" value='<?= $this->session->userdata('address')?>' />
                    </div>
                </div>
                <div class='control-group'>
                    <label class='control-label'>電話</label>
                    <div class='controls'>
                        <input type='text' name='phone' class='input-xlarge' placeholder="請輸入電話" value='<?= $this->session->userdata('phone')?>' />
                    </div>
                </div>
                <div class='control-group'>
                    <label class='control-label'>放假期間</label>
                    <div class='controls'>
                        <input name='start' class='date' style='margin-bottom: 12px;' type='text' placeholder="請選擇開始日"/>
                        <input name='end' class='date' style='margin-bottom: 12px;' type='text' placeholder="請選擇結束日"/>
                        <select name='time'>
                            <option value='1818'>18放18收</option>
                            <option value='2020'>20放20收</option>
                            <option value='2008'>20放08收</option>
                        </select>
                    </div>
                </div>
                <div class='control-group'>
                    <label class='control-label'>放假事由</label>
                    <div class='controls'>
                        <input type='text' name='reason' placeholder='請休六月份休假 2 日' />
                    </div>
                </div>
                <div class='control-group'>
                    <div class='controls'>
                        <a href='#' id='to_print' class='btn btn-block btn-large btn-primary'><i class='icon-print icon-white'></i> 列印假單</a>
                        <p class='helper-text'>請使用 Google Chrome 避免跑版</p>
                    </div>
                </div>
            </form>
        </div>
        <div class='model-footer'>
        </div>
    </div>
<div id='bg-container'></div>
</div>
<script>
var ENDDATE = '<?= $profile->end_date?>',
    STARTDATE = '<?= $profile->start_date?>',
    TOTALDATE = <?= date('t')?>;
                            
$("#to_print").click(function (e) {
    var $this = $(this),
        params = $("form").serialize();
               
    if ($("input[name='start']").val() == '' || $("input[name='end']").val() == '') {
        alert('休假日期不得為空!')
        return false;                        
    }
                            
    location.href = '/callleave/pt?' + params;
});
                            
$(".date").datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: 0
})
</script>
<link rel='stylesheet' href='/static/css/show_callleave.css' />
<script src='/static/js/underscore-min.js'></script>
<script src='/static/js/show_callleave.js'></script>
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