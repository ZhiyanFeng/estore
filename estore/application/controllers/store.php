<?php

class Store extends CI_Controller {
     
     
    function __construct() {
    		// Call the Controller constructor
	    	parent::__construct();
// 	    	session_start();
	    	
	    	
	    	$config['upload_path'] = './images/product/';
	    	$config['allowed_types'] = 'gif|jpg|png';
/*	    	$config['max_size'] = '100';
	    	$config['max_width'] = '1024';
	    	$config['max_height'] = '768';
*/
	    	$this->load->helper('html');
	    	$this->load->helper('url');
	    	$this->load->library('upload', $config);
// 	    	$this->load->library('session');
	    	
    }

    function index() {
    		$this->load->view('/pages/home');
//     		$this->load->model('product_model');
//     		$products = $this->product_model->getAll();
//     		$data['products']=$products;
//     		$this->load->view('product/list.php',$data)
    }
    
 
    function admin(){
    	$this->load->model('product_model');
    	$this->load->model('user_model');
    	$this->load->model('orders_model');
			// get from the database
    	$data['products'] = $this->product_model->getAll();
    	$this->load->view('/product/list.php', $data); //using thing you've already made
    	$data['customers'] = $this->user_model->getAll();
    	$this->load->view('/customers/list.php', $data);
    	$data['orders'] = $this->orders_model->getAll();
    	$this->load->view('/orders/list.php', $data);
    	    
    }
    
    
    function newProductForm() {
	    	$this->load->view('/product/newForm.php');
    }
   
    function login(){
    	$this->load->view('/pages/login');
    }
    
    function login_validation() {
    	// This method will have the credentials validationch
    	$this->load->library ( 'form_validation' );
    
    	$this->form_validation->set_rules ( 'login', 'Username', 'trim|required|xss_clean' );
    	$this->form_validation->set_rules ( 'password', 'Password', 'trim|required|xss_clean|callback_check_customer' );
    
    	if ($this->form_validation->run ()) {
    		// Go to private area
    		if ($user = $this->session->userdata ('loggedinCustomer')) {
    			if ($user ['login'] == 'admin') {
    				$this->admin ();
    			} else {
     				$this->catalogue ();
    		//		redirect('store/index');
    			}
    		}
    			
    	} else {
    		// Field validation failed. User redirected to login page
    		$this->load->view ('pages/login' );
    	}
    }
    
    function signup_validation(){
    	$this->load->library('form_validation');
    	$this->load->model('user_model');
    	
    	$this->form_validation->set_rules ( 'first', 'First Name', 'trim|required|xss_clean');
    	$this->form_validation->set_rules ( 'last', 'Last Name', 'trim|required|xss_clean');
    	 
		$this->form_validation->set_rules ( 'login', 'Username', 'trim|required|xss_clean|is_unique[customers.login]' );
		$this->form_validation->set_rules ( 'email', 'Email Address', 'trim|required|xss_clean|valid_email|is_unique[customers.email]' );
		$this->form_validation->set_rules ( 'password', 'Password', 'trim|required|xss_clean|min_length[6]|max_length[12]' );
		$this->form_validation->set_rules ( 'cpassword', 'Confirm Password', 'trim|required|xss_clean|matches[password]' );
    	
        $this->form_validation->set_message('is_unique', "Email or Username already exists");
    	
    	if ($this->form_validation->run())
    	{
    		$this->user_model->addUser();
    		$this->login();
    	}else {
    		$this->load->view('/pages/signup');
    	}
    }
    
    function logout(){
    	$this->session->sess_destroy();
    	redirect('store/index');
    }
    
    function showMember(){
    	$this->load->view('pages/member');
    }
    

    
	function check_customer() {
		$this->load->model('user_model');
		// Field validation succeeded. Validate against database
		$login = $this->input->post ( 'login' );
		$password = $this->input->post ( 'password' );
		// query the database
		$result = $this->user_model->login ( $login, $password );
		
		if ($result) {
			$sess_array = array ();
			foreach ( $result as $row ) {
				$sess_array = array (
						
						'first' => $row->first,
						'last' => $row->last,
						'login' => $row->login,
						'email' => $row->email,
						'id' => $row->id,
						'islogin' => 1
				);
				
				$this->session->set_userdata ('loggedinCustomer', $sess_array );
			}
			return TRUE;
		} else {
			$this->form_validation->set_message ( 'check_database', 'Invalid username or password' );
			return false;
		}
	}
	
    function home(){
    	$this->load->view('/pages/home');
    }
    
	function create() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required|is_unique[products.name]');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		$fileUploadSuccess = $this->upload->do_upload();
		
		if ($this->form_validation->run() == true && $fileUploadSuccess) {
			$this->load->model('product_model');

			$product = new Product();
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$data = $this->upload->data();
			$product->photo_url = $data['file_name'];
			
			$this->product_model->insert($product);

			//Then we redirect to the index page again
			redirect('store/admin', 'refresh');
		}
		else {
			if ( !$fileUploadSuccess) {
				$data['fileerror'] = $this->upload->display_errors();
				$this->load->view('product/newForm.php',$data);
				return;
			}
			
			$this->load->view('product/newForm.php');
		}	
	}
	
	function read($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/read.php',$data);
	}
	
	function editForm($id) {
		$this->load->model('product_model');
		$product = $this->product_model->get($id);
		$data['product']=$product;
		$this->load->view('product/editForm.php',$data);
	}
	
	function update($id) {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('description','Description','required');
		$this->form_validation->set_rules('price','Price','required');
		
		if ($this->form_validation->run() == true) {
			$product = new Product();
			$product->id = $id;
			$product->name = $this->input->get_post('name');
			$product->description = $this->input->get_post('description');
			$product->price = $this->input->get_post('price');
			
			$this->load->model('product_model');
			$this->product_model->update($product);
			//Then we redirect to the index page again
			redirect('store/index', 'refresh');
		}
		else {
			$product = new Product();
			$product->id = $id;
			$product->name = set_value('name');
			$product->description = set_value('description');
			$product->price = set_value('price');
			$data['product']=$product;
			$this->load->view('product/editForm.php',$data);
		}
	}
	
	function showProduct() {
		if ($this->session->userdata ('loggedinCustomer')) {
			if ($this->session->userdata ('loggedinCustomer')['login'] == 'admin') {
				$this->admin ();
			} else {
				$this->catalogue ();
			}
		} else {
			$this->catalogue ();
		}
	}
    	
	function deleteProduct($id) {
		$this->load->model('product_model');
		echo "$id";
		if (isset($id)) 
			$this->product_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('store/admin', 'refresh');
	}
	
	
	function deleteAllProduct(){
		$this->load->model('product_model');
		$this->product_model->deleteAll();
		redirect('store/admin', 'refresh');
	}
	
	function deleteCustomer($id){
		// copied your deleteProduct
		$this->load->model('user_model');
		
		if (isset($id))
			$this->user_model->delete($id);
		
		//Then we redirect to the index page again
		redirect('store/admin', 'refresh');
	}
      
   	function cart($data){
   		$this->load->view('/pages/cart.php', $data);
   		
   	}

   	function catalogue(){
   		$this->load->library('form_validation');
   		$this->form_validation->set_rules('total', 'Total', 'callback_addCartCheck');
   	
   		// get the customer, and his orders and products
   		$this->load->model('product_model');
   		$data['products'] = $this->product_model->getAll();
   		$data['customers'] = $this->session->userdata('loggedinCustomer');
   		$data['submit'] = $this->input->post('submit');
      	
   		// as discussed in chat, I'm assuming that customer has the array 'orders'
   		// orders basically will contain product id hashed to their quantities
   		$data['order_items'] = array();
   		if ($this->session->userdata('order_items')){
   			$data['order_items'] = $this->session->userdata('order_items');
   		}
   		if ($this->input->post('submit') == 'View Cart'){
   			
   			$this->cart($data);
   		} else if ($this->form_validation->run() == TRUE){
   				// POST data contains ProductID as key and quantity as value
   				foreach($this->input->post() as $key=>$value){
   					// if customer has already this product (ProductID) in his cart,
   					// just increase the quantity - only if "Add to Cart"
   					if ($value > 0){
   						if (array_key_exists($key, $data['order_items']) && $this->input->post('submit') == 'Add to Cart'){
							$data['order_items'][$key]++;   						
   						} else if ($key != 'total') {
   							$data['order_items'][$key] = $value;   						
   						}
   					}
   				}
   		
   			// update this customer's orders
   			$this->session->set_userdata('order_items', $data['order_items']);
   			// if user now clicks add to cart, load cart page
   			if ($this->input->post('submit') == 'Add to Cart'){
   				$this->cart($data);
   			} else if ($this->input->post('submit') == 'Save and Continue Shopping'){
   				$this->load->view('customers/catalogue', $data);
   			} else if ($this->input->post('submit') == 'Checkout'){
   				$this->checkout($data);
   			}
   		}
   		else {
   			// load customer's catalog. Still need to implement
   			$this->load->view('customers/catalogue',$data);
   		}
   	}	
   	
   	function addCartCheck($total){
   		if ($this->input->post('submit') == "Save and Continue Shopping"){
   			return true;
   		}
   		
   		if (!($this->session->userdata('loggedinCustomer'))){
   			redirect('/store/login', 'refresh');
   			return false;
   		}
   		
   		$this->form_validation->set_message('totalCheck', 'You need at least 1 item in the cart');
   		return (intval($total) > 0);  //hardcoded for now		
   	}
   	
   	function checkout($data=array()){
   		
   		$this->load->model('orders_model');
   		$this->load->model('order_items_model');
   		$this->load->library('form_validation');
   		$this->load->model('product_model');
   		
   		// get this customer
   		$data['customers'] = $this->session->userdata('loggedinCustomer');
   		$data['order_items'] = $this->session->userdata('order_items');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
   		$this->form_validation->set_rules('creditcard_number', 'Credit Card Number', 'required|exact_length[16]|numeric');
   		$this->form_validation->set_rules('creditcard_month', 'Expiry Month', 'required|exact_length[2]|numeric');
   		$this->form_validation->set_rules('creditcard_year', 'Expiry Year', 'required|exact_length[2]|numeric|callback_expiryCheck');
   		
   		if ($this->form_validation->run() == false){
   			$this->load->view('orders/checkout', $data);
   		} else {
   			$orders = array();
   			$orders['customer_id'] = $data['customers']['id'];
   			$orders['order_date'] = date('Y-m-d');
   			$orders['order_time'] = date('H:i:s');
   			$orders['total'] = $this->input->post('total');
   			$orders['creditcard_number'] = $this->input->post('creditcard_number');
   			$orders['creditcard_month'] = $this->input->post('creditcard_month');
   			$orders['creditcard_year'] = $this->input->post('creditcard_year');
   			$order_id = $this->orders_model->insert($orders);
   			foreach ($data['order_items'] as $key=>$value){
   				if ($value > 0){
   					$order_item = array(
   										'order_id'=> $order_id,
   										'product_id' => $key,
   										'quantity' => $value);
   					$this->order_items_model->insert($order_item);
   				}
   			}  				
   			
   			$this->session->set_userdata('orders', $orders);
   			$data['orders'] = $this->session->userdata('orders');
 
   			// load the receipt
   			$this->receipt($data);
   		}	
   	}
   	
   	function expiryCheck($year){

   		$month = $this->input->post('creditcard_month');
   		
   		// getting current month and year
   		$cur_month = date('m');
   		$cur_year = date('y');
   		
   		if ($month < 1 || $month > 12){
   			$this->form_validation->set_message('expiryCheck', 'Enter valid month!');
   			return false;
   		}
   		
   		if ($year > $cur_year || ($year == $cur_year && $month >= $cur_month)){
   			return true;
   		} else {
   			$this->form_validation->set_message('expiryCheck', 'This card has expired!');
   			return false;
   		}
   	}
   	
   	function receipt($orders){
   		
   		$this->load->view('orders/receipt', $orders);
   		$this->session->unset_userdata('orders');
   		$this->session->unset_userdata('order_items');
   	}
   	
   	function deleteAllCustomers(){
   		$this->load->model('user_model');
   		$this->user_model->deleteAll();
   		redirect('store/admin', 'refresh');
   	}
   	
   	function deleteAllOrders(){
   		$this->load->model('orders_model');
   		$this->orders_model->deleteAll();
   		redirect('store/admin', 'refresh');
   	}
   	
   	function deleteOrder($id){
   		$this->load->model('order_items_model');
   		if(isset($id)){
   			$this->order_items_model->delete($id);
   		}
   		redirect('store/admin', 'refresh');
   	}
}

