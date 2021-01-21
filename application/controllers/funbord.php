<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Funbord extends CI_Controller {

    function __construct() {
      // Call the Model constructor
    parent::__construct();
    $this->load->helper(array('form','url'));
  }
	
	public function index() {
		if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
        
        // View Render
		$this->load->view('header',array(
            'page' => 'funbord')
        );
        
		$this->load->view('funbord_add');
        
		$this->load->view('footer');
	} 




     function upload(){
        $upload = 1;
        $title = $_POST["title"];
        $content = $_POST["content"];
        $writer = $this->session->userdata('name');
        $message = "";
            
        $tempdata = $_POST["ext"] == null;

        if(!($_POST["ext"] == null)){
        //img address set , use date for filename 
        $target_dir = 'C:/xampp/htdocs/static/images/status/';   
        $date = date_create();
        $file_name = date_timestamp_get($date);

        $target_file =$target_dir.$file_name.'.'.$_POST["ext"];

        $path = '/static/images/status/';
        $path .=$file_name.'.'.$_POST["ext"];
        }  

        else{
        $path="";
        $target_file = "";
        }


        $data = array(
            'title' => $title , 
            'content' => $content , 
            'path' => $path ,
            'writer'=>$writer
        );

       
        if($_FILES["file-input"]["size"]>6000000){
            $upload = 0;
            $message = "alert('圖片檔案太大 請小於5MB');";

        }

        if($upload == 1){
            //將檔案存至target_file中
            @move_uploaded_file($_FILES["file-input"]["tmp_name"],$target_file);
             $this->load->model('funbord_model');
             $this->funbord_model->add_funbord($data);
              $message = "alert('資料新增成功');";
        }


        $this->load->view('header',array(
            'page' => 'funbord',
            )
        );
        $this->load->view('funbord_add',array('message' => $message));
        $this->load->view('footer');   

    }

}
?>