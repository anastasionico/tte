<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

/*
  $this->user_model->insert(array(
      'username' => $this->input->post('username', TRUE),
      'password' => $this->input->post('password', TRUE),
      'company_id' => $data['company']->id
  ));
 */
class User_model extends MY_Model {

    public $before_create = array( 'created_at', 'updated_at', 'hash_password' );
    public $after_create = array( 'after_create' );

    public $protected_attributes = array( 'id' );

    public $belongs_to = array( 'company' );
    public $has_many = array( 'permissions' );

    

    /*
     * After a User is created this function is run,
     * Currently only used to setup basic permissions
     */
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
        return (bool) $this->session->userdata('user_id');
    }

    /**
     * Hash the user submitted password
     *
     * @return $user
     */
    public function hash_password($user)
    {
        $this->load->helper('bcrypt');
        $bcrypt = new Bcrypt();

        $user['password'] = $bcrypt->hash($user['password']);

        return $user;
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

        return $this->update($this->data['user']['id'], array(
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

                $this->user_model->update($user['id'], array(
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
        $session_data = array('user_id','company_id','username');
        $this->session->unset_userdata($session_data);

        return TRUE;
    }
    

    function get_fleet_list($user_id, $company_id = NULL)
    {
        $fleet_list[] = 'TBA';

        // eur
        if($company_id == NULL) {
          $rows = $this->db
              ->select('reg')
              ->where('user_id', $user_id)
              ->get('user_fleet_list')
              ->result_array();
        }
        else {
          $rows = $this->db
              ->select('reg')
              ->where('user_id', $user_id)
              ->where('company_id', $company_id)
              ->get('user_fleet_list')
              ->result_array();
        }

        foreach($rows as $row)
            $fleet_list[] = $row['reg'];

        return $fleet_list;
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
      $query = $this->db->get('users');
      return $query->result_array();

    }

    public function set(){
      $data = array(
        'username' => $this->input->post('username'),
        'fullname' => $this->input->post('fullname'),
        'email' => $this->input->post('email'),
        'password' =>  $this->input->post('password'),
        'default_module_name' => "part_catalog",
      );

      $id = parent::insert($data);
      $this->session->set_flashdata('alert', array(
        'type' => 'success',
        'message' => 'User added.'
      ));
      redirect('/users/edit/' . $id);
      
    }
    public function get_user_by_id($id){
        $query = $this->db->get_where('users',"id = $id");
        return $query->row_array();
    }

    public function update_user($id){
      $newPassword = $this->input->post('password');
      $data = array(
        'username' => $this->input->post('username'),
        'fullname' => $this->input->post('fullname'),
        'email' => $this->input->post('email'),
        'default_module_name' => "part_catalog",
      );
      if(!empty($newPassword)){
        $this->load->helper('bcrypt');
        $bcrypt = new Bcrypt();
        $newPasswordHashed = $bcrypt->hash($newPassword);
        $data['password'] = $newPasswordHashed;
        
      }  
      
      return $this->db->where("id", $id)->update('users',$data);
    }


    public function delete($user_id){
        $this->db->delete('users', array('id' => $user_id)); 
        $this->db->delete('permissions', array('user_id' => $user_id)); 
        return TRUE;
    }
    
}
//EOF
