<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller
{
	function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->library('facebook');
            $this->load->library('session');
            $this->load->library('tank_auth');
            $this->load->helper('url');
            
            $this->load->model('template_model');
            $this->load->model('threadlist_m');
            $this->load->model('components_m');
            $this->load->model('header_m');
            $this->load->model('facebook_m');
            $this->load->model('logic_m');
            $this->load->model('slideout_m');
            $this->load->model('cliqbar_m');
            $this->load->model('newthread_m');
            $this->load->model('search_m');
            $this->load->model('create_m');
            $this->load->model('threads_m');
	}
        
                        /* AJAX METHODS */
        
        function ajax_change_cliq($cliqid='', $cliq=false)
        {
            if ($this->input->post('cliqid')) {
                $cliqid = $this->db->escape_str($this->input->post('cliqid'));
            } 
            if ($this->input->post('cliq')) {
                $cliq = $this->db->escape_str($this->input->post('cliq'));
            }
            $this->logic_m->change_active($cliqid, $cliq);
            $active = $this->session->userdata('active');
            $response['cliq'] = url_title($active['cliq']);
            $response['cliqid'] = $active['cliqid'];
            $response['active'] = $this->cliqbar_m->active($cliqid);
            if ($active['newcliq'])
            {
                $response['threadlist'] = $this->load->view('threadlist/newcliq', "", TRUE);
            } else {
                $response['threadlist'] = $this->components_m->threadlist($cliqid, $cliq);
            }
            $response['filters'] = $this->cliqbar_m->filters($cliqid);
            $response['newthread'] = $this->cliqbar_m->newthread($cliqid, $cliq);
            echo json_encode($response);
        }
        
        function ajax_check_active()
        {
            $active = $this->session->userdata('active');
            if ($active['cliqid']=='')
            {
                $this->logic_m->change_active($cliqid=6, $cliq='Cliq');
                $response['active'] = $this->cliqbar_m->active($cliqid);
                $response['cliqid'] = 6;
                $response['cliq'] = 'Cliq';
                echo json_encode($response);
            } else {
                $response['active'] = $this->session->userdata('active');
                echo json_encode($response);
            }
            
        }
        
        function ajax_changefav()
        {
            $isfaved = $this->input->post('isfaved');
            $cliqid = $this->input->post('cliqid');
            $this->logic_m->changefav($cliqid, $isfaved);
            $response['html'] = $this->components_m->starfavorite($cliqid);
            echo json_encode($response);
        }
        
        function ajax_newthread()
        {
            if (!$this->tank_auth->is_logged_in()) {
                $response['isloggedin'] = false;
            } else {
                $response['isloggedin'] = true;
                $active = $this->session->userdata('active');
                $cliqid = $active['cliqid'];
                $cliq = $active['cliq'];
                if ($cliqid == '')
                {
                   $this->logic_m->change_active($cliqid=6, $cliq='Cliq');
                   $response['active'] = $this->cliqbar_m->active($cliqid);
                   $response['cliqid'] = 6;
                   $response['cliq'] = 'Cliq';
                } else {
                    $response['cliq'] = $cliq;
                    $response['cliqid'] = $cliqid;
                }
                $response['newthread'] = $this->components_m->newthread($cliqid);
            }
                echo json_encode($response);
        }
        
        function ajax_find()
        {
            $search = $this->input->post('search');
            
            $active = $this->session->userdata('active');
            
            $cliqid = $active['cliqid'];
            $cliq = $active['cliq'];
            
            $response['cliq'] = strtolower(url_title($cliq,'-'));
            $response['cliqid'] = $cliqid;
            $response['search'] = strtolower(url_title($search, '%20'));
            $response['search_results'] = $this->components_m->searchresults($cliqid, $cliq, $search);
            echo json_encode($response);
        }
        
        function ajax_createthread()
        {
            if (!$this->tank_auth->is_logged_in()) {
                $response['isloggedin'] = false;
            } else {
                $active = $this->session->userdata('active');
                $cliqid = $active['cliqid'];
                $cliq = $active['cliq'];
                $subject = $this->db->escape_str($this->input->post('subject'));
                $body = $this->db->escape_str($this->input->post('body'));
                if ($active['newcliq']) 
                    {   
                        $newcliqid = $this->create_m->create_keyword($cliq, $cliqid);
                        $this->logic_m->change_active($newcliqid, $cliq);
                    } 
                $active2 = $this->session->userdata('active');
                $response['cliq'] = $active2['cliq'];
                $response['cliqid'] = $active2['cliqid'];

                $this->create_m->create_thread($subject, $body, $response['cliqid']);

                $response['active'] = $this->cliqbar_m->active($cliqid);
                $response['threadlist'] = $this->components_m->threadlist($cliqid, $cliq);
            }
            echo json_encode($response);
        }
        
        function authloginmodal()
        {
            if ($this->tank_auth->is_logged_in()) {									// logged in
			$result['loggedin'] = TRUE;
		} elseif ($this->tank_auth->is_logged_in(FALSE)) {						// logged in, not activated
			redirect('/auth/send_again/');

		} else {
			$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
					$this->config->item('use_username', 'tank_auth'));
			$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

			$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('remember', 'Remember me', 'integer');

			// Get login for counting attempts to login
			if ($this->config->item('login_count_attempts', 'tank_auth') AND
					($login = $this->input->post('login'))) {
				$login = $this->security->xss_clean($login);
			} else {
				$login = '';
			}

			$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				if ($data['use_recaptcha'])
					$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
				else
					$this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
			}
			$data['errors'] = array();

			if ($this->form_validation->run()) {								// validation ok
				if ($this->tank_auth->login(
						$this->form_validation->set_value('login'),
						$this->form_validation->set_value('password'),
						$this->form_validation->set_value('remember'),
						$data['login_by_username'],
						$data['login_by_email'])) {								// success
					redirect('');

				} else {
					$errors = $this->tank_auth->get_error_message();
					if (isset($errors['banned'])) {								// banned user
						$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);

					} elseif (isset($errors['not_activated'])) {				// not activated user
						redirect('/auth/send_again/');

					} else {													// fail
						foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
					}
				}
			}
			$data['show_captcha'] = FALSE;
			if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
				$data['show_captcha'] = TRUE;
				if ($data['use_recaptcha']) {
					$data['recaptcha_html'] = $this->_create_recaptcha();
				} else {
					$data['captcha_html'] = $this->_create_captcha();
				}
			}
                $authlogin =	$this->load->view('auth/login_form', $data, TRUE);
                $result['authlogin'] = $authlogin;
                echo json_encode($result);
                }
        }
        
        public function ajax_thread()
        {
            $threadid = $this->input->post('threadid');
            $cliqid = $this->logic_m->get_cliqid_w_threadid($threadid);
            $this->logic_m->change_active($cliqid);
            $result['active'] = $this->cliqbar_m->active($cliqid);
            $result['content']              = $this->components_m->thread($threadid);
            $result['filters']              = $this->cliqbar_m->thread_title($this->logic_m->get_subject($threadid));
            $result['reply']                = $this->cliqbar_m->reply($threadid);
            echo json_encode($result);
        }
        
        public function ajax_gethistory()
        {
            $cliqid = $this->input->post('hovcliqid');
            $result['history'] = $this->components_m->history($cliqid);
            echo json_encode($result);
        }
        
        public function replyTo()
        {
            $threadid = $this->input->post('threadid');
            $postnum = $this->input->post('postnum');
            $body = $this->input->post('body');
            if ($postnum == 'undefined') {$postnum = 1; }
            $replyid = $this->threads_m->addreply($threadid, $body, $postnum);
            $reply                = $this->threads_m->get_reply($replyid);
            $result['reply']      = $this->load->view('thread/reply_template', $reply, TRUE);
            echo json_encode($result);
        }
        
}