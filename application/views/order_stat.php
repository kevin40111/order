<div class='row-fluid'>
    <div class='span12'>
        <h1>統計報表</h1>
    </div>
</div>
<div class='row-fluid'>
    <div class='span12'>
        <a href='/order' class='btn'><i class='icon-chevron-left'></i> 返回清單</a>
    </div>
</div>
<div class='row-fluid'>
    <div class='span12'>
        <span>排序: </span>
        <a href='#shop' data-type='shop' class='btn btn-success type-seelctor'><i class='icon-home icon-white'></i> 店家</a>
        <a href='#dep' data-type='dep' class='btn btn-info type-seelctor'><i class='icon-flag icon-white'></i> 計畫</a>
        <a href='#person' data-type='person' class='btn btn-info type-seelctor'><i class='icon-user icon-white'></i> 個人</a>
    </div>
</div>
<div class='row-fluid'>
    <div id='container'>

    </div>
</div>
<div id='bg-container'></div>
<style>
    div#bg-container {
    width: 789px;
    height: 564px;
    z-index: -1;
    position: fixed;
    background-repeat: no-repeat;
    top: 200px;
    left: 200px;
  }
    .table {
        width: 290px;
        float: left;
        margin: 10px;
    }
    .table th {
        text-align: center;
    }
    @media print {
        div.span12 {
            display: none !important;
        }
        table {
            display: block;
        }
        table, td, th {
          border-color: #333 !important;
        }
    }

  td, th {
    background-color: rgba(255, 255, 255, .85) !important;
  }
  #today_total {
    text-align: right;
    font-size: 1.8em;
    color: #3CAAE7;
    font-weight: bold;
  }
</style>
<script src='/static/js/underscore-min.js'></script>
<script>
    var data = <?= json_encode($orders)?>,
        shops = <?= json_encode($shops)?>,
        tableTmpl = $("<table>").addClass('table table-bordered').append($("<thead>"), $("<tbody>")),
        shop, dep, person;

    shops = _.groupBy(shops, 'name');

    $(".type-seelctor").click(function () {
        var $this = $(this);

        switch ($this.data('type')) {
            case 'shop':
                shop();
                break;
            case 'dep':
                dep();
                break;
            case 'person':
                person();
                break;
        }

        $(".type-seelctor").removeClass('btn-success').addClass('btn-info');
        $this.addClass('btn-success').removeClass('btn-info');

        $("td").click(function() {
            if( $(this).css('color') == 'rgb(255, 0, 0)' ) {
                $(this).css("color", "black");
            } else {
                $(this).css("color", "red");
            }
        });
    });

    shop = function () {
        var grp = _.groupBy(data, 'shop'),
            grpItem, item, shop,
            tbl, html, totalCount, sum, count, price, totalToday,
            container = $("#container");

        container.empty();

        totalToday = _.reduce(data, function(memo, num){
          return (typeof memo == 'number' ? memo : parseInt(memo.total_price, 10)) + parseInt(num.total_price, 10)
        })
        container.append("<p id='today_total'>本日總價: " + totalToday + "</p>");

        for (shop in grp) {
            tbl = tableTmpl.clone();
            grpItem = _.groupBy(grp[shop], 'item');
            tbl.find('thead').html('<tr><th colspan="4">' + shop + '</th></tr><tr><th colspan="4">' + shops[shop][0].phone + '</th></tr><tr><th width="155px">品項</th><th>單價</th><th>數量</th><th>總價</th></tr>');
            html = '';

            for (item in grpItem) {
                count = _.pluck(grpItem[item], 'count')
                price = _.pluck(grpItem[item], 'total_price');
                sum = _.reduce(price, function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);
                totalCount = _.reduce(count, function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);
                html += "<tr><td>" + item + "</td><td>" + grpItem[item][0].price + "</td><td>" + totalCount + "</td><td>" + sum + "</td></tr>";
            }

            sumPrice = _.reduce(_.pluck(grp[shop], 'total_price'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);
            sumCount = _.reduce(_.pluck(grp[shop], 'count'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);

            html += "<tr><td colspan='2'>總數 / 總價</td><td>" + sumCount + "</td><td>" + sumPrice + "</td></tr>";

            tbl.find('tbody').html(html);

            container.append(tbl);
        }

    }

    dep = function () {
        var grp = _.groupBy(data, 'department'),
            shopGrp, dep, shop, shopPrice, itemGrp,
            tbl, html, item, count, price,
            container = $("#container");

        container.empty();
        grp = _.sortBy(grp, function(dep){
          return parseInt(dep[0].department_id, 10);
        });

        for (dep in grp) {
            tbl = tableTmpl.clone();
            tbl.find('thead').html('<tr><th colspan="4"> [ ' + grp[dep][0].department_id + ' ] ' + grp[dep][0].department + '</th></tr><tr><th width="155px">品項</th><th>單價</th><th>數量</th><th>總價</th></tr>');

            html = '';
            shopGrp = _.groupBy(grp[dep], 'shop');

            for (shop in shopGrp) {
                shopPrice = _.reduce(_.pluck(shopGrp[shop], 'total_price'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);
                html += "<tr><th colspan='4'>" + shop + "</th></tr>";

                itemGrp = _.groupBy(shopGrp[shop], 'item');

                for (item in itemGrp) {

                    count = _.reduce(_.pluck(itemGrp[item], 'count'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);
                    price = _.reduce(_.pluck(itemGrp[item], 'total_price'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);
                    html += "<tr><td>" + item + "</td><td>" + itemGrp[item][0].price + "</td><td>" + count + "</td><td>" + price + "</td></tr>";
                }

                sumCount = _.reduce(_.pluck(shopGrp[shop], 'count'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);
                sumPrice = _.reduce(_.pluck(shopGrp[shop], 'total_price'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);

                html += "<tr><td colspan='2'>總數 / 總價</td><td>" + sumCount + "</td><td>" + sumPrice + "</td></tr>";
            }

            totalPrice = _.reduce(_.pluck(grp[dep], 'total_price'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);

            html += "<tr><td colspan='3'>總價</td><td>" + totalPrice + "</td></tr>";

            tbl.find('tbody').html(html);

            container.append(tbl);
        }
    }

    person = function () {
		var dataSortedByOld = _.sortBy(data, 'member_old');

        var grp = _.groupBy(dataSortedByOld, 'member'),
            name, tbl, html, item, totalPrice,
            container = $("#container");

        container.empty();

        for (name in grp) {
            tbl = tableTmpl.clone();
            tbl.find('thead').html('<tr><th colspan="5">' + name + '</th></tr><tr><th>品項</th><th>單價</th><th>數量</th><th>備註</th><th>總價</th></tr>');

            html = '';

            for (item in grp[name]) {
                html += "<tr><td>" + grp[name][item].item + "</td><td>" + grp[name][item].price + "</td><td>" + grp[name][item].count + "</td><td>" +  grp[name][item].backup + "</td><td>" + grp[name][item].total_price + "</td></tr>";
            }

            totalPrice = _.reduce(_.pluck(grp[name], 'total_price'), function(memo, num){ return parseInt(memo, 10) + parseInt(num, 10) }, 0);
            html += '<tr><td colspan="4">總價</td><td>' + totalPrice + '</td></tr>';

            tbl.find('tbody').html(html);
            container.append(tbl);
        }
    }
    shop();
</script>
