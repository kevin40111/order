<?
 class Log_Model extends CI_Model {

    function __construct() {
      // Call the Model constructor
      parent::__construct();
    }
		
		function log_Write($member_id ,$type ,$log_txt){
			if(!empty($_SERVER["HTTP_CLIENT_IP"]))
			{
			  $source_ip = $_SERVER["HTTP_CLIENT_IP"];
			} elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
					$source_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else {
					$source_ip = $_SERVER["REMOTE_ADDR"];
			}
			$source_ip = ip2long($source_ip);
			
			$data = array(
	   		'member_id' => $member_id ,
	   		'source_ip' => $source_ip ,
	   		'type' => $type ,
	   		'log_txt' => $log_txt
				);
			$this->db->insert('action_log', $data); 
		}
}
?>