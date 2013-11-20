<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
        
        public function head($data)
        {
            return $this->load->view('template/head', $data, TRUE);
        }
        
        public function footer($data)
        {
            return $this->load->view('template/footer', $data, TRUE);
        }

}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */