<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class contact_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get(){
    	return $this->db->from("contactForm")->order_by('id','desc')->get()->result_array();
    }

    public function setMessage(){
    	$this->load->helper('url');

	    $data = array(
	    	'name' => $this->input->post('name'),
	        'email' => $this->input->post('email'),
	        'message' => $this->input->post('message'),
	        'date' => time()
	    );

	    return $this->db->insert('contactForm', $data);
	}
	public function delete($id){
	    $this->db->where('id', $id)->delete('contactForm');
	}


	public function getEnquiry(){
    	return $this->db->from("enquiryForm")->order_by('id','desc')->get()->result_array();
    }
	public function setEnquiry(){
    	$this->load->helper('url');
		$data = array(
	    	'name' => $this->input->post('name'),
	    	'company' => $this->input->post('company'),
	    	'email' => $this->input->post('email'),
	    	'phone' => $this->input->post('phone'),
	    	'part_number' => $this->input->post('part_number'),
	    	'chassis_number' => $this->input->post('chassis_number'),
	    	'description' => $this->input->post('description'),
	        'date' => time()
	    );
		$message = <<<EOT
Name : {$this->input->post('name')}
Company : {$this->input->post('company')}
Email : {$this->input->post('email')}
Phone : {$this->input->post('phone')}
part_number : {$this->input->post('part_number')}
chassis_number : {$this->input->post('chassis_number')}
description : {$this->input->post('description')}
EOT;
		mail("craig.lees@trucktrailerequip.co.uk", "New enquiry on www.trucktrailerequip.co.uk", $message);
		mail("sales@trucktrailerequip.co.uk", "New enquiry on www.trucktrailerequip.co.uk", $message);
		return $this->db->insert('enquiryForm', $data);

	}

	public function deleteEnquiry($id){
	    $this->db->where('id', $id)->delete('enquiryForm');
	}
	
}