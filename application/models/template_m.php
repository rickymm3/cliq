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
            $page['nav']        = $this->header_m->nav();
			$page['logo']		= $this->header_m->logo();
            
            if (!$this->tank_auth->is_logged_in()) {
                $page['login']          = $this->header_m->loginbutton();
            } else {
                $page['login']      = $this->header_m->profile();
            }
            return $this->load->view('header', $page, TRUE);   
        }
		
		public function infobar() {
			$page['selectedinfo']	=$this->infobar_m->selectedinfo();
			return $this->load->view('infobar', $page, TRUE);
		}
        
		public function thread_list()
		{
			
		}
		
		public function profile_page()
		{
			
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