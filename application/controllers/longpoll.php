<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Longpoll extends CI_Controller {
	function __construct() {
	  // Call the Model constructor
	  parent::__construct();
	 }	
	
	public function index() {
		if($this->session->userdata('uid') == ""){
			header("Location: /login");
			exit();
		}
		//model
		$this->load->model('forum_model');	
		
		$line = $_GET["line"];
		
		$result = array();
		$msg = $this->forum_model->long_get_txt($line,$this->session->userdata('uid'));
		$stickers = $this->forum_model->get_stickers();
		$timeout = 0;
		$this->forum_model->set_online($this->session->userdata('uid'));
		While($msg == null){
			if($timeout == 50) {
			  $msg = array();
				break;
			}
			usleep(600000);	
			$timeout = $timeout + 1 ;
			$msg = $this->forum_model->long_get_txt($line,$this->session->userdata('uid'));
			
		}
		$result["member_num"] = $this->forum_model->get_online();
		$result["msg"] = array_reverse($msg);
		$result["stickers"] = $stickers;
		echo json_encode($result);
	}
	
}

