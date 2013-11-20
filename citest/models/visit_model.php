<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Visit_model extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
	}

        function getvisitlist()
        {
            $sql = "SELECT * FROM visits ORDER BY `order` ASC";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        
        function getvisitinfo($visitid)
        {
            $sql = "SELECT * FROM visits WHERE visitid = $visitid";
            $query = $this->db->query($sql);
            return $query->row_array();
        }

        function addvisit($visitname)
        {
            $sql = "INSERT INTO visits (name, `order`)
                    VALUES ('$visitname', '1000')";
            $this->db->query($sql);
            return mysql_insert_id();
        }
        
        function getvisitlistitem($listitemid)
        {
            $sql = "SELECT * FROM visits WHERE visitid = $listitemid";
            $query = $this->db->query($sql);
            return $query->row_array();
        }
        
        function sortvisits($order)
        {
            
            //UPDATE `visits` SET `0` = Array WHERE `visitid` = Array
            foreach ($order as $item)
            {
                $visitid = $item['visitid'];
                $order = $item['order'];
                $sql = "UPDATE visits SET `order` = $order WHERE visitid = $visitid";
                $this->db->query($sql);
            }
            return true;
        }
        
        function getdatasetinfo($visitid)
        {
            $sql = "SELECT ds.name FROM visits_dataset vd
                    INNER JOIN dataset ds
                    ON vd.datasetid = ds.datasetid
                    WHERE visitid = $visitid";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        
        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */