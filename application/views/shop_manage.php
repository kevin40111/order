
<div class='row-fluid'>

    	<div class='span12' id='shop_list' style="width:82%;">
            <div class='page-header'>
            <h1>店家管理</h1>   
            <div class='btn-toolbar'></br>
                <a href='/shop/add' class='btn btn-primary'><i class='icon-plus icon-white'></i> 新增店家</a>
            </div>
        </div>

    		<table class='table table-striped'>
    			<thead>
    				<tr>
    					<th>店家名稱</th>
    					<th>連絡電話</th>
    					<th>備註</th>
                        <th width='200px'></th>
    				</tr>
    			</thead>
    			<tbody>
    				<? foreach ($list as $shop):?>
    				<tr data-id='<?= $shop->id?>'>
    					<td class='editable' data-placeholder='請輸入店家名稱'><?= $shop->name?></td>
    					<td class='editable' data-placeholder='請輸入店家電話'><?= $shop->phone?></td>
    					<td class='editable' data-placeholder='請輸入店家備註'><?= $shop->remark?></td>
                        <td>
                            <a href='/shop/edit/<?= $shop->id?>' class='btn btn-info'>
    						<i class='icon-pencil icon-white'></i> 編輯菜單</a>
                            <a href='/shop/delete/<?= $shop->id?>' class='btn btn-danger'>
    						<i class='icon-remove icon-white'></i> 刪除店家</a>
                        </td>
    				</tr>
    				<? endforeach;?>
    			</tbody>
    		</table>
    	</div>
  
</div>
<style>
    td.editable {
        cursor: pointer;
    }
</style>
<script>
    $("table").delegate("td.editable", 'click', function (e) {
        var input = $("<input>"),
            $this = $(this),
            val = $this.text();
        
        input
            .addClass('input-small')
            .attr({
                type: 'text',
                placeholder: $this.data('placeholder')
            })
            .val(val);
        
        if (!$this.find('input').length) {
            $this.html(input);
            input.focus();
        }
    });
    
    var submit = function (obj) {
        var $obj = $(obj),
            newVal = $obj.val(),
            td = $obj.parents('td'),
            tr = $obj.parents('tr'),
            params = {};
        
        params.id = tr.data('id');
        
        td.html(newVal);
        
        params.name = tr.find('td:eq(0)').text();
        params.phone = tr.find('td:eq(1)').text();
        params.remark = tr.find('td:eq(2)').text();
        
        $.post('/shop/edit_profile', params, function (result) {
            
        }, 'json');
    }
    
    $("table").delegate("td.editable > input", "keyup", function (e) {
        if (e.keyCode == 13 || e.which == 13) {
            submit(this);
        }
    });
    
    $("table").delegate("td.editable > input", "blur", function (e) {
        submit(this);
    });
</script>