<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nav_m extends CI_Model
{

        function __construct()
        {
                parent::__construct();
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