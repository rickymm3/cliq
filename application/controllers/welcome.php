<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
        function __construct()
        {
            parent::__construct();

            //$this->output->enable_profiler(TRUE);
            
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->library('session');
             //necessary models
            $this->load->model('page_m');
            $this->load->model('user_model');
            $this->load->model('templates/template_m');
			$this->load->model('templates/template_header_m');
			//used in header
			$this->load->model('nav_m');
            //everymodel below:
            $this->load->model('threadlist_m');
            $this->load->model('components_m');
            $this->load->model('header_m');
            $this->load->model('facebook_m');
            $this->load->model('slideout_m');
            $this->load->model('cliqbar_m');
            $this->load->model('newthread_m');
            $this->load->model('search_m');
            $this->load->model('create_m');
            $this->load->model('threads_m');
            $this->load->model('profile_m');
            /*loaded in other models*/
            $this->load->model('cliq_info_m');
            $this->load->model('angular_m');
        }
        
		function testcliqid()
		{
			print_r($this->session->userdata('active'));
		}

	public function does_cliqid_exist()
	{
		if ($this->session->userdata('active')) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
		
        function index()
		{
            //$this->session->sess_destroy();
            $page['session'] = $this->session->all_userdata();
									
			/*
			 * Necessary info needed for each return -
			 * CliqID
			 * History (Between both)
			 * Parent (Stored with Keyword)
			 * Category (stored with Keyword)
			 * 
			 */
			 
			
            //populate page data
            $data['page']                   = "Welcome to Cliq!";
			$data['cliqid']					= $cliqid;
			
            //build components
            $page['content'] 				= '';
            $page['head']                   = $this->load->view('template/components/head', $data, TRUE);
            $page['cliqid']					= $this->cliq_info_m->what_is_active_cliqid();
            $page['header']                 = $this->template_m->header();
			
            $this->load->view('template/template', $page);
        }

}