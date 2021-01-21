<?if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	function index() {
    if($this->session->userdata('uid') == "") {
				header("Location: /login");
				exit();
		};

		$this->load->model('vote_model');
		$count = $this->vote_model->vote_enable();


    	$this->load->model('member_model');
		//view
		$this->load->view('header', array(
			'page' => 'member',
			'count' => $count
		));
		$this->load->view('member_list',array(
			'members' => $this->member_model->get_members(),
			'dep' => $this->member_model->get_depname(),
			'rank' => $this->member_model->get_rankname(),
			'funbord' =>$this->member_model->get_funbord()
		));
		$this->load->view('footer');
    }

	function check_username()
	{
		$data = $_GET['username'];
		//model
		$this->load->model('member_model');
		$message = $this->member_model->member_user_Chek($data);
		echo $message;
	}


	function btl( $id )
	{
		$this->session->set_userdata('enemy',$id);
		$this->load->view('btl');
		//echo "Hello $id";

	}

	function add()
	{
	    $name = $_POST["name"] ;
		$nickname = ($_POST["nickname"] != "" ) ? $_POST["nickname"] : null ;
		$birth = ($_POST["birth"] != "" ) ? $_POST["birth"] : null ;
		$dep_id = $_POST["dep_id"];
		$username = $_POST["username"];
		//
		$chkpwd = $_POST["chkpwd"];
		$start_date = ($_POST["start_date"] != "" ) ? $_POST["start_date"] : null ;
		$end_date = ($_POST["end_date"] != "" ) ? $_POST["end_date"] : null ;
		$rank_id = $_POST["rank_id"] ;
		$address = $_POST["address"];
		$phone = $_POST["phone"];

		//model 帳號是否重複
		$this->load->model('member_model');
		$req = $this->member_model->member_user_Chek($username);
		if($req != 0){
			$message = 0;
			echo $message ;
			exit();
		}

		$data = array(
			'username' => $username ,
			'password' => $chkpwd ,
			'name' => $name ,
			'nickname' => $nickname ,
			'birth' => $birth ,
			'rank_id' => $rank_id,
			'dep_id' => $dep_id ,
			'start_date' => $start_date ,
			'end_date' => $end_date ,
			'phone' => $phone ,
			'address' => $address
		);

			//model
			$this->load->model('member_model');
			$message = $this->member_model->add_member($data);
			if($message == 1)
			{
        if($this->session->userdata('uid') != "") {
					header("Location: /manage/");
					exit();
				}
				else {
					echo $message ;
					exit();
				}

			}
			else
			{
				echo $message ;
				exit();
			}
	}

	function edit($type = -1) {
		if($this->session->userdata('uid') == "") {
				header("Location: /login");
				exit();
		};
		$message = "" ;

		if($type == 1) {
			$message = "alert('資料修改成功');";
		} else if($type == 2) {
			$message = "alert('密碼修改成功');location.href = '/member/edit_pwd_cl' ;";
		}
		//model
		$this->load->model('member_model');

		//view
		$this->load->view('header', array(
			'page' => 'member_edit',
			'member' => $this->member_model->get_data_member($this->session->userdata('uid')),
			'message' => $message
		));
		$this->load->view('member_edit_view');
		$this->load->view('footer');
	}

	function edit_pwd_cl() {
		if($this->session->userdata('uid') == "") {
				header("Location: /login");
				exit();
		};
		$this->session->sess_destroy();
		header("Location: /login");
	}

	function edit_action() {
		if($this->session->userdata('uid') == "") {
				header("Location: /login");
				exit();
		};
		$nickname = $_POST["nickname"];
		$birth = ($_POST["birth"] == "") ? NULL : $_POST["birth"] ;
		$phone = $_POST["phone"];
		$address = $_POST["address"] ;
		$start_date = ($_POST["start_date"] == "") ? NULL : $_POST["start_date"] ;
		$end_date = ($_POST["end_date"] == "" ) ? NULL : $_POST["end_date"] ;

		$data = array(
						'nickname' => $nickname,
						'birth' => $birth,
						'phone' => $phone,
						'address' => $address,
						'start_date' => $start_date,
						'end_date' => $end_date
						);
		$where = 'id =' . $this->session->userdata('uid') ;

		$this->load->model('member_model');
		$this->member_model->edit_member($data,$where);
		$this->session->set_userdata('nickname',$nickname);
		$this->session->set_userdata('start_date',$start_date);
		$this->session->set_userdata('end_date',$end_date);
		header("Location: /member/message/1");
	}


	function edit_pwd()	{
		$ckpwd = $_POST["ckpwd"];
		$this->load->model('member_model');
		$data = array("password" => $ckpwd );
		$where = 'id = ' . $this->session->userdata('uid');

		//model
		$this->load->model('member_model');
		$this->member_model->edit_member($data,$where);
		header("Location: /member/message/2");
	}


	function check_member_ok(){
    if($this->session->userdata('uid') == "") {
				header("Location: /login");
				exit();
		};
		//model
		$this->load->model('member_model');
		echo $this->member_model->del_check($_POST['uid']);
	}

	function check_member_no(){
		if($this->session->userdata('uid') == "") {
				header("Location: /login");
				exit();
		};
		//model
		$this->load->model('member_model');
		echo $this->member_model->del_check_member($_POST['uid']);
	}


	function message($type) {
		$this->edit($type);
	}

	function check_pwd() {
		$hpwd =	$_POST['check_pwd'];
		//model
		$this->load->model('member_model');
		$re = $this->member_model->password_check($this->session->userdata('uid'));
		if($re[0]->password == $hpwd ) {
			echo 1 ;
		}	else {
			echo 0 ;
		}
	}

	function memberlistSum()
	{
		$this->load->model('member_model');
		//view
		$this->load->view('header', array(
			'page' => 'member'
		));
		$this->load->view('member_list',array(
			'members' => $this->member_model->get_members_orderSum(),
			'dep' => $this->member_model->get_depname(),
			'rank' => $this->member_model->get_rankname()
		));
		$this->load->view('footer');
	}
}
?>
