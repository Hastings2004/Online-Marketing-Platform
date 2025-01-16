<?php

class Orders extends Database{
    private $customer_id;
    private	$total_amount;
    private	$order_status;
    private $created_at;

    // this function is used to place the order
    public function place_order($user_id){
        $stmt = $this -> connect() ->prepare("SELECT * FROM customers WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo"error in execute statement";
            exit();
        }

        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Customer ID not found!!</p>";
            exit();
       
        }

        $customer = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM shopping_cart WHERE customer_id = ? AND is_placed = ?");

        if(!$stmt->execute(array($customer[0]['customer_id'],0))) {
            $stmt = null;
            echo "error in execution";
            exit();
        }

        if($stmt->rowCount() == 0) {
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>
            You dont have products in your shopping cart </p>";            
            exit();
        }
        $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        $total_amount = 0;
        foreach ($cart_items as $item) {
            $item_total = $item['quantity_sold'] * $item['product_price'];
            $total_amount += $item_total;
        }


        $order_status = "pending";
             
        $stmt = $this-> connect() -> prepare("INSERT INTO orders (customer_id,total_amount,order_status) VALUES (?,?,?)");

        if(!$stmt->execute(array($customer[0]['customer_id'], $total_amount,$order_status))) {
            $stmt = null;
            echo "error in execution";
            exit();
        }

                
        $last_order_id = $this-> connect() -> lastInsertId();
        /*if(!$stmt->execute(array($customer[0]['customer_id']))) {
            $stmt = null;
            echo "error in execution";
            exit();
        }
       $last_order_id = 1;*/

       foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity_sold'];
            $product_price = $item['product_price'];
            $item_total = $quantity * $product_price;

            $stmt = $this->connect() -> prepare("INSERT INTO order_items (order_id,product_id,quantity,product_price,total_price) VALUES (?,?,?,?,?)");

                
            if(!$stmt->execute(array($last_order_id, $product_id, $quantity, $product_price, $total_amount ))) {
                $stmt = null;
                echo "error in execution";
                exit();
            }

       }
       $stmt = $this->connect() -> prepare("UPDATE shopping_cart SET is_placed = 1 WHERE customer_id = ?");
       if(!$stmt->execute(array($customer[0]['customer_id']))) {
        $stmt = null;
        echo "error in execution";
        exit();
    }
    $stmt = $this->connect() -> prepare("SELECT * FROM products WHERE product_id = ?");
    if(!$stmt->execute(array($cart_items[0]['product_id']))) {
        $stmt = null;
        echo "error in executing stmt";
        exit();
    }

    $merchant = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $this->connect() -> prepare("SELECT * FROM merchants WHERE merchant_id = ?");
    if(!$stmt->execute(array($merchant[0]['merchant_id']))) {
        $stmt = null;
        echo "error in executing stmt";
        exit();
    }

    $users = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    
    $message = "You have new order from ".$_SESSION['first_name']."";
    $stmt = $this -> connect() -> prepare("INSERT INTO notifications (user_id,message_created, is_read) VALUES (?, ?,?)");
    if(!$stmt -> execute(array($users[0]['user_id'], $message, 0))){
        $stmt = null;
        echo "error";
        exit();
    }

    $stmt = $this->connect() -> prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY order_id DESC LIMIT 1");
    if(!$stmt -> execute(array($customer[0]['customer_id']))){
        $stmt = null;
        echo "error in execution"; 
        exit();
    }
    $orders = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    $stmt = $this -> connect() -> prepare("UPDATE order_items SET order_id = ? WHERE total_price = ? ORDER BY order_id DESC LIMIT 10");
    if(!$stmt -> execute(array($orders[0]["order_id"], $orders[0]['total_amount']) )){
        $stmt = null;
        echo 'error occur during execution';
        exit();
    }




       echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'> You have successfully place an order <a href='shopping-cart.php' >See detailds</a></p>";

       
    }

    // this function is used to get number of orders
    public function get_number_order(){

        $stmt = $this -> connect()->prepare("SELECT COUNT(*) FROM orders");
        if(!$stmt->execute()){
            $stmt = null;
            echo "error in execution";
            exit();
        }
        if($stmt->rowCount() == 0){
            echo "0";
            exit();
        }
        $orders = $stmt->fetchColumn();
    
        echo $orders;
    
    }
    // this function is used to get order details to a customer
    public function get_customer_orders($user_id){
        $stmt = $this -> connect() ->prepare("SELECT * FROM customers WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo"error in execute statement";
            exit();
        }

        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Customer ID not found!!</p>";
            exit();
       
        }

        $customer = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM orders INNER JOIN order_items ON orders.order_id = order_items.order_id INNER JOIN products ON products.product_id = order_items.product_id WHERE customer_id =? ORDER BY orders.created_at DESC");

        if(!$stmt->execute(array($customer[0]['customer_id']))){
            $stmt = null;
            echo "ERROR in execution";
            exit();
        }

        if($stmt->rowCount() == 0){
            echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'>Customer you dont have any order!! make order</p>";
          
            exit();
        }
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        if($data[0]['order_status'] == "completed"){
             echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Recent Orders</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table border=1>
                            <tr>
                                <td>Product name</td>
                                <td>Quantity</td>
                                <td>Price </td>
                                <td>Order ID</td>
                                <td>Order status</td>
                                <td>Order date</td>
                                <td>Total amount</td>
                                <td>Product image</td>
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                                <td>".$row['product_name']."</td>
                                <td>".$row['quantity']."</td>
                                <td>".$row['product_price']."</td>
                                <td>".$row['order_id']."</td>
                                <td><p style='background-color:green; padding:7px; color:white;'>".$row['order_status']."</p></td>
                                <td>".$row['created_at']."</td>
                                
                                <td>".$row['total_price']."</td>
                                <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                                
                            </tr>
      
                            ";
                          


        }
        echo "  
        </table>
        </div>
        </div>
        </div>";
        

        }
        else{

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Recent Orders</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table border=1>
                            <tr>
                                <td>Product name</td>
                                <td>Quantity</td>
                                <td>Price </td>
                                <td>Order ID</td>
                                <td>Order status</td>
                                <td>Order date</td>
                                <td>Total amount</td>
                                <td>Product image</td>
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                                <td>".$row['product_name']."</td>
                                <td>".$row['quantity']."</td>
                                <td>".$row['product_price']."</td>
                                <td>".$row['order_id']."</td>
                                <td><p style='background-color:green; padding:7px; color:white;'>".$row['order_status']."</p></td>
                                <td>".$row['created_at']."</td>
                                
                                <td>".$row['total_price']."</td>
                                <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                                <td> 
                                    <form action='order.php' method='post'>
                                        <button type='submit' name='cancel' style='background-color:green; color:while; width: 50px;'>Cancel</button>
                                    </form>
                                </td>
                            </tr>
      
                            ";
                          


        }
       /* echo "  
        </table>
        </div>
        </div>
        </div>
                <div class='table-data'>
                <div class='order'>                          
                    <div class='head'>
                        <h3>Upload Payment Receipt</h3>
                        <i class='bx bx-search' ></i>
                        <i class='bx bx-filter' ></i>
                    </div>
                    <div>
                        <form action='../uploads/uploads.php' method='post' enctype='multipart/form-data'>
                            <table>
                                <tr>
                                    <td><span class='text'>Total Amount</span></td>
                                    <td><input type='number' name='total-amount' id=‘product-name’ class=‘input’ required ></td>
                                </tr>
                                <tr>
                                    <td><span class='text'>Payment Date</span></td>
                                    <td><input type='date' name='payment-date' class=‘input’ required></td>
                                </tr>
                                <tr>
                                    <td><span>Payment Receipt</span> </td>
                                    <td><input type='file' id=‘Image’ name='file' required> </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><button type='submit' name='receipt'>Upload</button> </td>
                                </tr>
                            </table>
                        </form>
                       
                        
                    </div>
                
                
                </div>
            </div>

";*/

        }
    }
    public function get_all_browsed_orders($user_id){
        $stmt = $this -> connect() ->prepare("SELECT * FROM customers WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo"error in execute statement";
            exit();
        }

        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Customer ID not found!!</p>";
            exit();
       
        }

        $customer = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM orders INNER JOIN order_items ON orders.order_id = order_items.order_id INNER JOIN products ON products.product_id = order_items.product_id WHERE customer_id =? ORDER BY created_at DESC LIMIT 10");

        if(!$stmt->execute(array($customer[0]['customer_id']))){
            $stmt = null;
            echo "ERROR in execution";
            exit();
        }

        if($stmt->rowCount() == 0){
            echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'>Customer you dont have any order!! <a href='home.php'>make order</a></p>";
          
            exit();
        }
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Recent Orders</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table border=1>
                            <tr>
                                <td>Product name</td>
                                <td>Quantity</td>
                                <td>Price </td>
                                <td>Order ID</td>
                                <td>Order status</td>
                                <td>Order date</td>
                               
                                <td>Total amount</td>
                                <td>Product image</td>
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                                <td>".$row['product_name']."</td>
                                <td>".$row['quantity']."</td>
                                <td>".$row['product_price']."</td>
                                <td>".$row['order_id']."</td>
                                <td><p style='background-color:green; padding:7px; color:white;'>".$row['order_status']."</p></td>
                                <td>".$row['created_at']."</td>
                                <td>".$row['total_price']."</td>
                                <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                            </tr>
      
                            ";
                          


        }
        echo "  
        </table>
        </div>
        </div>
        </div>"; 
    }

    public function get_merchant_orders($user_id){
         $stmt = $this -> connect() ->prepare("SELECT * FROM merchants WHERE user_id = ?");
       
         if(!$stmt -> execute(array($user_id))){
            $stmt = null;
            echo '';
            exit();
        }
        $merchant = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
        $this -> merchant_orders($merchant[0]['merchant_id'], "pending");
             
        $this -> merchant_orders($merchant[0]['merchant_id'], "completed");
    }

    public function view(){

        $stmt = $this -> connect() -> prepare("SELECT * FROM orders INNER JOIN order_items ON orders.order_id = order_items.order_id 
        INNER JOIN products ON products.product_id = order_items.product_id");

        if(!$stmt->execute()){
            $stmt = null;
            echo "ERROR in execution";
            exit();
        }

        if($stmt->rowCount() == 0){
            echo "0";
            exit();
        }
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Order present</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table border=1>
                            <tr>
                                <td>Order ID</td>
                                <td>Order status</td>
                                <td>Order date</td>
                                <td>Product name</td>
                                <td>Quantity</td>
                                <td>Price </td>
                                <td>Total amount</td>
                                <td>Product image</td>
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                                <td>".$row['order_id']."</td>
                                <td> <p style='background-color:green; padding:7px; color:white;'>".$row['order_status']."<p></td>
                                <td>".$row['created_at']."</td>
                                <td>".$row['product_name']."</td>
                                <td>".$row['quantity']."</td>
                                <td>".$row['product_price']."</td>
                                <td>".$row['total_price']."</td>
                                <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                            </tr>
      
                            ";
                          


        }
        echo "  
        </table>
        </div>
        </div>
        </div>"; 
    }

    public function get_total_sales($user_id){
        $stmt = $this -> connect() -> prepare("SELECT * FROM merchants WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo "error during prepare statement";
            exit();
        }
        $merchant = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT SUM(total_price) AS total FROM order_items INNER JOIN products ON order_items.product_id = products.product_id WHERE merchant_id = ?");
       
        if(!$stmt->execute(array($merchant[0]['merchant_id']))){
            $stmt = null;
            echo "Error during processing";
            exit();
        }
        $amount = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $total = $amount[0]["total"];

        echo $total;
    }

    public function cancel_order($user_id){
        $stmt = $this -> connect() -> prepare("SELECT * FROM customers WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo "error during processing";
            exit();
        }
        $customer = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM orders WHERE customer_id = ?");
        if(!$stmt->execute(array($customer[0]["customer_id"]))){
            $stmt = null;
            echo "error during processing";
            exit();
        }
        $orders = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("DELETE FROM orders WHERE customer_id = ? AND order_id = ? ORDER BY created_at DESC LIMIT 1");

        if(!$stmt->execute(array($orders[0]["customer_id"], $orders[0]['order_id']))){
            $stmt = null;
            echo 'error during processing';
            exit();
        }

        $stmt = $this -> connect() -> prepare('SELECT * FROM order_items WHERE order_id = ? ORDER BY order_item_id DESC');
        if(!$stmt->execute(array($orders[0]['order_id']))){
            $stmt = null;
            echo 'Error during processing';
            exit();

        }
        $order_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($order_items as $order_item){
            $order_id = $order_item['order_id'];
            $order_item_id = $order_item['order_item_id'];

            $stmt = $this -> connect() -> prepare('DELETE FROM order_items WHERE order_item_id = ? AND order_id = ?');
            if(!$stmt->execute(array($order_item_id, $order_id))){
                $stmt = null;
                echo 'error during deleting iterms';
                exit();
            }
        }
        $stmt = $this->connect() -> prepare("SELECT * FROM products WHERE product_id = ?");
        if(!$stmt->execute(array($order_items[0]['product_id']))) {
            $stmt = null;
            echo "error in executing stmt";
            exit();
        }

        $merchant = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = $this->connect() -> prepare("SELECT * FROM merchants WHERE merchant_id = ?");
        if(!$stmt->execute(array($merchant[0]['merchant_id']))) {
            $stmt = null;
            echo "error in executing stmt";
            exit();
        }
         $stmt = $this->connect() -> prepare("SELECT * FROM merchants WHERE merchant_id = ?");
        if(!$stmt->execute(array($merchant[0]['merchant_id']))) {
            $stmt = null;
            echo "error in executing stmt";
            exit();
        }

        $users = $stmt ->fetchAll(PDO::FETCH_ASSOC);
        
        $message = $_SESSION['first_name']." has cancel the transaction";
        $stmt = $this -> connect() -> prepare("INSERT INTO notifications (user_id,message_created, is_read) VALUES (?, ?,?)");
        if(!$stmt -> execute(array($users[0]['user_id'], $message, 0))){
            $stmt = null;
            echo "error";
            exit();
        }
         echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px; margin-top: 20px; border-radius: 10px;'>
            Your order has been canceled</p>";



    }

    public function approve_order($order_id) {
       
        $stmt = $this -> connect() -> prepare("UPDATE orders SET order_status = ? WHERE order_id =?");
        if(!$stmt->execute(array("completed",$order_id))) {
            $stmt = null;
            echo "error in prepare statement";
            exit();
        }
         echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px; margin-top: 20px; border-radius: 10px;'>
            The order approved successfully</p>";


    }
   

    public function payment_order($user_id,$paymemt_amount,	$payment_date,$payment_receipt){
        $stmt = $this -> connect() -> prepare("SELECT * FROM customers WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))) {
            $stmt = null;
            echo "error during execution";
            exit();
        }
        $customer = $stmt-> fetch(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT *  FROM orders WHERE customer_id = ? ORDER BY created_at DESC LIMIT 1");
        if(!$stmt -> execute(array($customer[0]["customer_id"]))){
            $stmt = null;
            echo "Error occur";
            exit();
        }
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($paymemt_amount < $orders[0]['total_amount']){
             echo "<p style='background-color: red; color:white; border-radius:10px; padding:10px; margin-top: 20px; border-radius: 10px;'>
            Your payment amount is low</p>";
            exit();
        }
        $stmt = $this -> connect() -> prepare("INSERT INTO payments (order_id,paymemt_amount,payment_date,payment_receipt) VALUES (?,?,?,?)");
        if(!$stmt -> execute(array($orders[0]['order_id'],$paymemt_amount,	$payment_date,$payment_receipt))) {
            $stmt = null;
            echo "error occur";
            exit();
        }
    }

    public function merchant_orders($merchant_id, $order_status){
       
      
        $stmt = $this -> connect() -> prepare("SELECT * FROM users 
        INNER JOIN customers ON users.user_id = customers.user_id 
        INNER JOIN orders ON customers.customer_id = orders.customer_id 
        INNER JOIN order_items ON orders.order_id = order_items.order_id 
        INNER JOIN products ON order_items.product_id = products.product_id 
        WHERE products.merchant_id = ? AND orders.order_status = ? ORDER BY orders.created_at DESC;");

        if(!$stmt->execute(array($merchant_id, $order_status))){
            $stmt = null;
            echo "error in execution";
            exit();
        }
        if($stmt->rowCount() == 0){
            echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px; margin-top: 20px; border-radius: 10px;'>
            You dont have  any order placed</p>";            
            exit();

        }
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        if($data[0]['order_status']  == "completed"){    
            echo "<div class='table-data' style='color:green;'>
                    <div class='order'>  						 
                        <div class='head'>
                            <h3>".$order_status." Orders</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <div>
                        
                            <table border=1>
                                <tr>
                                    <td>first name</td>
                                    <td>last name</td>
                                    <td>Email</td>
                                    <td>Order Status</td>
                                    <td>Order Date</td>
                                    <td>Product Name</td>
                                    <td>Quantity</td>
                                    <td>Price</td>
                                    <td>Category</td>
                                    <td>Image</td>
                                    <td>Total Price</td>
                                    <td>Total Amount</td>
                                </tr>

                        ";
            foreach($data as $row){
                echo "
                        
                                <tr>
                                    
                                    <td>".$row['first_name']."</td>
                                    <td>".$row['last_name']."</td>
                                    <td>".$row['user_email']."</td>
                                    <td><p style='background-color:green; padding:7px; color:white;'>".$row['order_status']."</p></td>
                                    <td>".$row['created_at']."</td>
                                    <td>".$row['product_name']."</td>
                                    <td>".$row['quantity']."</td>
                                    <td>".$row['product_price']."</td>
                                    <td>".$row['category']."</td>
                                    <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                                    <td>".$row['total_price']."</td>
                                    <td>".$row['total_amount']."</td>
                                    
                                </tr>
                                
        
                                    ";
        }
            echo "  
        
            </table>
            </div>
            </div>
            </div>"; 

        }
        
        else{
            echo "<div class='table-data' style='color:green;'>
                    <div class='order'>  						 
                        <div class='head'>
                            <h3>Recent present</h3>
                            <i class='bx bx-search'></i>
                            <i class='bx bx-filter'></i>
                        </div>
                        <div>
                        
                            <table border=1>
                                <tr>
                                <td>Order ID</td>
                                    <td>first name</td>
                                    <td>last name</td>
                                    <td>Email</td>
                                    <td>Order Status</td>
                                    <td>Order Date</td>
                                    <td>Product Name</td>
                                    <td>Quantity</td>
                                    <td>Price</td>
                                    <td>Category</td>
                                    <td>Image</td>
                                    <td>Total Price</td>
                                    <td>Total Amount</td>
                                </tr>

                        ";
            foreach($data as $row){
                echo "
                        
                                <tr> 
                                    <td>".$row['order_id']."</td>
                                    <td>".$row['first_name']."</td>
                                    <td>".$row['last_name']."</td>
                                    <td>".$row['user_email']."</td>
                                    <td><p style='background-color:green; padding:7px; color:white;'>".$row['order_status']."</p></td>
                                    <td>".$row['created_at']."</td>
                                    <td>".$row['product_name']."</td>
                                    <td>".$row['quantity']."</td>
                                    <td>".$row['product_price']."</td>
                                    <td>".$row['category']."</td>
                                    <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                                    <td>".$row['total_price']."</td>
                                    <td>".$row['total_amount']."</td>
                                    <td> 
                                        <form action='../merchant/orders-merch.php' method='post'>
                                            <input type='hidden' name='order_id' value='".$row["order_id"].">
                                            <input type='submit' name='approve' value='Approve' />
                                            <button type='submit' name='approve' style='background-color:green; color:while; width: 50px;'>Approve</button>
                                            
                                        </form>
                                        

                                            
                                    </td>
                                </tr>
                                
        
                                    ";
        }
            echo "  
        
            </table>
            </div>
            </div>
            </div>"; 
        }
        
        
    }
    

}
