<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Threadlist_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
        
        public function get_threadlist($cliqid = '', $limit = 0, $filter='')
        {
      
            $max = $limit + 20;
            $limit = 0;
            if ($cliqid == '') {
                $sql_where = " WHERE ct.cliqid LIKE '%'";
            } else {
                $sql_where = " WHERE ct.cliqid =  '$cliqid'";
            }
            
            $sql_select = "SELECT DISTINCT t.*, u.username, us.username AS lastposter, up.avatar_loc, c.*, cat.catabbr";
            $sql_from = " FROM cliqthread AS ct";
            $sql_ij = " INNER JOIN threads t ON t.threadid = ct.threadid
                    INNER JOIN users u ON u.id = t.userid
                    INNER JOIN users us ON us.id = t.lastposterid
                    INNER JOIN user_profiles up ON up.id = u.id
                    INNER JOIN cliqthread last ON last.cliqid = t.cliqid
                    INNER JOIN cliq c ON c.cliqid = last.cliqid
                    INNER JOIN cat ON cat.catid = c.catid";
            $sql_order = " ORDER BY t.replystamp DESC ";
            $sql_limit = " LIMIT $limit , $max";
            
            $sql = $sql_select.$sql_from.$sql_ij.$sql_where.$sql_order.$sql_limit;
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        
        function get_active()
        {
            if (!$this->session->userdata('active')) {
                $active = 'reset';
                return $active;
            } else {
                $active = $this->session->userdata('active');
                return ($active['cliqid']); 
            }
        }
        
        function get_thread_info($thread_id)
        {
            $sql = "SELECT * FROM threads WHERE threads_id = $thread_id";
            $query = $this->db->query($sql);
            return $query->row_array();
        }
        
        public function build_rows($cliqid, $limit)
        {
            if ($this->session->userdata('isadmin')==true) {
                //confirm user is admin
                $check = $this->logic_m->isadmin();
            } else { $check = false; }
            $threadList = $this->get_threadlist($cliqid, $limit);
            $html = '';
            $rowcolor = true;
            foreach ($threadList as $item)
            {
                if ($check == true) {
                    $item['isadmin'] = true;
                } else { $item['isadmin'] = false; }
                if ($item['deleted'] == 0 || $check==true) {
                    if (strlen($item['body']) >= 120) {
                        $string = substr($item['body'], 0, 120). "...";
                        $item['bodysum'] = strip_slashes(strip_tags(str_replace("\\n", "", $string)));
                    }
                    else {
                         $item['bodysum'] = strip_slashes(strip_tags(str_replace("\\n", "", $item['body'])));
                    }
                    $item['subject'] = strip_slashes(strip_tags(str_replace("\\n", "",  $item['subject'])));
                    (($rowcolor = !$rowcolor)?$item['rowcolor']='odd':$item['rowcolor']='');
                    $item['cliqlink'] = $this->template_model->cliqlink($item['cliqid'], $item['cliq']);
                    $html .= $this->load->view('threadlist/table_row', $item, TRUE);
                    }
            }
            return $html;
        }
        
      
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */