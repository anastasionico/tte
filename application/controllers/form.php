<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function parts($form)
    {
        if($this->input->post()) {
            switch($form) {
            case 'call_back':
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('number', 'Number', 'required');
                break;
            case 'email':
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                break;
            default :
                show_404();
                exit();
            }

            if ($this->form_validation->run() == FALSE)
            {
                if(validation_errors())
                {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => validation_errors()
                        )
                    );
                }
            }
            else
            {
                $this->load->model('part_model');
                $this->part_model->post_footer_submit($form);
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Your request has been sent to our contact team. We look forward to speaking to you.'
                    )
                );
            }
            redirect('mercedes-parts/enquiry');
            exit();
        }
    }

    public function footer($form)
    {
        if($this->input->post()) {

            switch($form) {
            case 'callback':
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('number', 'Number', 'required');
                break;
            case 'testdrive':
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('number', 'Number', 'required');
                $this->form_validation->set_rules('vehicle', 'Vehicle', 'required');
                break;
            case 'email':
                $this->form_validation->set_rules('name', 'Name', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required');
                break;
            default :
                show_404();
                exit();
            }

            if ($this->form_validation->run() == FALSE)
            {
                if(validation_errors())
                {
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => validation_errors()
                        )
                    );
                }
            }
            else
            {
                $this->load->model('used_model');
                $this->used_model->post_footer_submit($form);
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Your request has been sent to our contact team. We look forward to speaking to you.'
                    )
                );
            }
            redirect($this->input->post('request_path'));
            exit();
        }
    }

}
//EOF
