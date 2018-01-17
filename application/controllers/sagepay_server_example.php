<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Sage Pay Server example controller
 *
 * Functional code to pass order to Sage Pay Go Server service
 * http://www.sagepay.com/products_services/sage_pay_go/integration/server
 *
 * @package	  sagepay_server
 * @author    Ollie Rattue, Too many tabs <orattue[at]toomanytabs.com>
 * @copyright Copyright (c) 2011, Ollie Rattue
 * @license   http://www.opensource.org/licenses/mit-license.php
 * @link      http://github.com/ollierattue/codeigniter-sagepay-server
 */

class Sagepay_server_example extends CI_Controller
{	
    public function __construct()
    {
        parent::__construct();
		
		$this->load->library('sagepay_server');
    	$this->load->model('sagepay_server_model');
	}

	// --------------------------------------------------------------------

	function index()
	{
		$this->load->view('sagepay_server_example/index/index');
	}
	
	// --------------------------------------------------------------------
	
	// Example of a typical Sage Pay transaction

	function make_payment()
	{

		// You can create the VendorTXCode in a different way (e.g. db autoincrement) long as the VendorTxCode MUST be unique for 
		// each transaction you send to Sage Pay Server
		$VendorTxCode = $this->sagepay_server->create_vendor_tx_code();

		// Lets create the transaction
		$this->sagepay_server->set_field('Amount', '15.00'); // with 2 decimal places where relevant
		$this->sagepay_server->set_field('Currency', 'GBP'); // Optional. Uses value in config if not set.
		$this->sagepay_server->set_field('Description', 'My instructional DVD'); // Description of purchase displayed on the Sage Pay Max 100

		// Billing address
		$this->sagepay_server->set_field('BillingFirstnames', "Jo"); // Max 20 characters
		$this->sagepay_server->set_field('BillingSurname', "Blogs"); // Max 20 characters
		$this->sagepay_server->set_field('BillingAddress1', "Jo's place"); // Max 100 characters
		$this->sagepay_server->set_field('BillingAddress2', ""); // Optional Max 100 characters
		$this->sagepay_server->set_field('BillingCity', "London"); // Max 40 characters
		$this->sagepay_server->set_field('BillingPostCode', "EC8 8RH"); // Max 10 characters
		$this->sagepay_server->set_field('BillingCountry', "GB"); // 2 characters ISO 3166-1 country code
		$this->sagepay_server->set_field('BillingState', ""); // US customers only Max 2 characters State code
		$this->sagepay_server->set_field('BillingPhone', "01205581818"); // Optional Max 20 characters
		$this->sagepay_server->set_field('CustomerEmail', "na123456789@mailinator.com"); // Optional Max 255 characters
		$this->sagepay_server->set_same_delivery_address();

     	/** Now POST the data to Sage Pay
		*** Data is posted to purchaseurl which is set depending on whether you are using SIMULATOR, TEST or LIVE **/
		$sagepay_response = $this->sagepay_server->new_transaction($VendorTxCode, 'payment');;
		$this->sagepay_server->process_transaction_response($sagepay_response);


		// if successful the process_response() will redirect to SagePay.
		// Otherwise redirect to a failure page
		redirect('transaction_status/failed/003');
	}

	// --------------------------------------------------------------------
}

/* End of file example_transaction.php */
/* Location: ./application/controllers/example_transaction.php */
