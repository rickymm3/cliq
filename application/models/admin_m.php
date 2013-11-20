<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_m extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->library('tank_auth');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
	}
        
        public function change_delete($threadid)
        {
            $sql = "SELECT deleted from threads WHERE threadid = $threadid";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            $switch = 1;
            if ($result['deleted'] == 1) {
                $switch = 0;
            }
            $sql = "UPDATE threads set deleted = $switch WHERE threadid = $threadid";
            $this->db->query($sql);
            return true;
        }
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */