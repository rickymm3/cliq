<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
        
        public function head($data)
        {
            return $this->load->view('template/components/head', $data, TRUE);
        }
        
        public function header() {
            
            $page['nav']        = $this->template_header_m->nav();
            $page['more']      	= $this->template_header_m->more();
			$page['logo']		= $this->template_header_m->logo();
            
            if (!$this->tank_auth->is_logged_in()) {
                $page['login']          = $this->template_header_m->loginbutton();
            } else {
                $page['login']      = $this->template_header_m->profile();
            }
            return $this->load->view('header', $page, TRUE);   
        }
        
        public function facebook($data)
        {
            return $this->load->view('template/facebook', $data, TRUE);
        }
        
        public function footer()
        {
            return $this->load->view('template/footer', '', TRUE);
        }
       
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */