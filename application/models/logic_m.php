<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logic_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
        
   	public function change_active($cliqid, $cliq=FALSE)
    {
        
        /* 4 options
         *  (cliq/5)            => returns cliqid 5
         *  (cliq/5/sports)     => returns cliqid 5
         *  (cliq/5/baseball)   => returns cliqid 6
         *  (cliq/5/new)        => returns cliqid(parentid) = 5 with newcliq in 'active' session
         */
         
         /*
		  * 1. Check if the second segment is null
		  * 	a. send cliqid to active cliqid
		  * 	b. go to 2
		  * 2. Check if second segment exists in DB
		  * 	a. if exists - return cliqid
		  * 	b. if not exists - create temporary
		  * 3. Create CliqID in Session
		  * 
		  * */
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
        
        public function isfav($cliqid)
        {
                $userid = $this->tank_auth->get_user_id();
                $sql = "SELECT * FROM favorites WHERE userid = '$userid' AND cliqid='$cliqid' AND active = '1'";
                $query = $this->db->query($sql);
                $result = $query->row_array();
                if ($result) { $fav = true; } else { $fav = false;}
                return $fav;
        }
        
        public function isusername($username)
        {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            if ($result) 
            {
                return true;
            } else {
                return false;
            }
        }
        
        public function changefav($cliqid, $isfaved)
        {
            $userid = $this->tank_auth->get_user_id();
            if ($isfaved == 'true')
            {
                $sql = "UPDATE favorites SET active = 0 WHERE cliqid = $cliqid and userid = $userid";
                $this->db->query($sql);
            } else {
                $sql = "SELECT * FROM favorites WHERE cliqid = $cliqid AND userid = $userid";
                $query = $this->db->query($sql);
                $result = $query->row_array();
                if ($result) 
                {
                    $sql = "UPDATE favorites SET active=1 WHERE cliqid = $cliqid AND userid=$userid";
                } else {
                    $count = "SELECT COUNT(*) AS total FROM favorites WHERE userid = $userid";
                    $query = $this->db->query($count);
                    $total = $query->row_array();
                    $position = $total['total'] + 1;
                    $sql = "INSERT INTO favorites (userid, cliqid, position) 
                            VALUES ($userid, $cliqid, $position)";
                }
                $this->db->query($sql);
            }
        }
        
        public function isnew()
        {
            $active = $this->session->userdata('active');
            
            if ($active['newcliq'])
            {
                return true;
            } else {
                return false;
            }
        }
        
        public function get_active_cliqid()
        {
            if ($this->is_active_cliq())
            {
                $active = $this->session->userdata('active');
                $cliqid = $active['cliq_id'];
            } else {
                $cliqid = false;
            }
            return $cliqid;
        }
        
        public function get_cliq_all($cliqid = '')
        {
            if ($cliqid == '') { $cliqid = '%'; }
            $sql = "SELECT * FROM cliq WHERE cliqid = '$cliqid'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            return $result;
        }
        
        public function get_categories()
        {
            $sql = "SELECT * FROM cat";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
                
        public function get_catabbr($cliqid = '')
        {
            if ($cliqid == '') { $cliqid = '%'; }
            $sql = "SELECT cat.catabbr 
                    FROM `cliq` c
                    INNER JOIN cat
                    ON cat.catid = c.catid
                    WHERE c.cliqid = '$cliqid'";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            if (!$result) {
                $result['catabbr'] = 'all';
            }
            return $result['catabbr'];
        }

        public function checkcliqidexist($cliqid)
        {
            $sql = "select cliqid from cliq where cliqid = '$cliqid'";
            $query = $this->db->query($sql);
            if ($query->row_array())
            {
                return true;
            } else {
                return false;
            }
        }
        

        
        public function get_cliqid_w_threadid($threadid)
        {
            $sql = "SELECT cliqid FROM threads WHERE threadid = $threadid";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            return $result['cliqid'];
        }
        
        public function cliqidcheck($cliqid)
        {
            return (ctype_digit($cliqid)) AND ($this->checkcliqidexist($cliqid));
        }
        
        public function get_subject($threadid)
        {
            $sql = "SELECT subject from threads where threadid = $threadid";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            return $result['subject'];
        }
        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */