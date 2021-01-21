<?if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manage extends CI_Controller {		
	function __construct() {
    // Call the Model constructor
    parent::__construct();
    if ($this->session->userdata('uid') == "" || 
        (!(($this->session->userdata('dep_id') == "1") || ($this->session->userdata('dep_id') == "2"))) ) {
			header("Location: /login");
			exit();
		}
  }	
			
	function index() {
		//model
		$this->load->model('member_model');
		
		//view
		$this->load->view('header', array(
			'page' => 'manage'
		));

		$this->load->view('data_manage_choice');

		$this->load->view('manege_member_list_view',array(
			'members' => $this->member_model->get_members(),
			'dep' => $this->member_model->get_depname(),
			'rank' => $this->member_model->get_rankname()
		));
		$this->load->view('footer');
	}
	
	function member_add_view() {
		
		//model
		$this->load->model('member_model');
		
		//view
		$this->load->view('header', array(
			'page' => 'manage'
		));

		$this->load->view('data_manage_choice');

		$this->load->view('manage_member_add_view',array(
			'dep' => $this->member_model->get_depname(),
			'rank' => $this->member_model->get_rankname()
		));
		$this->load->view('footer');
	}
	
	function member_check_view() {
		//model
		$this->load->model('member_model');
		//view
		$this->load->view('header', array(
			'page' => 'manage'
		));


		$this->load->view('data_manage_choice');

		$this->load->view('manage_checkmember_view',array(
			'members' => $this->member_model->get_manage_members(),
			'dep' => $this->member_model->get_depname(),
			'rank' => $this->member_model->get_rankname()
		));
		$this->load->view('footer');
	}
	
	function vote_list() {
		//model
		$this->load->model('vote_model');
		
		//view
		$this->load->view('header', array(
			'page' => 'manage'
		));

		$this->load->view('data_manage_choice');

		$this->load->view('vote_list_view',array(
			'vote_list' => $this->vote_model->vote_list()
		));
		$this->load->view('footer');
	}

	 public function funbord_list(){
		//model
		$this->load->model('member_model');
		$this->load->view('header', array(
			'page' => 'manage'
		));


		$this->load->view('data_manage_choice');

		$funbord = $this->member_model->get_funbord();
		$funbord = json_decode($funbord);

		$data['funbord_data'] = $funbord;

		$this->load->view('funbord_list_edit_view',$data);
	}

	public function delete_funbord(){
		//model
		$this->load->model('funbord_model');

		if(isset($_POST['bord_id'])){
			$bord_id = $_POST['bord_id'];
			$this->funbord_model->delete_funbord($bord_id);
			
		} 
	}
}
?>