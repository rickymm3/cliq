<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Components_m extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
        
        public function history($cliqid)
        {
            $history = $this->header_m->get_history($cliqid);
            if (!$history) { 
                $data['history'] = '';
            } else {
                $data['history'] = $history;
            }
            if ($this->tank_auth->is_logged_in())
            {
            $data['starfavorite'] = $this->starfavorite($cliqid);
            } else {
                $data['starfavorite'] = 'Log in to ';
            }
            //get_cliqinfo returns array['total'] right now into $cliqinfo
            $cliqinfo = $this->header_m->get_cliqinfo($cliqid);
            $data['cliqinfo'] = $cliqinfo;
            return $this->load->view('components/cliqhistory', $data, TRUE);
        }
        
        public function starfavorite($cliqid)
        {
            $isfav = $this->logic_m->isfav($cliqid);
                if ($isfav == true) 
                {
                    $data['favstar'] = 'favstar';
                } else {
                    $data['favstar']  = '';
                }
                $data['cliqid'] = $cliqid;
            return $this->load->view('components/starfavorite', $data, TRUE);
        }
        
        public function threadlist($cliqid='', $cliq=false, $limit=0)
        {
            $data['table_row'] = $this->threadlist_m->build_rows($cliqid, $cliq, $limit);
            
            $page['sortbar']    = $this->load->view('threadlist/sortbar', '', TRUE);
            $page['tl_header']  = $this->load->view('threadlist/tl-header', '' , TRUE);      
            $page['tl_list']    = $this->load->view('threadlist/tl-list', $data, TRUE);
            return $this->load->view('threadlist', $page, TRUE);
        }
        
        public function cliqbar($cliqid = '', $cliq = '')
        {
            $page['active']         = $this->cliqbar_m->active($cliqid);
            $page['search']         = $this->cliqbar_m->search($cliqid);
            $page['filters']        = $this->cliqbar_m->filters($cliqid);
            $page['newthread']      = $this->cliqbar_m->newthread($cliqid, $cliq);
            return $this->load->view('cliqbar', $page, TRUE);
        }
        
        public function thread_cliqbar($threadid = '', $slug='')
        {
            $slug = $this->uri->segment(3);
            $active = $this->session->userdata('active');
            $cliqid = $active['cliqid'];
            $page['active']         = $this->cliqbar_m->active($cliqid);
            $page['filters']              = $this->cliqbar_m->thread_title($this->logic_m->get_subject($threadid));
            $page['search']         = $this->cliqbar_m->search($cliqid);
            $page['reply']          = $this->cliqbar_m->reply($threadid);
            return $this->load->view('thread_cliqbar', $page, TRUE);
        }
        
        public function profile($username)
        {
            $realun = $this->tank_auth->get_username();
            if ($realun == $username)
             { $owned = true; } else { $owned = false; }
             $page['profilenav'] = $this->profile_m->profilenav($username, $owned);
             $page['profileform'] = $this->profile_m->profileform($username, $owned);
             return $this->load->view('profile', $page, TRUE);
        }
        
        public function thread($threadid)
        {
            //add 1 to view            
            $data['threadid']           = $threadid;
            $data['wysihtml5_toolbar']  = $this->load->view('newthread/wysihtml5_toolbar','',TRUE);
            $data['op']                 = $this->threads_m->get_threads($threadid);
            $data['replies']            = $this->threads_m->replies($threadid);
            
            $page['subject']            = $data['op']['subject'];
            $page['replyTo']            = $this->threads_m->replyTo($data);
            $page['replies']                 = $this->threads_m->create_replies($data);
            return $this->load->view('thread', $page, TRUE);
        }
        
        public function newthread($cliqid='')
        {
            $data['wysihtml5_toolbar']  = $this->load->view('newthread/wysihtml5_toolbar', '', TRUE);
            $data['cliqid'] = $cliqid;
            $page['textarea']       = $this->newthread_m->textarea($data);
            return $this->load->view('newthread', $page, TRUE);
        }
        
        public function searchresults($cliqid, $cliq, $search)
        {
            $data = $this->search_m->find_cliq($cliqid, $search);
            
            //below, we take the returned data from find_cliq above and conver it
            //to html so that we keep consistency in cliq creation @ template_model->cliqlink
            $data['default_results'] = $this->search_m->buildresults_default($data);
            $data['related_results'] = $this->search_m->buildresults_related($data);
            $data['cliqid'] = $cliqid;
            $data['catabbr'] = $this->logic_m->get_catabbr($cliqid);
            $data['search'] = $search;
            $data['cliq'] =         $cliq;
            $page['related'] =      $this->load->view('search/related', $data, TRUE);
            $page['default'] =      $this->load->view('search/default', $data, TRUE);
            $checkdupe        =      $this->create_m->get_urls_cliqid($cliqid, $search);
            if (!$checkdupe) {
                $page['newcliq'] =      $this->load->view('search/newcliq', $data, TRUE);
            } else {
                $page['newcliq'] = '';
            }
            return $this->load->view('search', $page, TRUE);
        }

        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */