<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Facebook_m extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('url');
            $this->load->library('tank_auth');
            $this->load->library('facebook');
	}
        
        public function fb_load()
        {
            $user = $this->facebook->getUser();
                if ($user) {
                    try {
                        $data['user_profile'] = $this->facebook->api('/me');
                        $data['user_profile']['at'] = $this->facebook->getAccessToken();
                    } catch (FacebookApiException $e) {
                        $user = null;
                    }
                }

                if ($user) {
                    $data['logout_url'] = $this->facebook->getLogoutUrl();
                } else {
                    $data['login_url'] = $this->facebook->getLoginUrl();
                }
                return $data;
                //$this->load->view('fbtest',$data);
        }
        public function checkfbuser($userid)
        {
            $sql = "SELECT facebook FROM users WHERE id=$userid";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            if ($result['facebook'] == 0) 
            {
                return false;
            } else {
                return $result['facebook'];
            }
        }
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */