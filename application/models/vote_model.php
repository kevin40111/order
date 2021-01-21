<?
 class Vote_Model extends CI_Model {

    function __construct() {
      // Call the Model constructor
      parent::__construct();
    }

    function vote_list() {
        $sql = "SELECT *,(SELECT COUNT(DISTINCT member_id) FROM member_vote WHERE item_id IN (SELECT id FROM vote_item WHERE vote_id = id )) as member_num ,(SELECT name FROM member WHERE id = creator_id) as member FROM vote WHERE status = ? ORDER BY create_time DESC" ;
        return $this->db->query($sql,array('open'))->result();
    }
    
    function item_edit($id) {
        $this->db->where('id', $id);
        $this->db->select('name,description');
        return $query = $this->db->get('vote_item')->result();
    }
    
    function item_del($data) {
        $this->db->delete('vote_item', array('id' => $data));
        return $this->db->affected_rows() ;
    }
    
    function vote_close($id) {
        $this->db->where('id', $id);
        $this->db->update('vote', array('status' => 'close')); 
        return $this->db->affected_rows() ;
    }
    
    function vote_del($id) {
        $this->db->delete('vote', array('id' => $id));
        return $this->db->affected_rows() ;
    }
    
    public function vote_enable(){
      $time = date("Y-m-d H:i:s");
      $sql = "SELECT * FROM vote WHERE end_date >='$time'";
      $query_editable = $this->db->query($sql);
      $num_rows = $query_editable->num_rows();


      /*for($i=0;$i<$num_rows;$i++)
      {
         $row = $query_editable->row_array($i);
         $vote_id = $row['vote_id'];
         
         $sql = "SELECT * FROM `vote` join `vote_item`on vote.id = vote_item.vote_id join `member_vote` on member_vote.item_id = vote_item.id where vote_id='$vote_id'";
         $query_item_voted =  $this->db->query($sql);
         $limit = $query_item_voted['limit'];
         


         

      }*/



      return $num_rows ;
    }

    function uesr_vote_view() {
        $sql = "SELECT *,(SELECT COUNT(DISTINCT member_id) FROM member_vote WHERE item_id IN (SELECT id FROM vote_item WHERE vote_id = vote.id )) as member_num,(SELECT name FROM member WHERE id = creator_id) as member FROM vote WHERE status = ? ORDER BY create_time DESC" ;
        return $this->db->query($sql,array('open'))->result();
    }
    
    function vote_item_view($itemid) {
        $sql = "SELECT *,(SELECT COUNT(id) FROM member_vote WHERE item_id = vote_item.id AND member_id = ? ) AS bool,(SELECT COUNT(id) FROM member_vote WHERE item_id = vote_item.id ) AS vote_total FROM vote_item WHERE vote_id = ? ";
        return $this->db->query($sql,array($this->session->userdata('uid'),$itemid))->result();
    }
   
    function action_vote($itemid) {       
      $sql = "SELECT vote.limit AS num FROM vote WHERE id = (SELECT vote_id FROM vote_item WHERE id = ?)" ;
      $maxNum = $this->db->query($sql,array($itemid))->result();
     
      $sql = "SELECT COUNT(id) AS num FROM member_vote WHERE member_id = ? AND item_id in (SELECT id FROM vote_item WHERE vote_id in (SELECT vote_id FROM vote_item WHERE id = ? ))"  ;
      $uservoteNum = $this->db->query($sql,array($this->session->userdata('uid'),$itemid))->result();
      
      $sql = "SELECT COUNT(id) AS itemNum FROM member_vote WHERE item_id = ?   ";
      $nownum = $this->db->query($sql,array($itemid))->result();
      
      if($uservoteNum[0]->num >= $maxNum[0]->num){
      // "票數超過";
        return -1;
      }
      else{
        // "還可以投";
      $data = array(
        'member_id' => $this->session->userdata('uid'),
        'item_id' => $itemid
        );
        $this->db->insert('member_vote', $data); 
        return $this->db->affected_rows() + $nownum[0]->itemNum;
      } 
    }
    
    function action_cl($itemid) {
      $sql = "SELECT COUNT(id) AS itemNum FROM member_vote WHERE item_id = ? ";
      $nownum = $this->db->query($sql,array($itemid))->result();
      $this->db->delete('member_vote', array('item_id' => $itemid,'member_id' => $this->session->userdata('uid'))); 
      
      return $nownum[0]->itemNum - $this->db->affected_rows() ; 
    }
     
    function get_comment($voteID = -1, $updateTime = -1) {
	    if ($updateTime == -1) {
	        $updateTime = strtotime('1970-01-01');
	    }
	    return $this->db->query("SELECT *, (SELECT name FROM member WHERE id = member_id) AS member FROM `vote_comment` WHERE vote_id = ? AND update_time >= ?", array($voteID, $updateTime))->result();
    }
     
    function add_comment($voteID, $comment) {
	    $this->db->insert('vote_comment', array(
	        'member_id' => $this->session->userdata('uid'),
	        'vote_id'   => $voteID,
	        'comment'   => $comment
	    ));
	    return $this->db->insert_id();
    }
     
    function remove_comment($commentID) {
        return $this->db->where('id', $commentID)->delete('vote_comment');
    }
		
		function history_list(){
			$sql = "SELECT *,(SELECT COUNT(DISTINCT member_id) FROM member_vote WHERE item_id IN (SELECT id FROM vote_item WHERE vote_id = vote.id )) as member_num ,(SELECT name FROM member WHERE id = creator_id) as member FROM vote WHERE status = ? ORDER BY create_time DESC" ;
	    return $this->db->query($sql,array('close'))->result();
		}
		
		function vote_num($id){
			$sql = "SELECT `limit` as num FROM vote WHERE id = ? ";	
			return $this->db->query($sql,array($id))->result() ;
		}
		
		function create_project($data){	
      $this->db->insert('vote', $data);
      return $this->db->insert_id();
		}
		
		function create_item($data){
			$this->db->insert_batch("vote_item",$data);
			 return $this->db->affected_rows();
		}
		
}
?>