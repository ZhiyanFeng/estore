<?php
class orders_model extends CI_Model {
	
	// insert the order
	public function insert($order) {
		$data = array (
				'customer_id' => $order['customer_id'],
				'order_date' =>  $order['order_date'],
				'order_time' => $order['order_time'],
				'total' => $order['total'],
				'creditcard_number' => $order['creditcard_number'],
				'creditcard_month' => $order['creditcard_month'],
				'creditcard_year' => $order['creditcard_year'] 
		);
		
		$query = $this->db->insert ( 'orders', $data );
		return $this->db->insert_id();
	}
	
	// Return all orders
	function getAll() {
		$query = $this->db->get ( 'orders' );
		return $query->result();
	}
	
	// Return one order
	function get($id) {
		$query = $this->db->get_where ( 'orders', array ('id' => $id) );
		return $query->row ( 0, 'Order' );
	}
	
	// Delete an order
	function delete($id) {
		$this->db->delete ( "orders", array (
				'id' => $id 
		) );
	}
	
	function  deleteAll(){
		$this->db->empty_table("orders");
	}
}
?>