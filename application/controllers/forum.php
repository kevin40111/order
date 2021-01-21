<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends CI_Controller {
	function __construct() {
	  // Call the Model constructor
	  parent::__construct();
	 }	
	
	
	public function index() {
	if($this->session->userdata('uid') == ""){
		header("Location: /login");
		exit();
	}
		//view
		$this->load->view('header', array(
			'page' => 'forum'
		));
		$this->load->view('forum_view',array(
			'member' => $this->session->userdata('name')
		));
		$this->load->view('footer');
	}
	
	public function set_txt() {
		if($this->session->userdata('uid') == ""){
			echo 0 ;
			exit();
		}
		$txt = strip_tags($_POST["text"]);
		$data = array(
				'member_id' => $this->session->userdata('uid'),
				'talk_text' => $txt
			);
		#model
		$this->load->model('forum_model');
		$this->load->model('log_model');
		$this->log_model->log_Write($this->session->userdata("uid"),3 ,"發言紀錄： ".$txt);	
		$this->forum_model->set_txt($data);		
		echo 1;
	}
	
	public function set_to_txt() {
		if($this->session->userdata('uid') == ""){
			echo 0 ;
			exit();
		}
		//model
		$this->load->model('forum_model');	
		$this->load->model('log_model');
		$member_id = $this->forum_model->member_id($_POST["member"]);
		$txt = strip_tags($_POST["text"]);
		//'tomember' =>
		$data = array(
				'member_id' => $this->session->userdata('uid'),
				'tomember' => $member_id[0]->id,
				'talk_text' => $txt
			);
		$this->log_model->log_Write($this->session->userdata("uid"),3 ,"密語紀錄： ".$txt);		
		$this->forum_model->set_txt($data);	
		echo 1;
	}
	
	function get_txt() {
		//model
		$this->load->model('forum_model');
		$msg = $this->forum_model->get_txt($this->session->userdata('uid'));
		$this->forum_model->set_online($this->session->userdata('uid'));
		$stickers = $this->forum_model->get_stickers();
		$result["msg"] = array_reverse($msg);
		$result["member_num"] = $this->forum_model->get_online();
		$result["stickers"] = $stickers;
		echo json_encode(array_reverse($result));	
	}

	/*function get_sticker_path() {
		$tag = strip_tags($_GET["tag"]);
		//model
		$this->load->model('forum_model');
		$path = $this->forum_model->get_sticker_path($tag);
		echo json_encode($path);
	}*/
	
	function pop_forum() {
		$this->load->model('forum_model');

		$this->load->view('pop_forum_view', array(
			'stickers' => $this->forum_model->get_stickers()
		)) ;
	}
}

