<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class about_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getAbout(){
    	$this->query = $this->db->get('about');
    	return $this->query->row_array();
	}
	public function update(){
		$this->load->helper('url');
		$data = array(
			'aboutHeader' => $this->input->post('about-header'),
			'aboutDescription' => $this->input->post('about-description'),
			'bullet1' => $this->input->post('bullet1'),
			'bullet2' => $this->input->post('bullet2'),
			'bullet3' => $this->input->post('bullet3'),
			'whatwedoHeader' => $this->input->post('whatwedo-header'),
			'whatwedoDescription' => $this->input->post('whatwedo-description'),
			'id' => 1
		);
		$this->db->replace('about', $data);
	}

	public function getLocations(){
		$this->query = $this->db->get('locations');
    	return $this->query->row_array();
	}
	public function updateLocation($images){
		$this->load->helper('url');
		$data = $this->db->get('locations')->row_array();

		//echo "<pre>"; print_r($data); echo "</pre>"; exit();
		
		$data['firstHeader'] = $this->input->post('firstHeader');
		$data['firstDescription'] = $this->input->post('firstDescription');
		$data['firstbullet1'] = $this->input->post('firstbullet1');
		$data['firstbullet2'] = $this->input->post('firstbullet2');
		$data['secondHeader'] = $this->input->post('secondHeader');
		$data['secondDescription'] = $this->input->post('secondDescription');
		$data['secondbullet1'] = $this->input->post('secondbullet1');
		$data['secondbullet2'] = $this->input->post('secondbullet2');
		$data['deliveryHeader'] = $this->input->post('deliveryHeader');
		$data['deliveryDescription'] = $this->input->post('deliveryDescription');
			

		foreach ($images as $key => $value) {
			$data[$key] = $value;
		}
		
		$this->db->replace('locations', $data);
	}
}