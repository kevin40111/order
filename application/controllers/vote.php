<?if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {
	
	function __construct() {
      // Call the Model constructor
    parent::__construct();
		if($this->session->userdata('uid') == "") {
				header("Location: /login");
				exit();
		};
  }
	
	function index() {

		$this->load->model('vote_model');


		//view
		$this->load->view('header', array(
			'page' => 'vote'
		));
		//model
		
		$this->load->view('vote_view',array(
			'list' => $this->vote_model->uesr_vote_view(),
			'userid' => $this->session->userdata('uid')
		));
		$this->load->view('footer');
	}
	
	function user_vote(){
		//view
		$this->load->view('header', array(
			'page' => 'vote'
		));
		
		$this->load->view('user_vote_add_view');
		
		$this->load->view('footer');
	}
	
	function item_view($voteID,$type) {
		//model
		$this->load->model('vote_model');
        
    # 取得留言
    $comments = $this->vote_model->get_comment($voteID);
        
		//view
		$this->load->view('header', array(
			'page' => 'vote'
		));
		$this->load->view('vote_item_view',array(
      'voteID'    => $voteID,
			'item_list' => $this->vote_model->vote_item_view($voteID),
      'comments'  => $comments,
      'type' => $type,
      'maxvote' => $this->vote_model->vote_num($voteID)
		));
		$this->load->view('footer');
	}
	
	function vote_close() {
		//model
		$this->load->model('vote_model');
		$re = $this->vote_model->vote_close($_POST["voteid"]);
    echo $re;
	}
	
	function vote_del() {
		$this->load->model('vote_model');
		$re = $this->vote_model->vote_del($_POST["voteid"]);
		echo $re;
	}
	
	function item_edit() {
		//model
		$this->load->model('vote_model');
		$re = $this->vote_model->item_edit($_POST["itemid"]);
		echo json_encode($re);
	}
	
	function item_del() {
		//model
		$this->load->model('vote_model');
		echo $this->vote_model->item_del($_POST["itemid"]);
	}
    
  function action_vote() {
      //model
      $this->load->model('vote_model');  
      echo $this->vote_model->action_vote($_POST["itemid"]);
    
  }
    
  function action_cl() {
      //model
      $this->load->model('vote_model');  
      echo $this->vote_model->action_cl($_POST["itemid"]);
  }
  
  function add_comment($voteID = -1) {
      $this->load->model('vote_model');
      echo $this->vote_model->add_comment($voteID, $_POST['comment']);
  }
  
  function remove_comment($commentID = -1) {
      $this->load->model('vote_model');
      echo $this->vote_model->remove_comment($commentID);
  }
	
	function history(){
			$this->load->view('header', array(
			'page' => 'vote'
		));
		//model
		$this->load->model('vote_model');
		
		
		$this->load->view('vote_history_view',array(
			'list' => $this->vote_model->history_list(),
			'userid' => $this->session->userdata('uid')
		));
		$this->load->view('footer');
	}
	function vote_create(){
		$vote_name = $_POST["vote_project"];
		$vote_num = $_POST["vote_num"];
		$vote_end_date = $_POST["vote_end_date"];
		
		//model
		$this->load->model('vote_model');
		#project add
		$data = array(
			'name' => $vote_name,
			'limit' => $vote_num,
			'end_date' => $vote_end_date,
			'creator_id' => $this->session->userdata('uid')
			);
		$vote_id = $this->vote_model->create_project($data);
		#item add
		$item = array();
		foreach($_POST["item_data"] as $option ){		
			array_push($item,array(
				'name' => $option["name"],
				'description' => $option["description"],
				'vote_id' => $vote_id 
				));	
		};
		$re = $this->vote_model->create_item($item);
		echo $re;
	}
	
}
?>