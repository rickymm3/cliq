<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
            parent::__construct();
            $this->load->helper('url');
            $this->load->library('tank_auth');
            $this->load->model('template_model');
            $this->load->model('components_model');
            $this->load->model('logic_model');
	}

	function index()
	{
            if (!$this->tank_auth->is_logged_in()) {
                redirect('/auth/login/');
            } else {
                $data['page']           = "home";
                $data['user_id']	= $this->tank_auth->get_user_id();
                $data['username']	= $this->tank_auth->get_username();
                $page['head']           = $this->template_model->head($data);
                $page['footer']         = $this->template_model->footer($data);
                $page['create_thread']  = $this->components_model->create_thread($data);
                $page['choose_cliq']   = $this->components_model->choose_cliq($data);
                $page['view_threads']   = $this->components_model->view_threads($data);
                $page['search_cliqs']   = $this->components_model->search_cliqs($data);
                $this->load->view('template/all_template' ,$page);
            }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */