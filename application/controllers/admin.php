<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->library('facebook');
            $this->load->library('session');
            $this->load->library('tank_auth');
            $this->load->helper('url');
            
            $this->load->model('page_m');
            $this->load->model('user_model');
            $this->load->model('templates/template_m');
            $this->load->model('templates/template_header_m');
			$this->load->model('header/nav_m');
			$this->load->model('cliq_info_m');
			
            $this->load->model('threadlist_m');
            $this->load->model('components_m');
            $this->load->model('header_m');
            $this->load->model('facebook_m');
            $this->load->model('logic_m');
            $this->load->model('slideout_m');
            $this->load->model('cliqbar_m');
            $this->load->model('newthread_m');
            $this->load->model('search_m');
            $this->load->model('create_m');
            $this->load->model('threads_m');
            $this->load->model('admin_m');
	}
        
                        /* AJAX METHODS */
        
        public function change_delete()
        {
            if ($this->logic_m->isadmin()) {
                $threadid = $this->input->post('threadid');
                $this->admin_m->change_delete($threadid);
                $active = $this->session->userdata('active');
                if ($active) {
                    $cliq = $active['cliq'];
                    $cliqid = $active['cliqid'];
                } else {
                    $cliq = '';
                    $cliqid = false;
                }
                $result['content'] = $this->components_m->threadlist($cliqid, $cliq);
            } else {
                $result['error'] = 'failed';
            }
             echo json_encode($result);
        }
        
}