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

        //echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'> Order successfully placed</p>";
        
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
    $stmt = $this->connect() -> prepare("SELECT * FROM products WHERE merchant_id = ?");
    
    
    $message = "You have new order from ".$_SESSION['first_name']."";
    $stmt = $this -> connect() -> prepare("INSERT INTO notifications (user_id,message_created, is_read) VALUES (?, ?,?)");
    if(!$stmt -> execute(array(3, $message, 0))){
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
    public function get_browser_order($user_id){
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

        $stmt = $this -> connect() -> prepare("SELECT * FROM orders INNER JOIN order_items ON orders.order_id = order_items.order_id INNER JOIN products ON products.product_id = order_items.product_id WHERE customer_id =?");

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
						<h3>Order present</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table>
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
                                <td>".$row['order_status']."</td>
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

    public function get_merchant_orders($user_id){
        $stmt = $this -> connect() -> prepare("SELECT * FROM merchants WHERE user_id =?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo "error in execution";
            exit();
        }
        if($stmt->rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>
            You dont have any order  </p>";            
            exit();

        }

        $merchant = $stmt -> fetchAll(PDO::FETCH_ASSOC);

      
        $stmt = $this -> connect() -> prepare("SELECT * FROM users INNER JOIN customers ON users.user_id = customers.user_id 
        INNER JOIN orders ON customers.customer_id = orders.customer_id 
        INNER JOIN order_items ON orders.order_id = order_items.order_id 
        INNER JOIN products ON order_items.product_id = products.product_id WHERE merchant_id = ?");

        if(!$stmt->execute(array($merchant[0]["merchant_id"]))){
            $stmt = null;
            echo "error in execution";
            exit();
        }
        if($stmt->rowCount() == 0){
            echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px; margin-top: 20px; border-radius: 10px;'>
            You dont have  any order placed</p>";            
            exit();

        }
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data' style='color:green;'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Order present</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table>
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
                                <td>".$row['order_status']."</td>
                                <td>".$row['created_at']."</td>
                                <td>".$row['product_name']."</td>
                                <td>".$row['quantity']."</td>
                                <td>".$row['product_price']."</td>
                                <td>".$row['category']."</td>
                                <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                                <td>".$row['total_price']."</td>
                                <td>".$row['total_amount']."</td>
                            </tr>
                            <hr>
      
                                ";
       }
        echo "  
        </table>
        </div>
        </div>
        </div>"; 

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
                                <td>".$row['order_status']."</td>
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

        $stmt = $this -> connect() -> prepare("SELECT AVG(total_price) AS total FROM order_items INNER JOIN products ON order_items.product_id = products.product_id WHERE merchant_id = ?");
       
        if(!$stmt->execute(array($merchant[0]['merchant_id']))){
            $stmt = null;
            echo "Error during processing";
            exit();
        }
        $amount = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $total = $amount[0]["total"];

        echo $total;
    }


    

}