<?if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Callleave extends CI_Controller {
	
	function __construct() {
		parent::__construct();
	}
	
	function index() {
		$this->show();
	}
	
	# Callleave Report
	function all($month = -1) {
		# Login Check
		if ($this->session->userdata('uid') == "") {
			header("Location: /login");
			exit();
		}
				
		# Month Default
		if ($month == -1)
			$month = date('Y-m');
		$split = explode('-', $month);
		
		# Week Translate
		$week = array('日', '一', '二', '三', '四', '五', '六');
		
		# Leave Days
		$leaveDays = array(0, 0, 10, 9, 10, 10, 10, 9, 10, 9, 10, 10, 9, 10);
		
		$this->load->model('member_model');
		
		# Get Member List
		$members = $this->member_model->get_members_order_by_dep($month . '-01');
		
		# Get Callleave Data
		foreach ($members as $key => $member) {
			$members[$key]->list = $this->member_model->get_callleave($member->id, $month);
		}
		
		# Get Graduate Member List
		$graduate = array();
		$graduate[(intval($split[1]) + 3) % 12] = $this->member_model->get_graduate(date("Y-m", strtotime($split[0] . '-' . ((intval($split[1]) + 3) % 12) . '-1')));
		$graduate[(intval($split[1]) + 4) % 12] = $this->member_model->get_graduate(date("Y-m", strtotime($split[0] . '-' . ((intval($split[1]) + 4) % 12) . '-1')));
		$graduate[(intval($split[1]) + 5) % 12] = $this->member_model->get_graduate(date("Y-m", strtotime($split[0] . '-' . ((intval($split[1]) + 5) % 12) . '-1')));
				
		# Render Page
		$this->load->view('header', array(
			'page' => 'callleave'
		));
		
		$this->load->view('callleave_all', array(
			'week' => $week,
			'leaveDays' => $leaveDays[date('n', mktime(0, 0, 0, intval($split[1]), 1, intval($split[0]))) + 1],
			'month' => intval($split[1]),
			'year' => intval($split[0]),
			'graduate' => $graduate,
			'members' => json_encode($members)
		));
		
		$this->load->view('footer');
	}
	
	# Callleave Main Page
	function show() {
		# Login Check
		if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
		
		# Week Translate
		$week = array('日', '一', '二', '三', '四', '五', '六');
		
		# Leave Days
		$leaveDays = array(10, 9, 10, 10, 10, 9, 10, 9, 10, 10, 9, 10);
		
		$this->load->model('member_model');
		
		# Get Member End Date
		$profile = $this->member_model->get_data_member($this->session->userdata('uid'));
		
		# Get Callleave Data
		$callleave = $this->member_model->get_callleave();
				
		$this->load->view('header', array(
			'page' => 'callleave'
		));

		$this->load->view('callleave_show', array(
			'week' => $week,
			'profile' => $profile,
			'leaveDays' => $leaveDays,
			'callleave' => $callleave['list'],
			'accuLeave' => $callleave['accuLeave']
		));
		
		$this->load->view('footer');
	}
	
	# Ajax Get Leave Date
	function get_leave_date() {
		# Login Check
		if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
		
		# Post Check
		if (!isset($_GET['month'])) {
			exit();
		}
		
		# Data Check
		$split = explode('-', $_GET['month']);
		if (count($split) != 2 || !is_numeric($split[0]) || !is_numeric($split[1])) {
			exit();
		}
		
		$this->load->model('member_model');
		$callleave = $this->member_model->get_callleave($this->session->userdata('uid'), $_GET['month']);
		
		echo json_encode(array(
			'list' => $callleave['list'],
			'accuLeave' => $callleave['accuLeave'],
			'month' => $_GET['month'],
			'monthDays' => date('t', mktime(0, 0, 0, intval($split[1]), 1, $split[0]))
		));
	}
	
	# Ajax Update Leave
	function set_leave() {
		# Login Check
		if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
				
		# Insert
		$this->load->model('member_model');
		$status = $this->member_model->set_callleave($_POST['date'], $_POST['deleteOnly']);
		
		# Result
		echo json_encode($status);
	}
    
    # 請假單
    function pt() {
        $this->load->view('callleave_print', array(
            'params' => isset($_GET) ? $_GET : array()
        ));
    }	
}
?>