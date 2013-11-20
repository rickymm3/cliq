<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    	function __construct()
	{
            parent::__construct();
            $this->load->database();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->helper('url');
            
            $this->load->model('content_model');
            $this->load->model('dataset_model');
	}
        
        public function buildvisit()
        {   
            //get all pages
            $page['select_visit'] = $this->content_model->visit();
            $page['head'] = $this->load->view('template/head','',TRUE);
            $page['header'] = $this->load->view('template/header','',TRUE);
            $this->load->view('template', $page);
        }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */