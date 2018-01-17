<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_management extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("about_model");
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index() {
        $this->data['about'] = $this->about_model->getAbout();
        //echo "<pre>"; print_r($this->data['about']);echo "</pre>"; 
    
        $this->form_validation->set_rules('about-header', 'About header', 'required');
        $this->form_validation->set_rules('about-description', 'About Description', 'required');
        $this->form_validation->set_rules('bullet1', 'bullet1', 'required');
        $this->form_validation->set_rules('bullet2', 'bullet2', 'required');
        $this->form_validation->set_rules('bullet3', 'bullet3', 'required');
        $this->form_validation->set_rules('whatwedo-header', 'whatwedo header', 'required');
        $this->form_validation->set_rules('whatwedo-description', 'whatwedo description', 'required');
        if($this->input->post()){
            if ($this->form_validation->run() == FALSE){
                echo "<a href='/about_management'>ERROR OCCURED<a>";
            }else{
                $this->about_model->update();
                header("Refresh:0");
            }    
        }
        
        
    }





    public function location(){
        $this->data['locations'] = $this->about_model->getLocations();

        //echo "<pre>"; print_r($this->input->post()); echo "</pre>";

        
        $config['upload_path']          = $this->config->item('dir_local').'/assets/img/about/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1200;
        $this->load->library('upload', $config);
        
        //echo "<pre>"; print_r($_FILES); echo "</pre>"; //exit();
        $images = array();





        if(! empty($_FILES) ) {
            foreach($_FILES as $key => $file) {
                if(!empty($file['type'])){
                    if ( !$this->upload->do_upload($key)){
                        $error = array('error' => $this->upload->display_errors());
                        echo "<pre>"; print_r($error); echo "</pre>";
                    }else{
                        $data = array('upload_data' => $this->upload->data());
                        $images[$key] = $file['name'];
                    }
                }else{
                    continue;
                }
            }
        
        //echo "<pre>"; print_r($images); echo "</pre>"; //exit();

            //echo "<pre>"; print_r($images); echo "</pre>"; 
            
            $this->form_validation->set_rules('firstHeader', 'firstHeader', 'required');
            $this->form_validation->set_rules('firstDescription', 'firstDescription', 'required');
            $this->form_validation->set_rules('firstbullet1', 'firstbullet1', 'required');
            $this->form_validation->set_rules('firstbullet2', 'firstbullet2', 'required');

            $this->form_validation->set_rules('secondHeader', 'secondHeader', 'required');
            $this->form_validation->set_rules('secondDescription', 'secondDescription', 'required');
            $this->form_validation->set_rules('secondbullet1', 'secondbullet1', 'required');
            $this->form_validation->set_rules('secondbullet2', 'secondbullet2', 'required');

            $this->form_validation->set_rules('deliveryHeader', 'deliveryHeader', 'required');
            $this->form_validation->set_rules('deliveryDescription', 'deliveryDescription', 'required');
            $this->form_validation->set_rules('deliverybullet1', 'deliverybullet1', 'required');
            $this->form_validation->set_rules('deliverybullet2', 'deliverybullet2', 'required');
            
            if (!$this->input->post() && $this->form_validation->run() == FALSE){
                echo "<a href='/about_management'>ERROR OCCURED<a>";
            }else{
                $this->about_model->updateLocation($images);
                header("Refresh:0");
            }
        }
        
       
    }
}
