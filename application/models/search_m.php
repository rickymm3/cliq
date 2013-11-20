<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search_m extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('url');
            $this->load->library('tank_auth');
            $this->load->library('session');
	}
        
        public function find_cliq($cliqid, $cliq)
        {
            //1. Default Cliq Loaded (active_cliq == false)
            //  - display search related to all cliqs
            //2. Cliq active    (active_cliq == true)
            //  - display search related to active cliq
            //  - display search related to all cliqs
            if (!$cliqid == '') { 
                $active_cliq_id = $cliqid;
                $sql = "SELECT DISTINCT * 
                        FROM cliq c
                        WHERE c.cliq
                        LIKE '$cliq%' AND c.parentid = $active_cliq_id
                        ORDER BY count DESC
                        LIMIT 0, 10";
                $query = $this->db->query($sql);
                $data['related'] = $query->result_array();
            } else {
                $data['related'] = false;
            }
            
            //get results based on no active keyword
            $sql = "SELECT DISTINCT * 
                    FROM cliq c
                    WHERE c.cliq 
                    LIKE '$cliq%'
                    ORDER BY count DESC
                    LIMIT 0 , 10";
            $query = $this->db->query($sql);
            $data['default'] = $query->result_array();
            return $data;
            //display BOTH sets
        }
        
        public function buildresults_related($data)
        {
            $html = '';
            if ($data['related']) { 
                foreach ($data['related'] as $item)
                {
                    $item['cliqlink'] = $this->template_model->cliqlink($item['cliqid'], $item['cliq']);
                    $html .= $this->load->view('search/search_result', $item, TRUE);
                }
                $data['related_results'] = $html;
            } else {
                $data['related_results'] = "No Related Reults";
            }
            return $data['related_results'];
        }
        
        public function buildresults_default($data)
        {
            $html = '';
            if ($data['default']) {
                foreach ($data['default'] as $item)
                {
                    $item['cliqlink'] = $this->template_model->cliqlink($item['cliqid'], $item['cliq']);
                    $html .= $this->load->view('search/search_result', $item, TRUE);
                }
                $data['default_results'] = $html;
            } else {
                $data['default_results'] = "No Related Reults";
            }
            return $data['default_results'];
        }
        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */