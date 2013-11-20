<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dataset_model extends CI_Model
{

	function __construct()
	{
            parent::__construct();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
	}

        function getvists()
        {
            $sql = 'SELECT DISTINCT * FROM visitmap ';
            $query = $this->db->query($sql);
            $visit['visit'] = $query->result_array();
            return $visit;
        }
        
        function getcontent($vnum, $dataset)
        {
            $sql = "SELECT * FROM ecspecs WHERE dataset = '$dataset' AND visit = '$vnum'";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        /*
         Array ( 
         * [0] => stdClass Object 
         * ( 
            * [ecid] => 2 
            * [field] => SITEID 
         * ) ) 
         Array ( 
         * [0] => stdClass Object 
         * ( 
            * [ecid] => 3 
            * [field] => SUBJID 
         * ) ) Array ( [0] => stdClass Object ( [ecid] => 4 [field] => INITIALS ) )  
         
         */
        function getdsinfo($items, $ds, $string = '')
        {
            if ($string == '') {    
                $i = 1;
                $count = count($items);
                foreach ($items as $item)
                {
                    if ($count != $i) {
                        $string .= $item[0]['ecid'] . ","; 
                    } else {
                        $string .= $item[0]['ecid'];
                    }
                    $i++;
                }
            }
            $sql = "SELECT DISTINCT ec.*, md.vartyp, md.varmaxl FROM ecspecs ec
                    INNER JOIN metadata md
                    ON md.varname = ec.field
                    WHERE ecspecs_id in ($string)
                    AND ec.dataset = '$ds'
                    AND md.dataset = '$ds'";
            $query = $this->db->query($sql);
            return $query->result_array();
        }
        
        function createoutput($dsarray, $dependant, $ds)
        {
        //array $item :
        //ecspecs_id:4
        //dataset: DM
        //ecnum:A3
        //visit:1
        //field:INITIALS
        //multi:
        //descript:Subject Initials Missing\/Invalid
        //logic:
        //INITIALS < 3 characters
        //code:checklen!<!3
        //stdtxt:THE SUBE THE APPROPRIATE CORRECTION.
        //query:
        //ecseq:26
        //vartyp:text,
        //varmaxl:3
            
        //check_if!NE!!99-CM-CMCONT1!NE!
        //dataset     visit	field	code
            $final = array();
            $i = 0;
            $a = 'a';
            foreach ($dsarray as $item) { 
                $type = $item['vartyp'];
                $final[$i]['dataset'] = $ds;
                $final[$i]['ecnum'] = $dependant[0]['ecnum'].$a;
                $final[$i]['field'] = $item['field'];
                switch($type):
                    case 'text':
                        //check_if!=!!99-CM-CMTRT1!=!
                        $string = $item['visit']."-".$item['dataset']."-".$dependant[0]['field'];
                        $final[$i]['code'] = 'check_if!=!!'.$string."!NE!";
                        break;
                    case 'date':
                        //length_if!<!11!99-CM-CMTRT1!NE!
                        $string = $item['visit']."-".$item['dataset']."-".$dependant[0]['field'];
                        $final[$i]['code'] = 'length_if!<!11!'.$string."!NE!";
                        // and delete the other one ?
                        break;
                endswitch;
            $i++;
            $a++;
            }
            return $final;
            //start with check_if!
        }
        
        
}

/* End of file users.php */
/* Location: ./application/models/auth/users.php */


