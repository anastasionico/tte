<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_management extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model(array('contact_model','part_catalog_model'));
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index(){
        $this->data['groups'] = $this->part_catalog_model->getGroupsAndParentName();
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

       $this->data['groups'] = $this->part_catalog_model->getGroupName($id);
       $this->data['getParentGroups'] = $this->part_catalog_model->getParentGroups();
    }

    public function update($id){
        $this->view = FALSE;
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('parent_id', 'parent_id', 'required');
        
        if ($this->form_validation->run() === FALSE){
            $this->session->set_flashdata('alert', array(
                'type' => 'error',
                'message' => 'There has been an error, Check your data'
            ));
            redirect('/categories_management/edit/' . $id);
        }else{   
            $this->data['category'] = $this->part_catalog_model->update_group($id);
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Category updated'
            ));
            redirect('/categories_management');

        }
    }

    public function add() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->data['getParentGroups'] = $this->part_catalog_model->getParentGroups();
        
        
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_rules('parent_id', 'parent_id', 'required');
        if($_POST){
            if ($this->form_validation->run() === FALSE){
                $this->session->set_flashdata('alert', array(
                    'type' => 'error',
                    'message' => 'There has been an error, Check your data'
                ));
                redirect('/categories_management/add');
            }else{
                $this->part_catalog_model->store();
                
            }        
        }
    }
    public function delete($id){
        $this->part_catalog_model->destroy($id);
        redirect('categories_management');
    }
}
