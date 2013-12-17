<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Infobar_m extends CI_Model
{

	function __construct()
		{
		    parent::__construct();
		    $this->load->library('tank_auth');
		    $this->load->helper(array('form', 'url'));
		    $this->load->library('form_validation');
		}

	public function selectedinfo()
	{
		$data = $this->session->all_userdata();
		$page['thecliq']	= $this->load->view('shared/a_cliq', $data, TRUE);
		return $this->load->view('infobar/selectedinfo', $page, TRUE);
	}
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */