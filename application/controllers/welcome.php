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
			$this->load->model('header/nav_m');
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
	
        function index() {
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
            $data['page']                   = "Welcome to Cliq!";
            $data['cliqid']                   = $this->cliq_info_m->what_is_active_cliqid();
            $data['cliqinfo']                = $this->cliq_info_m->get_cliq_info($data['cliqid']);
            //build components
            $page['content']               = $this->load->view('testpage', $data, TRUE);
            $page['head']                   = $this->load->view('template/components/head', $data, TRUE);
            $page['header']                = $this->template_m->header();
			
            $this->load->view('template/template', $page);
        }

}