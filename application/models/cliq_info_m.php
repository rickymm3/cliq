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

    public function get_active_cliqid()
    {
        /*Different options
         * 
         * 1. There is no cliq id 
         *   This means the default cliq is active
         *   The cliq id must always be present
        */
        if ($this->cliqid_exist()) {
            $cliq_info = $this->session->userdata('cliq_info');
            return $cliq_info['cliqid'];
        }else {
            return $this->default_cliqid();
        }
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
        $this->session->unset_userdata('cliq_info');
        $this->session->unset_userdata('cliq_history');
        if ($cliq === FALSE) {
        	$data = $this->get_cliq_info($cliqid);
			 
            //if url is (cliq/5) with no second parameter
            $data['cliq_info']['newcliq'] = FALSE;
            $data['cliq_info']['cliqid']  = $cliqid;
            $data['cliq_info']['cliq'] = $this->get_cliq($cliqid);
            $this->session->set_userdata($data);
        } else {
            //here if url looks like (cliq/5/::any) <- any exists for sure!
            $realcliqid = $this->get_urls_cliqid($cliqid, $cliq);
            if ($realcliqid === FALSE) {
            	//this is for new cliq
            	$data          	= $this->get_cliq_info($cliqid);
				
                $data['cliq_info']['newcliq'] 	= TRUE;
                $data['cliq_info']['cliqid'] 	= $cliqid;
                $data['cliq_info']['cliq'] 		= $cliq;
            } else {
            	//this is for cliq that where the cliqid is not the same as teh written cliqs
            	$data          	= $this->get_cliq_info($cliqid);
				
                $data['cliq_info']['newcliq'] 	= FALSE;
                $data['cliq_info']['cliqid']  	= $realcliqid;
                $data['cliq_info']['cliq'] 		= $this->get_cliq($realcliqid);
            }
            $this->session->set_userdata($data);
        }
    }

        public function get_urls_cliqid($cliqid, $newcliq)
        {
            //only here IF --
            
            /* 3 options
             *  (cliq/5/sports)     => returns cliqid 5
             *  (cliq/5/baseball)   => returns cliqid 6
             *  (cliq/5/new)        => returns cliqid(parentid) = 5 with newcliq in 'active' session
             */
            
                //check if newcliq exists under parentid (cliq/5/baseball)
	        $sql = "select c.cliq, c.cliqid from cliq c where c.parentid = '$cliqid' AND c.cliq = '$newcliq'";
	        $query = $this->db->query($sql);
			$result = $query->row_array();
	        if ($result)
	        {
	            //if it does, return its cliqid for baseball
	            return $result['cliqid'];
	        } else {
	            //check if newcliq is equal to the current id (cliq/5/sports)
	            $cliq = $this->get_cliq($cliqid);
	            if(url_title(strtolower($cliq),"-") == url_title(strtolower($newcliq),"-")) {
	                //if it is, return 5
	                return $cliqid;
	            } else {
	                return FALSE;
	            }             
	        }
        }

    public function cliqid_exist()
    {
    	$cliq_info = $this->session->userdata('cliq_info');
		$cliqid = $cliq_info['cliqid'];
		if ($cliqid) 
		{
			$sql = "SELECT * from cliq where cliqid = $cliqid";
			$query = $this->db->query($sql);
		    if ($query->row_array())
		    	return TRUE;
		    else 
		    	return FALSE;
        }	
    }
    
    public function get_cliq_info()
    {
    	$cliqid = $this->get_active_cliqid();
		if ($this->cliqid_exist($cliqid))
		{		
        	$data['cliq_history'] = $this->get_history($cliqid);
        	$data['cliq_info']      = $this->get_info($cliqid);
		} else {
			$data['cliq_info'] = false;
		}
        #get cliq info (cat included)
        #get history
        return $data;
    }
    
    public function get_info($cliqid) {
        $sql = "SELECT * from cliq where `cliqid` = $cliqid";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
     public function get_history($cliqid)
        {
            $parentid = $cliqid;
            if ($cliqid == false) {
                return false;
            } else {
                $history = array();
                while (!$parentid == 0)
                {
                    $select = "SELECT c.* FROM cliq c";
                    $where =  " WHERE c.cliqid = '$parentid'";
                    $query = $this->db->query($select.$where);
                    $result = $query->row_array();
                    $parentid = $result['parentid'];
                    $history[] = $result;
                }
                return $history;
            }
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
            $active = $this->session->userdata('cliq_info');
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
                $data['cliq_history'] = $history;
                $this->session->set_userdata($data);
                return $history;
            }
            
        }
}