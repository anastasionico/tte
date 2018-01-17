<?php 


class Store extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library(array('cart','form_validation'));
        $this->load->model(array('part_model','vehicle_model','about_model','part_catalog_model'));
        $this->load->helper('form');
    }


    public function vehicles(){
    
        $this->data['manufacturers'] = $this->vehicle_model->get_manufacturers();
		$this->data['vehicles'] = $this->vehicle_model->get();
        $this->data['categories'] = $this->vehicle_model->get_category();
        /*echo "<pre>";print_r($this->data['categories']);
		echo "</pre>";*/
        $this->data['title'] = "TTE | truck trailer and equipment";
        
        
        $this->data['offers'] = $this->part_model->getOffers(6);
        
        $this->data['latest'] = $this->latest(6);
        $this->data['bestSeller'] = $this->bestSeller(6);
        $this->data['featured'] = $this->featured(6);
        $this->data['about'] = $this->about_model->getAbout();
        $this->data['location'] = $this->about_model->getLocations();
        

        $this->load->view('template/header', $this->data);
        $this->load->view("store/index", $this->data);
        $this->load->view('footer', $this->data);

    }

    
    
    public function getPartByManufacturer($manufacturer , $model = null, $group = null ){
        $this->data['manufacturer'] = urldecode($manufacturer);
        $this->data['model'] = urldecode($model);
        $this->data['group'] = urldecode($group);
        $this->data['vehicles_name'] = $this->vehicle_model->getVehiclesNameByManufacturer(urldecode($manufacturer));
        $this->data['parts'] = $this->vehicle_model->getPartByManufacturer(urldecode($manufacturer), urldecode($model), $group);
        
        
        $this->data['groups'] = $this->part_catalog_model->get_groups();

        //echo "<pre>"; print_r($this->data['groups']); echo "</pre>"; 
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/vehicle_detail", $this->data);
        $this->load->view('footer', $this->data);        
    }

    public function getPartByCategory($category , $group = null){
        $this->load->model('part_model');
        $this->data['category'] = $category;
        $this->data['group'] = $group;

        $this->data['vehicles'] = $this->vehicle_model->get();
        $this->data['parts'] = $this->part_model->getPartByCategory($category, $group);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        //echo "<pre>"; print_r($this->data['vehicles']); echo "</pre>"; 
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/category_detail", $this->data);
        $this->load->view('footer', $this->data);        
    }

    public function getparts($part_name, $pnumber ){
        

        $this->data['part_name'] = $part_name;
        $this->data['pnumber'] = $pnumber;
        $this->data['part'] = $this->part_model->getPartbyModel($pnumber);

        
        $group = $this->data['part']['group'];
        //die( var_dump($pnumber));
        $this->data['similar'] = $this->part_model->getSimilarItems($group,$pnumber);
        $this->data['VehiclesFitted'] = $this->part_catalog_model->getVehiclesFitted($pnumber);
        $this->data['additionalImages'] = $this->part_catalog_model->getAdditionalImagesViaPnumber($pnumber);
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/part_detail", $this->data);
        $this->load->view('footer', $this->data);  
    }
    
    public function contact(){
        $this->load->model('about_model');
        $this->data['title'] = "TTE | Contact Us";
        $this->data['about'] = $this->about_model->getAbout();
        $this->data['location'] = $this->about_model->getLocations();

        $this->load->view('template/header', $this->data);
        $this->load->view("store/contact", $this->data);
        $this->load->view('footer', $this->data);  
    }
    public function enquiry(){
        $this->data['title'] = "TTE | Enquiry";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/enquiry", $this->data);
        $this->load->view('footer', $this->data);  
    }
    public function enquiry_form(){
        $this->load->model("contact_model");

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('part_number', 'Part Number', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        
        if ($this->form_validation->run() === FALSE){
           redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->contact_model->setEnquiry();
            $this->session->set_flashdata('success', 'Your enquiry has been sent');
            redirect("/store/enquiry");
        }
    }

    public function vehiclesList($manufacturer_item = null, $group = null){
        $this->load->model('vehicle_model');
        $this->load->view = false;

        $this->data['title'] = "TTE | Vehicles";

        if( $manufacturer_item === null && $group === null ){
            $this->data['manufacturers'] = $this->vehicle_model->get_manufacturers();
            $this->data['groups'] = $this->part_catalog_model->get_groups(); 
            $this->data['vehicles'] = $this->vehicle_model->get();

            $this->load->view('template/header', $this->data);
            $this->load->view("store/vehicles", $this->data);
            $this->load->view('footer', $this->data);

        }elseif( $manufacturer_item !== null && $group === null ){
            $this->data['manufacturers'] = $this->vehicle_model->get_manufacturers();
            $this->data['manufacturer_item'] = $this->vehicle_model->getManufacturersByName($manufacturer_item);
            $this->data['groups'] = $this->part_catalog_model->get_groups();    
            $this->data['vehicles'] = $this->vehicle_model->getVehiclesNameByManufacturer($manufacturer_item);

            $this->load->view('template/header', $this->data);
            $this->load->view("store/vehicle_filter", $this->data);
            $this->load->view('footer', $this->data);
        }
       // echo "<pre>"; print_r($this->data['manufacturer']); echo "</pre>";
    }

    public function categoriesList(){
        $this->load->model('part_catalog_model');

        $this->data['vehicles'] = $this->part_catalog_model->get_vehicles();
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['manufacturers'] = $this->vehicle_model->get_manufacturers();
        $this->data['title'] = "TTE | Categories";
       
        $this->load->view('template/header', $this->data);
        $this->load->view("store/categories", $this->data);
        $this->load->view('footer', $this->data);

    }

    public function part_filters($manufacturer){
        $this->load->model('part_catalog_model');
        $this->view = false;
        $model = $this->input->post('vehicle');
        $id_group = $this->input->post('inputGroup');
        if(isset($id_group)){
            $group_name = $this->part_catalog_model->getGroupName($id_group);    
            redirect(site_url()."trucks/$manufacturer/$model/$group_name[addr]");
        }else{
            redirect(site_url()."trucks/$manufacturers/$model");
        }
    }
    public function vehicle_filters(){
        $this->load->model('part_catalog_model');
        $this->view = false;
        
        $manufacturer = $this->input->post('manufacturer');
        $id_group = $this->input->post('inputGroup');
        
        if($id_group){
            echo $id_group; exit();
            $group_name = $this->part_catalog_model->getGroupName($id_group);    
            //echo "<pre>"; print_r($group_name);echo "</pre>";
            redirect(site_url()."vehicles/$manufacturer/$group_name[addr]");
        }else{
            redirect(site_url()."vehicles/$manufacturer");
        }
    }
    public function group_filters(){
        $this->view = false;
        $id_group = $this->input->post('inputGroup');
        
        $group_name = $this->part_catalog_model->getGroupName($id_group);    
        redirect(site_url()."categories/$group_name[parentAddr]/$group_name[addr]");
        
    }

    public function offers_page(){
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['offers'] = $this->part_model->getOffers();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        $this->load->view('template/header', $this->data);
        $this->load->view("store/offers_page", $this->data);
        $this->load->view('footer', $this->data);
    }
    public function offers_page_filtered(){
        $group = $this->input->post('inputGroup');
        $this->data['offers'] = $this->part_model->getOffersByGroup($group);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/offers_page", $this->data);
        $this->load->view('footer', $this->data);   

    }


    public function latest($limit = 32){
        $this->view = false;
        $this->load->model('part_model');
        $query = $this->part_model->getLatest($limit);
        return $query;
    }
    public function latest_page(){
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['latest'] = $this->latest();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        $this->load->view('template/header', $this->data);
        $this->load->view("store/latest_page", $this->data);
        $this->load->view('footer', $this->data);
    }
    public function latest_page_filtered(){
        $group = $this->input->post('inputGroup');
        $this->data['latest'] = $this->part_model->getLatestByGroup($group);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/latest_page", $this->data);
        $this->load->view('footer', $this->data);   
    }

    public function featured($limit = 5000){
        $this->view = false;
        $this->load->model('part_model');
        $query = $this->part_model->getFeatured($limit);
        return $query;
    }
    public function featured_page(){
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['featured'] = $this->featured();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        $this->load->view('template/header', $this->data);
        $this->load->view("store/featured_page", $this->data);
        $this->load->view('footer', $this->data);
    }
    public function featured_page_filtered(){
        $group = $this->input->post('inputGroup');
        $this->data['featured'] = $this->part_model->getFeaturedByGroup($group);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/featured_page", $this->data);
        $this->load->view('footer', $this->data);   
    }

    public function bestSeller($limit = 32){
        $this->view = false;
        $this->load->model('part_model');
        $query = $this->part_model->getBestSeller($limit);
        return $query;
    }
    public function bestSeller_page(){
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['bestSeller'] = $this->bestSeller();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        $this->load->view('template/header', $this->data);
        $this->load->view("store/bestseller_page", $this->data);
        $this->load->view('footer', $this->data);
    }
    public function bestSeller_page_filtered(){
        $group = $this->input->post('inputGroup');
        $this->data['bestSeller'] = $this->part_model->getBestSellerByGroup($group);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/bestseller_page", $this->data);
        $this->load->view('footer', $this->data);   
    }

    public function searchbar(){
        $this->form_validation->set_rules('keyword', 'Keyword', 'required');
        if($this->form_validation->run() === FALSE){
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->data['keyword'] = $this->input->post("keyword");
            $this->data['searchResult'] = $this->part_model->searchbar();


            $this->load->view('template/header', $this->data);
            $this->load->view("store/searchPage", $this->data);
            $this->load->view('footer', $this->data);          
        }
    }

    public function terms(){
        $this->data['title'] = "Parts | Buy Genuine Mercedes-Benz Van Spare Parts";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/terms", $this->data);
        $this->load->view('footer', $this->data);          
    }

    public function cookies(){
        $this->data['title'] = "Parts | Buy Genuine Mercedes-Benz Van Spare Parts";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/cookies", $this->data);
        $this->load->view('footer', $this->data);          
    }

    public function contact_form(){
        $this->load->model("contact_model");

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        

        if ($this->form_validation->run() === FALSE){
           redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->contact_model->setMessage();
            $this->contact();
            
        }
    }
    

    public function purchase_confirmation(){
        $this->data['title'] = "TTE | purchase Confirmation";
        $this->data['about'] = $this->about_model->getAbout();
        $this->data['location'] = $this->about_model->getLocations();

        $this->load->view('template/header', $this->data);
        $this->load->view("store/purchase_confirmation", $this->data);
        $this->load->view('footer', $this->data);    
    }

    public function recycled(){
        $this->data['recycled'] = $this->part_model->getRecycled();
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['title'] = "Recycled | Our recycled parts";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/recycled", $this->data);
        $this->load->view('footer', $this->data);    
    }
    
    public function recycled_filtered(){
        $group = $this->input->post('inputGroup');

        $this->data['recycled'] = $this->part_model->getRecycledByGroup($group);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/recycled", $this->data);
        $this->load->view('footer', $this->data);   
    }

    public function factor(){
        $this->data['factor'] = $this->part_model->getFactor();
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['title'] = "factor | Our factor parts";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/factor", $this->data);
        $this->load->view('footer', $this->data);    
    }
    
    public function factor_filtered(){
        $group = $this->input->post('inputGroup');
        
        $this->data['factor'] = $this->part_model->getfactorByGroup($group);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/factor", $this->data);
        $this->load->view('footer', $this->data);   
    }

    public function oem(){
        $this->data['oem'] = $this->part_model->getOem();
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        $this->data['title'] = "oem | Our oem parts";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/oem", $this->data);
        $this->load->view('footer', $this->data);    
    }
    
    public function oem_filtered(){
        $group = $this->input->post('inputGroup');
        
        $this->data['oem'] = $this->part_model->getOemByGroup($group);
        $this->data['groups'] = $this->part_catalog_model->get_groups();
        //echo "<pre>"; print_r($this->data['offers']);echo "</pre>";
        
        $this->load->view('template/header', $this->data);
        $this->load->view("store/oem", $this->data);
        $this->load->view('footer', $this->data);   
    }
}