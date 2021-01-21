 <?
 class Member_Model extends CI_Model {

    function __construct() {
      // Call the Model constructor
      parent::__construct();
    }

    function get_profile() {
        $query = $this->db->query('SELECT *,(SELECT name FROM department WHERE id = dep_id) AS dep_name FROM member');
        foreach($query->result() as $row){

        }
    }

    //撈部門名稱
    function get_depname(){
        $query = $this->db->query('SELECT id,name FROM department');
        $dep = array();
        foreach ($query->result() as $row) {
            $dep[] = $row;
        }
        return $dep;
    }

    //撈位階名稱
    function get_rankname(){
        $query = $this->db->query('SELECT id,name FROM rank LIMIT 0,13');
        $rank = array();
        foreach ($query->result() as $row) {
            $rank[] = $row;
        }
        return $rank;
    }


    #撈所有人資料
    function get_members($date = -1) {
        if ($date == -1) {
            $date = date("Y-m-d");
            $dateLast = date("Y-m-t");
        } else {
            $tmp = explode('-', $date);
            $dateLast = date('Y-m-t', mktime(0, 0, 0, $tmp[1], 1, $tmp[0]));
        }
        $query = $this->db->query('SELECT *,
                (SELECT name FROM rank WHERE id = rank_id) AS rank_name,
                (SELECT name FROM department WHERE id = dep_id) AS dep_name,
                (SELECT SUM(X.count * A.price) FROM order_item as X
                Inner Join shop_item as A on A.id = X.item_id
                Inner Join `order` as B on B.id = X.order_id
                WHERE X.member_id = member.id AND B.create_time >= \'2014-08-05\') AS SUM
                FROM member WHERE (SELECT member_id FROM register_check WHERE member_id = id) IS NULL', array(
            $dateLast,
            $date
        ));

        return $query->result();
    }

    #撈所有人資料 (處室排序)
    function get_members_order_by_dep($date = -1) {
        if ($date == -1) {
            $date = date("Y-m-d");
            $dateLast = date("Y-m-t");
        } else {
            $tmp = explode('-', $date);
            $dateLast = date('Y-m-t', mktime(0, 0, 0, $tmp[1], 1, $tmp[0]));
        }

        $query = $this->db->query('SELECT *,(SELECT name FROM rank WHERE id = rank_id) AS rank_name,(SELECT name FROM department WHERE id = dep_id) AS dep_name FROM member WHERE (SELECT member_id FROM register_check WHERE member_id = id) IS NULL', array(
            $dateLast,
            $date
        ));

        return $query->result();
    }

    #撈所有人資料 (審核中)
    function get_manage_members() {
        $query = $this->db->query('SELECT *,(SELECT name FROM rank WHERE id = rank_id) AS rank_name,(SELECT name FROM department WHERE id = dep_id) AS dep_name FROM member WHERE (SELECT member_id FROM register_check WHERE member_id = id) IS NOT NULL ORDER BY end_date DESC') ;
        return $query->result();
    }

    #取得娛樂版資料
    public function get_funbord(){
         $this->db->SELECT('*');
         $this->db->from('funbord');
         $this->db->order_by('bord_id','desc');
         $query = $this->db->get();


        $data = $query->result();

        return json_encode($data);
    }

    #撈所有人資料(夜點費排序)
    function get_members_orderSum($date = -1) {
        if ($date == -1) {
            $date = date("Y-m-d");
            $dateLast = date("Y-m-t");
        } else {
            $tmp = explode('-', $date);
            $dateLast = date('Y-m-t', mktime(0, 0, 0, $tmp[1], 1, $tmp[0]));
        }
        $query = $this->db->query('SELECT *,
(SELECT name FROM rank WHERE id = rank_id) AS rank_name,
(SELECT name FROM department WHERE id = dep_id) AS dep_name,
(SELECT SUM(X.count * A.price) FROM order_item as X
Inner Join shop_item as A on A.id = X.item_id
Inner Join `order` as B on B.id = X.order_id
WHERE X.member_id = member.id AND B.create_time >= \'2014-08-05\') AS SUM
FROM member WHERE (SELECT member_id FROM register_check WHERE member_id = id) IS NULL ORDER BY SUM DESC', array(
            $dateLast,
            $date
        ));

        return $query->result();
    }

    //新增人員
    function add_member($data) {
        $sql = $this->db->insert_string('member',$data);
        $this->db->query($sql);


        $line = $this->db->affected_rows();
        $id = $this->db->insert_id();
        $sql = "INSERT INTO register_check VALUES(?)";
        $this->db->query($sql,array($id));
        return $line ;
    }

    //撈個人資料
    function get_data_member($uid){
        $sql = 'SELECT *,(SELECT name FROM rank WHERE id = rank_id) AS rank_name,(SELECT name FROM department WHERE id = dep_id) AS dep_name FROM member WHERE id = ?';
        $query = $this->db->query($sql,array($uid))->result();
        return $query[0];
    }

    //編輯個人資料
    function edit_member($data,$where){
      	$this->db->query($this->db->update_string('member', $data, $where));
				return $this->db->affected_rows();
    }

    //確認舊密碼
    function password_check($uid) {
        $sql = "SELECT password FROM member WHERE id = ?" ;
        return $this->db->query($sql,array($uid))->result();
    }

    //檢查帳號有無重複
    function member_user_Chek($data){
        $sql = 'SELECT count(username) as num FROM member WHERE username = ?';
        $query = $this->db->query($sql,array($data));
        $num = "";
        foreach ($query->result() as $row) {
            $num = $row->num;
        }
        return $num ;
    }

    # 設定假表
    function set_callleave ($list = array(), $deleteOnly = -1) {

        $this->db->query('DELETE FROM callleave WHERE member_id = ? AND date BETWEEN ? AND ?', array(
            $this->session->userdata('uid'),
            date("Y-m", substr($list[0], 0, -3)) . '-01',
            date("Y-m-d", mktime(0, 0, 0, date("m", substr($list[0], 0, -3)), date("t", substr($list[0], 0, -3)), date("Y", substr($list[0], 0, -3))))
        ));

        if ($deleteOnly == 1) {
            return array('status' => 'success');
        }


        for ($i = 0, $l = count($list); $i < $l; $i++) {
            $this->db->query('INSERT INTO callleave (member_id, date) VALUES (?, ?) ON DUPLICATE KEY UPDATE member_id = member_id', array(
                $this->session->userdata('uid'),
                date("Y-m-d", substr($list[$i], 0, -3))
            ));
        }


        # 積休判斷
        $member = $this->db->where('id', $this->session->userdata('uid'))->from('member')->get()->result();
        $endMonth = date('n', strtotime($member[0]->end_date));
        $leaves = $this->db->where('member_id', $this->session->userdata('uid'))->order_by('date', 'ASC')->from('callleave')->get()->result();
        $totalLeave = count($leaves);
        if ($totalLeave) {
            $startMonth = date('n', strtotime($leaves[0]->date));
            $endCallleaveMonth = date('n', strtotime($leaves[($totalLeave - 1)]->date));
            if ($endCallleaveMonth == $endMonth) {
                $lastMonthTotal = round(date('j', strtotime($member[0]->end_date)) / date('t', strtotime($member[0]->end_date)) * $this->shouldDays(date('n', strtotime($member[0]->end_date)), 1));
                $totalShould = $this->shouldDays($startMonth, $this->monthCount($startMonth, $endMonth - 1)) + $lastMonthTotal;
            } else {
                $totalShould = $this->shouldDays($startMonth, $this->monthCount($startMonth, $endCallleaveMonth));
            }
            if ($totalShould < $totalLeave) {
                $nextMonth = str_pad((date("m", substr($list[0], 0, -3)) == 12) ? 1 : date("m", substr($list[0], 0, -3)) + 1, 2, 0, STR_PAD_LEFT);
                $this->db->where('member_id', $this->session->userdata('uid'))->where('date >=', date("Y-", substr($list[0], 0, -3)) . $nextMonth . '-01')->from('callleave')->delete();
                return array('status' => 'deleted');
            } else {
                return array('status' => 'success');
            }
        }
    }

    function monthCount ($from, $to) {
        if ($to > $from) {
            return $to - $from + 1;
        } else if ($to == $from){
            return 12;
        } else {
            return $to + 13 - $from;
        }
    }

    # 預假日統計
    function shouldDays ($from, $total) {
        $should = array(10, 10, 9, 10, 10, 10, 9, 10, 9, 9, 10, 9, 10);
        $tmp = 0;
        for ($i = 0; $i < $total; $i++) {
            $tmp += $should[($from + $i) % 12];
        }
        return $tmp;
    }

    # 取得放假資料
    function get_callleave ($memberID = -1, $month = -1) {

        # 預設現在使用者
        if ($memberID == -1) {
            $memberID = $this->session->userdata('uid');
        }

        # 預設當月
        if ($month == -1) {
            $start = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
            $accuMonth = intval(date('m'));
            $accuYear = intval(date('Y'));
            $end = date('Y-m-d', mktime(0, 0, 0, date('m'), date('t'), date('Y')));
        } else {
            $split = explode('-', $month); # 格式 YYYY-MM
            $start = date('Y-m-d', mktime(0, 0, 0, $split[1], 1, $split[0]));
            $accuMonth = intval(date('m', mktime(0, 0, 0, $split[1], 1, $split[0])));
            $accuYear = intval(date('Y', mktime(0, 0, 0, $split[1], 1, $split[0])));
            $end = date('Y-m-d', mktime(0, 0, 0, $split[1], date('t', mktime(0, 0, 0, $split[1], 1, $split[0])), $split[0]));
        }

        # 預定假表
        $should = array(10, 9, 10, 10, 10, 9, 10, 9, 9, 10, 9, 10);

        # 查詢積休
        $accuLeave = $this->db->query("SELECT date FROM callleave WHERE member_id = ? AND date < ? ORDER BY date ASC", array(
            $memberID,
            $start
        ))->result();

        if (count($accuLeave)) {
            $firstMonth = intval(date('m', strtotime($accuLeave[0]->date)));
            $firstYear = intval(date('Y', strtotime($accuLeave[0]->date)));
            $totalMonth = ($accuYear - $firstYear) * 12 + $accuMonth - $firstMonth;
            $totalShould = $this->shouldDays($firstMonth, $totalMonth);
            $accuLeave = $totalShould - count($accuLeave);
        } else {
            $accuLeave = 0;
        }

        # 資料庫查詢
        $result = $this->db->query("SELECT date FROM callleave WHERE member_id = ? AND date BETWEEN ? AND ?", array(
            $memberID,
            $start,
            $end
        ))->result();

        return array(
            'list' => $result,
            'accuLeave' => $accuLeave
        );
    }

    # 取得月份退伍弟兄清單
    function get_graduate($month = -1) {
        if ($month == -1) {
            $month = date("Y-m");
        }

        $month = explode('-', $month);
        $dateFrom = date("Y-m-d", mktime(0, 0, 0, $month[1], 1, $month[0]));
        $dateTo = date("Y-m-t", mktime(0, 0, 0, $month[1], 1, $month[0]));

        $result = $this->db->query("SELECT name, CONVERT(SUBSTR(end_date, 9), UNSIGNED INTEGER) AS date FROM member WHERE end_date BETWEEN ? AND ?", array(
            $dateFrom,
            $dateTo
        ))->result();

        return $result;
    }


    //通過待審核人員資料
    function del_check($id){
        $sql = "DELETE FROM register_check WHERE member_id = ?";
        $this->db->query($sql,array($id));
        return $this->db->affected_rows();
    }

    //刪除待審核人員資料
    function del_check_member($id){
        $sql = "DELETE FROM member WHERE id = ?";
        $this->db->query($sql,array($id));
        return $this->db->affected_rows();
    }

    function print_leave() {

    }
}
?>
