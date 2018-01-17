<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends MY_Controller {

    public function index() {
        $this->data['customer_accounts'] = $this->customer_model->get_all();
    }
    
    
    public function edit($id) {
         $this->load->helper('form');
        if($_POST) {
            $this->permission_model->update_user($id);

            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'User updated.'
            ));
            redirect($this->uri->segment(1) . '/users/' . $id);
        }
        $this->load->model('module_model');
        $this->data['modules'] = $this->module_model->get_all();

        $this->data['customer_account'] = $this->customer_model->get_customer_by_id($id);
    }
    /*
    public function add() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->load->model('user_model');
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('fullname', 'Fullname', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        if($_POST){
            if ($this->form_validation->run() === FALSE){
                echo "error during the validation <a href='add'>Click here to try again</a>";exit();

            }else{
                $this->user_model->set();
                
            }        
        }
        
    }
    */
    public function update_customers($id){
        $this->view = FALSE;
        $this->load->model("customer_model");
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('firstname', 'firstname', 'required');
        $this->form_validation->set_rules('lastname', 'lastname', 'required');
        $this->form_validation->set_rules('address1', 'first address', 'required');
        $this->form_validation->set_rules('address2', 'second address', '');
        

        $this->form_validation->set_rules('city', 'city', 'required');
        $this->form_validation->set_rules('postcode', 'postcode', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('phone', 'phone', '');
        $this->form_validation->set_rules('mobile', 'mobile', '');
        
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', '');
        $this->form_validation->set_rules('creditcard', 'creditcard number', 'required');
        $this->form_validation->set_rules('creditcard_type', 'creditcard type', 'required');
        $this->form_validation->set_rules('creditcard_expmm', 'expiration month', 'required');
        
        $this->form_validation->set_rules('creditcard_expyy', 'expiration year', 'required');
        $this->form_validation->set_rules('billing_address', 'billing address', '');
        $this->form_validation->set_rules('billing_city', 'billing city', '');
        $this->form_validation->set_rules('billing_postcode', 'billing postcode', '');
        $this->form_validation->set_rules('ship_address', 'ship address', '');
        $this->form_validation->set_rules('ship_city', '', 'ship city');
        $this->form_validation->set_rules('ship_postcode', 'ship postcode', '');
        if ($this->form_validation->run() === FALSE){
            redirect('/customers/edit/' . $id);
        }else{   
            
            $this->data['customer'] = $this->customer_model->update_customer($id);
            redirect('/customers/edit/' . $id);
        }
    }

    public function delete($id){
        $this->load->model("customer_model");
        $result = $this->customer_model->delete($id);

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'customer deleted.'
        ));
        redirect('/customers'); 
    }
    
}
//EOF
