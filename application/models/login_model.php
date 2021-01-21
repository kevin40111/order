<?
class Login_Model extends CI_Model
{

    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    public function account_check($user, $pwd)
    {

        $sql = "SELECT * FROM member WHERE username = ? AND password = ?";
        $query = $this->db->query($sql, array($user, $pwd));

        if ($row = $query->result()) {
            $newdata = array(
                'uid' => $row[0]->id,
                'nickname' => $row[0]->nickname,
                'name' => $row[0]->name,
                'dep_id' => $row[0]->dep_id,
                'address' => $row[0]->address,
                'phone' => substr($row[0]->phone, 0, 4) . '-' . substr($row[0]->phone, 4, 3) . '-' . substr($row[0]->phone, 7, 3),
            );

            $register_check = "SELECT member_id FROM register_check WHERE member_id = ?";
            $register_check = $this->db->query($register_check, array($newdata['uid']));
            if ($register_check->result()) {
                return ['errorMessage' => "帳號尚未開通"];
            }

            return $newdata;
        } else {
            return ['errorMessage' => "帳號/密碼錯誤"];
        }
    }
}
