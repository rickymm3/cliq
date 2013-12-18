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
            $this->load->model('user_model');
            $this->load->model('template_m');
            $this->load->model('templates/header_m');
			$this->load->model('templates/infobar_m');
			$this->load->model('header/nav_m');
			$this->load->model('cliq_info_m');
			$this->load->model('application_m');
			$this->load->model('post_m');
            //everymodel below:
   
            $this->load->model('facebook_m');
 
            /*loaded in other models*/
        }
	
        function index($cliqid = false, $cliq = false) {
            //$this->session->sess_destroy();
            /*setup page
             * set users default cliq 
             * if no user, then return default cliq (1)
             */
            /*
             * Necessary info needed for each return -
             * CliqID
             * History (Between both)
             * Parent (Stored with Keyword)
             * Category (stored with Keyword)
             * 
             */
            //populate page data
			$data['cliqid'] = 				$this->application_m->change_active($cliqid, $cliq);
            $data['page']                   = "Welcome to Cliq!";
						//set session data
			
			$data['session']				= $this->session->all_userdata();
            //build components
            $data['posts'] 					= $this->post_m->get_posts();
			
            $page['content']              	= $this->load->view('testpage', $data, TRUE);
            $page['head']                   = $this->load->view('template/components/head', $data, TRUE);
            $page['header']                	= $this->template_m->header();
			$page['infobar']				= $this->template_m->infobar();
			
			$this->load->view('template/template', $page);
        }

		function cliq($cliqid = false, $cliq = false) {
			
			
			$data['cliqid'] = 				$this->application_m->change_active($cliqid, $cliq);
            $data['page']                   = "Welcome to Cliq!";
            $data['cliq_info']              = $this->cliq_info_m->get_cliq_info();
						//set session data
			
			$data['session']				= $this->session->all_userdata();
			$data['posts'] 					= $this->post_m->get_posts();
            //build components
            $page['content']              	= $this->load->view('testpage', $data, TRUE);
            $page['head']                   = $this->load->view('template/components/head', $data, TRUE);
            $page['header']                	= $this->template_m->header();
			$page['infobar']				= $this->template_m->infobar();
			
			$this->load->view('template/template', $page);
		}

}