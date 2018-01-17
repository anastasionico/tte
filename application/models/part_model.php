<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Part_model extends CI_Model {

    function get($id)
    {
        $part = $this->db
            ->get_where('parts_store_index', array('id' => $id, 'availability' => 1), 1)
            ->row_array();
        if($part['group'] > 0) {
            $part['group'] = $this->db
                ->get_where('parts_store_groups', array('id' => $part['group']), 1)
                ->row_array();
        }
        $vat = $part['price'] * $this->config->item('vat');
        $part['price_vat'] = number_format($part['price'] + $vat, 2, '.', '');

        return $part;
    }
    public function getAll(){
        return $group = $this->db
                    ->where('availability', 1)
                    ->get('parts_store_index')
                    ->result_array();
        }
    
    function get_by_model($vehicle_vin, $model, $group = 0)
    {
        $vehicle = $this->get_vehicle($vehicle_vin, $model);

        $sql = "SELECT parts_store_index.*, parts_store_groups.name as group_name, parts_store_groups.addr as group_addr FROM parts_store_index
            JOIN parts_store_vehicle_parts on parts_store_index.id = parts_store_vehicle_parts.part_id
            JOIN parts_store_groups on parts_store_index.group = parts_store_groups.id
            WHERE parts_store_vehicle_parts.vehicle_id = ?";

        return $this->db
            ->query($sql, array($vehicle['id']))
            ->result_array();
    }

    function get_by_model_group($vehicle_vin, $model, $group_id)
    {
        $vehicle = $this->get_vehicle($vehicle_vin, $model);

        $sql = "SELECT parts_store_index.*, parts_store_groups.name as group_name, parts_store_groups.addr as group_addr FROM parts_store_index
            JOIN parts_store_vehicle_parts on parts_store_index.id = parts_store_vehicle_parts.part_id
            JOIN parts_store_groups on parts_store_index.group = parts_store_groups.id
            WHERE parts_store_vehicle_parts.vehicle_id = ? AND parts_store_index.group = ?";

        return $this->db
            ->query($sql, array($vehicle['id'], $group_id))
            ->result_array();
    }

    function get_groups_from_parts($parts)
    {
        $group_ids = array();
        $groups = array();

        foreach($parts as $part)
        {
            if(in_array($part['group'], $group_ids) == FALSE)
            {
                $group = $this->db
                    ->where('id', $part['group'])
                    ->get('parts_store_groups')
                    ->row_array();

                $group_ids[] = $group['id'];
                $groups[$group['id']] = $group;
            }
        }

        return $groups;
    }
    public function getSimilarItems($group,$pnumber){
        return $this->db->query("
            SELECT * 
            FROM parts_store_index 
            WHERE parts_store_index.group = $group
            AND parts_store_index.pnumber <> '$pnumber'
            LIMIT 5
            ")->result_array();    
        //die( var_dump($this->db->last_query())); */
        
    }
    
    /*
     * This function is used alongside the REG lookup to determine if we stock
     * parts for their vehicle.
     */
    function get_vehicle($vin_three, $model, $year = 0) {
        // Get the vehicles that i can add part to 
        $sql = "SELECT * FROM `parts_store_vehicles` WHERE `vehicle_vin` = ? AND `model` = ? LIMIT 1";

        if($year !== 0) {
            // bodge new sprinter 
            if($vin_three == 906 && $year >= 2013)
                $vin_three = 999;
            // bodge new vito
            if($vin_three == 639 && $year >= 2015)
                $vin_three = 777;
        }

        $vehicle = $this->db
            ->query($sql, array($vin_three, $model))
            ->row_array();

        if($vehicle) {
            $vehicle['url'] = $this->part_url_vin($vehicle['vehicle_vin']) . '/' . $vehicle['model'];
            return $vehicle;
        }
        else {
            return NULL;
        }
    }

    function get_vehicles()
    {
        $vehicles = $this->db
            ->query("SELECT * FROM `parts_store_vehicles` WHERE `vehicle_vin` != 0 ORDER BY `vehicle_order`") // vehicle_vin != 0 gets rid of accessories
            ->result_array();

        foreach($vehicles as &$vehicle) {
            $vehicle['url'] = $this->part_url_vin($vehicle['vehicle_vin']) . '/' . $vehicle['model'];
        }

        return $vehicles;
    }

    /*
     * Adds posted part items to cart library
     */
    function checkout()
    {
        $this->load->library('cart');
        $cart_data = array();

        foreach($this->input->post() as $name => $value)
        {
            if(substr($name, 0, 4) == "part")
            {
                $input_id = explode('_', $name);
                $part_id = $input_id[1];// validate?
                $part = $this->get($part_id);

                if($part) {
                    $cart_data[] = array(
                        'id'      => $part['id'], 
                        'qty'     => $value, // validate?
                        'price'   => $part['price'], // only pricewatch?
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

        return TRUE;
    }

    /*
     * Updates checkout quantitys
     */
    function update_checkout()
    {
        $this->load->library('cart');
        $cart_data = array();

        foreach($this->input->post() as $name => $value)
        {
            if(substr($name, 0, 3) == "row")
            {
                list( , $row_no) = explode('_', $name);

                $cart_data[] = array(
                    'rowid'   => $this->input->post('row_' . $row_no),
                    'qty'     => $this->input->post('qty_' . $row_no),
                );
            }
        }

        $this->cart->update($cart_data);

        return TRUE;
    }

    /*
     * Process the order with sagepay
     */
    public function process_order()
    {
        // validaiton
        $mandatory_fields = array(
            'BillingFirstnames',
            'BillingSurname',
            'BillingAddress1',
            'BillingCity',
            'BillingPostCode',
            'BillingCountry',
            'BillingPhone',
            'CustomerEmail',
        );
        if($this->input->post('IsDeliverySame') != 'on') {
            $mandatory_fields = array_merge($mandatory_fields, array(
                'DeliveryFirstnames',
                'DeliverySurname',
                'DeliveryAddress1',
                'DeliveryCity',
                'DeliveryPostCode',
                'DeliveryCountry',
            ));
        }
        $error_fields = array();
        foreach($mandatory_fields as $field_name) {
            $value = $this->input->post($field_name);
            if(empty($value)) $error_fields[] = $field_name;
        }
        if(! empty($error_fields)) {
            $this->session->set_flashdata('error_fields', $error_fields);
            return 'Error, you need must fill in all of the required fields.';
        }
        // end of validation

        $this->load->library('sagepay_server');
        $this->load->model('sagepay_server_model');
        // You can create the VendorTXCode in a different way (e.g. db autoincrement) long as the VendorTxCode MUST be unique for 
        // each transaction you send to Sage Pay Server
        $VendorTxCode = $this->sagepay_server->create_vendor_tx_code();

        $part_order = array(
            'VendorTxCode' => $VendorTxCode,
            'date' => date("Y-m-d H:i:s"),
            'reg' => $this->input->post('reg'),
            'dispatch' => 0,
        );
        $this->db->insert('parts_store_orders', $part_order);
        $row_id = $this->db->insert_id();

        $this->load->library('cart');
        foreach ($this->cart->contents() as $item) {
            $part = $this->get($item['id']);
            // if somethings wrong return

            $this->db->insert('parts_store_orders_items', array(
                'order_id' => $row_id,
                'part_id' => $part['id'],
                'price' => $part['price'],
                'quantity' => $item['qty'],
            ));
        }

        $amount = $this->cart->format_number($this->cart->total());
        $vat = $amount * $this->config->item('vat');
        $amount = $this->cart->format_number($amount + $vat);

        // Lets create the transaction
        $this->sagepay_server->set_field('Amount', $amount); // with 2 decimal places where relevant
        $this->sagepay_server->set_field('Currency', 'GBP'); // Optional. Uses value in config if not set.
        $this->sagepay_server->set_field('Description', 'Mercedes-Benz Parts'); // Description of purchase displayed on the Sage Pay Max 100

        // Billing address
        $this->sagepay_server->set_field('BillingFirstnames', $this->input->post('BillingFirstnames')); // Max 20 characters
        $this->sagepay_server->set_field('BillingSurname', $this->input->post('BillingSurname')); // Max 20 characters
        $this->sagepay_server->set_field('BillingAddress1', $this->input->post('BillingAddress1')); // Max 100 characters
        $this->sagepay_server->set_field('BillingAddress2', $this->input->post('BillingAddress2')); // Optional Max 100 characters
        $this->sagepay_server->set_field('BillingCity', $this->input->post('BillingCity')); // Max 40 characters
        $this->sagepay_server->set_field('BillingPostCode', $this->input->post('BillingPostCode')); // Max 10 characters
        $this->sagepay_server->set_field('BillingCountry', $this->input->post('BillingCountry')); // 2 characters ISO 3166-1 country code
        $this->sagepay_server->set_field('BillingPhone', $this->input->post('BillingPhone')); // Optional Max 20 characters
        $this->sagepay_server->set_field('CustomerEmail', $this->input->post('CustomerEmail')); // Optional Max 255 characters
		$this->sagepay_server->set_field('BillingState', ""); // US customers only Max 2 characters State code

        if($this->input->post('IsDeliverySame') == 'on') {
            $this->sagepay_server->set_same_delivery_address();
        }
        else {
            // Can be the same as billing  
            $this->sagepay_server->set_field('DeliveryFirstnames', $this->input->post('DeliveryFirstnames')); // Max 20 characters
            $this->sagepay_server->set_field('DeliverySurname', $this->input->post('DeliverySurname')); // Max 20 characters
            $this->sagepay_server->set_field('DeliveryAddress1', $this->input->post('DeliveryAddress1')); // Max 100 characters
            $this->sagepay_server->set_field('DeliveryAddress2', $this->input->post('DeliveryAddress2')); // Optional Max 100 characters
            $this->sagepay_server->set_field('DeliveryCity', $this->input->post('DeliveryCity')); // Max 40 characters
            $this->sagepay_server->set_field('DeliveryPostCode', $this->input->post('DeliveryPostCode')); // Max 10 characters
            $this->sagepay_server->set_field('DeliveryCountry', $this->input->post('DeliveryCountry')); // 2 characters ISO 3166-1 country code
            $this->sagepay_server->set_field('DeliveryState', ""); // US customers only Max 2 characters State code
            $this->sagepay_server->set_field('DeliveryPhone', ""); // Optional Max 20 characters
        }

        /** Now POST the data to Sage Pay
        *** Data is posted to purchaseurl which is set depending on whether you are using SIMULATOR, TEST or LIVE **/
        $sagepay_response = $this->sagepay_server->new_transaction($VendorTxCode, 'payment', 'parts');;
        $this->sagepay_server->process_transaction_response($sagepay_response);

        // if successful the process_response() will redirect to SagePay.
        // Otherwise redirect to a failure page
        redirect('transaction_status/failed/003');

    } // process

    function part_url_vin($vin_three)
    {
        switch($vin_three) {
        case '415':
            return '415-citan';
            break;
        case '638':
            return '638-vito';
            break;
        case '639':
            return '639-vito';
            break;
        case '901':
        case '902':
        case '903':
        case '904':
        case '905':
            return '901-sprinter';
            break;
        case '906':
            return '906-sprinter';
            break;
        // temporary
        case '777':
            return '777-vito';
            break;
        case '999':
            return '999-sprinter';
            break;
        }
    }

    public function search($pnumber)
    {
        $pnumber = strtoupper( preg_replace('/\s+/', '', $pnumber) );
        // sometimes staff put 'm' infront of part numbers.
        $pnumber = (substr($pnumber, 0, 1) == 'M') ? $pnumber = substr($pnumber, 1) : $pnumber;

        $row = $this->db
            ->query('SELECT `id` FROM `parts_store_index` WHERE `pnumber` = ? LIMIT 1', array($pnumber))
            ->row_array();

        return (isset($row['id'])) ? $row['id'] : NULL;
    }





    // these will need updating
    public function emailnote($to, $subject, $message) {
        $htmessage = "<html>
            <head>
            <title>" . $subject . "</title>
            </head>
            <body>
            " . $message . "
            </body>
            </html>";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers .= 'To: <' . $to . '>' . "\r\n"; // seems to duplicate
        $headers .= 'From: S&B Commercials PLC <iorder@sbcommercials.co.uk>' . "\r\n";

        mail($to, $subject, $htmessage, $headers);
        return;
    }
    public function post_footer_submit($form)
    {
        switch($form) {
        case 'call_back':
          $subject = 'Contact us: call back form submit';
          $message = 'URL : ' . $this->input->post('request_path') . '<br>';
          $message .= 'Page Section : ' . $this->input->post('request_page_section') . '<br>';
          $message .= 'Name : ' . $this->input->post('name') . '<br>';
          $message .= 'Number : ' . $this->input->post('number') . '<br>';
          $message .= 'Email : ' . $this->input->post('email') . '<br>';
          $message .= 'Message : ' . $this->input->post('message') . '<br>';
          break;
        case 'email':
          $subject = 'Contact us: email form submit';
          $message = 'URL : ' . $this->input->post('request_path') . '<br>';
          $message .= 'Page Section : ' . $this->input->post('request_page_section') . '<br>';
          $message .= 'Name : ' . $this->input->post('name') . '<br>';
          $message .= 'Email : ' . $this->input->post('email') . '<br>';
          $message .= 'Message : ' . $this->input->post('message') . '<br>';
          break;
        }

        if($this->input->post('honeypot') == '') { 
            $this->emailnote('enquiry@sbcommercials.co.uk', $subject, $message);
        }

        return TRUE;
    }

    function get_part_vehicles($part_id)
    {
        $vehicle = $this->get_vehicle($vehicle_vin, $model);

        $sql = "SELECT parts_store_vehicle_parts.*, parts_store_vehicles.* FROM parts_store_vehicle_parts
            JOIN parts_store_vehicles on parts_store_vehicle_parts.vehicle_id = parts_store_vehicles.id
            WHERE parts_store_vehicle_parts.part_id = ? ORDER BY parts_store_vehicle_parts.vehicle_id";

        return $this->db
            ->query($sql, array($part_id))
            ->result_array();
    }

    public function get_order($id)
    {
        $sql = "SELECT * FROM parts_store_orders
            INNER JOIN sagepay_payments ON parts_store_orders.VendorTxCode = sagepay_payments.VendorTxCode WHERE parts_store_orders.VendorTxCode = ? LIMIT 1";

        $order = $this->db
            ->query($sql, array($id))
            ->result_array();

        $order = $order[0];

        $query = $this->db->query("
            SELECT parts_store_orders_items.order_id, parts_store_orders_items.part_id, parts_store_orders_items.price, parts_store_orders_items.quantity, parts_store_index.pnumber, parts_store_index.title
            FROM parts_store_orders_items, parts_store_index
            WHERE parts_store_orders_items.order_id = '" . $order['id'] . "' AND parts_store_orders_items.part_id = parts_store_index.id");
        $order['items'] = $query->result_array();

        return $order;
    }
    function getPartbyModel($pnumber){
       $query = $this->db->query("
            select parts_store_index.*, parts_store_groups.addr, parts_store_groups.name 
            from parts_store_index 
            join parts_store_groups on parts_store_index.group = parts_store_groups.id
            where pnumber = '$pnumber' 
            ");
                        
        return $query->row_array();   
    }
    function set_order($amount, $newsLetter = null, $fastDelivery = false) {
        $order = array(
            'paid' => 0,
            'amt' => $amount,
            'newsLetter' => $newsLetter
        );
        $this->db->insert('orders', $order);    
        
        $order_id = $this->db->insert_id();

        $cart = $this->cart->contents();
        

        foreach ($cart as $item) {
            $data = array(
                'price' => $item['price'],
                'qty' => $item['qty'],
                'order_id' => $order_id,
                'name' => $item['name'],
                'item_id' => $item['id'],
                'subtotal' => $item['subtotal'],
            );
            $this->db->insert('order_items', $data);    
        }         
        if($fastDelivery === true){
            $data = array(
                'price' =>  7.9,
                'qty' => 1,
                'order_id' => $order_id,
                'name' => 'Fast Delivery',
                'item_id' => 0,
                'subtotal' => 7.9,
            );
            $this->db->insert('order_items', $data); 
        }




        return $order_id;
        
    }
    public function add_token($transaction_id, $token){
        $this->db
                ->where("id", $transaction_id)
                ->update('orders', array(
                    'token' => $token
                ));    
    }

    public function getPartByCategory($category, $group){
        //This function will look for a general research of parts. if the model name is in the url, look for all the parts of that model if there is no model in the url look for all the part of the selected manufacturer.
        if($group !== NULL){
            $query = $this->db->query("SELECT parts_store_index.* 
                                FROM parts_store_index
                                WHERE parts_store_index.group IN
                                        (SELECT parts_store_groups.id 
                                        FROM parts_store_groups 
                                        WHERE parts_store_groups.addr = '$group')
                                ");    
        }else{
            $query = $this->db->query("SELECT parts_store_index.*
                                FROM parts_store_index
                                JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group
                                WHERE (parts_store_groups.id IN (SELECT parts_store_groups.id FROM `parts_store_groups` 
                                WHERE addr='$category') ) 
                                OR (parts_store_groups.parent_id IN (SELECT parts_store_groups.id FROM `parts_store_groups` 
                                WHERE addr='$category'))
                                ");    
        }
        return $query->result_array();   
    }

    public function getOffers($limit = 5000){
        if( $limit == 5000){
            return $this->db
                ->where('offer IS NOT NULL', null, false)
                ->where('availability = 1')
                ->get('parts_store_index')
                ->result_array();
        }else{
            return $this->db->limit($limit)
                ->where('offer IS NOT NULL', null, false)
                ->where('homepage IS NOT NULL', null, false)
                ->where('availability = 1')
                ->order_by('homepage')
                ->get('parts_store_index')
                ->result_array();
        }
        
    }
    public function getOffersByGroup($group){
        return $this->db->query("
                SELECT parts_store_index.* 
                FROM parts_store_index
                JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group
                WHERE offer <> 0
                AND parts_store_groups.id = $group
            ")
            ->result_array();
    }

    public function getLatest($limit){
        if(!isset($limit)){
            return $this->db
                ->where('availability = 1')
                ->order_by("last_updated", "desc")
                ->get('parts_store_index')
                ->result_array();
        }else{
            return $this->db
                ->limit($limit)
                ->where('availability = 1')
                ->order_by("last_updated", "desc")
                ->get('parts_store_index')
                ->result_array();
        }
    }
    public function getLatestByGroup($group){
        return $this->db->query("
                SELECT parts_store_index.* 
                FROM parts_store_index
                JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group
                WHERE parts_store_groups.id = $group
                ORDER BY last_updated desc
            ")
            ->result_array();
    }
    
    
    public function getFeatured($limit){
        if(!isset($limit)){
            return $this->db
                ->where("featured <> 'null'")
                ->where('availability = 1')
                ->get('parts_store_index')
                ->result_array();
        }else{
            return $this->db
                ->limit($limit)
                ->where("featured <> 'null'")
                ->where('availability = 1')
                ->get('parts_store_index')
                ->result_array();
        }
    }
    public function getFeaturedByGroup($group){
        return $this->db->query("
                SELECT parts_store_index.* 
                FROM parts_store_index
                JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group
                WHERE featured = 1
                AND parts_store_groups.id = $group
            ")
            ->result_array();
    }

    public function getBestSeller($limit){
        if(!isset($limit)){
            return $this->db
                ->where('availability = 1')
                ->order_by("count_sold", "desc")
                ->get('parts_store_index')
                ->result_array();
        }else{
            return $this->db
                ->limit($limit)
                ->where('availability = 1')
                ->order_by("count_sold", "desc")
                ->get('parts_store_index')
                ->result_array();
        }
    }
    public function getBestSellerByGroup($group){
        return $this->db->query("
                SELECT parts_store_index.* 
                FROM parts_store_index
                JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group
                WHERE parts_store_groups.id = $group
                ORDER BY count_sold desc
            ")
            ->result_array();
    }

    public function searchbar(){
        $keyword = $this->input->post('keyword');
        $keywordNoS = rtrim($this->input->post('keyword'),"s");
        $keywordNoEs = rtrim($this->input->post('keyword'),"es");
        return
         $this->db->query("
                SELECT DISTINCT parts_store_groups.name, parts_store_index.* 
                FROM parts_store_index 
                JOIN parts_store_groups ON parts_store_groups.id = parts_store_index.group
                JOIN parts_store_vehicle_parts ON parts_store_vehicle_parts.part_id = parts_store_index.id
                JOIN parts_store_vehicles ON parts_store_vehicles.id = parts_store_vehicle_parts.vehicle_id
                JOIN parts_store_manufacturers ON parts_store_manufacturers.id = parts_store_vehicles.manufacturer_id
                WHERE parts_store_index.title LIKE '%$keyword%'
                OR parts_store_index.title LIKE '%$keywordNoS%'
                OR parts_store_index.title LIKE '%$keywordNoEs%'
                OR parts_store_index.pnumber LIKE '%$keyword%'
                OR parts_store_groups.name LIKE '%$keyword%'
                OR parts_store_vehicles.vehicle_text LIKE '%$keyword%'
                OR parts_store_manufacturers.name LIKE '%$keyword%'
                AND parts_store_index.availability = 1
                order BY parts_store_groups.id
                ")
                ->result_array();
         // die($this->db->last_query());
    }
    public function getRecycled()
    {
        return $this->db->get_where("parts_store_index", "type = 'recycled' ")->result_array();
    }

    public function getRecycledByGroup($group){
        return $this->db->query("
                SELECT parts_store_index.* 
                FROM parts_store_index
                JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group
                WHERE type = 'recycled'
                AND parts_store_groups.id = $group
            ")
            ->result_array();
    }

    public function getfactor()
    {
        return $this->db->get_where("parts_store_index", "type = 'factor' ")->result_array();
    }

    public function getFactorByGroup($group){
        return $this->db->query("
                SELECT parts_store_index.* 
                FROM parts_store_index
                JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group
                WHERE type = 'factor'
                AND parts_store_groups.id = $group
            ")
            ->result_array();
    }

    public function getOem()
    {
        return $this->db->get_where("parts_store_index", "type = 'oem' ")->result_array();
    }

    public function getOemByGroup($group){
        return $this->db->query("
                SELECT parts_store_index.* 
                FROM parts_store_index
                JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group
                WHERE type = 'oem'
                AND parts_store_groups.id = $group
            ")
            ->result_array();
    }
}
//EOF
