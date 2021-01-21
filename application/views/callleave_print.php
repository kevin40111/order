<html>
<head>
    <title>請假單</title>
    <?= meta('Content-type', 'text/html; charset=utf-8', 'equiv') ?>
    <script src='/static/js/jquery-1.9.1.js'></script>
    <script src='/static/js/bootstrap.min.js'></script>
    <link href='/static/css/bootstrap.min.css' rel='stylesheet' />
</head>
<style>
    * {
        font-family: 標楷體;
    }
    .container {
        margin-top: 50px;
    }
    thead th {
        font-size: 22px;
    }
    tbody td {
        text-align: center !important;
        vertical-align: middle !important;
    }
    <? if ($this->agent->browser() == 'Internetq Explorer'):?>
    <? endif;?>
    .check-type p {
        margin: 0;
    }
    .check-type span {
        font-size: 14px;
        margin-right: 1px;
    }
    .tblContainer {
        border: 2px solid #000;
    }
    .table-bordered {
        border-radius: 0;
        border: 1px solid #000;
    }
    .table {
        margin: 0;
    }
    .table td {
        border-top: 1px solid #000;
    }
    .table-bordered td, .table-bordered th {
        border-left: 1px solid #000;
        border-radius: 0 !important;
    }
    .date-col p{
        margin: 0;
        font-size: 14px;
    }
    span.blue {
        color: blue;
        font-weight: bold;
    }
    #address p {
        text-align: left;
    }
    hr {
        border: 1px dashed #000;
    }
    p.indent {
        margin-left: 2em;
    }
    p.indent2 {
        margin-left: 5em;
    }
    p.indent3 {
        margin-left: 3em;
    }
    .hidden-tbl td {
        border: 0;
        padding: 0;
    }
</style>
<body>
    <div class='container'>
        <div class='row-fluid'>
            <div class='span12'>
                <div class='tblContainer'>
                    <table id='tbl1' class='table table-bordered' width='930px'>
                        <thead>
                            <tr>
                                <th colspan='8' style='letter-spacing: 16px;text-align: center;'>海岸巡防總局通資作業大隊休﹝請﹞假單</th>
                                <th style='font-size: 16px;'>編號</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width='70'>服務單位</td>
                                <td width='270' style='font-size: 22px' colspan='4'>通資第三中隊</td>
                                <td width='60'>職務</td>
                                <td width='270'><span class='blue'><?= $this->session->userdata('rank')?></span></td>
                                <td width='50'>姓名</td>
                                <td width='60'><span class='blue'><?= $this->session->userdata('name')?></span></td>
                            </tr>
                            <tr>
                                <td>差假別</td>
                                <td class='check-type' colspan='4'>
                                    <p>
                                        <span>A <d data-type='A'>□</d> 出差</span>
                                        <span>E <d data-type='E'>□</d> 病假</span>
                                        <span>I <d data-type='I'>□</d> 喪假　</span>
                                        <span>N <d data-type='N'>□</d> 監考假</span>
                                    </p>
                                    <p>
                                        <span>B <d data-type='B'>□</d> 公出</span>
                                        <span>F <d data-type='F'>□</d> 休假</span>
                                        <span>J <d data-type='J'>□</d> 天災假</span>
                                        <span>O <d data-type='O'>□</d> 進修假</span>
                                    </p>
                                    <p>
                                        <span>C <d data-type='C'>□</d> 公假</span>
                                        <span>G <d data-type='G'>□</d> 婚假</span>
                                        <span>K <d data-type='K'>□</d> 補假　</span>
                                        <span>P <d data-type='P'>□</d> 產前假</span>
                                    </p>
                                    <p>
                                        <span>D <d data-type='D'>□</d> 事假</span>
                                        <span>H <d data-type='H'>□</d> 娩假</span>
                                        <span>L <d data-type='L'>□</d> 其他假</span>
                                        <span>Q <d data-type='Q'>□</d> 陪產假</span>
                                    </p>
                                </td>
                                <td>
                                    起訖<br/>
                                    日期
                                </td>
                                <td class='date-col'>
                                    <p>自 102年 <span class='blue'><?= date('n', strtotime($params['start']))?></span>月 <span class='blue'><?= date('j', strtotime($params['start']))?></span>日 <span class='blue'><?
                                        switch ($params['time']) {
                                            case '2020':
                                            case '2008':
                                                echo '20';
                                                break;
                                            case '1818':
                                            default:
                                                echo '18';
                                                break;
                                        }
                                        ?></span>時 <span class='blue'>00</span>分起 <span class='blue'><?
                                        if ($params['time'] == '2008') {
                                            echo (strtotime($params['end']) - strtotime($params['start'])) / 86400 - 1;
                                        } else {
                                            echo (strtotime($params['end']) - strtotime($params['start'])) / 86400;
                                        }
                                        
                                        ?></span> 　日</p>
                                    <p style='text-align: right; position: relative; right: 45px;'>共</p>
                                    <p>至 102年 <span class='blue'><?= date('n', strtotime($params['end']))?></span>月 <span class='blue'><?= date('j', strtotime($params['end']))?></span>日 <span class='blue'><?
                                        switch ($params['time']) {
                                            case '2020':
                                                echo '20';
                                                break;
                                            case '2008':
                                                echo '08';
                                                break;
                                            case '1818':
                                            default:
                                                echo '18';
                                                break;
                                        }
                                        ?></span>時 <span class='blue'>00</span>分起 <span class='blue'><?= ($params['time'] == '2008') ? '12' : '0'?></span>小時</p>
                                </td>
                                <td>職務<br/>代理人</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>事由</td>
                                <td colspan='8' style='text-align: left !important;'><span class='blue'><?= $params['reason']?></span></td>
                            </tr>
                            <tr>
                                <td>請假期間<br/>聯絡地址<br/>或電話</td>
                                <td id='address' colspan='4'><p style='font-size: 14px;'><?= $params['address']?></p><p><?= $params['phone']?></p></td>
                                <td width='30'>證明<br/>文件</td>
                                <td></td>
                                <td>備註</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>人事人員<br/>會章</td>
                                <td colspan='2'></td>
                                <td width=30>審<br/>核</td>
                                <td></td>
                                <td>主<br/>官<br/>核<br/>章</td>
                                <td colspan='3'></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr/>
                <div class='tblContainer'>
                    <div style='border: 1px solid #000;font-size: 15px;paddding: 0 2px;'>
                        <p>一、依據「本總局暨所屬機關軍職人員週休二日實施規定」：</p>
                        <p class='indent'>（一）休（請）假均應於完成休（請）假手續後，始可離營，未完成手續擅離職守者，視情節輕重予以論處。</p>
                        <p class='indent'>（二）官兵休假期間如與戰備突發狀況，應依國防部頒「國軍人員緊急召回規定」迅速歸建。</p>
                        <p class='indent'>（三）軍職人員休（請）假離營，因不可抗力原因，延誤回營時間，應先以電話回報，具有確實證明者，得免以逾假論處，</p>
                        <p class='indent2'>如因天候因素無法如期返營，其延休日數應於次月休假日數中扣抵。</p>
                        <p>二、休假期間應恪遵下列規定：</p>
                        <p class='indent'>（一）嚴禁涉足舞廳、酒吧（酒廊）、酒家、有仕女陪侍之卡拉ＯＫ餐廳、ＫＴＶ、ＭＴＶ、ＰＵＢ、色情理容院、茶室、三</p>
                        <p class='indent2'>溫暖、網咖及賭博性電玩等場所。</p>
                        <p class='indent'>（二）不租用民（機）車，不酒後開（騎）車，不飆車，不無照駕駛民（機）車。</p>
                        <p class='indent'>（三）不偷竊、不酗酒、不調戲婦女、不吸食（持有、販賣）毒品、不違規私自持有違禁物品（槍械、彈藥）。</p>
                        <p class='indent'>（四）嚴禁現役軍人參加從事任何違背國軍使命，或破壞單位榮譽之組織或活動，違者，視情節輕重予以論處。</p>
                        <p class='indent'>（五）休假期間要與休假編組組員聯繫，相互提醒遵循安全事項。</p>
                    </div>
                    <table id='tbl2' class='table table-bordered'>
                        <thead>
                            <tr>
                                <th colspan='8' style='letter-spacing: 16px;width: 780px;text-align: center;'>海岸巡防總局通資作業大隊休﹝請﹞假單</th>
                                <th style='font-size: 16px;'>編號</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width='70'>服務單位</td>
                                <td width='270' style='font-size: 22px' colspan='4'>通資第三中隊</td>
                                <td width='60'>職務</td>
                                <td width='270'><span class='blue'><?= $this->session->userdata('rank')?></span></td>
                                <td width='50'>姓名</td>
                                <td width='60'><span class='blue'><?= $this->session->userdata('name')?></span></td>
                            </tr>
                            <tr>
                                <td>差假別</td>
                                <td class='check-type' colspan='4'>
                                    <p>
                                        <span>A <d data-type='A'>□</d> 出差</span>
                                        <span>E <d data-type='E'>□</d> 病假</span>
                                        <span>I <d data-type='I'>□</d> 喪假　</span>
                                        <span>N <d data-type='N'>□</d> 監考假</span>
                                    </p>
                                    <p>
                                        <span>B <d data-type='B'>□</d> 公出</span>
                                        <span>F <d data-type='F'>□</d> 休假</span>
                                        <span>J <d data-type='J'>□</d> 天災假</span>
                                        <span>O <d data-type='O'>□</d> 進修假</span>
                                    </p>
                                    <p>
                                        <span>C <d data-type='C'>□</d> 公假</span>
                                        <span>G <d data-type='G'>□</d> 婚假</span>
                                        <span>K <d data-type='K'>□</d> 補假　</span>
                                        <span>P <d data-type='P'>□</d> 產前假</span>
                                    </p>
                                    <p>
                                        <span>D <d data-type='D'>□</d> 事假</span>
                                        <span>H <d data-type='H'>□</d> 娩假</span>
                                        <span>L <d data-type='L'>□</d> 其他假</span>
                                        <span>Q <d data-type='Q'>□</d> 陪產假</span>
                                    </p>
                                </td>
                                <td>
                                    起訖<br/>
                                    日期
                                </td>
                                <td class='date-col'>
                                    <p>自 102年 <span class='blue'><?= date('n', strtotime($params['start']))?></span>月 <span class='blue'><?= date('j', strtotime($params['start']))?></span>日 <span class='blue'><?
                                        switch ($params['time']) {
                                            case '2020':
                                            case '2008':
                                                echo '20';
                                                break;
                                            case '1818':
                                            default:
                                                echo '18';
                                                break;
                                        }
                                        ?></span>時 <span class='blue'>00</span>分起 <span class='blue'><?
                                        if ($params['time'] == '2008') {
                                            echo (strtotime($params['end']) - strtotime($params['start'])) / 86400 - 1;
                                        } else {
                                            echo (strtotime($params['end']) - strtotime($params['start'])) / 86400;
                                        }
                                        
                                        ?></span> 　日</p>
                                    <p style='text-align: right; position: relative; right: 45px;'>共</p>
                                    <p>至 102年 <span class='blue'><?= date('n', strtotime($params['end']))?></span>月 <span class='blue'><?= date('j', strtotime($params['end']))?></span>日 <span class='blue'><?
                                        switch ($params['time']) {
                                            case '2020':
                                                echo '20';
                                                break;
                                            case '2008':
                                                echo '08';
                                                break;
                                            case '1818':
                                            default:
                                                echo '18';
                                                break;
                                        }
                                        ?></span>時 <span class='blue'>00</span>分起 <span class='blue'><?= ($params['time'] == '2008') ? '12' : '0'?></span>小時</p>
                                </td>
                                <td>職務<br/>代理人</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>攜帶物品</td>
                                <td colspan='4'>個人行李</td>
                                <td>家長<br/>簽章</td>
                                <td colspan='3'></td>
                            </tr>
                            <tr>
                                <td>審<br/>核</td>
                                <td colspan="4"></td>
                                <td>主<br/>官<br/>核<br/>章</td>
                                <td colspan='3'></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style='font-size: 14px;font-weight: bold;'>
                    <p>說明：一、本請假單適用部隊型態單位，由當事人填寫後交人事人員統一陳送單位主官核批。</p>
                    <p class='indent3'>二、本單經單位主官核准後，第一聯為請假存根，第二聯由單位主官實施離營宣教後交當事人收執，收假後送人事人員登記。</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("d[data-type='<?= $params['type']?>']").text('■');
    </script>
</body>
</html>