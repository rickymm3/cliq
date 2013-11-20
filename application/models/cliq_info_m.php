<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cliq_info_m extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }
	
	public function default_cliqid()
	{
		return 1;
	}
	
	public function what_is_active_cliqid()
	{
		/*Different options
		 * 
		 * 1. There is no cliq id 
		 * 		This means the default cliq is active
		 * 		The cliq id must always be present
		 * 		
		 * 
		*/
		if ($this->does_cliqid_exist())
			return $this->default_cliqid();
		else
			$active = $this->session->userdata('active');
			return $active['cliqid'];
	}
	
	public function does_cliqid_exist()
	{
		if ($this->session->userdata('active'))
			return TRUE;
		else 
			return FALSE;	
	}
    
    public function change_active($cliqid, $cliq=FALSE)
        {
            
            /* 4 options
             *  (cliq/5)            => returns cliqid 5
             *  (cliq/5/sports)     => returns cliqid 5
             *  (cliq/5/baseball)   => returns cliqid 6
             *  (cliq/5/new)        => returns cliqid(parentid) = 5 with newcliq in 'active' session
             */
                $data=array();
                $this->session->unset_userdata('active');
                $this->session->unset_userdata('history');
            if ($cliq === FALSE) { 
                //if url is (cliq/5) with no second parameter
                    $data['active']['newcliq'] = FALSE;
                    $data['active']['cliqid']  = $cliqid;
                    $data['active']['cliq'] = $this->get_cliq($cliqid);
                    $this->session->set_userdata($data);
            } else {
                //here if url looks like (cliq/5/::any) <- any exists for sure!
                $realcliqid = $this->create_m->get_urls_cliqid($cliqid, $cliq);
                if ($realcliqid === FALSE) {
                    $data['active']['newcliq'] = TRUE;
                    $data['active']['cliqid'] = $cliqid;
                    $data['active']['cliq'] = $cliq;
                } else {
                    $data['active']['newcliq'] = FALSE;
                    $data['active']['cliqid']  = $realcliqid;
                    $data['active']['cliq'] = $this->get_cliq($realcliqid);
                }
                $this->session->set_userdata($data);
            }
            $this->change_history();
        }
        
        public function get_cliq($cliqid ='')
        {
            if ($cliqid == '') { 
                $result['cliq'] = false; 
            } else {
                $sql = "SELECT cliq FROM cliq WHERE cliqid = '$cliqid'";
                $query = $this->db->query($sql);
                $result = $query->row_array();
            }
            return $result['cliq'];
        }
        
        public function change_history()
        {
            $active = $this->session->userdata('active');
            $cliqid = $active['cliqid'];
            $parentid = $cliqid;
            if ($cliqid == false) { 
                return false;
            } else {
                $history = array();
                while (!$parentid == 0)
                {
                $sql = "SELECT c.* FROM cliq c
                        WHERE c.cliqid = $parentid";
                $query = $this->db->query($sql);
                $result = $query->row_array();
                $parentid = $result['parentid'];
                $history[] = $result;
                }
                $data['history'] = $history;
                $this->session->set_userdata($data);
                return $history;
            }
            
        }
}