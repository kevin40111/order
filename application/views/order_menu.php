<style>
    h2 {
        font-size: 1.4em;
    }
    #user-order {
        background: #E3E3E3;
        box-shadow: 1px 1px 3px #CCC;
        border: 1px solid #AAA;
        list-style: none;
        margin: 0;
        min-height: 420px;
        overflow-x: hidden;
        overflow-y: auto;
        padding: 15px 20px;
        margin-bottom: 10px;
    }
    input.count {
        width: 40px;
    }
    div.option > * {
        margin: 0 4px;
    }
    div.tab-pane table tbody td {
        height: 30px;
        vertical-align: middle;
    }
    ul#user-order p {
        margin: 0;
    }
    ul#user-order p i {
        cursor: pointer;
    }
    div#price {
        font-size: 1.4em;
        font-weight: bold;
    }
    #fixed {
        position: fixed;
        width: 220px;
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
  td, th {
    background-color: rgba(255, 255, 255, .85) !important;
  }
</style>
<div id='bg-container'></div>
<div class='row-fluid'>
    <div class='span12'>
        <div class='page-header'>
            <h1>點餐系統</h1>
        </div>
    </div>
</div>
<div class='row-fluid'>
    <div class='btn-toolbar'>
        <a href='/order' class='btn btn-info'><i class='icon-chevron-left icon-white'></i> 返回清單</a>
        <a class='btn btn-info' href='/order/statistic/<?= $orderID?>'><i class='icon-list-alt icon-white'></i> 報表</a>
    </div>
</div>
<div class='row-fluid'>
    <div class='span3'>
        <div id='fixed'>
            <h2>您的訂單</h2>
            <ul id='user-order'>
                <? foreach ($myOrder as $order):?>
                <li data-id='<?= $order->id?>'>
                    <p>
                        <?= $order->item?> x<?= $order->count?>
                        <span class='pull-right item-total-price'>
                            <?= $order->price * $order->count?>
                            <i class='icon-remove del-order'></i>
                        </span>
                    </p>
                    <p class='muted'><?= $order->type_one?>, <?= $order->type_two?></p>
                </li>
                <? endforeach;?>
            </ul>
            <div id='price'>
                <span>總價: </span>
                <span id='total-price' class='pull-right'>0</span>
            </div>
        </div>
    </div>
    <div class='span9'>
        <h2>本次菜單</h2>
        <ul id='menu' class='nav nav-pills'>
            <? foreach($shops as $shop):?>
            <li><a href="#<?= $shop->id?>"><?= $shop->name?></a></li>
            <? endforeach?>
        </ul>
        <div class='tab-content'>
            <? foreach ($shops as $shop):?>
            <div class='tab-pane' id='<?= $shop->id?>'>
                <div style="padding-bottom:10px" >
                    <b> 商家資訊: </b> <?=$shop->remark ?>
                </div>

                <table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>商品名稱</th>
                            <th width='30'>價格</th>
                            <th>下訂</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($shop->items as $item):?>
                        <tr data-id='<?= $item->id?>'>
                            <td><?= $item->name?></td>
                            <td><?= $item->price?></td>
                            <td width='500'>
                                <a class='btn btn-success order-it' href='#' data-cus-first='<?= $item->type_1_id?>' data-cus-second='<?= $item->type_2_id?>'><i class='icon-shopping-cart icon-white'></i> 訂購</a>
                            </td>
                        </tr>
                        <? endforeach;?>
                    </tbody>
                </table>
            </div>
            <? endforeach;?>
        </div>
        <div id='customerize' class='hide'>
            <? foreach ($customerize as $id => $cus):?>
            <select class='input-small' data-type='<?= $id?>'>
                <? foreach ($cus as $option):?>
                <option value='<?= $option->id?>'><?= $option->option?></option>
                <? endforeach;?>
            </select>
            <? endforeach;?>
        </div>
    </div>
</div>
<script>
    var orderID = <?= $orderID?>;

    (function (window) {
        var count = 0
        $("#user-order span.item-total-price").each(function () {
            count += parseInt($(this).text(), 10);
        });
        $("#total-price").text(count);
    })(window)

    $("#menu a:first").tab('show');

	if($("#menu a:first").text() == "黑丸嫩仙草")
		window.open("/static/images/black_ball.jpg", "menu", config="width=500,height=500");

    $("#menu").delegate('a', 'click', function (e) {
        e.preventDefault();
        $(this).tab('show');
		if($(this).text() == "黑丸嫩仙草")
			window.open("/static/images/black_ball.jpg", "menu", config="width=500,height=500");
    });

    $(".tab-content")
        .delegate('a.order-it', 'click', function (e) {
            var $this = $(this),
                td = $this.parent(),
                input, txt, div, btn, select1, select2;

            e.preventDefault();

            if (!$this.hasClass('active')) {
                $this.addClass('active');
                // Clean
                $("div.option").remove();
                $("a.order-it").fadeIn().removeClass('active');

                $this.fadeOut(function () {
                    div.fadeIn();
                    input.focus();
                });

                select1 = $("select[data-type=" + $this.data('cusFirst') + "]:first").clone();
                select2 = $("select[data-type=" + $this.data('cusSecond') + "]:first").clone();

                div = $("<div>").addClass('option hide').append(select1, select2);
                txt = $("<span>").text('數量: ').appendTo(div);
                input = $("<input>").attr('type', 'text').attr('maxlength', '2').addClass('count').val(1).appendTo(div);
                btn = $("<a>").attr('href', '#submit').addClass('btn btn-primary add-item').html('<i class="icon-white icon-plus"></i> 加入').appendTo(div);
                td.append(div);
            }
        })
        .delegate("a.add-item", 'click', function (e) {
            var $this = $(this),
                tr = $this.parents('tr'),
                itemID = tr.data('id'),
                name = tr.find('td:eq(0)').text(),
                price = tr.find('td:eq(1)').text(),
                td = $this.parents('td'),
                typeFirst = td.find('select:first').val() || -1,
                typeSecond = td.find('select:eq(1)').val() || -1,
                count = td.find('input').val(),
                ul = $("#user-order"),
                priceCount = parseInt(price, 10) * parseInt(count, 10),
                totalPrice = $("#total-price");

            e.preventDefault();

            $.post('/order/add_item_order', {orderID: orderID, itemID: itemID, count: count, type_one: typeFirst, type_two: typeSecond}, function (json){
                if (json.status === 'success') {
                    ul.append("<li data-id='" + json.insertID + "'><p>" + name + " x" + count + " <span class='pull-right item-total-price'>" + priceCount + " <i class='icon-remove del-order'></i></span></p><p class='muted'>" + $("option[value='" + typeFirst + "']:first").text() + ", " + $("option[value='" + typeSecond + "']:first").text() + "</p></li>");
                    totalPrice.text(parseInt(totalPrice.text(), 10) + priceCount);
                    td.find('div').fadeOut(function() {
                        td.find('a').show();
                    });
                }
            }, 'json');
        });

    $("#user-order").delegate('i.del-order', 'click', function (e){
        var $this = $(this),
            li = $this.parents('li'),
            id = li.data('id'),
            price = parseInt(li.find('span.item-total-price').text(), 10);

        $.getJSON('/order/del_item_order/' + id, {}, function (json) {
            if (json.status === 'success') {
                li.fadeOut(function () {
                    li.remove();
                    $("#total-price").text(parseInt($("#total-price").text(), 10) - price);
                });
            }
        });
    });

    $(window).scroll(function (e) {
        if (navigator.appName.match('Microsoft Internet Explorer')) {
          if (document.documentElement.scrollTop >= 215) {
            $("#fixed").css('top', 0);
          } else {
            $("#fixed").css('top', 240 - document.documentElement.scrollTop);
          }
        } else {
          if ($("body")[0].scrollTop >= 215) {
              $("#fixed").css('top', 0);
          } else {
              $("#fixed").css('top', 240 - $("body")[0].scrollTop);
          }
        }
    });
</script>
