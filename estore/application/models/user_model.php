<?php
class user_model extends CI_Model {
	public function login($username, $password) {
		$this->db->select ( 'first, last, login, email, id');
		$this->db->from ( 'customers' );
		$this->db->where ( 'login', $username );
		$this->db->where ( 'password', $password );
		$this->db->limit ( 1 );
		
		
		$query = $this->db->get ();
		
		
		if ($query->num_rows () == 1) {
			return $query->result ();
		} else {
			return false;
		}
	}
	public function addUser() {
		$data = array (
				'email' => $this->input->post ( 'email' ),
				'first' => $this->input->post ( 'first' ),
				'last' => $this->input->post ( 'last' ),
				'password' => $this->input->post ( 'password' ),
				'login' => $this->input->post ( 'login' ) 
		);
		
		$query = $this->db->insert ( 'customers', $data );
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	// Return all customers
	function getAll() {
		$query = $this->db->get ( 'customers' );
		return $query->result();
	}
	
	// Return one customer
	function get($id) {
		$query = $this->db->get_where ( 'customer', array ('id' => $id) );
		return $query->row ( 0, 'Customer' );
	}
	
	// Delete a customer
	function delete($id) {
		$this->db->delete ( "customers", array (
				'id' => $id 
		) );
	}
	
	function  deleteAll(){
		$this->db->where('login !=', 'admin');
		$this->db->delete("customers");
	}
}
?>