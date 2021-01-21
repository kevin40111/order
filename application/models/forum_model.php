<?
 class Forum_Model extends CI_Model {

    function __construct() {
      // Call the Model constructor
      parent::__construct();
    }
		
		function set_txt($data) {
			$this->db->insert('forum', $data);
			return $this->db->affected_rows();
		}
		
		function set_to_txt($data) {
			$this->db->insert('forum', $data);
			return $this->db->affected_rows();
		}
		
		function get_txt($id) {
			$this->db->select('forum.id,tomember,member_id,talk_text,talk_date,(SELECT name FROM member WHERE id = member_id ) as name,(SELECT name FROM member WHERE id = tomember ) as toname');
			$this->db->from('forum');
			$this->db->where_in('tomember',array(-1,$id));
			$this->db->or_where('member_id',$id);
			$this->db->order_by("id","desc");
			$this->db->limit(350);
			return $this->db->get()->result();
		}
		
		function long_get_txt($line,$id) { 
			$this->db->select('forum.id,tomember,member_id,talk_text,talk_date,(SELECT name FROM member WHERE id = member_id ) as name,(SELECT name FROM member WHERE id = tomember ) as toname');
			$this->db->from('forum');
			$str = "forum.id > $line AND (tomember in('-1','$id') OR member_id = $id)";
			$this->db->where($str);
			$this->db->order_by("forum.id","desc");
			$this->db->limit(10);
			return $this->db->get()->result();
		}
		
		function member_id($name){
			$sql = "SELECT id FROM member WHERE name = ?";
			return $this->db->query($sql,array($name))->result();
		}
		function set_online($id){
			$this->db->insert('online', array("member_id" => $id));
			return $this->db->affected_rows();
		}

		function get_online(){
			$sql = "SELECT DISTINCT member_id,(SELECT name FROM member WHERE id = member_id ) as name FROM online WHERE last_activity >= date_add(now(),interval -40 second) " ;
			
			return $this->db->query($sql)->result();
		}

		function get_stickers(){
			$sql = "SELECT stickers_id as id, stickers_path as path, stickers_tag as tag FROM forum_stickers ORDER BY stickers_id ASC";
			
			return $this->db->query($sql)->result();
		}
}
?>