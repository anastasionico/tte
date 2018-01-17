<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model("user_model");
        
    }

    public function login(){
        if($this->uri->segment(2)){
            show_404();
        }

        if($_POST){
            $login = $this->user_model->login(
                $this->input->post('username', TRUE),
                $this->input->post('password', TRUE)
            );

            if($login === TRUE){
                redirect('dashboard');
            }
            else
            {
                // login errors to flashdata?
                redirect("admin");
            }
        }
        else
        {
            $this->load->view('public/header');
            $this->load->view('public/login');
            $this->load->view('public/footer');
        }
    }

    public function index()
    {
        $this->load->view('public/trade');
    }

    public function logout(){
        $login = $this->user_model->logout();
        redirect(site_url());
    }

}
//EOF
