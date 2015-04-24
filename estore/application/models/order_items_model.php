<?php
class order_items_model extends CI_Model {
	
	// insert the order
	public function insert($order_item) {
		$data = array (
				'order_id' => $order_item['order_id'],
				'product_id' =>  $order_item['product_id'],
				'quantity' => $order_item['quantity'],
		);
		$query = $this->db->insert ( 'order_items', $data );
		
		
		return $this->db->insert_id();
	}
	
	// Return all orders
	function getAll($order_id) {
		$query = $this->db->get_where ( 'order_items', array('id'=>$order_id) );
		return $query->result();
	}
	
	// Return one order
	function get($id) {
		$query = $this->db->get_where ( 'order_items', array ('id' => $id) );
		return $query->row ( 0, 'Order Item' );
	}
	
	// Delete an order
	function delete($id) {
		$this->db->delete ( "order_items", array (
				'id' => $id 
		) );
	}
	
	function  deleteAll($order_id){
		$this->db->empty_table("order_items", array('id'=>$order_id));
	}
}
?>