<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Part_order extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("part_order_model");
    }
    public function index(){
        
        $this->data['orders'] = $this->part_order_model->get();

    }
    public function delete($id){
        $this->part_order_model->delete($id);
        redirect('part_order');
    }
    public function dispatch($id){
        $this->part_order_model->dispatch($id);
        redirect('part_order');
    }
    public function show($id){
        $this->data['order'] = $this->part_order_model->getOrder($id);     
        
           
    }
    /*
    public function order_list($site)
    {
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }
        $this->data['orders'] = $this->part_order_model->get_order_list($this->data['site']);
    }

    public function order($site, $id)
    {
        $this->load->helper('form');
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }
        $this->data['order'] = $this->part_order_model->get_order($this->data['site'], $id);

        if($this->data['site']['sbdirect'] == 1)
        {
            $this->view = '/part_order/order/sbdirect_default';
        }
        else if (file_exists(APPPATH . 'views/part_order/order/' . $site . '.php'))
        {
            $this->view = '/part_order/order/' . $site;
        }
        else
        {
            $this->view = '/part_order/order/default';
        }
    }

    public function submit_quote($site, $id)
    {
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }

        $this->part_order_model->submit_quote($this->data['site'], $id);

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Order has been quoted.'
        ));
        redirect($this->uri->segment(1) . '/part_order/' . $site . '/' . $id);
    }

    public function add_note($site, $id)
    {
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }

        if($this->data['site']['sbdirect'] == 1)
        {
            $this->load->model('note_model');
            $this->note_model->insert(array(
                'module_id' => 7,
                'row_id' => $id,
                'user_id' => $this->data['user']['id'],
                'user_fullname' => $this->data['user']['fullname'],
                'message' => $this->input->post('note', TRUE)
            ));
        }
        else
        {
            $this->part_order_model->add_note($site, $id);
        }

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Your note has been added.'
        ));
        redirect($this->uri->segment(1) . '/part_order/' . $site . '/' . $id);
    }

    public function dispatch($site, $id)
    {
        $this->data['site'] = $this->part_order_model->get_site($site);
        if( empty($this->data['site']) )
        {
            show_404();
            exit();
        }

        $this->part_order_model->dispatch($this->data['site'], $id);

        if($site == 'retail') {
            // mail out
            $this->data['order'] = $this->part_order_model->get_order($this->data['site'], $id);
            $this->data['message'] = 'Your order has been dispatched.';
            $this->data['email'] = $this->load->view('part_order/order/retail_email', $this->data, TRUE);
            if(! empty($this->data['order']['CustomerEMail']) ) {
                $this->load->library('email');
                $result = $this->email
                    ->from('sbcommercialsplc@gmail.com')
                    ->to($this->data['order']['CustomerEMail'])
                    ->subject('Order dispatched')
                    ->message($this->data['email'])
                    ->send();
            }
        }

        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Order has been dispatched.'
        ));
        redirect($this->uri->segment(1) . '/part_order/' . $site . '/' . $id);
    }
    */
}
//EOF
