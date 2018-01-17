<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Part_catalog extends MY_Controller {

    public function index() {
        $this->data['all_items'] = $this->part_catalog_model->get_all();
    }

    public function awaiting_image() {

        $this->data['awaiting_image'] = $this->part_catalog_model->get_awaiting_image();

    }

    public function search()
    {
        $this->view = FALSE;

        $query = $this->input->post('query');
        $part_id = $this->part_catalog_model->search($query);

        if($part_id !== NULL)
        {
            redirect('/part_catalog/' . $part_id);
        }
        else
        {
            $this->session->set_flashdata('pnumber', $query);
            redirect('/part_catalog/add');
        }
    }

    public function add(){
        if($_POST){

            $this->view = FALSE;
            $id = $this->part_catalog_model->put();
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'The parts catalog has been updated.'
            ));
            redirect(base_url('/part_catalog/') .'/'. $id);
        }
        $this->data['vehicles'] = $this->part_catalog_model->get_vehicles();
        // $this->data['homepage'] = $this->part_catalog_model->isHomepage();
        $this->data['groups'] = $this->part_catalog_model->get_groups();

        $this->load->helper('form');
    }

    public function edit($id){
        if($_POST){
            //echo "<pre>"; print_r($this->input->post());echo "</pre>";exit();
            $this->view = FALSE;
            $this->part_catalog_model->put($id);
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'The parts catalog has been updated.'
            ));
            redirect($this->uri->segment(1) . '/part_catalog/' . $id);
        }

        $this->data['part'] = $this->part_catalog_model->get($id);
        $this->data['additionalImages'] = $this->part_catalog_model->getAdditionalImages($id);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['vehicles'] = $this->part_catalog_model->get_vehicles($id);

        $this->load->helper('form');
    }

    public function dele($id)
    {
        $this->view = FALSE;
        $this->part_catalog_model->dele($id);
        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'The part was deleted.'
        ));
        redirect($this->uri->segment(1) . '/part_catalog');
    }
    
    public function available($id)
    {
        $this->view = FALSE;
        $this->part_catalog_model->available($id);
        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'The part has changed availability.'
        ));
        redirect($this->uri->segment(1) . '/part_catalog');
    }
    


    public function AddAdditionaImage($part){
        $config['upload_path']          = './inc/img/parts/additional';
        $config['allowed_types']        = 'gif|jpg|png';
       
        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload('additionalImage')){
            $error = array('error' => $this->upload->display_errors());
            print_r($config['upload_path']);echo"<br>";
            print_r($error);
            

        }else{
            $data = array('upload_data' => $this->upload->data());
            $data['part'] = $part;
            /* echo "<pre>"; print_r($data); echo "</pre>"; exit(); */
            
            $this->dataImage = $this->part_catalog_model->setAdditionalImage($data);
            //print_r($this->dataImage);
            
            redirect("/part_catalog/$part");

        }
    }

    public function orderAdditionalImage(){
        $this->view = false;
        $output = array();
        
        $list = $_POST['list']; 
        $list = parse_str($list, $output);
        $this->part_catalog_model->orderAdditionalImage($output);
    }

    public function delete_picture($part_id, $image_id) {
        $this->view = FALSE;

        $this->db
            ->where('id', $image_id)
            ->where('part_id', $part_id)
            ->delete('parts_store_additional_photos');

        redirect("/part_catalog/$part_id");
    }
   

}
//EOF
