<?
class Event_Model extends CI_Model {

  function __construct() {
    // Call the Model constructor
    parent::__construct();
  }

  function set_block($uid = 0) {
    if ($uid == 109)
      return;
    $this->db->insert('event', array(
      'member_id' => $uid,
      'type'      => 'block'
    ));
  }
  
  function get_done_event($uid = 0) {
    $events = $this->db->where('member_id', $uid)->from('event')->get()->result();
    $arr = array();
    foreach ($events as $event) {
      array_push($arr, $event->type);
    }
    return $arr;
  }
}
?>