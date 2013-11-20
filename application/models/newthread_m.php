<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Newthread_m extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->library('tank_auth');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
	}

        public function textarea($data)
        {
            return $this->load->view('newthread/textarea',$data,TRUE);
        }
        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */