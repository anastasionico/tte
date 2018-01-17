<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_management extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("contact_model");
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index(){
        $this->data['messages'] = $this->contact_model->get();
        
    }
    public function delete($id){
        $this->contact_model->delete($id);
        redirect('contact_management');
    }
}
