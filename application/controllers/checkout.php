<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checkout extends CI_Controller {
    //the transactionId as to be increased automatically.
    

    public function __construct(){
    	parent::__construct();
    	$this->load->library(array('omnipaygateway', 'cart'));
        $this->load->model('part_model');
        $this->load->helper('form');
    }
    public function index() {
        // -------------- S&B SCRIPT -----------------------------
        $this->load->helper('form');
        if($this->input->post()){
            $this->part_model->checkout();
        }

        if($this->cart->total_items() < 1) {
            $this->session->set_flashdata('error', 'Your checkout session has expired.');
            redirect('/');
        }
        $data = array();
        $data['meta']['noindex'] = TRUE;
        // -------------- S&B SCRIPT ------------------------------------
        $this->load->view('checkout/index');
    }
    
    public function cart() {
        if($this->cart->total_items() < 1) {
            $this->session->set_flashdata('error', 'Your checkout session has expired.');
            redirect('/');
        }
        $this->data['title'] = "Parts | Buy Genuine Mercedes-Benz Van Spare Parts";
        $this->data['meta']['description'] = "Browse our wide range of genuine Mercedes-Benz van parts. Including Vito, Sprinter and Citan spare parts. UK WIDE FREE DELIVERY!";
        
        $this->load->view('template/header', $this->data);
        $this->load->view('checkout/cart');
        $this->load->view('footer', $this->data);        

    }
    public function submit($amount, $transactionId ){
        //ONSUBMIT CREATE A NEW ROW IN THE ORDER TABLE 
        $gateway = new omnipaygateway('PayPal_Express', false);
        
        $amount = number_format($amount, 2, '.', '');
        $options = array(
            'amount' => $amount,
            'currency' => 'GBP',
            'description' => 'test description',
            'transactionId' => $transactionId,
            'returnUrl' => site_url('checkout/complete'),
            'cancelUrl' => site_url('checkout/cart'),
        );
       
        //This command redirect to the paypal page.
        $data = $gateway->purchase($options);
    }

    public function complete() {
        $order = $this->db->get_where("orders", array('token' => $_GET['token']))->row_array();
        //echo "<pre>"; print_r($order); echo "</pre>";exit();
        //HERE SELECT THE ROW FROM THE ORDER TABLE USING THE TOKEN
        $gateway = new omnipaygateway('PayPal_Express', false);
        $amount = number_format($order['amt'], 2, '.', '');
        $options = array(
            'amount' => $amount,
            'currency' => 'GBP',
            'description' => 'test description',
            'transactionId' =>  $order['id'],
            'returnUrl' => site_url('checkout/complete'),
            'cancelUrl' => site_url('checkout/cart'),
        );
        //This command redirect to the paypal page.

        $data = $gateway->completePurchase($options);
        redirect('trucks');
    }

    /* The function below was taken from the SBcommercial and updates the quantities of the cart on the truck/checkout page */
    public function process(){
        
        if($this->input->post('update') == 1) {
            $this->part_model->update_checkout();
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Order quantitys have been updated.'
            ));
            redirect('/checkout/cart');
        }else if($this->input->post()) {
           
            //the $newsLetter will be 1 or null depending if the user has ticked the checkbox on checkout/cart
            $newsLetter = ($this->input->post('newsLetter') !== false)? 1 : null;    
            $fastDelivery = ($this->input->post('fastDelivery') == 'on')? true : false;    
            
            //********************* paypal stuff ********************
            $amount = $this->cart->total();
            $vat = $amount * $this->config->item('vat');
            $amount = $amount + $vat;
            $amount = ($fastDelivery)? $amount + 7.9 : $amount ;
            
            $transactionId = $this->part_model->set_order($amount, $newsLetter, $fastDelivery);    
            $log = $this->submit($amount, $transactionId );
            
            //$log = $this->part_model->process_order();
            // if successful the process_order() will redirect to SagePay or success()
            // Otherwise it will return an error ($log)
            
            $this->session->set_flashdata('error', $log);
            redirect('/checkout/cart');
        }
        redirect('/checkout/cart');
    }
    

}
