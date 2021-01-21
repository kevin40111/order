<?
 class Login_Model extends CI_Model {

    function __construct() {
      // Call the Model constructor
      parent::__construct();
    }
		
		function account_check($user,$pwd) {
			$sql = "SELECT *,(SELECT name FROM rank WHERE id = rank_id) as rank_name,(SELECT name FROM department WHERE id = dep_id) AS dep_name FROM member WHERE (SELECT member_id FROM register_check WHERE member_id = id) IS NULL AND username = ? AND password = ?";
			$query = $this->db->query($sql,array($user,$pwd));
			if ($row = $query->result()) {
				$newdata = array(
					'uid' => $row[0]->id,
					'nickname' => $row[0]->nickname,
					'name' => $row[0]->name,
					'rank' => $row[0]->rank_name,
					'dep_id' => $row[0]->dep_id,
					'dep_name' => $row[0]->dep_name,
					'start_date' => $row[0]->start_date,
					'end_date' => $row[0]->end_date,
					'address' => $row[0]->address,
					'phone' => substr($row[0]->phone, 0, 4) . '-' . substr($row[0]->phone, 4, 3) . '-' . substr($row[0]->phone, 7, 3)
				);
				return $newdata ;	
			} 
			else {
				return false ;
			}
		}
}
?>