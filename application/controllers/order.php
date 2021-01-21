<?
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {
	
	public function index() {
		if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
        
        $this->load->model('shop_model');
        $this->load->model('order_model');
        
        $list = $this->order_model->get_list();
        $shops = $this->shop_model->get_list();
        
        // View Render
		$this->load->view('header', array(
			'page' => 'order'
		));
        
		$this->load->view('order_main_old', array(
            'shops'     => $shops,
            'orders'    => $list
        ));
        
		$this->load->view('footer');
	}
    
    function del($orderID = -1) {
        # Auth Check
        if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
        
        $this->load->model('order_model');
        
        $this->order_model->del($orderID);
        echo json_encode(array(
            'status'    => 'success'
        ));
    }
    
    function menu($orderID = -1) {
        if ($orderID == -1) {
          header('Location: /order');
          exit();
        }
        
        $this->load->model('order_model');
        if (!$this->order_model->is_expired($orderID)){
          header('Location: /order');
          exit();
        }
        
        $shops = $this->order_model->get_list_by_order($orderID);
        $customerize = $this->order_model->get_customerize();
        $order = $this->order_model->get_order_item($orderID);
        $myOrder = $this->order_model->get_my_order($orderID);
        
        // View Render
		$this->load->view('header', array(
			'page' => 'order'
		));
        
		$this->load->view('order_menu', array(
            'shops'         => $shops,
            'customerize'   => $customerize,
            'order'         => $order,
            'orderID'       => $orderID,
            'myOrder'       => $myOrder
        ));
        
		$this->load->view('footer');
    }
    
    function statistic($orderID = -1) {
        # Auth Check
        if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
        
        $this->load->model('order_model');
        $this->load->model('shop_model');
        
        $orders = $this->order_model->get_all_order($orderID);
        $shops = $this->shop_model->get_list();

		// $member_orders = $this->order_model->get_all_order_ordered_by_member($orderID);
        
        // View Render
		$this->load->view('header', array(
			'page' => 'order'
		));
        
		$this->load->view('order_stat', array(
            'orders'    => $orders,
            'shops'     => $shops,
			// 'members'	=> $member_orders 
        ));
        
		$this->load->view('footer');
    }
    
    function add() {
        # Auth Check
        if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
        
        $this->load->model('order_model');
        
        $this->order_model->add($this->session->userdata('uid'), $_POST['shopID'], $_POST['expire']);
        echo json_encode(array(
            'status'    => 'success'
        ));
    }

    function update_expire(){
         if ($this->session->userdata('uid') == "" ) {
            header("Location: /login");
            exit();
        }
         $this->load->model('order_model');
         $this->order_model->update_expire($_POST['id'],$_POST['expire']);

         echo json_encode(array(
            'status'    => 'success'
        ));
    }
    
    function del_item_order($orderItemID = -1) {
        # Auth Check
        if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
        
        if ($orderItemID == -1) {
            return false;
        }
        
        $this->load->model('order_model');
        $this->order_model->del_item_order($orderItemID);
        echo json_encode(array(
            'status'    => 'success'
        ));
    }
    
    function add_item_order() {
        # Auth Check
        if ($this->session->userdata('uid') == "" ) {
			header("Location: /login");
			exit();
		}
        
        $this->load->model('order_model');
        $insertID = $this->order_model->add_item_order($_POST['orderID'], $_POST['itemID'], $_POST['count'], $_POST['type_one'], $_POST['type_two']);
        
        echo json_encode(array(
            'status'    => 'success',
            'insertID'  => $insertID
        ));
    }
}
?>