<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends CI_Controller {
  
  function __construct() {
    parent::__construct();
  }

  function block() {
    $this->load->model('event_model');
    $this->event_model->set_block($this->session->userdata('uid'));
  }

}
?>