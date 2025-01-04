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
        $stmt = $this -> connect()->prepare("SELECT * FROM orders  WHERE 
         order_id LIKE '%$search%' OR customer_id LIKE '%$search%' OR 	total_amount LIKE '%$search%' OR	order_status LIKE '%$search%' OR created_at LIKE '%$search%'");

        $stmt->execute();
         
        				
        if($stmt->rowCount() == 0){
            echo "Product not found in the database";
            exit();
        }

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $row){
            echo "<a href='../customer/home.html'>'data: " . $row['order_id'] ." ". $row['customer_id'] ." ". $row['total_amount'] ." ". $row['order_status']. "  ". $row['created_at']."</a></br>";
        }
    }

    public function search_all($search){
        
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