<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logic_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
        
        public function get_active_cliqs()
        {
            return false;
        }

}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */