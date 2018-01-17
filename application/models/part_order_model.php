<?php if ( ! defined('BASEPATH')) exit ('No direct script access allowed');

class Part_order_model extends MY_Model {
  
  public function get(){
    $orders = $this->db->order_by('id','desc')
      ->get('orders')
      ->result_array();
    foreach ($orders as &$order) {
      if(!$order['dispatch']){continue;}
      $order['dispatcher'] = $this->user_model->get($order['dispatch']);
    }
    return $orders;
  }        

  public function delete($id){
    $this->db->where('id', $id)->delete('orders');
  }
	
	public function dispatch($id){
  		$data = array(
       		'dispatch' => $this->data['user']['id']
    	);
    	$this->db->where('id', $id)->update('orders' , $data);
	}

  public function getOrder($id){
    $order = $this->db->where('id', $id)
      ->get('orders')
      ->row_array();

    $order['items'] = $this->db->where('order_id', $id)
      ->get('order_items')
      ->result_array();  

    return $order;

  }
}
