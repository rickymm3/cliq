<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cliqbar_m extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->library('tank_auth');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
	}
        
        public function active ($cliqid) {
            
            $active = $this->session->userdata('active');
            $cliq = $active['cliq'];
            
            if (!$cliqid == '')
            {
                $page['cliqlink'] = $this->template_model->cliqlink($cliqid, $cliq);
            } else {
                $page['cliqlink'] = "<span class='default'><i class='icon-smile' style='font-size: 24px'></i></span>";
            }
            return $this->load->view('cliqbar/active', $page, TRUE);
        }
        
        public function search($cliqid)
        {
            if ($cliqid == '') {
                $data['cliqid'] = 'all';
            } else {
                $data['cliqid'] = $cliqid;
            }
            return $this->load->view('cliqbar/search', $data, TRUE);
        }
        
        public function filters($cliqid)
        {
            $data['cliqid'] = $cliqid;
            return $this->load->view('cliqbar/filters', $data, TRUE);
        }
        
        public function newthread($cliqid, $newcliq)
        {
            $data['cliqid'] = $cliqid;
            $data['newcliq'] = $newcliq;
            return $this->load->view('cliqbar/newthread', $data, TRUE);
        }
        
        public function reply($threadid)
        {
            $data['threadid'] = $threadid;
            return $this->load->view('cliqbar/reply', $data, TRUE);
        }
        
        public function thread_title($slug)
        {
            return "<div class='verticalalign2'><div class='thread_title'><a href='' class='subjectjump'> ".ucwords(str_replace('-', ' ', $slug))."</a></div></div>";
        }

}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */