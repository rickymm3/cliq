<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Angular_m extends CI_Model
{
    function __construct()
    {
            parent::__construct();
    }

    function get_content()
    {
        $data['cliqid'] = $this->send_data();
        return $this->load->view('angular/test.php', $data, TRUE);
    }
    
    function send_data($cliqid = 0)
    {
        return $cliqid;
    }
}