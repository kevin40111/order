<?
class Funbord_model extends CI_Model {
	function __construct() {
      // Call the Model constructor
      parent::__construct();
    }

    //新增娛樂版
    public function add_funbord($data){
    	 $sql = $this->db->insert_string('funbord',$data);
    	 $this->db->query($sql);
    }

    //刪除娛樂版
    public function delete_funbord($bord_id){
    	$this->db->where("bord_id",$bord_id);
    	$this->db->delete('funbord');
    	echo '<script>alert("ok");</script>';
    }
}
?>