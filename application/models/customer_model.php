<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

/*
  $this->user_model->insert(array(
      'username' => $this->input->post('username', TRUE),
      'password' => $this->input->post('password', TRUE),
      'company_id' => $data['company']->id
  ));
 */
class Customer_model extends MY_Model {
    /*
    public $before_create = array( 'created_at', 'updated_at', 'hash_password' );
    public $after_create = array( 'after_create' );

    public $protected_attributes = array( 'id' );

    public $belongs_to = array( 'company' );
    public $has_many = array( 'permissions' );

    

    /*
     * After a User is created this function is run,
     * Currently only used to setup basic permissions
     * /
    public function after_create($user_id)
    {
        $this->permission_model->setup_default($user_id);
    }

    /**
     * Checks to see if the user is logged in.
     *
     * @return bool
     */
    

    public function logged_in()
    {
        return (bool) $this->session->userdata('customer_id');
    }

    /**
     * Hash the user submitted password
     *
     * @return $user
     */
    public function hash_password($customer)
    {
        $this->load->helper('bcrypt');
        $bcrypt = new Bcrypt();

        $customer['password'] = $bcrypt->hash($customer['password']);

        return $customer;
    }

    /**
     *
     */
    public function change_password()
    {
        $this->load->helper('bcrypt');
        $bcrypt = new Bcrypt();

        // input has already been validated in controllers/account.php
        $password = $bcrypt->hash($this->input->post('password'));

        return $this->update($this->data['customer']['id'], array(
            'password' => $password,
        ), TRUE);
    }

    /**
     * Logs the user into the system, stores info in Session
     *
     * @return bool
     **/
    public function login($username, $password){
        $this->load->helper('bcrypt');

        $user = $this->get_by(array(
            'username' => $username,
        ));

        if(!empty($user)){
            $bcrypt = new Bcrypt();

            if($bcrypt->verify($password, $user['password']) === TRUE)
            {
                /* stored session variables, if changed
                   update $this->logout() so they get cleared */
                $session_data = array(
                    'user_id' => $user['id'],
                    'username' => $user['username']
                );
                $this->session->set_userdata($session_data);

                $this->customer_model->update($user['id'], array(
                    'last_login' => date('Y-m-d H:i:s')
                ), TRUE );

                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * Logs the user out
     */
    public function logout()
    {
        $session_data = array('customer_id','company_id','username');
        $this->session->unset_userdata($session_data);

        return TRUE;
    }
    

    
    function log_action($user_id, $module_id, $action)
    {
        return $this->db->insert('user_log', $data = array(
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'user_id' => $user_id,
            'module_id' => $module_id,
            'action' => $action,
        ));
    }

    public function get_all(){
      $query = $this->db->get('customers');
      return $query->result_array();

    }

    public function set(){
      $this->load->helper('bcrypt');
      $bcrypt = new Bcrypt();
      $password = $bcrypt->hash($this->input->post('password'));

      $data = array(
        'username' => $this->input->post('username'),
        'fullname' => $this->input->post('fullname'),
        'email' => $this->input->post('email'),
        'password' => $password,
        'default_module_name' => "part_catalog",
      );

      $id = parent::insert($data);
      
      
      echo $id;
      
      $this->session->set_flashdata('alert', array(
        'type' => 'success',
        'message' => 'customer added.'
      ));
      redirect('/customers/edit/' . $id);
      
    }
    public function get_customer_by_id($id){
        $query = $this->db->get_where('customers',"id = $id");
        return $query->row_array();
    }

    public function update_customer($id){
      $this->load->helper('url');
      $newPassword = $this->input->post('password');

      $data = array(
        'firstname' => $this->input->post('firstname'),
        'lastname' => $this->input->post('lastname'),
        'address1' => $this->input->post('address1'),
        'address2' => $this->input->post('address2'),
        'city' => $this->input->post('city'),
        'postcode' => $this->input->post('postcode'),
        'email' => $this->input->post('email'),
        'phone' => $this->input->post('phone'),
        'mobile' => $this->input->post('mobile'),
        'username' => $this->input->post('username'),
        'creditcard' => $this->input->post('creditcard'),
        'creditcard_type' => $this->input->post('creditcard_type'),
        'creditcard_expmm' => $this->input->post('creditcard_expmm'),
        'creditcard_expyy' => $this->input->post('creditcard_expyy'),
        'billing_address' => $this->input->post('billing_address'),
        'billing_city' => $this->input->post('billing_city'),
        'billing_postcode' => $this->input->post('billing_postcode'),
        'ship_address' => $this->input->post('ship_address'),
        'ship_city' => $this->input->post('ship_city'),
        'ship_postcode' => $this->input->post('ship_postcode'),
        
      );

      if(!empty($newPassword)){
        $this->load->helper('bcrypt');
        $bcrypt = new Bcrypt();
        $newPasswordHashed = $bcrypt->hash($newPassword);
        $data['password'] = $newPasswordHashed;
        
      }  
      
      return $this->db->where("id", $id)->update('customers',$data);
    }


    public function delete($customer_id){
        $this->db->delete('customers', array('id' => $customer_id)); 
        //$this->db->delete('permissions', array('customer_id' => $customer_id)); 
        return TRUE;
    }
    
}
//EOF
