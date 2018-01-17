<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Part_catalog_model extends MY_Model {

    public $module_id = 6;

    public function __construct() 
    {
        parent::__construct();
    }
    
    public function get_all()
    {
        $query = $this->db->query("SELECT  parts_store_index.*, parts_store_index.pnumber, parts_store_groups.name as category_name,
            (select COUNT(parts_store_vehicle_parts.part_id)
            FROM parts_store_vehicle_parts
            where parts_store_vehicle_parts.part_id = parts_store_index.id) as vehicles_fitted
        FROM parts_store_index
        JOIN parts_store_groups on parts_store_groups.id = parts_store_index.group");
        return $query->result_array();
    }

    public function search($pnumber)
    {
        $pnumber = strtoupper( preg_replace('/\s+/', '', $pnumber) );
        // sometimes staff put 'm' infront of part numbers.
        $pnumber = (substr($pnumber, 0, 1) == 'M') ? $pnumber = substr($pnumber, 1) : $pnumber;

        $row = $this->db->query('SELECT `id` FROM `parts_store_index` WHERE `pnumber` = ? LIMIT 1', array($pnumber))
            ->row_array();

        return (isset($row['id'])) ? $row['id'] : NULL;
    }
    
    public function get($id)
    {
        $stmt = $this->db->query('SELECT * FROM `parts_store_index` WHERE `id` = ? LIMIT 1', array($id));

        $row = $stmt->row_array();

        if($row)
        {
            /* image
            $filename = '/opt/lampp/htdocs/sbcommercials/mercedes-van-parts/img/' . $row['id'] . '_1.jpg';
            $row['img'] = ( file_exists($filename) ) ? 1 : 0;
            */
            // fits vehicles
            $fits_vehicles_rows = $this->db->query('SELECT `vehicle_id` FROM `parts_store_vehicle_parts`
                WHERE `part_id` = ' . $row['id'])->result_array();
            $row['fits_vehicles'] = array();
            
            foreach($fits_vehicles_rows as $vehicle_row) {
                $row['fits_vehicles'][] = $vehicle_row['vehicle_id'];
            }
        }

        return ($row) ? $row : NULL;
    }

    
    public function getAdditionalImagesViaPnumber($pnumber)
    {
        $id = $this->search($pnumber);
        $row['additional_images'] = $this->db
            ->where('part_id', $id)
            ->order_by('sort')
            ->get('parts_store_additional_photos')
            ->result_array();
        return $row;
    }

    public function getAdditionalImages($id)
    {
        $row['additional_images'] = $this->db
            ->where('part_id', $id)
            ->order_by('sort')
            ->get('parts_store_additional_photos')
            ->result_array();
        return $row;
    }

    public function get_groups()
    {
        return $this->db
            ->query('SELECT * FROM `parts_store_groups`')
            ->result_array();
    }

    public function getParentGroups()
    {
        return $this->db
            ->query('SELECT * FROM `parts_store_groups` where parent_id = 0 ')
            ->result_array();
    }
    
    public function getGroupsAndParentName()
    {
        return $this->db
            ->query('SELECT parent.addr as parentAddr, child.*
                    FROM parts_store_groups as child
                    LEFT JOIN parts_store_groups as parent on child.parent_id = parent.id
                    ORDER BY child.parent_id')
            ->result_array();
    }
    
    public function getGroupName($id_group)
    {
        if($id_group){
            return $this->db->query(
                        "SELECT parent.addr as parentAddr, child.*
                        FROM parts_store_groups as child
                        LEFT JOIN parts_store_groups as parent on child.parent_id = parent.id
                        WHERE child.id = $id_group")
                        ->row_array();    
        }
    }

    public function get_vehicles($part_id = NULL)
    {
        

        $stmt = $this->db->query('SELECT * FROM `parts_store_vehicles` ORDER BY `manufacturer_id` ASC, `id` ASC');
        $vehicle_rows = $stmt->result_array();




        foreach($vehicle_rows as $vehicle_row)
        {

        }

        return $vehicle_rows;
    }

    public function put($id = NULL)
    {
        //$offer_occupied = $this->homepageTaken($id , $this->input->post('homepage'));
        
        // If the part added is a new one the flow enter this if the user id editing a part the code goes into the else
        if($id == NULL){
            // INSERT
            $featured = ($this->input->post('featured') == 'on' )? 1 : null ;
            $ebay = ($this->input->post('ebay') == 'on' )? 1 : 0 ;
            $eBayGSP = ($this->input->post('eBayGSP') == 'on' )? 1 : 0 ;
            $offer = ($this->input->post('offer') !== '' )? $this->input->post('offer') : null ;
            $inputPnumber = url_title( $this->input->post('inputPnumber') );
            $slug = url_title($this->input->post('inputTitle'));
            $homepage = ($this->input->post('homepage') == 'null' )? null : $this->input->post('homepage');
            
            $sql = 'INSERT INTO `parts_store_index`
                (`pnumber`, `title`,  `slug`, `description`, `group`, `price`, `price_ebay`,
                 `last_updated`, `last_updated_by`, `offer`, `homepage`, `featured`, `type`, `ebay`, `ebay_gsp`, `count_sold`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            

            $stmt = $this->db->query($sql, array(
                $inputPnumber,
                $this->input->post('inputTitle'),
                $slug,
                $this->input->post('inputDescription'),
                $this->input->post('inputGroup'),
                number_format($this->input->post('price'), 2, '.', ''),
                number_format($this->input->post('priceEbay'), 2, '.', ''),
                date("Y-m-d H:i:s"),
                $this->data['user']['id'],
                $offer,
                $homepage,
                $featured,
                $this->input->post('type'),
                $ebay,
                $eBayGSP,
                $this->input->post('count_sold'),
            ));
            $id = $this->db->insert_id();
            $action = 'Part ' . $id . ' added.';
        }else{
            // UPDATE
            $featured = ($this->input->post('featured') === 'on' )? 1 : null ;
            $ebay = ($this->input->post('ebay') === 'on' )? 1 : 0 ;
            $eBayGSP = ($this->input->post('eBayGSP') == 'on' )? 1 : 0 ;
            $offer = ($this->input->post('offer') !== '' )? $this->input->post('offer') : null ;
            $inputPnumber = url_title( $this->input->post('inputPnumber') );
            $slug = url_title($this->input->post('inputTitle'));
            $homepage = ($this->input->post('homepage') == 'null' )? null : $this->input->post('homepage');

            $sql = 'UPDATE `parts_store_index` SET `pnumber` = ?, `title` = ?, `slug` = ?,
                `description` = ?, `group` = ?, `price` = ?,`price_ebay` = ?,
                `last_updated` = \'' . date("Y-m-d H:i:s") . '\',
                `last_updated_by` = ' . $this->data['user']['id'] . '
                , `offer` = ?, `homepage` = ?, `featured` = ?, `type` = ?, `ebay` = ?, `ebay_gsp` = ?, `count_sold` = ?
                WHERE `id` = ?';
            $stmt = $this->db->query($sql, array(
                $inputPnumber,
                $this->input->post('inputTitle'),
                $slug,
                $this->input->post('inputDescription'),
                $this->input->post('inputGroup'),
                number_format($this->input->post('price'), 2, '.', ''),
                number_format($this->input->post('priceEbay'), 2, '.', ''),
                $offer,
                $homepage,
                $featured,
                $this->input->post('type'),
                $ebay,
                $eBayGSP,
                $this->input->post('count_sold'),
                $id
            ));
            //echo $this->db->last_query(); exit();
            $action = 'Part ' . $id . ' updated.';
        }
        
        $part = $this->get($id);
        
        // Sort the 'fits' tables
        $this->db->query('DELETE FROM `parts_store_vehicle_parts` WHERE `part_id` = ?', array($id));
        foreach($this->input->post() as $input_name => $input_value) {
            if(substr($input_name, 0, 2) == 'm_') {
                list( , $vehicle_id) = explode('_', $input_name);
                $sql = 'INSERT INTO `parts_store_vehicle_parts` (`vehicle_id`, `part_id`)
                    VALUES (?, ?)';
                $stmt = $this->db->query($sql, array(
                    $vehicle_id,
                    $id,
                ));
            }
        }

        // Sort the Picture
        if($_FILES['picture']['name']){
            $_FILES['picture']['name'] = preg_replace("/[^a-z0-9\.]/", "", strtolower($_FILES['picture']['name']));
            //$_FILES['picture']['name'] = urlencode($_FILES['picture']['name']);
            
            $fileinfo = array (
                array('name' => 'm/' . $_FILES['picture']['name'], 'width' => 500, 'height' => 333),
                array('name' => 'l/' . $_FILES['picture']['name'], 'width' => 1000, 'height' => 667)
            );
            $this->config->item('dir_local') . "/inc/img/parts/l/";
            
            $filename_base = $this->config->item('dir_local') . "/inc/img/parts/";
            $filename = $filename_base . 'o/' . $_FILES['picture']['name'];
            //die(var_dump($_FILES['picture']["tmp_name"]));
            move_uploaded_file($_FILES['picture']["tmp_name"], $filename);
            list($width_orig, $height_orig) = getimagesize($filename);
            $ratio_orig = $width_orig / $height_orig;
            $image = imagecreatefromjpeg($filename);

            foreach($fileinfo as $dim)
            {
                $output_filename = $filename_base . $dim['name'];
                $width = $dim['width'];
                $height = $dim['height'];
                if($dim['name'] == 'medium' && $width/$height > $ratio_orig)
                {
                    $height = $width/$ratio_orig;
                }
                else
                {
                    if ($width/$height > $ratio_orig) $width = $height*$ratio_orig;
                    else $height = $width/$ratio_orig;
                }

                $this->db
                    ->where('id', $id)
                    ->update("parts_store_index", array(
                        'img' => $_FILES['picture']['name'],
                    ));

                $image_p = imagecreatetruecolor($width, $height);
                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                imagejpeg($image_p, $output_filename, 80);

                

                imagedestroy($image_p);
            }
            imagedestroy($image);
        }

        // log the user
        $this->user_model->log_action($this->data['user']['id'], $this->module_id, $action);

        return $id;
    }

    public function get_awaiting_image() 
    {
        
        $stmt = $this->db->query('SELECT * FROM `parts_store_index`');
        $parts = $stmt->result_array();
        $awaiting_image = array();
 
        foreach($parts as $part) {
            // check image returns image location, will contain none if its awaiting
            $filename = $this->config->item('sbdocroot') . "/inc/img/parts/m/" . strtoupper($part['pnumber']) . "_M.jpg";
            if(! file_exists($filename)) {
                    $awaiting_image[] = $part;
            }
        }

        return $awaiting_image;
    }

    public function dele($part_id) 
    {
        $this->db->query('DELETE FROM `parts_store_index` WHERE `id` = ?', array($part_id));
        $this->db->query('DELETE FROM `parts_store_vehicle_parts` WHERE `part_id` = ?', array($part_id));
       return TRUE;
    }
    
    public function available($part_id) 
    {
        $available = $this->db->query("SELECT availability FROM `parts_store_index` WHERE `id` = $part_id ")->row_array();
        if ($available['availability'] == '1') {
            $this->db->query("UPDATE parts_store_index set availability = 0 WHERE `id` = $part_id ");
        }else{
            $this->db->query("UPDATE parts_store_index set availability = 1 WHERE `id` = $part_id ");
        }

        return TRUE;
    }

    public function setAdditionalImage($img)
    {
        //get the last sorted element of the part and add an unit to its number
        $part_id = $img['part'];
        $this->query = $this->db->select_max('sort')
                ->where("part_id = $part_id")
                ->get('parts_store_additional_photos');

        $sort_max = $this->query->row_array();     
        ++$sort_max['sort'];
        
        //save into the database the new image with a sort number increased by one 
        $data = array(
            "part_id" => $img['part'],
            'image' => $img['upload_data']['file_name'],
            'sort' => $sort_max['sort'],
        );
        
        $this->db->insert('parts_store_additional_photos', $data);
        var_dump($data);
        //return $data;
    }
    
    
    public function orderAdditionalImage($images)
    {
        foreach ($images["item"] as $id_image => $image) {
            $this->db->set("sort", $id_image)
                    ->where("id",$image)
                    ->update("parts_store_additional_photos");
        }
    }

    public function getVehiclesFitted($pnumber)
    {
        return $this->db->query("SELECT parts_store_manufacturers.name as manufacturer, parts_store_vehicles.vehicle_text
            FROM `parts_store_vehicles`
            JOIN parts_store_manufacturers on parts_store_manufacturers.id = parts_store_vehicles.manufacturer_id
            JOIN parts_store_vehicle_parts on parts_store_vehicle_parts.vehicle_id = parts_store_vehicles.id
            JOIN parts_store_index on parts_store_index.id = parts_store_vehicle_parts.part_id
            WHERE parts_store_index.pnumber = '$pnumber'")->result_array();
        // return $this->db->query("SELECT distinct parts_store_vehicles.vehicle_text 
        //                 FROM `parts_store_vehicles`
        //                 JOIN parts_store_vehicle_parts on parts_store_vehicle_parts.vehicle_id = parts_store_vehicles.id
        //                 JOIN parts_store_index on parts_store_index.id = parts_store_vehicle_parts.part_id
        //                 WHERE parts_store_index.pnumber = '$pnumber'")->result_array();
    }
    
    public function store()
    {
        $slug = url_title($this->input->post('name'));
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'parent_id' => $this->input->post('parent_id'),
            'addr' => $slug
          );
        $this->db->insert('parts_store_groups', $data);
        $this->session->set_flashdata('alert', array(
            'type' => 'success',
            'message' => 'Category added.'
        ));
        redirect('/categories_management');
    }

    public function update_group($id)
    {
        $this->load->helper('url');
        $slug = url_title($this->input->post('name'));
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'parent_id' => $this->input->post('parent_id'),
            'addr' => $slug
        );
        return $this->db->where("id", $id)->update('parts_store_groups',$data);
    }

    public function destroy($id)
    {
        $this->db->where('id', $id)->delete('parts_store_groups');
    }

}
