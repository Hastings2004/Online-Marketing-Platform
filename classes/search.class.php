<?php
 


 class Searching extends Database{

    public function search_product($search){
        $stmt = $this -> connect()->prepare("SELECT * FROM products  WHERE 
         product_name LIKE '%$search%' OR product_description LIKE '%$search%' OR category LIKE '%$search%'");

        $stmt->execute();
         
        				
        if($stmt->rowCount() == 0){
            echo "Product not found in the database";
            exit();
        }

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='table-data'>
                <div class='order'>  						 
					<div class='head'>
						<h3>Our products</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
				    </div>
                    
                    <div>
                    <table border=1>
                        <tr style='font-size: 25px;'>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                         
                       
                    ";
        
        foreach($products as $product){
            echo "
            
                            <form action='../customer/shopping-cart.php' method='post'>
                            
                            <tr>
                                <td><h3>".$product['product_name']."</h3></td>
                                <td>
                                    <img src='../uploads/upload/". $product['image_url'] ."' alt='' style='width: 100px;'>
                                    
                                </td>

                                <td> Price: K".$product['product_price']."</td>
                                 <td> <input type='number' min='1' name='quantity' required style=' width: 50px; padding: left 7px;'> 
                                <input type='hidden' name='product_id' value='".$product['product_id']."'> 
                                <input type='hidden' name='product_price' value='".$product['product_price']."'>
                                </td>
                                 <td>
                                   <button type='submit' name='cart' style='background-color:green; color:while; width: 50px;'>Add</button>
                                    
                                </td>
                               
                                
                            </tr>    
                            </form>                       
            ";
        }
         echo "  
        </table>
        </div>
        </div>
        </div>";
 

    }
    public function search_user($search){
        $stmt = $this -> connect()->prepare("SELECT * FROM users  WHERE 
         first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR user_email LIKE '%$search%' OR username LIKE '%$search%'");

        $stmt->execute();
         
        				
        if($stmt->rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Result not found in the Database </p>";
       
            exit();
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>Users searched</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table>
                            <tr>
                                <td>First Name</td>
                                <td>Last Name</td>
                                <td>Email</td>
                                <td>Username</td>
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                                <td>".$row['first_name']."</td>
                                <td>".$row['last_name']."</td>
                                <td>".$row['user_email']."</td>
                                <td>".$row['username']."</td>
                            </tr>
                        
                   ";
        }
    }

    public function search_order($search){
        $stmt = $this -> connect() -> prepare("SELECT * FROM users INNER JOIN customers ON users.user_id = customers.user_id 
        INNER JOIN orders ON customers.customer_id = orders.customer_id 
        INNER JOIN order_items ON orders.order_id = order_items.order_id 
        INNER JOIN products ON order_items.product_id = products.product_id 
        WHERE customer_id LIKE '%$search%' OR product_id LIKE '%$search%' OR product_name LIKE '%$search%' OR order_date LIKE '%$search%'");

       
        if($stmt->rowCount() == 0){
            echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px; margin-top: 20px; border-radius: 10px;'>
            You dont have  any order placed</p>";            
            exit();

        }
        $data = $stmt ->fetchAll(PDO::FETCH_ASSOC);

        if($data[0]['order_status'] == "completed"){
            echo "<div class='table-data' style='color:green;'>
                    <div class='order'>  						 
                        <div class='head'>
                            <h3>Order present</h3>
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
    }

    public function search_all($search){
        
        if($search == ""){
            echo "Searching all customers";
        }
        else{
         $stmt = $this -> connect()->prepare("SELECT * FROM users  WHERE 
         first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR user_email LIKE '%$search%' OR username LIKE '%$search%'");

        $stmt->execute();
         
        				
        if($stmt->rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Result not found in the Database </p>";
       
            exit();
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3> Result</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table>
                            <tr>
                                <td>First Name</td>
                                <td>Last Name</td>
                                <td>Email</td>
                                <td>Username</td>
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                                <td>".$row['first_name']."</td>
                                <td>".$row['last_name']."</td>
                                <td>".$row['user_email']."</td>
                                <td>".$row['username']."</td>
                            </tr>
                        
                   ";
        }
        echo "</table>
        </div>
         </div>
        </div>";
        
         $stmt = $this -> connect()->prepare("SELECT * FROM products  WHERE 
         product_name LIKE '%$search%' OR product_description LIKE '%$search%' OR category LIKE '%$search%'");

        $stmt->execute();
         
        				
        

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<div class='table-data'>
                <div class='order'>  						 
					<div class='head'>
						<h3>Searched products</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
				    </div>
                    
                    <div>
                    <table border=1>
                        <tr style='font-size: 25px;'>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                        </tr>
                         
                       
                    ";
        
        foreach($products as $product){
            echo "
            
                            <form action='../customer/shopping-cart.php' method='post'>
                            
                            <tr>
                                <td><h3>".$product['product_name']."</h3></td>
                                <td>
                                    <img src='../uploads/upload/". $product['image_url'] ."' alt='' style='width: 100px;'>
                                    
                                </td>

                                <td> Price: K".$product['product_price']."</td>
                                 <td> <input type='number' min='1' name='quantity' required style=' width: 50px; padding: left 7px;'> 
                                <input type='hidden' name='product_id' value='".$product['product_id']."'> 
                                <input type='hidden' name='product_price' value='".$product['product_price']."'>
                                </td>
                                 <td>
                                   <button type='submit' name='cart' style='background-color:green; color:while; width: 50px;'>Add</button>
                                    
                                </td>
                               
                                
                            </tr>    
                            </form>                       
            ";
        }
         echo "  
        </table>
        </div>
        </div>
        </div>";
 


    }
    }
     public function search_notification($search){
        $stmt = $this -> connect()->prepare("SELECT * FROM users INNER JOIN notifications ON users.user_id = notifications.user_id WHERE
         notification_id LIKE '%$search%' OR message_created LIKE '%$search%' OR created_time LIKE '%$search%'");

        $stmt->execute();
         
        				
        if($stmt->rowCount() == 0){
            echo "Product not found in the database";
            exit();
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
               echo "<div class='table-data'>
                <div class='order'>  						 
					<div class='head'>
						<h3>Searched Notifications</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
				    </div>
                    
                    <div>
                    <table border=1>
                        <tr style='font-size: 25px;'>
                            <th>First name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Time</th>
                           
                        </tr>
                         
                       
                    ";
        foreach($data as $row){

             echo "                          
                <tr>
                    <td>".$row['user_email']."</td>
                    <td> ". $row['first_name'] ."</td>
                    <td>".$row['message_created']."</td>
                    <td>".$row['created_time']."</td>                            
                    </tr>    
                                                  
            ";
              }
    }

}