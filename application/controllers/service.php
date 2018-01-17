<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('service_model');
    $this->load->model('vehicle_model');
  }

  /**
   * 1. Index page displays form with:
   *    Reg, Mileage, Service Type, Workshop (WG,ST,TH)
   */
  public function index()
  {
    $data['levels'] = $this->service_model->get_levels_info();
    $data['title'] = 'Service';

    $this->load->view('header', $data);
    $this->load->view('service/index', $data);
    $this->load->view('footer', $data);
  }

  /**
   * 2. Order page, customer selects which level of service
   */
  public function order()
  {
    // save any posted input from index() into the session
    if($_POST)
      $this->service_model->input_to_session('order');
    // load page data, will return error with problems
    $data = $this->service_model->get_client_data('order');

    // if any errors redirect back one stage
    if(isset($data['error']))
    {
      $this->session->set_flashdata('error', $data['error']);
      redirect('/service/');
      exit();
    }

    $this->load->view('header', $data);
    $this->load->view('service/order', $data);
    $this->load->view('footer', $data);
  }

  /**
   * 3. Extras page. Gives option to add MOT, Fixed Price Repairs
   *    and Vehicle Diagnosis Information
   */
  public function extras()
  {
    // ** need to store the posted data (service)
    if($_POST)
      $this->service_model->input_to_session('extras');

    // load page data, will return error with problems
    $data = $this->service_model->get_client_data('extras');

    // if any errors redirect back to the start
    if(isset($data['error']))
    {
      $this->session->set_flashdata('error', $data['error']);
      redirect('/service/');
      exit();
    }

    // stop errors for the $sd variable in diagnostic view
    error_reporting(error_reporting() & ~E_NOTICE);

    $this->load->view('header', $data);
    $this->load->view('service/extras', $data);
    $this->load->view('footer', $data);
  }

  /**
   * 4. Booking, takes the customer details along with the date for service.
   *    Gives the option to pay now or at site.
   */
  public function booking()
  {
    // ** need to capture POST for fixed price repairs (fpr_[id]) and mot (mot[id])
    if($_POST)
      $this->service_model->input_to_session('booking');

    // if posted a diagnosis, store it
    $diagnosis = $this->service_model->post_diagnostics();
    if($diagnosis !== NULL)
      $this->session->set_userdata(array('diagnosis' => $diagnosis));

    // load page data, will return error with problems
    $data = $this->service_model->get_client_data('booking');

    // if any errors redirect back to the start
    if(isset($data['error']))
    {
      $this->session->set_flashdata('error', $data['error']);
      redirect('/service/');
      exit();
    }

    // all being well display the booking page
    $this->load->view('header', $data);
    $this->load->view('service/booking', $data);
    $this->load->view('footer', $data);
  }

  public function process()
  {
    // load page data, will return error with problems
    $data = $this->service_model->get_client_data('process');

    // if any errors with the data redirect back to the start
    if(isset($data['error']))
    {
      $this->session->set_flashdata('error', $data['error']);
      redirect('/service/');
      exit();
    }

    $log = $this->service_model->process_order($data);

    // if successful the process_order() will redirect to SagePay or success()
    // Otherwise it will return an error ($log)
    $this->session->set_flashdata('error', $log);
    redirect('yourservice/booking');
  }

  /*
   * Success page, used only for 'pay later' as sagepay has a seperate page for
   * response.
   */
  public function success()
  {
    $data = array();

    if($this->session->flashdata('order_id'))
      $this->service_model->email_notification($this->session->flashdata('order_id'));

    $this->load->view('header', $data);
    $this->load->view('service/success', $data);
    $this->load->view('footer', $data);
  }

  public function enquiry($type = NULL)
  {
    if($type != 'van' && $type != 'truck')
    {
      show_404();
    }

    $data['title'] = 'Service Enquiry';

    $this->load->view('header', $data);
    $this->load->view('service/enquiry_' . $type, $data);
    $this->load->view('footer', $data);
  }

  /*
   * Enquiry post
   */
  public function enquiry_post($type)
  {
    if($type != 'van' && $type != 'truck')
    {
      show_404();
    }

    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');

    $this->form_validation->set_rules('email', 'Email', 'required');

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
      $to = 'joinemail@sbcommercials.co.uk';
      $message = '';
      foreach($_POST as $key => $name)
      {
        $message .= $key . ': ' . $name . '<br />';
      }
      $this->contact_model->emailnote($to, $type . ' Service Enquiry Submit', $message);

      $this->session->set_flashdata('alert', array(
        'type' => 'success',
        'message' => 'Thank you for your enquiry, we will be in contact shortly.'
      )
    );
    }
    redirect('yourservice/enquiry/' . $type);
  }

}
//EOF
