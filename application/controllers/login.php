<?if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata('uid') != "") {
            header("Location: /member");
            exit();
        }
        //model
        $this->load->model('member_model');
        $this->load->view('login_form', array(
            'dep' => $this->member_model->get_depname(),
            'rank' => $this->member_model->get_rankname(),
        ));
    }

    public function check_username()
    {
        $data = $_GET['username'];
        //model
        $this->load->model('member_model');
        $message = $this->member_model->member_user_Chek($data);
        echo $message;
    }

    public function register_success()
    {
        $this->index();
    }

    public function register_error()
    {
        $this->index();
    }

    public function checkID()
    {
        if (! (isset($_POST["user"])) || ! (isset($_POST["pwd"]))) {
            header("Location: /login");
            exit();
        }
        $user = $this->input->post("user");
        $pwd = $this->input->post("pwd");
        #models
        $this->load->model('login_model');
        $this->load->model('log_model');
        $data = $this->login_model->account_check($user, $pwd);
        $this->log_model->log_Write(0, 1, "account：" . $user . " " . "password：" . $pwd);

        if (! isset($data['errorMessage'])) {
            $this->session->set_userdata($data);
            $this->log_model->log_Write($this->session->userdata("uid"), 1, "登入系統，帳號為：" . $user);
            $this->session->userdata('uid');
            header("Location: /member");
            exit();
        } else {
            $this->load->view('login_form', array(
                'message' => '<script>alert("' . $data['errorMessage'] . '")</script>',
            ));

        }
    }

    public function logout()
    {
        $this->load->model('log_model');
        $this->log_model->log_Write($this->session->userdata("uid"), 2, "登出系統");
        $this->session->sess_destroy();
        header("Location: /login");
        exit();
    }

    public function googledown()
    {
        $this->load->helper('download');
        //echo dirname(__FILE__);
        //C:\xampp\htdocs\application\controllers
        $data = file_get_contents("C:\\xampp\htdocs\static\GoogleChromePortable.zip"); // Read the file's contents
        $name = "GoogleChromePortable.zip";
        force_download($name, $data);

    }
}
