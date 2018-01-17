<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vehicle_management extends MY_Controller {

    public function index() {
        $this->load->model('vehicle_model');
        $this->data['items'] = $this->vehicle_model->get();
       
    }

    public function add() {
        $this->view = false;
        
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('vehicle_model');
        $this->data['manufacturers'] = $this->vehicle_model->get_manufacturers();

        $this->form_validation->set_rules('manufacturer', 'Manufacturer', 'required');
        $this->form_validation->set_rules('vehicle_text', 'Name of the Vehicle', 'required');
        $this->form_validation->set_rules('year_from', 'Start Production', 'required|numeric|is_natural');
        $this->form_validation->set_rules('year_to', 'End Production', 'numeric|is_natural|
            callback_check_equal_less['.$this->input->post('year_from').']');
        $this->form_validation->set_rules('model', 'Model', 'required');
        
        $config = array(
            'upload_path' => FCPATH."assets/img/vehicle",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
            'max_size' => "2048000", //here it is 2 MB(2048 Kb)
            'max_height' => "768",
            'max_width' => "1024",
            //'file_name' => $newimg_name,
        );

        //get the name of manufacturer
        //upload image
        if(isset($_FILES["img"]['name'])){
            $manufacturer_name = $this->vehicle_model->getManufacturersById($this->input->post('manufacturer'));
            $newimg_name = time()."-".$manufacturer_name['name']."-".$this->input->post('vehicle_text')."-".$this->input->post('year_from');
            //->$_FILES["img"]['name'];    
            $config['file_name']=  $newimg_name;
        }
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('img')){
            $error = array('error' => $this->upload->display_errors());
            echo "<pre>"; print_r($error);echo "</pre>";
            
        }else{
            $data = array('upload_data' => $this->upload->data());
            $name_image = $data['upload_data']['file_name'];
            if ($this->form_validation->run() === FALSE){
                echo "I am here";
            }else{
                $this->vehicle_model->set($name_image);
                redirect("vehicle_management");
            }    
        }
        
    }

    public function create(){
        $this->load->model('vehicle_model');
        $this->load->helper('form');
        $this->data['manufacturers'] = $this->vehicle_model->getAllManufacturers();
        $this->data['items'] = $this->vehicle_model->get();
    }


    public function edit($id) {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->load->model('vehicle_model');
        $this->data['vehicle'] = $this->vehicle_model->getById($id);
        $this->data['manufacturers'] = $this->vehicle_model->get_manufacturers();

        $this->form_validation->set_rules('manufacturer', 'Manufacturer', 'required');
        $this->form_validation->set_rules('vehicle_text', 'Name of the Vehicle', 'required');
        $this->form_validation->set_rules('year_from', 'Start Production', 'required|numeric|is_natural');
        $this->form_validation->set_rules('year_to', 'End Production', 'numeric|is_natural');
        $this->form_validation->set_rules('model', 'Model', 'required');
        
        //upload image
        $config = array(
            'upload_path' => FCPATH."assets/img/vehicle",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => TRUE,
            'max_size' => "2048000", //here it is 2 MB(2048 Kb)
            'max_height' => "768",
            'max_width' => "1024"
        );

        $this->load->library('upload', $config);
        
        if($this->form_validation->run() !== FALSE){
            if(empty($_FILES['img']['name'])){
                $this->vehicle_model->update($id);
                redirect("vehicle_management/edit/$id");
            }else{
                //print_r($_FILES['img']['name']); exit();
                if(!$this->upload->do_upload('img')){    
                    $error = array('error' => $this->upload->display_errors());
                    echo "<pre>"; print_r($error);echo "</pre>";
                }
                else{
                    $data = array('upload_data' => $this->upload->data());
                    $name_image = $data['upload_data']['file_name'];
                    $this->vehicle_model->update($id,$name_image);
                    redirect("vehicle_management");
                }
            }  
        }
    }
    public function delete($id) {

        $this->load->model('vehicle_model');
        $this->data['vehicle'] = $this->vehicle_model->delete($id);
        redirect("vehicle_management");
    }    
}
//EOF
