<div class='row-fluid'>
    <div class='span12'>
        <h1>產品清單</h1>
        <hr/>
    </div>
    <div class='span12'>
        <div id='alert-box' class='alert alert-info'>
            <i class='icon-info-sign'></i> <span>點擊兩下名稱即可修改</span>
        </div>
    </div>
    <div class='span12'>
        <div class='btn-toolbar'>
            <a href='/shop/manage' class='btn'><i class='icon-chevron-left'></i> 返回清單</a>
        </div>
    </div>
    <div class='span12'>
        <table class='table table-striped'>
            <thead>
                <tr>
                    <th>#</th>
                    <th width='180px'>品項名稱</th>
                    <th>價格</th>
                    <th colspan='3'>客製化項目</th>
                </tr>
            </thead>
            <tbody>
                <? $idx = 1;?>
                <? foreach ($list as $item):?>
                <tr data-id='<?= $item->id?>'>
                    <td><?= $idx?></td>
                    <td class='edit-trigger'><?= $item->name?></td>
                    <td class='edit-trigger'><?= $item->price?></td>
                    <td>
                        <select class='input-medium'>
                            <option value='-1' <?= $item->type_1_id == -1 ? 'selected' : ''?>>- 不提供 -</option>
                            <? foreach ($customerizes as $option):?>
                                <? if ($option->id == $item->type_1_id):?>
                                <option value="<?= $option->id?>" selected><?= $option->name?></option>
                                <? else:?>
                                <option value="<?= $option->id?>"><?= $option->name?></option>
                                <? endif;?>
                            <? endforeach;?>
                        </select>
                    </td>
                    <td>
                        <select class='input-medium'>
                            <option value='-1' <?= $item->type_2_id == -1 ? 'selected' : ''?>>- 不提供 -</option>
                            <? foreach ($customerizes as $option):?>
                                <? if ($option->id == $item->type_2_id):?>
                                <option value="<?= $option->id?>" selected><?= $option->name?></option>
                                <? else:?>
                                <option value="<?= $option->id?>"><?= $option->name?></option>
                                <? endif;?>
                            <? endforeach;?>
                        </select>
                    </td>
                    <td>
                        <i class='icon-remove'></i>
                    </td>
                </tr>
                <? $idx++;?>
                <? endforeach;?>
                <tr class='new-line'>
                    <td>
                        <?= count($list) + 1?>
                    </td>
                    <td>
                        <input type='text' class='new-field input-medium' placeholder='請輸入產品名稱' />
                    </td>
                    <td>
                        <input type='text' class='new-field input-medium' placeholder='請輸入產品新台幣價格' />
                    </td>
                    <td>
                        <select class='input-medium'>
                            <option value='-1'>- 不提供 -</option>
                            <? foreach ($customerizes as $option):?>
                                <option value="<?= $option->id?>"><?= $option->name?></option>
                            <? endforeach;?>
                        </select>
                    </td>
                    <td>
                        <select class='input-medium'>
                            <option value='-1'>- 不提供 -</option>
                            <? foreach ($customerizes as $option):?>
                                <option value="<?= $option->id?>"><?= $option->name?></option>
                            <? endforeach;?>
                        </select>
                    </td>
                    <td>
                    
                    </td>
                </tr>
            </tbody>
        </table>
        <p class='muted text-right'>新增產品按下 Enter 自動儲存，修改請直接點擊欄位或點選下拉式選單。</p>
    </div>
</div>
<style>
    input.name-changer {
        width: 150px;
    }
    td > i.icon-remove {
        cursor: pointer;
    }
</style>
<script>
    var shopID = <?= $shopID?>,
        newLine = $("tr.new-line").clone(),
        editItem, alertChanger;
    
    // 修改產品
    editItem = function ($tr) {
        var params = {},
            name = $tr.find('td:eq(1)').text(),
            price = $tr.find('td:eq(2)').text();
        
        if (isNaN(price)) {
            alertChanger('價格僅能輸入數字，請檢查後再送出', 'warning');
            return;
        }
        
        params.itemID = $tr.data('id');
        params.name = name === '' ? '未命名商品' : name;
        params.price = price === '' ? 0 : price;
        params.customerize1 = $tr.find('select:eq(0)').val(),
        params.customerize2 = $tr.find('select:eq(1)').val();
        
        
        $.post('/shop/edit_item', params, function (json){
            if (json.status !== 'success') {
                alertChanger('無法修改商品: ' + params.name, 'danger');
            } else {
                $tr.find('td:eq(1)').text(params.name);
                $tr.find('td:eq(2)').text(params.price);
                alertChanger('修改商品: ' + params.name, 'success');
            }
        }, 'json');
    }
    
    // 警告控制器
    alertChanger = function (msg, type) {
        type = type || 'alert';
        msg = msg || '';
        
        var alertBox = $("#alert-box"),
            icon = alertBox.find('i');
        
        alertBox.removeClass('alert-info alert-success alert-danger alert-warning');
        icon.removeClass('icon-info-sign icon-remove icon-ok icon-warning-sign')
        switch (type) {
            case 'info':
                icon.addClass('icon-info-sign');
                alertBox.addClass('alert-info');
                break;
            case 'danger':
                icon.addClass('icon-remove');
                alertBox.addClass('alert-danger');
                break;
            case 'success':
                icon.addClass('icon-ok');
                alertBox.addClass('alert-success');
                break;
            case 'alert':
            default:
                icon.addClass('icon-warning-sign');
                alertBox.addClass('alert-warning');
                break;
        }
        
        alertBox.find('span').text(msg);
    }
    
    $("table").delegate('tr.new-line input', 'keyup', function (e) {
        var keyCode = (window.event) ? e.keyCode : e.which,
            $this = $(this),
            val = $this.val(),
            $td = $this.parents('td'),
            $tr = $td.parents('tr'),
            name = $tr.find('input:eq(0)').val(),
            price = $tr.find('input:eq(1)').val(),
            newItem, params = {};
        
        if (keyCode === 13 && val !== '') {
            $tr.find('input, select').attr('disabled', 'disabled').addClass('disabled');
            newItem = newLine
                .clone()
                .find('td:eq(0)')
                .text($("table tbody tr").length + 1)
                .end();
            
            if (isNaN(price)) {
                alertChanger('價格僅能輸入數字，請檢查後再送出', 'warning');
                return;
            }
            
            params.name = name === '' ? '未命名商品' : name;
            params.price = price === '' ? 0 : price;
            params.shopID = shopID;
            params.customerize1 = $tr.find('select:eq(0)').val();
            params.customerize2 = $tr.find('select:eq(1)').val();
            $.post('/shop/add_item', params, function (json) {
                $tr.removeClass('new-line').attr('data-id', json.itemID);
                $tr.find('td:eq(1)').html(params.name);
                $tr.find('td:eq(2)').html(params.price);
                $tr.find('select').removeAttr('disabled').removeClass('disabled');
                $tr.find('td:last').append('<i class="icon-remove"></i>')
                alertChanger('新增商品: ' + params.name, 'success');
            }, 'json');
            
            $("table tbody").append(newItem);
        } 
    });
    
    $("table").delegate('.edit-trigger', 'click', function (e) {
        var $this = $(this),
            input = $("<input>").attr('type', 'text').addClass('edit-changer input-medium').val($this.text());
        
        if (!$this.find('input').length) {
            $this.html(input);
            input.focus();
        }
    });
    
    $("table").delegate('i.icon-remove', 'click', function (e) {
        var $tr = $(this).parents('tr'),
            name = $tr.find('td:eq(1)').text();
        
        $.post('/shop/del_item/' + $tr.data('id'), {}, function (json) {
            if (json.status === 'success') {
                $tr.fadeOut(function () {
                    $tr.remove();
                })
                alertChanger('已刪除商品: ' + name, 'success');
            } else {
                alertChanger('無法刪除商品: ' + name, 'success');
            }
        }, 'json');
    });
    
    $("table").delegate('select', 'change', function (e) {
        editItem($(this).parents('tr'));
    });
    
    $("table").delegate('.edit-changer', 'blur', function (e) {
        var $this = $(this),
            $td = $this.parents('td');
        
        $td.html($this.val());
        editItem($td.parents('tr'));
    });
    
    $("table").delegate('.edit-changer', 'keyup', function (e) {
        var keyCode = (window.event) ? e.keyCode : e.which,
            $this = $(this),
            $td = $this.parents('td');
        
        if (keyCode === 13) {
            $td.html($this.val());
            editItem($td.parents('tr'));
        }
    });
</script>
