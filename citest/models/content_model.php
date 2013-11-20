<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content_model extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->model('visit_model');
	}
        
        function visit()
        {
            $data['visit'] = $this->visit_model->getvisitlist();
            $page['form']           = $this->load->view('content/visit/form','', TRUE);
            $page['visitlist']      = $this->load->view('content/visit/visitlist', $data, TRUE);
            return                  $this->load->view('content/visit',$page,TRUE);
        }

        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */


