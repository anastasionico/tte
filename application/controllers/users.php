<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {

    public function index() {
        $this->data['user_accounts'] = $this->user_model->get_all();
        
    }
    

    public function edit($id) {
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

        $this->data['user_account'] = $this->user_model
            ->with('permissions')
            ->get($id);
    }

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
    public function update_user($id){
        $this->view = FALSE;
        $this->load->model("user_model");
        $this->data['user'] = $this->user_model->update_user($id);
        redirect('/users/edit/' . $id);
    }

    public function delete($id){
        $this->load->model("user_model");
        $result = $this->user_model->delete($id);

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'User deleted.'
        ));
        redirect('/users'); 
    }

}
//EOF
