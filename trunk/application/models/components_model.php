<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Components_model extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->model('logic_model');
	}
        
        public function create_thread($data)
        {
            return $this->load->view('components/create_thread', $data, TRUE);
        }
        
        public function choose_cliq($data)
        {
            #Display currently selected Cliq, and gives ability to change thorugh popup div
            return $this->load->view('components/choose_cliq', $data, TRUE);
        }
        
        public function view_threads($data)
        {
            $data['active_cliqs'] = $this->logic_model->get_active_cliqs();
            return $this->load->view('components/view_threads', $data, TRUE);
        }
        
        public function search_cliqs($data)
        {
            return $this->load->view('components/search_cliqs', $data, TRUE);
        }

}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */