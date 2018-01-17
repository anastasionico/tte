<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('part_model');
        $this->load->library('cart');
    }

    public function index()
    {

        $data['vehicles'] = $this->part_model->get_vehicles();
        $data['inline_javascript'] = $this->load->view('parts/index_inline_js', $data, true);

        $data['title'] = "Van Parts | Buy Genuine Mercedes-Benz Van Spare Parts";
        $data['meta']['description'] = "Browse our wide range of genuine Mercedes-Benz van parts. Including Vito, Sprinter and Citan spare parts. UK WIDE FREE DELIVERY!";

        $this->load->view('header', $data);
        $this->load->view('parts/index', $data);
        $this->load->view('footer', $data);
    }

    /*
     * Takes front pages POSTs and sends user to correct page
     */
    public function go($form){
        //this function returns all the part available for a selected vehicle from index.php
        switch($form) {
        case 'reg':
            if($this->input->post('my-reg')) {
                // lookup reg
                $this->load->model('vehicle_model');
                $lookup = $this->vehicle_model->reg_lookup($this->input->post('my-reg'), 'PARTS');
                if($lookup == NULL){
                    $this->session->set_flashdata('alert', array(
                        'type' => 'danger',
                        'message' => 'Unfortunately we can\'t identify your vehicle using that registration number, please check and try again.'
                    ));
                    redirect();
                }
                else {
                    $vin_three = preg_replace('/\D/', '', substr($lookup['vin'], 3, 3));
                    $vehicle = $this->part_model->get_vehicle($vin_three, $lookup['model'], $lookup['year']);

                    if(empty($vehicle)) {
                        $this->session->set_flashdata('alert', array(
                            'type' => 'danger',
                            'message' => 'Unfortunately we have no parts listed for your vehicle. Please fill in our contact request form below.'
                        ));
                        redirect('parts-enquiry');
                    }
                    else {
                        // transfer
                        redirect('mercedes-parts/' . $vehicle['url']);
                        exit();
                    }
                }
            }
            break;
        case 'model':
            if($this->input->post('vehicle_id')) {
                $vehicle = $this->db
                    ->get_where('parts_store_vehicles', array('id' => preg_replace('/\D/', '', $this->input->post('vehicle_id')) ), 1)
                    ->row_array();

                if($vehicle) {
                    $url = 'mercedes-parts/' . $this->part_model->part_url_vin($vehicle['vehicle_vin']) . '/' . $vehicle['model'];
                    redirect($url);
                }
                else {
                    show_404();
                }
            }
            break;
        case 'part':
            $part_id = $this->part_model->search($this->input->post('part_number'));
            if($part_id != NULL) {
                //redirect
                redirect('mercedes-parts/part/' . $part_id);
                exit();
            }
            else {
                $this->session->set_flashdata('alert', array(
                    'type' => 'danger',
                    'message' => 'Unfortunately we dont have that part listed online. Please fill in our contact request form below. We will check if we can source the part for you.'
                ));
                redirect($this->uri->segment(1) . '/enquiry');
            }
            break;
        default:
            show_404();
        }
        exit();
    }

    /*
     * Enquiry form
     */
    public function enquiry()
    {
        $data = array();

        $this->load->view('header', $data);
        $this->load->view('parts/enquiry', $data);
        $this->load->view('footer', $data);
    }


    /*
     * Displays products given vehicle & model
     *
     * What happens if theres no parts??? 404???
     */
    public function products($vehicle, $model) {

        $data = array(
            'vehicle' => $vehicle,
            'model' => $model,
            'parts' => $this->part_model->get_by_model($vehicle, $model),
        );
        $data['groups'] = $this->part_model->get_groups_from_parts($data['parts']);

//        $data['meta']['noindex'] = TRUE;
        $this->load->view('header', $data);
        $this->load->view('parts/products', $data);
        $this->load->view('footer', $data);
    }

    /*
     * Displays products given vehicle & model & group
     *
     * What happens if theres no parts??? 404???
     */
    public function group_products($vehicle, $model, $group) {
        $group_id = preg_replace('/\D/', '', $group);

        $data['group'] = $this->db
            ->get_where('parts_store_groups', array('id' => $group_id), 1)
            ->row_array();

        $data['vehicle'] = $vehicle;
        $data['model'] = $model;
        $data['parts'] = $this->part_model->get_by_model_group($vehicle, $model, $data['group']['id']);

//        $data['meta']['noindex'] = TRUE;
        $this->load->view('header', $data);
        $this->load->view('parts/products', $data);
        $this->load->view('footer', $data);
    }

    /*
     * Displays single product
     */
    public function part($part_id) {

        $part_id = preg_replace('/\D/', '', $part_id);
        $data['part'] = $this->part_model->get($part_id);

        if(empty($data['part']))
            show_404();

        $data['part']['vehicles'] = $this->part_model->get_part_vehicles($part_id);

        $data['title'] = $data['part']['title'] . ' | Mercedes-Benz Van Parts';
        $data['meta']['canonical'] = site_url('mercedes-parts/part/' . $part_id . '-' . url_title($data['part']['title'], '_', TRUE));
//        $data['meta']['noindex'] = TRUE;
        $data['meta']['description'] = $data['part']['title'];
        if(! empty($data['part']['description']) ) {
           $sentence = preg_replace('/([^?!.]*.).*/', '\\1', $data['part']['description']);
           $data['meta']['description'] .= '. ' . $sentence;
        }
        $this->load->view('header', $data);
        $this->load->view('parts/product', $data);
        $this->load->view('footer', $data);
    }

    /*
     * Displays single product with vehicle and model
     */
    public function product($vehicle, $model, $product) {
        // fixes a bug where there were numbers in the url, numbers other than the id used the
        // preg_replace below
        if (strpos($product,'-') !== false) {
            $product = explode('-', $product);
            $product = $product[0];
        }

        $part_id = preg_replace('/\D/', '', $product);
        $data['part'] = $this->part_model->get($part_id);
        $data['title'] = $data['part']['title'] . ' | Mercedes-Benz Van Parts';
        $data['part']['vehicles'] = $this->part_model->get_part_vehicles($part_id);
        $data['meta']['canonical'] = site_url('mercedes-parts/part/' . $part_id . '-' . url_title($data['part']['title'], '_', TRUE));


        if(empty($data['part']))
            show_404();

//        $data['meta']['noindex'] = TRUE;
        $data['meta']['description'] = $data['part']['title'];
        if(! empty($data['part']['description']) ) {
           $sentence = preg_replace('/([^?!.]*.).*/', '\\1', $data['part']['description']);
           $data['meta']['description'] .= '. ' . $sentence;
        }
        $this->load->view('header', $data);
        $this->load->view('parts/product', $data);
        $this->load->view('footer', $data);
    }

    /*
     * The ajax function for getting checkout data to the js client
     */
    public function j($function) 
    {
        switch($function)
        {
        case 'basket':
            header('Content-type: application/json');

            $basket_items = array();
            $in_basket = array();
            foreach($this->cart->contents() as $item) {
                $basket_items[] = array(
                    'id' => 'part_' . $item['id'],
                    'part_no' => $item['options']['pnumber'],
                    'qty' => (int)$item['qty'],
                    'price' => (float)$item['price'],
                    'title' => $item['name'],
                );
                $in_basket[] = 'part_' . $item['id'];
            }

            echo json_encode(array(
                'basketItems' => $basket_items,
                'inBasket' => $in_basket,
            ));
            break;
        case 'sync':
            if($this->input->post('basketItems'))
            {
                $basketItems = json_decode( $this->input->post('basketItems') );

                foreach($basketItems as $basket_item)
                {
                    $basket_item = get_object_vars($basket_item);
                    if(substr($basket_item['id'], 0, 4) == "part")
                    {
                        $input_id = explode('_', $basket_item['id']);
                        $part_id = preg_replace('/\D/', '', $input_id[1]);
                        $part = $this->part_model->get($part_id); // CHANGE WHEN MOVE TO MODEL

                        if(isset($part['offer'])){
                            $part['price'] = $part['offer'];
                        }
                        
                        if($part) {
                            $cart_data[] = array(
                                'id'      => $part['id'],
                                'qty'     => preg_replace('/\D/', '', $basket_item['qty']),
                                'price'   => $part['price'],
                                'name'    => preg_replace("/[^0-9a-zA-Z ]/", "", $part['title']), // keep them names clean for the cart, otherwise it drops em
                                'options' => array(
                                    'pnumber' => $part['pnumber'],
                                )
                            );
                        }
                    }
                }
                $this->cart->destroy();
                $this->cart->insert($cart_data);
            }
            break;
        }
    }

    /*
     * Will take the submitted form and put
     * the info into the cart library (session)
     */
    public function checkout($section = NULL)
    {
        $this->load->helper('form');

        if($this->input->post())
        {
            $this->part_model->checkout();
        }

        if($this->cart->total_items() < 1) {
            $this->session->set_flashdata('error', 'Your checkout session has expired.');
            redirect('/');
        }
        $data = array();

        $data['meta']['noindex'] = TRUE;
        $this->load->view('header', $data);
        $this->load->view('parts/checkout', $data);
        $this->load->view('footer', $data);
    }

    public function process()
    {
        if($this->input->post('update') == 1) {
          $this->part_model->update_checkout();
          $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Order quantitys have been updated.'
          ));
          redirect($this->uri->segment(1) . '/checkout');
        }
        else if($this->input->post()) {
            $log = $this->part_model->process_order();

            // if successful the process_order() will redirect to SagePay or success()
            // Otherwise it will return an error ($log)
            $this->session->set_flashdata('error', $log);
            redirect('mercedes-parts/checkout');
        }
        redirect('mercedes-parts/checkout');
    }


}
//EOF
