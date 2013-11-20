<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Header_m extends CI_Model
{

	function __construct()
		{
		    parent::__construct();
		    $this->load->library('tank_auth');
		    $this->load->helper(array('form', 'url'));
		    $this->load->library('form_validation');
		}
        
        public function profile()
        {
            $data['username'] = $this->tank_auth->get_username();
            return $this->load->view('header/profile',$data,TRUE);
        }
        
        public function active () {
            return "";
        }
                
       //navigation
        
        public function nav()
        {
            $data['category'] = $this->logic_m->get_categories();
            return $this->load->view('header/category', $data, TRUE);
        }
        
        public function more()
        {
            //$data here will be replaced with suggested, or most visited
            //static for now
            $data = '';
            return $this->load->view('header/more',$data,TRUE);
        }
        
        public function favorites()
        {
            $userid = $this->tank_auth->get_user_id();
            if (!$this->tank_auth->is_logged_in())
            {
                $data['loggedin'] = false;
                $data['favorites'] = "";
            } else {
                $data['loggedin'] = true;
                $favorites = $this->getfavorites($userid);
                $data['favorites'] = $favorites;
            }
            return $this->load->view('favorites/more',$data,TRUE);
        }
        
        public function getfavorites($userid)
        {
            $sql = "SELECT f.position, c.cliq, c.cliqid FROM favorites f
                INNER JOIN cliq c 
                ON f.cliqid = c.cliqid
                WHERE f.userid=$userid AND active=1 ORDER BY f.position ASC ";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        
        //end navigation
        
        
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
        
        public function get_cliqinfo($cliqid)
        {
            $sql = "SELECT COUNT(*) AS total FROM cliqthread WHERE cliqid = $cliqid";
            $query = $this->db->query($sql);
            $result = $query->row_array();
            return $result;
        }
        
        public function loginbutton()
        {
            $fb = $this->facebook_m->fb_load();
            return $this->load->view('header/loginbutton', $fb, TRUE);
        }
        
        public function login()
        {
            	if ($this->tank_auth->is_logged_in()) {				// logged in
			$data['user_id']	= $this->tank_auth->get_user_id();
                        $data['username']	= $this->tank_auth->get_username();
                        $data['tankauth'] = $data['username']."</br>". anchor('/auth/logout/', 'Logout');

		} elseif ($this->tank_auth->is_logged_in(FALSE)) {			// logged in, not activated
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
		$data['tankauth'] = $this->load->view('auth/login_mini',$data,TRUE);
		}
            return $this->load->view('header/login', $data, TRUE);
        }

}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */