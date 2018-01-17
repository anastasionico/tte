<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Used extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('used_model');
    }

    /*
     * Original controller taken from old framework, needs a tidy.
     
    public function index($area = NULL, $area_id = NULL)
    {
        switch($area)
        {
        case 'm': // models
            $data['vehicles'] = $this->used_model->get_vehicles('used', 0, 0, $area_id);
            //$model = get_models($id);
            $data['title'] = 'models';
            break;
        case 'c': // categorys
            $data['vehicles'] = array();
            $category = $this->used_model->get_categorys($area_id); // id from addr
            $vehicles_by_cat = $this->used_model->get_vehicles_by_category($category['id']);
            if($category && $vehicles_by_cat)
            {
                foreach($vehicles_by_cat as $c)
                    $data['vehicles'][] = $this->used_model->get_vehicles('used', 0, $c['vehicle_id']);
                $data['title'] = $category['category'];
            }
            break;
        case 'vans': // /used/vans/
            $data['vehicles'] = $this->used_model->get_vehicles('used', 'van');
            $data['title'] = 'Vans';
            break;
        case 'trucks': // /used/trucks/
            $data['vehicles'] = $this->used_model->get_vehicles('used', 'truck');
            $data['title'] = 'Trucks';
            break;
        case NULL: // /used/
            $data['title'] = 'Used Mercedes Vans & Trucks';
            $data['vehicles'] = $this->used_model->get_vehicles('used', 0, 0, 0, 1);
            $data['special_offer'] = $this->used_model->get_vehicles('used', 0, 181, 0, 1); // change for special
            $data['jsfade'] = 1;
        }
        if(empty($data['vehicles']))
            show_404();

        $data['categorys'] = $this->used_model->get_categorys();
        $data['models'] = $this->used_model->get_models();
        $data['count_van'] = $this->used_model->_count('van');
        $data['count_truck'] = $this->used_model->_count('truck');

        $this->load->view('header', $data);
        $this->load->view('used/index', $data);
        $this->load->view('footer', $data);
    }
*/

    public function index($area = NULL, $area_id = NULL)
    {
        $data['phone_number'] = '01707 283426';

        switch($area)
        {
        case 'm': // models
            $data['vehicles'] = $this->used_model->get_vehicles('used', 0, 0, $area_id);
            //$model = get_models($id);
            $data['title'] = $data['override_h1'] = ucfirst($area_id);
//            if($area_id == 'sprinter') $data['usedchristmas'] = 1;
            $data['override_content'] = $this->used_model->get_area_content($area_id);
            break;
        case 'c': // categorys
            $data['vehicles'] = array();
            $category = $this->used_model->get_categorys($area_id); // id from addr
            $vehicles_by_cat = $this->used_model->get_vehicles_by_category($category['id']);
            if($category && $vehicles_by_cat)
            {
                foreach($vehicles_by_cat as $c)
                {
                    $vehicle = $this->used_model->get_vehicles('used', 0, $c['vehicle_id']);
                    if(! empty($vehicle) )
                        $data['vehicles'][] = $vehicle;
                }
                $data['title'] = $data['override_h1'] = $category['category'];
                $data['override_content'] = $this->used_model->get_area_content($area_id);
            }

            break;
        case 'vans': // /used/vans/
            $data['vehicles'] = $this->used_model->get_vehicles('used', 'van');
            $data['title'] = 'Vans';
            break;
        case 'trucks': // /used/trucks/
            $data['vehicles'] = $this->used_model->get_vehicles('used', 'truck');
            $data['title'] = 'Trucks';
            break;
        case NULL: // /used/
            $data['title'] = 'Approved Used Mercedes-Benz Vans & Trucks';
            $data['meta']['description'] = 'Approved Used Mercedes-Benz Vans & Trucks in North & East London, Herts & Essex. Contact S & B Commercials today to test drive an affordable & reliable Used Mercedes-Benz Commercial Vehicle.';
            $data['vehicles'] = $this->used_model->get_vehicles('used', 0, 0, 0, 1);
            $data['special_offer'] = $this->used_model->get_vehicles('used', 0, 181, 0, 1); // change for special
//            $data['jsfade'] = 1;
//            $data['usedchristmas'] = 1;
        }
        if(empty($data['vehicles']))
            show_404();

        $data['livechat'] = 1;
        $data['categorys'] = $this->used_model->get_categorys();
        $data['models'] = $this->used_model->get_models();
        $data['count_van'] = $this->used_model->_count('van');

        $this->load->view('header', $data);
        $this->load->view('used/index', $data);
        $this->load->view('footer', $data);
    }

    public function test()
    {
        $data['title'] = 'Approved Used Mercedes-Benz Vans & Trucks';
        $data['meta']['description'] = 'Approved Used Mercedes-Benz Vans & Trucks in North & East London, Herts & Essex. Contact S & B Commercials today to test drive an affordable & reliable Used Mercedes-Benz Commercial Vehicle.';
        $data['vehicles'] = $this->used_model->get_vehicles('used', 0, 0, 0, 1);
        $data['special_offer'] = $this->used_model->get_vehicles('used', 0, 181, 0, 1); // change for special
        $data['jsfade'] = 1;

        $data['categorys'] = $this->used_model->get_categorys();
        $data['models'] = $this->used_model->get_models();
        $data['count_van'] = $this->used_model->_count('van');
        $data['count_truck'] = $this->used_model->_count('truck');

        $this->load->view('header', $data);
        $this->load->view('used/index', $data);
        $this->load->view('footer', $data);
    }


    public function aboutus()
    {
        $data['phone_number'] = '01707 283426';

        $data['title'] = 'Used Mercedes-Benz Commercial Vehicles';
        $data['meta']['description'] = 'Approved Used Mercedes-Benz Commercial Vehicles in North London, Herts & Essex. Buy a Used Vito or Used Mercedes Sprinter online, or contact S & B Commercials to test drive a Used Mercedes Van.';

        // needed?
        $data['categorys'] = $this->used_model->get_categorys();
        $data['models'] = $this->used_model->get_models();
        $data['count_van'] = $this->used_model->_count('van');
        $data['count_truck'] = $this->used_model->_count('truck');

        $this->load->view('header', $data);
        $this->load->view('used/aboutus', $data);
        $this->load->view('footer', $data);
    }

    public function signup()
    {
        $data['phone_number'] = '01707 283426';

        $data['title'] = 'Used Mercedes-Benz Commercial Vehicles';
//        $data['meta']['description'] = 'Approved Used Mercedes-Benz Commercial Vehicles in North London, Herts & Essex. Buy a Used Vito or Used Mercedes Sprinter online, or contact S & B Commercials to test drive a Used Mercedes Van.';

        // needed?
        $data['categorys'] = $this->used_model->get_categorys();
        $data['models'] = $this->used_model->get_models();
        $data['count_van'] = $this->used_model->_count('van');
        $data['count_truck'] = $this->used_model->_count('truck');

        $this->load->view('header', $data);
        $this->load->view('used/signup', $data);
        $this->load->view('footer', $data);
    }
    public function contact()
    {
        $data['phone_number'] = '01707 283426';

        $data['title'] = 'Used Mercedes-Benz Commercial Vehicles';
//        $data['meta']['description'] = 'Approved Used Mercedes-Benz Commercial Vehicles in North London, Herts & Essex. Buy a Used Vito or Used Mercedes Sprinter online, or contact S & B Commercials to test drive a Used Mercedes Van.';

        // needed?
        $data['categorys'] = $this->used_model->get_categorys();
        $data['models'] = $this->used_model->get_models();
        $data['count_van'] = $this->used_model->_count('van');
        $data['count_truck'] = $this->used_model->_count('truck');

        $this->load->view('header', $data);
        $this->load->view('used/contact', $data);
        $this->load->view('footer', $data);
    }

    public function stocklist()
    {
        $data['vehicles'] = $this->used_model->get_vehicles('used', 0, 0, 0, 1);
       // $this->load->view('used/stocklist.old.php', $data);
        $this->load->view('used/stocklist', $data);
    }

    public function vehicle($id = NULL)
    {
        $data['phone_number'] = '01707 283426';

        $id = explode("-", $id);
        $id = $id[0];

        if(preg_replace('/[^0-9]/', '', $id))
            $data['vehicle'] = $this->used_model->get_vehicles('used', 0, $id);

        if(empty($data['vehicle']) || $id == NULL)
        {
            show_404();
        }

        if($data['vehicle']['category'] == 'truck')
        {
            $data['phone_number'] = '01708 892515';
        }

        $data['addr'] = 'mercedes/used/v/' . $data['vehicle']['id'] . '-' . $data['vehicle']['model_addr'] . '_';
        $data['addr'] .= (!empty($data['vehicle']['categorys'][0]['addr'])) ? $data['vehicle']['categorys'][0]['addr'] : '';

        $data['livechat'] = 1;

        $data['inline_modal'] = $this->load->view('used/vehicle_modal', $data, true);
        $data['inline_javascript'] = $this->load->view('used/vehicle_inline_js', $data, true);

        $this->load->view('header', $data);
        $this->load->view('used/vehicle', $data);
        $this->load->view('footer', $data);
    }

    public function footer_submit($form, $vehicle_id) {

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $vehicle_id = preg_replace('/[^0-9]/', '', $vehicle_id);

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
                $this->used_model->post_footer_submit($form);
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Your request has been sent to our contact team. We look forward to speaking to you.'
                    )
                );
            }
            redirect('mercedes/used/v/' . $vehicle_id);
            exit();
        }

    }

    /*
     * Cart function
     * $action:
     *    1 = Buy Now
     *    2 = Reserve
     *    3 = Bid
     */
    public function cart($action = NULL, $id = NULL)
    {
        $data['phone_number'] = '01707 283426';

        if($action !== NULL && $id !== NULL)
        {
            // load basket from address and save to session
            $data['order'] = $this->used_model->get_product_info($action . '_' . $id);
            if($data['order'] != NULL)
                $this->session->set_userdata(array('basket' => $action . '_' . $id));
        }
        else
        {
            $data['order'] = $this->used_model->get_product_info($this->session->userdata('basket'));
        }

        if($data['order'] == NULL)
            show_404();

        $this->load->view('header', $data);
        $this->load->view('used/order', $data);
        $this->load->view('footer', $data);
    }

    /*
     * Page after cart, process
     */
    public function process()
    {
        $data['order'] = $this->used_model->get_product_info($this->session->userdata('basket'));

        if($data['order'] == NULL)
        {
            $this->session->set_flashdata('error', 'Your session has expired due to inactivity.');
            redirect('/mercedes/used/');
            exit();
        }

        $log = $this->used_model->process_order($data);

        // if successful the process_order() will redirect to SagePay
        // Otherwise it will return an error ($log)
        $this->session->set_flashdata('error', $log);
        redirect('mercedes/used/cart');
    }

    /*
     * Bid POST
     */
    public function bid($id = NULL)
    {
        $data['phone_number'] = '01707 283426';

        $data['vehicle'] = $this->used_model->get_vehicles('used', 0, $id);

        if($id == NULL || empty($data['vehicle']))
            show_404();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

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
            redirect('/mercedes/used/v/' . $data['vehicle']['id']);
            exit();
		}
		else
		{
            // past validation, is the offer more then 50%?
            $fifty_percent = $data['vehicle']['price'] / 2;
            if($this->input->post('number') > $fifty_percent)
            {
                $customer_url = $this->used_model->post_bid($data['vehicle']['id']);
                $this->session->set_flashdata('alert', array(
                    'type' => 'success',
                    'message' => 'Your bid has been sent to our sales team. We will repond shortly via the email address you provided.'
                    )
                );
                redirect('/mercedes/used/v/' . $data['vehicle']['id'] . "/" . $customer_url);
            }
            else
            {
                $this->session->set_flashdata('alert', array(
                    'type' => 'danger',
                    'message' => 'Bid declined, we will only accept serious offers!'
                    )
                );
                redirect('/mercedes/used/v/' . $data['vehicle']['id']);
            }
        }
    }
    /*
     * Bid Response is used by sales admin for accept/reject/suggest
     * Accepts/Rejects goto /bidresponse/$admin_url/[accept,decline]/
     * Suggests get posted to /bidresponse/$admin_url/
     */
    public function bidresponse($admin_url = NULL, $response = NULL)
    {
        $data['phone_number'] = '01707 283426';

        $data['bid'] = $this->used_model->get_bid(array('admin_url' => $admin_url));

        if($admin_url == NULL || empty($data['bid']))
            show_404();

        // Deal with accepts or declines
        if($response == 'accept' || $response == 'decline' || $response == 'suggested')
        {
            $this->used_model->bid_response($admin_url, $response);
            redirect('mercedes/used/bidresponse/' . $admin_url);
        }

        $this->load->view('used/bid/response', $data);
    }
    /*
     * Bid Notification is used for showing the customer the accept/declined
     * answer from sales admin. Customer can the reserve online.
     */
    public function bidnotify($customer_url = NULL)
    {
        $data['phone_number'] = '01707 283426';

        $data['bid'] = $this->used_model->get_bid(array('customer_url' => $customer_url));

        if($customer_url == NULL || empty($data['bid']))
            show_404();

        $page_data = $this->used_model->bid_notification_data($data['bid']);
        $this->session->set_flashdata('alert', $page_data['alert']);
        // fix for first view, flash data not working as its the next page
        $data['alert'] = $page_data['alert'];

        // if no vehicle then move to index page
        if($page_data['page'] == 'bid/notify_no_vehicle')
            redirect('mercedes/used');

        $data['vehicle'] = $data['bid']['vehicle'];

        $data['livechat'] = 1;

        $data['inline_modal'] = $this->load->view('used/vehicle_modal', $data, true);
        $data['inline_javascript'] = $this->load->view('used/vehicle_inline_js', $data, true);

        $this->load->view('header', $data);
        $this->load->view('used/' . $page_data['page'], $data);
        $this->load->view('footer', $data);
    }

    /*
     * call me request POST
     */
    public function callme($id = NULL)
    {
        $data['vehicle'] = $this->used_model->get_vehicles('used', 0, $id);

        if($id == NULL || empty($data['vehicle']))
            show_404();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('number', 'Number', 'required');

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
            redirect('/mercedes/used/v/' . $data['vehicle']['id']);
            exit();
		}
		else
		{
            $this->used_model->post_callme($data['vehicle']['reg']);
            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Your call me request has been sent to our sales team. We look forward to speaking to you.'
                )
            );
            $this->session->set_flashdata('analytics', array(
                'code' => '<!-- Google Code for Used: call me request Conversion Page -->
                    <script type="text/javascript">
                    /* <![CDATA[ */
                    var google_conversion_id = 1034243379;
                    var google_conversion_language = "en";
                    var google_conversion_format = "3";
                    var google_conversion_color = "ffffff";
                    var google_conversion_label = "OPZ0CK_ggwcQs5qV7QM";
                    var google_conversion_value = 0;
                    /* ]]> */
                    </script>
                    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
                    </script>
                    <noscript>
                    <div style="display:inline;">
                    <img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/1034243379/?value=0&amp;label=OPZ0CK_ggwcQs5qV7QM&amp;guid=ON&amp;script=0"/>
                    </div>
                    </noscript>'
                )
            );
            redirect('/mercedes/used/v/' . $data['vehicle']['id']);
        }
    }

    /*
     * newsletter request POST
      /signup
     */
    public function signuppost()
    {

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

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
            $data = array(
               'date' => date('Y-m-d H:i:s'),
               'name' => $this->input->post('name'),
               'company_name' => $this->input->post('company_name'),
               'email' => $this->input->post('email')
            );
            $this->db->insert('vehicles_signups', $data); 

            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Thankyou for signing up to our newsletter.'
                )
            );
        }
        redirect('/mercedes/used/signup');
    }

    /*
     */
    public function contactpost()
    {

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');

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
            $data = array(
               'date' => date('Y-m-d H:i:s'),
               'name' => $this->input->post('name'),
               'company_name' => $this->input->post('company_name'),
               'phone' => $this->input->post('phone_number'),
               'email' => $this->input->post('email'),
               'enquiry' => $this->input->post('enquiry')
            );
            $this->db->insert('vehicles_contact', $data); 

            $this->session->set_flashdata('alert', array(
                'type' => 'success',
                'message' => 'Thankyou for your enquiry.'
                )
            );
        }
        redirect('/mercedes/used/contact');
    }

    public function sellitdearer()
    {
        $vehicles = $this->used_model->get_vehicles('used', 0, 0, 0, 1);
        // put the view in the controller, i've only got 20 minutes...
        echo "<table><tr>
            <th>Reg No</th>
            <th>Model</th>
            <th>Model Description</th>
            <th>Price</th>
            <th>Days In Stock</th>
            <th>Views</th>
            <th>Av. Views/Week</th>
            </tr>";
        
        foreach($vehicles as $vehicle)
        {
            $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
            $now = date("Y-m-d");
            
            $days_online = round((abs(strtotime($now) - strtotime($date_added))) / (60*60*24));

            if($date_added > date("Y-m-d", strtotime("2013-07-02")) )
            {
                $diff = abs(strtotime($now) - strtotime($date_added));

                $days = floor($diff / (60*60*24));
                $weeks = $days / 7;
                $awv = round($vehicle['pageviews'] / $weeks);
            }
            else
            {
                $diff = abs(strtotime($now) - strtotime(date("2013-07-02")) );

                
                $days = floor($diff / (60*60*24));
                $weeks = $days / 7;
                $awv = round($vehicle['pageviews'] / $weeks);
            }

            if($awv > 100 && $days_online > 60)
            {
                echo "<tr class='ohshit'>";
            }
            else 
            {
                echo "<tr>";
            }

            echo "
                <td>" . $vehicle['reg'] . "</td>
                <td>" . $vehicle['model'] . "</td>
                <td>" . $vehicle['model_description'] . "</td>
                <td>" . $vehicle['price'] . "</td>
                <td>" . $days_online . "</td>
                <td>" . $vehicle['pageviews'] . "</td>
                <td>" . $awv . "</td>
                </tr>";
        }
        echo "</table>

      <style type=\"text/css\" media=\"all\">
        body { background-color: black; font-family: courier; }
        table { color: limegreen; }
        table td { padding: 3px; padding-right: 30px; }
        table tr.ohshit { color: red; }
      </style>";


        
    }

    public function trevorsellitdearer($report = NULL)
    {
        if($report === NULL)
        {
            echo '
                <p>
                <a href="/mercedes/used/trevorsellitdearer/vehicles_callme">vehicle call me requests</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_bids">vehicle bids</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_contact">contact form submits</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_newsletter">newsletter signups</a><br /><br />

                <a href="/mercedes/used/trevorsellitdearer/parts_offers">Parts Tyre Offer (coupons)</a>
                </p>
                <p>New Used Reports (16/12/13)<br><br>
                <a href="/mercedes/used/trevorsellitdearer/vehicles_all_unsold">All unsold</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_exdemo_unsold">Exdemo unsold</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_vito_unsold">Vito unsold</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_sprinter_unsold">Sprinter unsold</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_truck_unsold">Truck unsold</a><br />
                <br>
                <a href="/mercedes/used/trevorsellitdearer/vehicles_all_sold">All sold</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_exdemo_sold">Exdemo sold</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_vito_sold">Vito sold</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_sprinter_sold">Sprinter sold</a><br />
                <a href="/mercedes/used/trevorsellitdearer/vehicles_truck_sold">Truck sold</a><br />
                </p>
                <p>IT USE ONLY<br><br>
                <a href="/mercedes/used/trevorsellitdearer/service_invoiced">Invoiced</a><br />
                <a href="/mercedes/used/trevorsellitdearer/service_authorised">Authorised</a><br />
                <a href="/mercedes/used/trevorsellitdearer/service_resolved">Resolved</a><br />
                <a href="/mercedes/used/trevorsellitdearer/service_queried">Queried</a><br />
                </p>
                ';
        }
        else
        {
            /*
             * 1 Vito
	         * 2 Sprinter
             * 3 Vario
             * 4 Actros
             * 5 Axor
             * 6 Atego
             * 7 Econic
             * 8 Canter
             */                
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=file.csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            $column_names = array();
            switch($report)
            {
            case 'vehicles_all_unsold':
                $sql = "SELECT id, reg, date_added, model_id, model_description, price, ga_unique_pageviews,
                    CASE
                        WHEN (model_id = 1) THEN 'Vito'
                        WHEN (model_id = 2) THEN 'Sprinter'
                        WHEN (model_id >= 3) THEN 'Truck'
                    END as category
                    FROM vehicles_index WHERE sold = 0";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $now = date("Y-m-d");
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $vehicle['category'],
                        $vehicle['model_description'],
                        round((abs(strtotime($now) - strtotime($date_added))) / (60*60*24)),
                        $vehicle['price'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'category',
                    'model_description',
                    'days_advertised',
                    'price',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_vito_unsold':
                $sql = "SELECT id, reg, date_added, model_id, model_description, price, ga_unique_pageviews
                    FROM vehicles_index WHERE sold = 0 && model_id = 1";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $now = date("Y-m-d");
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $vehicle['model_description'],
                        round((abs(strtotime($now) - strtotime($date_added))) / (60*60*24)),
                        $vehicle['price'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'model_description',
                    'days_advertised',
                    'price',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_sprinter_unsold':
                $sql = "SELECT id, reg, date_added, model_id, model_description, price, ga_unique_pageviews
                    FROM vehicles_index WHERE sold = 0 && model_id = 2";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $now = date("Y-m-d");
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $vehicle['model_description'],
                        round((abs(strtotime($now) - strtotime($date_added))) / (60*60*24)),
                        $vehicle['price'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'model_description',
                    'days_advertised',
                    'price',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_exdemo_unsold':
                $sql = "SELECT id, reg, date_added, model_id, model_description, price, ga_unique_pageviews,
                    CASE
                        WHEN (model_id = 1) THEN 'Vito'
                        WHEN (model_id = 2) THEN 'Sprinter'
                        WHEN (model_id >= 3) THEN 'Truck'
                    END as category
                    FROM vehicles_index WHERE sold = 0 && exdemonstrator = 1";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $now = date("Y-m-d");
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $vehicle['category'],
                        $vehicle['model_description'],
                        round((abs(strtotime($now) - strtotime($date_added))) / (60*60*24)),
                        $vehicle['price'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'category',
                    'model_description',
                    'days_advertised',
                    'price',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_truck_unsold':
                $sql = "SELECT id, reg, date_added, model_id, model_description, price, ga_unique_pageviews,
                    CASE
                        WHEN (model_id = 3) THEN 'Vario'
                        WHEN (model_id = 4) THEN 'Actros'
                        WHEN (model_id = 5) THEN 'Axor'
                        WHEN (model_id = 6) THEN 'Atego'
                        WHEN (model_id = 7) THEN 'Econic'
                        WHEN (model_id = 8) THEN 'Canter'
                    END as category
                    FROM vehicles_index WHERE sold = 0 && model_id >= 3";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $now = date("Y-m-d");
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $vehicle['category'],
                        $vehicle['model_description'],
                        round((abs(strtotime($now) - strtotime($date_added))) / (60*60*24)),
                        $vehicle['price'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'model',
                    'model_description',
                    'days_advertised',
                    'price',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_all_sold':
                $sql = "SELECT id, reg, date_added, date_sold, model_id, model_description, price as price_advertised, sold_price as price_sold, ga_unique_pageviews,
                    CASE
                        WHEN (model_id = 1) THEN 'Vito'
                        WHEN (model_id = 2) THEN 'Sprinter'
                        WHEN (model_id >= 3) THEN 'Truck'
                    END as category
                    FROM vehicles_index WHERE sold = 1 AND date_sold >= NOW() - INTERVAL 3 MONTH";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $date_sold = date("Y-m-d", strtotime($vehicle['date_sold']));
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $date_sold,
                        $vehicle['category'],
                        $vehicle['model_description'],
                        round((abs(strtotime($date_added) - strtotime($date_sold))) / (60*60*24)),
                        $vehicle['price_advertised'],
                        $vehicle['price_sold'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'date_sold',
                    'category',
                    'model_description',
                    'days_advertised',
                    'price_advertised',
                    'price_sold',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_vito_sold':
                $sql = "SELECT id, reg, date_added, date_sold, model_id, model_description, price as price_advertised, sold_price as price_sold, ga_unique_pageviews
                    FROM vehicles_index WHERE sold = 1 AND model_id= 1 AND date_sold >= NOW() - INTERVAL 3 MONTH";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $date_sold = date("Y-m-d", strtotime($vehicle['date_sold']));
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $date_sold,
                        $vehicle['model_description'],
                        round((abs(strtotime($date_added) - strtotime($date_sold))) / (60*60*24)),
                        $vehicle['price_advertised'],
                        $vehicle['price_sold'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'date_sold',
                    'model_description',
                    'days_advertised',
                    'price_advertised',
                    'price_sold',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_sprinter_sold':
                $sql = "SELECT id, reg, date_added, date_sold, model_id, model_description, price as price_advertised, sold_price as price_sold, ga_unique_pageviews
                    FROM vehicles_index WHERE sold = 1 AND model_id= 2 AND date_sold >= NOW() - INTERVAL 3 MONTH";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $date_sold = date("Y-m-d", strtotime($vehicle['date_sold']));
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $date_sold,
                        $vehicle['model_description'],
                        round((abs(strtotime($date_added) - strtotime($date_sold))) / (60*60*24)),
                        $vehicle['price_advertised'],
                        $vehicle['price_sold'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'date_sold',
                    'model_description',
                    'days_advertised',
                    'price_advertised',
                    'price_sold',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_exdemo_sold':
                $sql = "SELECT id, reg, date_added, date_sold, model_id, model_description, price as price_advertised, sold_price as price_sold, ga_unique_pageviews,
                    CASE
                        WHEN (model_id = 1) THEN 'Vito'
                        WHEN (model_id = 2) THEN 'Sprinter'
                        WHEN (model_id >= 3) THEN 'Truck'
                    END as category
                    FROM vehicles_index WHERE sold = 1 AND exdemonstrator = 1 AND date_sold >= NOW() - INTERVAL 3 MONTH";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $date_sold = date("Y-m-d", strtotime($vehicle['date_sold']));
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $date_sold,
                        $vehicle['category'],
                        $vehicle['model_description'],
                        round((abs(strtotime($date_added) - strtotime($date_sold))) / (60*60*24)),
                        $vehicle['price_advertised'],
                        $vehicle['price_sold'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'date_sold',
                    'category',
                    'model_description',
                    'days_advertised',
                    'price_advertised',
                    'price_sold',
                    'ga_unique_pageviews'
                );
                break;
            case 'vehicles_truck_sold':
                $sql = "SELECT id, reg, date_added, date_sold, model_id, model_description, price as price_advertised, sold_price as price_sold, ga_unique_pageviews,
                    CASE
                        WHEN (model_id = 3) THEN 'Vario'
                        WHEN (model_id = 4) THEN 'Actros'
                        WHEN (model_id = 5) THEN 'Axor'
                        WHEN (model_id = 6) THEN 'Atego'
                        WHEN (model_id = 7) THEN 'Econic'
                        WHEN (model_id = 8) THEN 'Canter'
                    END as category
                    FROM vehicles_index WHERE sold = 1 AND model_id >= 3 AND date_sold >= NOW() - INTERVAL 3 MONTH";
                $vehicles = $this->db->query($sql)->result_array();
                $data = array();
                foreach($vehicles as $vehicle)
                {
                    $date_added = date("Y-m-d", strtotime($vehicle['date_added']));
                    $date_sold = date("Y-m-d", strtotime($vehicle['date_sold']));
                    $data[] = array(
                        $vehicle['id'],
                        $vehicle['reg'],
                        $date_added,
                        $date_sold,
                        $vehicle['category'],
                        $vehicle['model_description'],
                        round((abs(strtotime($date_added) - strtotime($date_sold))) / (60*60*24)),
                        $vehicle['price_advertised'],
                        $vehicle['price_sold'],
                        $vehicle['ga_unique_pageviews']
                    );
                }
                $column_names = array(
                    'id',
                    'reg',
                    'date_added',
                    'date_sold',
                    'category',
                    'model_description',
                    'days_advertised',
                    'price_advertised',
                    'price_sold',
                    'ga_unique_pageviews'
                );
                break;
            case 'parts_offers':
                $table = 'parts_offers';
                $data = $this->db->get('parts_offers')->result_array();
                break;
            case 'vehicles_callme':
                $table = 'vehicles_callme';
                $data = $this->db->get('vehicles_callme')->result_array();
                break;
            case 'vehicles_bids':
                $table = 'vehicles_bids';
                $data = $this->db->get('vehicles_bids')->result_array();
                break;
            case 'vehicles_contact':
                $table = 'vehicles_contact';
                $data = $this->db->get('vehicles_contact')->result_array();
                break;
            case 'vehicles_newsletter':
                $table = 'vehicles_newsletter';
                $data = $this->db->get('vehicles_newsletter')->result_array();
                break;
            case 'service_invoiced':
                $dbh = new PDO('mysql:host=localhost;dbname=sbdb', 'root', 'kayleigh182.');
                $sql = "SELECT * FROM `service_invoices` WHERE `status` = 1 AND `company_id` = 1";
                $data = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                $q = $dbh->prepare("DESCRIBE `service_invoices`");
                $q->execute();
                $column_names = $q->fetchAll(PDO::FETCH_COLUMN);

                break;
            case 'service_authorised':
                $dbh = new PDO('mysql:host=localhost;dbname=sbdb', 'root', 'kayleigh182.');
                $sql = "SELECT * FROM `service_invoices` WHERE `status` = 5 AND `company_id` = 1";
                $data = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);

                $q = $dbh->prepare("DESCRIBE `service_invoices`");
                $q->execute();
                $column_names = $q->fetchAll(PDO::FETCH_COLUMN);

                break;
            case 'service_resolved':
                $dbh = new PDO('mysql:host=localhost;dbname=sbdb', 'root', 'kayleigh182.');
                $sql = "SELECT * FROM `service_invoices` WHERE `status` = 3 AND `company_id` = 1";
                $data = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as &$date_line)
                {
                    $sql = "SELECT `datetime` FROM `service_invoice_queries` WHERE `service_invoice_id` = " . $date_line['id'] . " AND `response` = 1 ORDER BY `datetime` LIMIT 1";
                    $row = $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);
                    $date_line['date_responded'] = $row['datetime'];
                }

                $q = $dbh->prepare("DESCRIBE `service_invoices`");
                $q->execute();
                $column_names = $q->fetchAll(PDO::FETCH_COLUMN);
                $column_names[] = 'date_resolved';

                break;
            case 'service_queried':
                $dbh = new PDO('mysql:host=localhost;dbname=sbdb', 'root', 'kayleigh182.');
                $sql = "SELECT * FROM `service_invoices` WHERE `status` = 2 AND `company_id` = 1";
                $data = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                foreach($data as &$date_line)
                {
                    $sql = "SELECT `datetime` FROM `service_invoice_queries` WHERE `service_invoice_id` = " . $date_line['id'] . " AND `response` = 0 ORDER BY `datetime` DESC LIMIT 1";
                    $row = $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);
                    $date_line['date_responded'] = $row['datetime'];
                }

                $q = $dbh->prepare("DESCRIBE `service_invoices`");
                $q->execute();
                $column_names = $q->fetchAll(PDO::FETCH_COLUMN);
                $column_names[] = 'date_last_queried';

                break;
            }

            if(empty($column_names))
            {
                $fields = $this->db->list_fields($table);
                foreach ($fields as $field)
                {
                   $column_names[] = $field;
                }
                $column_names[] = 'report_description';
            }
            array_unshift($data, $column_names);
            $this->used_model->outputCSV($data);
        }
    }

    public function exdemonstrators()
    {
        $data['phone_number'] = '01707 283426';

        $data['title'] = 'Ex demonstrators Mercedes-Benz';

        $data['livechat'] = 1;

        $data['meta']['description'] = 'At S & B Commercials we have a large range of ex demonstrator Mercedes-Bens vans at our sites in Welham Green, Thurrock and Stansted.';
        $data['vehicles'] = $this->used_model->get_vehicles('used', 0, 0, 0, 0, 1);

        /*
        $data['categorys'] = $this->used_model->get_categorys();
        $data['models'] = $this->used_model->get_models();
        $data['count_van'] = $this->used_model->_count('van');
        $data['count_truck'] = $this->used_model->_count('truck');
         */

        $this->load->view('header', $data);
        $this->load->view('used/exdemonstrators', $data);
        $this->load->view('footer', $data);
    }

}
//EOF
