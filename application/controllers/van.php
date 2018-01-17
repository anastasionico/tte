<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Van extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('used_model');
    }

    public function deal()
    {
        $this->load->view('header', $data);
        $this->load->view('van/deal-of-the-month', $data);
        $this->load->view('footer', $data);
    }

    /*
     * call me request POST
     */
    public function makeoffer()
    {
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('offer', 'Offer', 'required');

		if ($this->form_validation->run() == FALSE)
		{
            if(validation_errors())
            {
                $this->session->set_flashdata('alert', array(
                    'type' => 'error',
                    'message' => validation_errors()
                    )
                );
            }
		}
		else
		{
            $this->load->model('contact_model'); // needed?
            // email sales admin
            $to = 'enquiry@sbcommercials.co.uk, enquiries@sbcommercials.co.uk';
            $message = 'EMAIL: ' . $_POST['email'] . '<br />
                NUMBER: ' . $_POST['number'] . '<br />
                OFFER: ' . $_POST['offer'];
            $this->contact_model->emailnote($to, 'New Van Deal Of the Month Offer', $message);

            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Your offer has been sent to our sales team who will respond shortly.'
                )
            );
        }
        redirect('mercedes-vans/deal-of-the-month');
    }
}
//EOF
