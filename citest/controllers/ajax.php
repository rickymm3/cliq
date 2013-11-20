<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

    	function __construct()
	{
            parent::__construct();
            $this->load->database();
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->library('session');
            $this->load->helper('url');
            
            $this->load->model('content_model');
            $this->load->model('dataset_model');
	}
        
        public function getvisitcontent()
        {
            $visitid = $this->input->post('visitid');
            $data['datasets'] = $this->visit_model->getdatasetinfo($visitid);
            $data['visitinfo'] = $this->visit_model->getvisitinfo($visitid);
            $html['content'] = $this->load->view('content/visit/dscontent', $data, TRUE);
            echo json_encode($html);
        }
               
        public function addvisit()
        {
            $visitname = $this->input->post('visitname');
            $listitemid = $this->visit_model->addvisit($visitname);

            //retreive data for contentp page of build datasets
            $data['listitem'] = $this->visit_model->getvisitlistitem($listitemid);
            $html['listitem'] = $this->load->view('content/visit/visitlistitem', $data, TRUE);
            echo json_encode($html); 
        }
        
        
        
        public function resortvisit()
        {
            $order = json_decode($this->input->post('order'), TRUE);
            if ($this->visit_model->sortvisits($order))
            {
                $response = true;
                echo json_encode($response);
            } else {
                $response = false;
                echo json_encode($response);
            }
            
        }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */