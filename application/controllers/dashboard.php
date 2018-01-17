<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    /*
     * Redirect the user to their default module
     */
    public function index(){
        redirect("part_catalog");
    }

}
//EOF
