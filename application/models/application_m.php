<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Application_m extends CI_Model
{
    function __construct()
    {
    	parent::__construct();
		$this->load->model('cliq_info_m');
    }
	
	public function assign_cliq_info_to_session($data)
	{
		$this->session->set_userdata($data['cliq_info']);
	}
	
	public function change_active($cliqid, $cliq)
	{
		
		$active_cliqid = $this->cliq_info_m->get_active_cliqid();
		
		if ($cliqid == false || $cliqid == $active_cliqid) {
			return $this->cliq_info_m->default_cliqid();
		} elseif ($cliqid != $active_cliqid) {
			$this->cliq_info_m->change_active($cliqid, $cliq);
			return $this->cliq_info_m->get_active_cliqid();
		}
	}
}