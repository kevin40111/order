<?if ( ! defined('BASEPATH')) exit('No direct script access allowed');

###################################
#				Author: Chai Yu Pai				#
###################################

class Shop extends CI_Controller {


        private $menu_html ="";


	
	function __construct() {
        # Call the Model constructor
        parent::__construct();
		if($this->session->userdata('uid') == "") {
				header("Location: /login");
				exit();
		};
    }
    
    function index() {
        $this->manage();
    }
	
    // Add Shop UI Page
	function add() {
		# Auth Check
		if ($this->session->userdata('dep_id') != 1) {
			header("Location: /order");
			exit();
		}
		
		$this->load->model('shop_model');
		
		# Customerize Type
		$types = $this->shop_model->get_customerize_types();
		
		$this->load->view('header', array(
			'page' => 'manage'
		));
		$this->load->view('shop_new', array(
			'types' => $types ,
            
		));
		$this->load->view('footer');
	}
    
    // Get Ajax Add Request
    function add_shop() {
        # Auth Check
		if ($this->session->userdata('dep_id') != 1) {
			header("Location: /order");
			exit();
		}
        
        $this->load->model('shop_model');
        
        $shopID = $this->shop_model->add_shop($_POST['name'], $_POST['phone'], $_POST['remark']);
                
        if ($shopID) {
            $count = count($_POST['item']);
            for ($i = 0; $i < $count; $i++) {
                $this->shop_model->add_item($shopID, $_POST['item'][$i], $_POST['price'][$i], $_POST['customerize1'][$i], $_POST['customerize2'][$i]);
            }
            echo json_encode(array(
                'status'    => 'success'
            ));
        } else {
            echo json_encode(array(
                'status'    => 'shop_fail'
            ));
        }
    }
    
    // Ajax Add Item Request
    function add_item() {
        # Auth Check
		if ($this->session->userdata('dep_id') != 1) {
			echo json_encode(array('status' => 'Unaccess token.'));
            exit();
		}
        
        $this->load->model('shop_model');
        
        $itemID = $this->shop_model->add_item($_POST['shopID'], $_POST['name'], $_POST['price'], $_POST['customerize1'], $_POST['customerize2']);
        echo json_encode(array(
            'status'    => 'success',
            'itemID'    => $itemID
        ));
    }
    
    // Ajax Edit Item Request
    function edit_item() {
        # Auth Check
		if ($this->session->userdata('dep_id') != 1) {
			echo json_encode(array('status' => 'Unaccess token.'));
            exit();
		}
        
        $this->load->model('shop_model');
        
        $affectedRows = $this->shop_model->edit_item($_POST['itemID'], $_POST['name'], $_POST['price'], $_POST['customerize1'], $_POST['customerize2']);
        echo json_encode(array(
            'status'    => 'success'
        ));
    }
    
    function del_item($itemID = -1) {
        if ($itemID == -1) {
            echo json_encode(array(
                'status'    => 'failed'
            ));
            return;
        }
        
        $this->load->model('shop_model');
        
        $affectedRows = $this->shop_model->delete_item($itemID);
        
        echo json_encode(array(
            'status'    => 'success'
        ));
    }

	//function delete($shopID = -1){

	//}
    
    function edit($shopID = -1) {
        # Auth Check
		if ($this->session->userdata('dep_id') != 1) {
			header("Location: /order");
			exit();
		}
        
        $this->load->model('shop_model');
        
        $profile = $this->shop_model->profile($shopID);
                                              
        if (count($profile)) {
            $list = $this->shop_model->item_list($shopID);
            $customerizes = $this->shop_model->customerize_list();
            
            # Render View
            $this->load->view('header', array(
                'page' => 'manage'
            ));
            $this->load->view('shop_edit_item',array(
                'shopID' => $shopID,
                'list' => $list,
                'customerizes' => $customerizes
            ));
            $this->load->view('footer');
        } else {
            header("Location: /shop/add");
            exit();
        }
    }
	
	function manage() {
		# Auth Check
		if ($this->session->userdata('dep_id') != 1) {
			header("Location: /order");
			exit();
		}
		
		$this->load->model('shop_model');
		
		# 店家列表
		$list = $this->shop_model->get_list();
		
		$this->load->view('header', array(
			'page' => 'manage'
		));
 
        $this->load->view('data_manage_choice');

		$this->load->view('shop_manage',array(
			'list' => $list
		));
		$this->load->view('footer');
	}
    
    function edit_profile() {
        # Auth Check
		if ($this->session->userdata('dep_id') != 1) {
			header("Location: /order");
			exit();
		}
        
        $this->load->model('shop_model');
        
        return $this->shop_model->edit_profile($_POST['id'], $_POST['name'], $_POST['phone'], $_POST['remark']);
    }
}
?>