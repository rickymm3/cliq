<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile_m extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->library('tank_auth');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
	}
        
        public function profilenav($username, $owned)
        {
            $data['username'] = $username;
            $data['owned'] = $owned;
            return $this->load->view('profile/profilenav', $data, TRUE);
        }
        
        public function profileform($username, $owned)
        {
            $data['owned'] = $owned;
            $data['username'] = $username;
            return $this->load->view('profile/profileform', $data, TRUE);
        }
        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
