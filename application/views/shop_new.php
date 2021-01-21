<div class='row-fluid'>
	<div class='span12' id='shop_profile'>
		<form>
			<fieldset>
				<legend>新增店家</legend>
				<label>店家名稱</label>
				<input type='text' name='name' placeholder="請輸入店家名稱" />
				<label>聯絡電話</label>
				<input type='text' name='phone' placeholder="請輸入聯絡電話(含區碼)" />
				<label>備註</label>
				<input type='text' name='remark' placeholder="備註" />
			</fieldset>
		</form>
	</div>
	<div class='span12' id='items'>
		<table class='table table-striped'>
			<caption>
				<h4>商品清單</h4>
			</caption>
			<thead>
				<tr>
					<th>#</th>
					<th>品項</th>
					<th>價格</th>
					<th>客製選項1</th>
					<th>客製選項2</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>
						<input type='text' name='item[]' placeholder="請輸入商品名稱" />
					</td>
					<td>
						<input type='number' name='price[]' placeholder="請輸入新台幣價格" />
					</td>
					<td>
						<select name='customerize1[]' class='sel1'>
							<option value='-1'>- 請選擇客製化選項 -</option>
							<? foreach ($types as $type):?>
							<option value='<?= $type->id?>'><?= $type->name?></option>
							<? endforeach;?>
						</select>
					</td>	
					<td>
						<select name='customerize2[]' class='sel2'>
							<option value='-1'>- 請選擇客製化選項 -</option>
							<? foreach ($types as $type):?>
							<option value='<?= $type->id?>'><?= $type->name?></option>
							<? endforeach;?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class='span12 btn-toolbar'>
		<button id='submit' class='btn btn-primary'><i class='icon-ok icon-white'></i> 新增店家</button>
	</div>
</div>
<script src='/static/js/underscore-min.js'></script>
<script>
    $("#submit").click(function (e) {
        var $trs = $("tbody > tr"),
            $this = $(this),
            params = {},
            pass = true;

        // 執行綁定
        if ($this.hasClass('disabled')){
            return;
        }
        $this.addClass('disabled');
        
        // 檢查名稱、價格
        $trs.each(function () {
            var $this = $(this),
                item = $this.find('input:eq(0)').val(),
                price = $this.find('input:eq(1)').val();
            
            if (item === '' || price === '') {
                if ($("tbody > tr").length > 1) {
                    $this.remove();
                }
            }
        });
        
        // 檢查客製化
        $trs.find('select').each(function () {
            if ($(this).val() == -1) {
                pass = confirm('您有部分商品尚未選擇客製化選項，仍要送出嗎?');
                return false;
            }
        });
        
        // 送出新增
        if (pass) {
            params = $("form").serializeArray();
            params = _.object(_.pluck(params, 'name'), _.pluck(params, 'value'));
            params.item = [];
            params.price = [];
            params.customerize1 = [];
            params.customerize2 = [];
            $("#items tbody > tr").each(function () {
                var $this = $(this);
                
                params.item.push($this.find('input[name="item[]"]').val());
                params.price.push($this.find('input[name="price[]"]').val());
                params.customerize1.push($this.find('select[name="customerize1[]"]').val());
                params.customerize2.push($this.find('select[name="customerize2[]"]').val());
            });
            
            // POST
            $.post('/shop/add_shop', params, function (result) {
                if (result.status === 'success') {
                    alert('新增店家: ' + params.name + ' 成功!');
                    location.href = '/shop';
                } else {
                    alert('新增店家: ' + params.name + ' 失敗!');
                }
            }, 'json');
        } else {
            $this.removeClass('disabled');
        }
    });
	$("#items > table > tbody").delegate('tr input', 'focus', function () {
		var check = 0,
				$tbody = $("#items > table > tbody"),
                firstOne,
				$trs = $tbody.find("tr");
				
		$trs.each(function () {
			var $this = $(this),
				item = $this.find('input:eq(0)').val(),
				price = $this.find('input:eq(1)').val();
			if (item === '' && price === '') {
				check++;
			}
		});
		
		if (check == 1) {
			// 建立新表格
            firstOne = $trs.first();
            
			$trs
				.last()
				.clone()
				.find('td:eq(0)')
				.text($trs.length + 1)
				.end()
				.find('input')
				.val('')
				.end()
                .find('select:eq(0)')
                .val(firstOne.find('select:eq(0)').val())
                .end()
                .find('select:eq(1)')
                .val(firstOne.find('select:eq(1)').val())
                .end()
				.appendTo($tbody);
		}
	});
	$("#items > table > tbody").delegate('tr select', 'change', function () {
		var $tr = $(this).parents('tr'),
				sel1 = $tr.find('.sel1').val(),
				sel2 = $tr.find('.sel2').val();
		
		if (sel1 === sel2) {
			$tr.addClass('error');
		} else {
			$tr.removeClass('error');
		}
	});
</script>