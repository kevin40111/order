<?
class Order_Model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

    function add($uid, $shops, $expire) {
        $this->db->insert('order', array(
            'member_id'     => $uid,
            'expire_time'   => date('Y-m-d H:i:s', substr($expire, 0, 10))
        ));

        $orderID = $this->db->insert_id();

        for ($i = 0; $i < count($shops); $i++) {
            $this->db->insert('order_shop', array(
                'order_id'  => $orderID,
                'shop_id'   => $shops[$i]
            ));
        }
        return true;
    }

    function update_expire($uid,$expire){
        $data = array('expire_time'=>date('Y-m-d H:i:s', substr($expire, 0, 10)));
        $this->db->where("id",$uid);
        $this->db->update('order',$data);
        return true;
    }


    function del($orderID) {
        $this->db->where('id', $orderID)->delete('order');
        return true;
    }

    function is_expired($orderID = -1) {
      return count($this->db->query("SELECT * FROM `order` WHERE `id` = ? AND `expire_time` >= now()", array($orderID))->result());
    }

    function get_customerize() {
        $list = $this->db->order_by('id', 'asc')->from('shop_customerize_type')->get()->result();
        $arr = array();
        foreach ($list as $cus) {
            $arr[$cus->id] = $this->db->from('shop_customerize')->where('type_id', $cus->id)->order_by('id', 'desc')->get()->result();
        }
        return $arr;
    }

    function get_my_order($orderID = -1) {
        return $this->db->query("SELECT id, (SELECT price FROM shop_item WHERE id = item_id) AS price, (SELECT name FROM shop_item WHERE id = item_id) AS item, count, (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL THEN '無' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_one) END) AS type_one, (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '無' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_two) END) AS type_two FROM `order_item` WHERE order_id = ? AND member_id = ?", array($orderID, $this->session->userdata('uid')))->result();
    }

	function get_all_order_ordered_by_member($orderID = -1)
	{
		return $this->db->query("SELECT id, (SELECT name FROM shop WHERE id = (SELECT shop_id FROM shop_item WHERE id = item_id)) AS shop, (SELECT phone FROM shop WHERE id = (SELECT shop_id FROM shop_item WHERE id = item_id)) AS shop_phone, (SELECT name FROM member WHERE id = member_id) AS member, (SELECT start_date FROM member WHERE id = member_id) AS member_old, ( SELECT name FROM department WHERE id = (SELECT dep_id FROM member WHERE id = member_id)) AS department, ( SELECT id FROM department WHERE id = (SELECT dep_id FROM member WHERE id = member_id)) AS department_id, (SELECT price FROM shop_item WHERE id = item_id) * count AS total_price, (SELECT price FROM shop_item WHERE id = item_id) AS price, concat((SELECT name FROM shop_item WHERE id = item_id), (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL AND (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '' ELSE ' (' END),(CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL THEN '' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_one) END), (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL THEN '' WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '' ELSE ', ' END), (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_two) END),  (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL AND (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '' ELSE ')' END)) AS item, count, (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL THEN '無' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_one) END) AS type_one, (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '無' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_two) END) AS type_two FROM `order_item` WHERE order_id = ? ORDER BY member_old, member, item_id ASC", array($orderID))->result();
	}

    function get_all_order($orderID = -1) {
        return $this->db->query("SELECT id, (SELECT name FROM shop WHERE id = (SELECT shop_id FROM shop_item WHERE id = item_id)) AS shop, (SELECT phone FROM shop WHERE id = (SELECT shop_id FROM shop_item WHERE id = item_id)) AS shop_phone, (SELECT name FROM member WHERE id = member_id) AS member, (SELECT start_date FROM member WHERE id = member_id) AS member_old, ( SELECT name FROM department WHERE id = (SELECT dep_id FROM member WHERE id = member_id)) AS department, ( SELECT id FROM department WHERE id = (SELECT dep_id FROM member WHERE id = member_id)) AS department_id, (SELECT price FROM shop_item WHERE id = item_id) * count AS total_price, (SELECT price FROM shop_item WHERE id = item_id) AS price, concat((SELECT name FROM shop_item WHERE id = item_id), (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL AND (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '' ELSE ' (' END),(CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL THEN '' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_one) END), (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL THEN '' WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '' ELSE ', ' END), (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_two) END),  (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL AND (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '' ELSE ')' END)) AS item, count, (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_one) IS NULL THEN '無' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_one) END) AS type_one, (CASE WHEN (SELECT `option` FROM `shop_customerize` WHERE id = type_two) IS NULL THEN '無' ELSE (SELECT `option` FROM `shop_customerize` WHERE id = type_two) END) AS type_two FROM `order_item` WHERE order_id = ? ORDER BY item_id ASC", array($orderID))->result();
		//
    }

    function get_list() {
        $orders = $this->db->query('SELECT *, (SELECT name FROM member WHERE id = member_id) AS member FROM `order` ORDER BY expire_time DESC')->result();

        foreach ($orders as $key => $order) {
            $shops = $this->db->query('SELECT *, (SELECT name FROM shop WHERE id = shop_id) AS shop FROM order_shop WHERE order_id = ?', array($order->id))->result();

            $shopArr = array();
            $shopIDArr = array();
            foreach ($shops as $shop) {
                array_push($shopArr, $shop->shop);
                array_push($shopIDArr, $shop->shop_id);
            }
            $orders[$key]->shop = $shopArr;
            $orders[$key]->shopID = $shopIDArr;
        }
        return $orders;
    }

    function get_list_by_order($orderID = -1) {
        $list = $this->db->query("SELECT * FROM shop WHERE id IN (SELECT shop_id FROM `order_shop` WHERE order_id = ?)", array($orderID))->result();
        foreach ($list as $key => $shop) {
            $list[$key]->items = $this->db->from('shop_item')->where('shop_id', $shop->id)->get()->result();
        }
        return $list;
    }

    function add_item_order($orderID = -1, $itemID, $count = 1, $typeOne = -1, $typeTwo = -1) {
        if ($orderID == -1 || !isset($itemID)) {
            return false;
        }

        $this->db->insert('order_item', array(
            'order_id'  => $orderID,
            'member_id' => $this->session->userdata('uid'),
            'item_id'   => $itemID,
            'count'     => $count,
            'type_one'  => $typeOne,
            'type_two'  => $typeTwo
        ));

        return $this->db->insert_id();
    }

    function del_item_order($orderItemID = -1) {
        $this->db->where('id', $orderItemID)->delete('order_item');
        return $this->db->affected_rows();
    }

    function get_order_item($orderID = -1) {

    }
}
?>
