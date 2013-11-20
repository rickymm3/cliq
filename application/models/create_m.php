<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Create_m extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->library('tank_auth');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
	}
        
        function create_keyword($cliq, $parentid='error')
        {
            //perform check to see if it already exists
            if ($parentid == 'error') 
            {
                $error = $this->load->view('template/error_content', '', TRUE);
                return $error;
            }
            $sql = "SELECT catid FROM cliq WHERE cliqid = $parentid";
            $result = $this->db->query($sql)->row_array();
            $catid = $result['catid'];
            //add keyword
            $insert = array(    'cliq' => $cliq,
                                'parentid' => $parentid,
                                'count' => 1,
                                'catid' => $catid);
            $this->db->insert('cliq', $insert); 
            return $this->db->insert_id();
        }
        
        public function create_thread($subject, $body, $cliqid)
        {
            $userid =  $this->tank_auth->get_user_id();
            $slug = url_title($subject, 'dash', TRUE);
            $insert = array(    'subject' =>        $subject,
                                'body' =>           $body,
                                'userid' =>         $userid,
                                'lastposterid' =>   $userid,
                                'slug' =>           $slug,
                                'cliqid' =>         $cliqid,
                                );
            $this->db->insert('threads', $insert);
            $threadid = $this->db->insert_id();
            $update = "UPDATE threads SET numreplies = numreplies + 1, replystamp = now() WHERE threadid = $threadid";
            $this->db->query($update);
            //ktbridge_id, threads_id, keywords_id
            if ($this->session->userdata('history')) {
                $history = $this->session->userdata('history');
                foreach ($history as $item)
                {
                    $insert = array(    'threadid' =>     $threadid,
                                        'cliqid' =>    $item['cliqid']         
                                        );
                    $this->db->insert('cliqthread', $insert);
                } 
            }
            return true;
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
                if ($query->row_array())
                {
                    //if it does, return its cliqid for baseball
                    $results = $query->row_array();
                    return $results['cliqid'];
                } else {
                    //check if newcliq is equal to the current id (cliq/5/sports)
                    $cliq = $this->logic_m->get_cliq($cliqid);
                    if(url_title(strtolower($cliq),"-") == url_title(strtolower($newcliq),"-")) {
                        //if it is, return 5
                        return $cliqid;
                    } else {
                        return FALSE;
                    }             
                }
        }

}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */
