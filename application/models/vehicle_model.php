<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Vehicle_model extends CI_Model {

    /*
     * Will take a model name, normally returned from CDL, and clean
     * it so it is in the format used in the DB.
     * example: 311 cdi sport
     * return: 311CDI
     *
     * @param string
     * @return string
     */
    public function resolve_model($model) {
        // Add a space at the end of $model, incase 'D' is the last in the string (we search 'D ').
        $model = $model . " ";
        // strpos is case sensitive
        $model = strtoupper($model);
        // Get numbers from the $model
        $model_number = preg_replace("/[^0-9]/", "",$model);
        // Check if CDI or D, if not return just model_number
        if(strpos($model,"CDI"))
            return $model_number . "CDI";
        else if(strpos($model,"D "))
            return $model_number . "D";
        else
            return $model_number;
    }

    /*
     * New reg lookup function. Dec 2011
     * 08/12 - put into model on codeigniter, some refactoring. Changed
     *         to use active record.
     *
     * If succesful lookup will return array with vehicle details, NULL otherwise.
     * Uses resolve_model($model) to clean up model number.
     *
     * @param string
     * @return Array
     */
    public function reg_lookup($reg, $area = 'SERVICE') {
        $reg = preg_replace('#\W#', '', $reg); // validation, only alphanumerical
        // check db cache, see if this reg has been looked up before
        $sql = "
            SELECT reg, vin, timestamp, engine_number, model, model_info, colour, failed, year
            FROM `vehicles_lookups` WHERE `reg` = ? LIMIT 1"; 
        $cache = $this->db->query($sql, array($reg));
        if($cache->num_rows() == 1)
        {
            // if reg is cached, return it if it didnt fail
            $lookup = $cache->row_array();
            return ($lookup['failed'] == 0) ? $lookup : NULL;
        }
        else
        {
            // if not perform lookup at CDL
            $cdl_address = "https://iris.cdlis.co.uk/iris/elvis?vehicle_type=PC&userid=SB_COMMERCIALS&test_flag=N&client_type=external&search_type=vrm&function_name=xml_sb_commercials_fnc&search_string=" . $reg. "&password=3uM3FRWOzIiMeuZwQK0Og3Gr4UpfMGOPVOYkoi8AhYAwezt2V";
            
            $xml = @simplexml_load_file($cdl_address);
            if ($xml->DVLA->VEHICLE->VIN)
            {
                // lookup successful, cache in the DB
                $date = date_create_from_format('j-M-Y', $xml->DVLA->VEHICLE->MANUF_DATE);
                $year = date_format($date, "Y");

                $lookup = array(
                    'reg' => $reg,
                    'vin' => (string) $xml->DVLA->VEHICLE->VIN,
                    'timestamp' => time(),
                    'engine_number' => (string) $xml->DVLA->VEHICLE->ENGINE_NUMBER,
                    'model' => (string) $this->resolve_model($xml->DVLA->VEHICLE->MODEL),
                    'model_info' => (string) $xml->DVLA->VEHICLE->MODEL,
                    'colour' => (string) $xml->DVLA->VEHICLE->COLOUR,
                    'year' => $year,
                    'xml_dump' => $xml->asXML(),
                    'initial_lookup' => $area,
                );
                $this->db->insert('vehicles_lookups', $lookup);
                return array_slice($lookup, 0, 8); // dont return xml_dump and initial lookup
            }
            else
            {
                // CDL lookup failed, cache in DB to save further lookups at cost
                $stmt = 'INSERT INTO `vehicles_lookups` (reg, failed) VALUES (?, ?)';
                $this->db->query($stmt, array($reg, 1));
                return NULL;
            }
        }
    }
    public function get(){
        $query = $this->db
                    ->select("parts_store_vehicles.* , parts_store_manufacturers.name")
                    ->from("parts_store_vehicles")
                    ->join("parts_store_manufacturers", "parts_store_manufacturers.id = parts_store_vehicles.manufacturer_id")
                    ->get();
        return $query->result_array();
    }

    public function getById($id){
        $query = $this->db
                    ->select("parts_store_vehicles.* , parts_store_manufacturers.name")
                    ->from("parts_store_vehicles")
                    ->join("parts_store_manufacturers", "parts_store_manufacturers.id = parts_store_vehicles.manufacturer_id")
                    ->where("parts_store_vehicles.id = $id")
                    ->get();
        //echo $this->db->last_query(); exit;
        return $query->row_array();
    }
    public function getAllManufacturers(){
        $query = $this->db->query("SELECT parts_store_manufacturers.* from parts_store_manufacturers");
        return $query->result_array();   
    }
    public function get_manufacturers(){
        // The following query select all the manufacturer with at least one part;
        $query = $this->db->query("SELECT parts_store_manufacturers.id, parts_store_manufacturers.name, parts_store_manufacturers.image, count(parts_store_index.id) as parts_number
                    FROM parts_store_manufacturers
                    JOIN parts_store_vehicles ON parts_store_vehicles.manufacturer_id = parts_store_manufacturers.id
                    JOIN parts_store_vehicle_parts ON parts_store_vehicle_parts.vehicle_id = parts_store_vehicles.id
                    JOIN parts_store_index ON parts_store_index.id = parts_store_vehicle_parts.part_id
                    GROUP by parts_store_manufacturers.name");
        //$query = $this->db->get("parts_store_manufacturers");
        return $query->result_array();   
    }
    public function getManufacturersById($id){
        $query = $this->db->get_where("parts_store_manufacturers", "id = $id");
        return $query->row_array();   
    }
    public function getManufacturersByName($name){
        $query = $this->db->get_where("parts_store_manufacturers", "name = '$name'");
        return $query->row_array();   
    }

    public function getPartByManufacturer($manufacturer, $model, $group){
        
        //This function will look for a general research of parts. if the model name is in the url, look for all the parts of thet model if there is no medel in the url look for all the part of the selected manufacturer.
        if(isset($group)){
            $query = $this->db->query("
                SELECT DISTINCT parts_store_index.*,parts_store_manufacturers.name 
                FROM `parts_store_index` 
                JOIN parts_store_groups on parts_store_index.group = parts_store_groups.id
                JOIN parts_store_vehicle_parts on parts_store_index.id =    parts_store_vehicle_parts.part_id
                JOIN parts_store_vehicles on parts_store_vehicles.id = parts_store_vehicle_parts.vehicle_id
                JOIN parts_store_manufacturers on parts_store_manufacturers.id = parts_store_vehicles.manufacturer_id
                WHERE parts_store_groups.addr = '$group'
                AND parts_store_vehicles.vehicle_text = '$model'
            ");    
            
        }elseif(!empty($model)){
            $query = $this->db->query("
                SELECT DISTINCT i.*, parts_store_manufacturers.name 
                FROM parts_store_index as i
                JOIN parts_store_vehicle_parts on i.id = parts_store_vehicle_parts.part_id
                JOIN parts_store_vehicles on parts_store_vehicle_parts.vehicle_id = parts_store_vehicles.id
                JOIN parts_store_manufacturers on parts_store_manufacturers.id = parts_store_vehicles.manufacturer_id
                JOIN parts_store_groups on i.group = parts_store_groups.id
                WHERE parts_store_vehicles.vehicle_text = '$model'
            ");    
        }else{
            $query = $this->db->query("SELECT DISTINCT i.*, parts_store_manufacturers.name FROM parts_store_index as i
                                JOIN parts_store_vehicle_parts on i.id = parts_store_vehicle_parts.part_id
                                JOIN parts_store_vehicles on parts_store_vehicle_parts.vehicle_id = parts_store_vehicles.id
                                JOIN parts_store_manufacturers on parts_store_manufacturers.id = parts_store_vehicles.manufacturer_id
                                JOIN parts_store_groups on i.group = parts_store_groups.id
                                WHERE parts_store_manufacturers.name = '$manufacturer'
                                ");    
        }
        return $query->result_array();   
    }

    public function set($name_image){
        $this->load->helper('url');
        $year_from = $this->input->post('year_from');
        $year_to = $this->input->post('year_to');
        
        //var_dump($year_to); exit();
        if($year_to == FALSE){$year_to = 9000;}
        $vehicle_slug = url_title($this->input->post('vehicle_text')) ."-". url_title($this->input->post('year_from')) ."-".
        url_title($this->input->post('year_to'));
        if($year_from <= $year_to){
            $data = array(
                'manufacturer_id' => $this->input->post('manufacturer'),
                'img' => $name_image,
                'vehicle_text' => $this->input->post('vehicle_text'),
                'vehicle_slug' => $vehicle_slug,
                'year_from' => $this->input->post('year_from'),
                'year_to' => $this->input->post('year_to'),
                'model' => $this->input->post('model'),
            );
            return $this->db->insert('parts_store_vehicles', $data);
        }else{
            echo "<b>Check your data.</b><br>the year of starting production cannot be successive of the end of production";
        }
    }
   
    
    public function update($id, $name_image = null){
        $this->load->helper('url');
        $year_from = $this->input->post('year_from');
        $year_to = $this->input->post('year_to');
        
        if($year_to == FALSE){$year_to = 9000;}
        $vehicle_slug = url_title($this->input->post('vehicle_text')) ."-". 
            url_title($this->input->post('year_from')) ."-".
            url_title($this->input->post('year_to'));
        if($year_from <= $year_to){
            $data = array(
                'manufacturer_id' => $this->input->post('manufacturer'),
                //'img' => $name_image,
                'vehicle_text' => $this->input->post('vehicle_text'),
                'vehicle_slug' => $vehicle_slug,
                'year_from' => $this->input->post('year_from'),
                'year_to' => $this->input->post('year_to'),
                'model' => $this->input->post('model'),
            );
            if($name_image !== null){ 
                $data['img'] = $name_image;
            }    
            return $this->db->update('parts_store_vehicles', $data, "id = $id");
        }else{
            echo "<b>Check your data.</b><br>the year of starting production cannot be successive of the end of production";
        }
    }
    public function delete($id){
        $this->db->delete('parts_store_vehicles', array('id' => $id));
    }    

    public function get_category(){
        $query = $this->db->get_where('parts_store_groups', "parent_id = 0");
        return $query->result_array();   
    }

    public function getVehiclesNameByManufacturer($manufacturer){
        return $query = $this->db->query("
            SELECT DISTINCT parts_store_vehicles.* ,parts_store_manufacturers.name
            FROM parts_store_vehicles 
            JOIN parts_store_manufacturers on parts_store_vehicles.manufacturer_id = parts_store_manufacturers.id
            WHERE parts_store_manufacturers.name = '$manufacturer'
        ")->result_array();
    }
}
//EOF
