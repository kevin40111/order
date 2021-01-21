<?
class Shop_Model extends CI_Model {
	
	function __construct() {
		parent::__construct();
	}
	
	function get_list() {
		return $this->db->from('shop')->get()->result();
	}
	
	function get_customerize_types() {
		return $this->db->from('shop_customerize_type')->get()->result();
	}
    
    function add_shop($name, $phone, $remark = '') {
        if (!isset($name) || !isset($phone)){
            return false;
        }
        
        $this->db->insert('shop', array(
            'name'      => $name,
            'phone'     => $phone,
            'remark'    => $remark
        ));
        
        return $this->db->insert_id();
    }
    
    function edit_profile($id = -1, $name = '', $phone = '', $remark = '') {
        if ($id == -1) {
            return false;
        }
        
        $this->db->where('id', $id)->update('shop', array(
            'name'      => $name,
            'phone'     => $phone,
            'remark'    => $remark
        ));
        
        return $this->db->affected_rows();
    }
    
    function add_item($shopID, $item, $price, $customerize1 = -1, $customerize2 = -1) {
        if (!isset($shopID)) {
            return false;
        }
        
        $this->db->insert('shop_item', array(
            'shop_id'   => $shopID,
            'type_1_id' => $customerize1,
            'type_2_id' => $customerize2,
            'name'      => $item,
            'price'     => $price
        ));
        return $this->db->insert_id();
    }
    
    function edit_item($itemID, $item, $price, $customerize1 = -1, $customerize2 = -1) {
        if (!isset($itemID)) {
            return false;
        }
        
        $this->db->where('id', $itemID)->update('shop_item', array(
            'type_1_id' => $customerize1,
            'type_2_id' => $customerize2,
            'name'      => $item,
            'price'     => $price
        ));
        return $this->db->affected_rows();
    }
    
    function delete_item($itemID) {
        $this->db->where('id', $itemID)->delete('shop_item');
        return $this->db->affected_rows();
    }

	//function delete_shop($shopID){
		//$this->db->
    
    function customerize_list() {
        return $this->db->from('shop_customerize_type')->get()->result();
    }
    
    function item_list($shopID = -1) {
        return $this->db->from('shop_item')->where('shop_id', $shopID)->get()->result();
    }
    
    function profile($shopID = -1) {
        return $this->db->where('id', $shopID)->from('shop')->get()->result();
    }
}
?>