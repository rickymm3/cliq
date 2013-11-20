<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Page_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('cliq_info_m');
    }
    
    function load_session($default_cliq)
    {
        //check if session is new
        if ($this->session->userdata('exists') !== FALSE) {
            return false;
        } else {
             //the list of things to do
            $this->record_session();   //check if ip exists in DB, if not, record     
            $this->cliq_info_m->change_active($default_cliq);
            
            //make session old
            $data['exists'] = true;
            $this->session->set_userdata($data); 
        }
    }
    
    function record_session()
    {
            $ip = $this->input->ip_address();
            $sql = "SELECT * from hits where ip = '$ip'";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            if (!$result)
            {
                // Never visited - add
                $this->db->insert('hits', array('ip' => $ip) );
            }       
    }
    
 
    
}