<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Threads_m extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->library('tank_auth');
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
	}

        public function get_threads($threadid)
        {
            $sql = "SELECT t.*, u.username, up.avatar_loc from threads t
                INNER JOIN users u
                on u.id = t.userid
                INNER JOIN user_profiles up
                on u.id = up.id
                where threadid = $threadid";
            $result = $this->db->query($sql)->row_array();
            $update = "UPDATE threads SET numviews = numviews + 1 WHERE threadid = $threadid";
            $this->db->query($update);
            return $result;
        }
        public function create_replies($data)
        {
            $html = '';
            $html .= $this->load->view('thread/reply_template', $data['op'], TRUE);
            foreach ($data['replies'] as $reply) 
            {
                $html .= $this->load->view('thread/reply_template', $reply, TRUE);
            }
            $data['html'] = $html;
            return $this->load->view('thread/replies',$data, TRUE);
           
        }
        
        public function getthreadcliqid($threadid)
        {
            $sql = "SELECT cliqid from threads where threadid = $threadid";
            return $this->db->query($sql)->row_array();
        }
        
        public function replyTo($data)
        {
            $data['replyTo'] = $this->load->view('thread/replyTo', $data, TRUE);
            return $this->load->view('thread/replyTo_template', $data, TRUE);
        }
        
        public function addreply($threadid, $body, $postnum=1)
        {
            $update = "UPDATE threads SET numreplies = numreplies + 1, replystamp = now() WHERE threadid = $threadid";
            $this->db->query($update);
            $sql = "SELECT  COUNT(*) AS `total`
                    FROM    reply
                    where threadid = $threadid";
            $count = $this->db->query($sql)->row_array();
            $total = $count['total'] + 2;
            //add reply specifically to threadid
            $insert = array(    'threadid' => $threadid,
                                'usersid' => $this->tank_auth->get_user_id(),
                                'body' => $body,
                                'postnum' => $total);
            $this->db->insert('reply', $insert); 
            return $this->db->insert_id();
        }
        
        public function replies($threadid)
        {
            $sql = "SELECT r.*, u.username, up.avatar_loc 
                from reply r
                INNER JOIN users u
                on u.id = r.usersid
                INNER JOIN user_profiles up
                on u.id = up.id
                where threadid = $threadid";
            return $this->db->query($sql)->result_array();
        }
       
        public function get_reply($replyid)
        {
            $sql = "SELECT r.*, u.username, up.avatar_loc 
                from reply r
                INNER JOIN users u
                on u.id = r.usersid
                INNER JOIN user_profiles up
                on u.id = up.id
                where replyid = $replyid";
            return $this->db->query($sql)->row_array();
        }
        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */