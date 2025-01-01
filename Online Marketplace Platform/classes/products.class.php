<?php


class Products extends Database{
    private $product_id;
    private $product_name;
    private $price;
    private $description;
    private $category;
    private $merchant_id;
    private $image_url;

    public function add_product($product_name,$description, $category, $image_url, $price){
        $stmt = $this -> connect() -> prepare("SELECT * FROM products WHERE product_name = ?");
        if(!$stmt->execute(array($product_name))){
            $stmt = null;
            echo "error";
            exit();
        }

        if($stmt -> rowCount() > 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Product  name already exit </p>";
            exit();
        }

        $stmt = $this -> connect() -> prepare("SELECT * FROM merchants WHERE user_id = ?");

        if(!$stmt -> execute(array($_SESSION['user_id']))){
            $stmt = null;
            echo "error";
            exit();
        }
        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Merchant ID does not exit </p>";
            exit();
        }

        $merchant = $stmt -> fetchAll(PDO::FETCH_ASSOC);


        $stmt = $this-> connect()->prepare("INSERT INTO products (merchant_id,product_name,product_description,product_price,category,image_url) 
        VALUES (?,?,?,?,?,?)");

        if(!$stmt -> execute(array($merchant[0]['merchant_id'],$product_name, $description, $price, $category, $image_url))){
            $stmt = null;
            echo "error";
            exit();
        }
        //echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'>product inserted successfully</p>";
           
       
    }

    public function update_product($product_name, $description, $price, $category){
        $stmt = $this->connect()->prepare("SELECT * FROM products WHERE 
         product_name = ? OR product_description = ?");

        if(!$stmt -> execute(array($product_name, $description))){
            $stmt = null;
            echo "error";
            exit();
        }

        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Product  not found </p>";
       
            exit();
        }

        
        $stmt = $this -> connect() -> prepare("SELECT * FROM merchants WHERE user_id = ?");

        if(!$stmt -> execute(array($_SESSION['user_id']))){
            $stmt = null;
            echo "error";
            exit();
        }
        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Merchant ID does not exit </p>";
            exit();
        }

        $merchant = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->connect()->prepare("UPDATE products SET product_name = ?, product_description = ?, product_price = ?, category = ? 
        WHERE  merchant_id = ?");
         if(!$stmt -> execute(array($product_name, $description, $price, $category, $merchant[0]['merchant_id']))){
            $stmt = null;
            echo "error";
            exit();
        }
        //echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'>product updated successfully </p>";
       
       
    }

    public function delete_product($product_id,$user_id){
        $stmt = $this->connect()->prepare("SELECT * FROM merchants WHERE user_id = ?");
         if(!$stmt -> execute(array($user_id))){
            $stmt = null;
            echo "error";
            exit();
        }
         if($stmt -> rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Merchant  not found </p>";
       
            exit();
        }
        $merchant = $stmt -> fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->connect()->prepare("SELECT * FROM products WHERE product_id = ? AND merchant_id = ?");
        if(!$stmt -> execute(array($product_id,$merchant[0]['merchant_id']))){
            $stmt = null;
            echo "error";
            exit();
        }

        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>Product  not found </p>";
       
            exit();
        }

        $stmt = $this->connect()->prepare("DELETE FROM products WHERE product_id = ? AND merchant_id = ? ");

        if(!$stmt -> execute(array($product_id,$merchant[0]["merchant_id"]))){
            $stmt = null;
            echo "error";
            exit();
        }
        echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px; margin-top:10px;'>Product successfully deleted </p>";
       
       
    }

    public function view_product(){
        $stmt = $this->connect()->prepare("SELECT * FROM products ORDER BY product_id DESC");
        if(!$stmt -> execute(array())){
            $stmt = null;
                echo "error";
                exit();
        }

        if($stmt -> rowCount () == 0){
            echo "<p style='background-color: red; color:white; boarder-radius:10px; padding:10px;'>You dont Product  found </p>";
       
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
                        <tr>
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
                                <td style='height: 100px; width: 100px'>
                                    <img src='../uploads/upload/". $product['image_url'] ."' alt='' w>
                                    
                                </td>

                                <td> Price: ".$product['product_price']."</td>
                                 <td> <input type='number' min='1' name='quantity' required style=' width: 50px;'> 
                                <input type='hidden' name='product_id' value='".$product['product_id']."'> 
                                <input type='hidden' name='product_price' value='".$product['product_price']."'>
                                </td>
                                 <td>
                                   <button type='submit' name='cart' style='background-color:green; color:while; width: 50px;'>Add</button>
                                    
                                </td>
                               
                                
                            </tr>    
                            </form>
                            <hr>
                      
                         
                        
                        
            ";
        }
         echo "  
        </table>
        </div>
        </div>
        </div>";
       
    }

    public function view_merchant_product($user_id){
        $stmt = $this -> connect() ->prepare("SELECT * FROM merchants WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo"error in execute statement";
            exit();
        }

        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: green; color:white; border-radius:10px; padding:10px;'>You dont have product <a href='product-merch.php'>Add products</a>!!</p>";
            exit();
       
        }

        $merchant = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM merchants INNER JOIN products ON merchants.merchant_id = products.merchant_id WHERE user_id = ?");
        if(!$stmt -> execute(array($merchant[0]['user_id']))){
            $stmt = null;
            echo "error occurred while fetching";
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
						<h3>Your poducts</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table>
                            <tr>
                                <td>Product name</td>
                                <td>Description</td>
                                <td>Product price</td>
                                <td>Category</td>
                                <td>Image</td>
                                
                            </tr>

                    ";
        foreach($data as $row){
            echo "
                    
                            <tr>
                              
                                <td>".$row['product_name']."</td>
                                <td>".$row['product_description']."</td>
                                <td>".$row['product_price']."</td>
                                <td>".$row['category']."</td>
                                <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                                <td>
                                    <form action='../merchant/product-merch.php' method='post'>
                                         <input type='hidden' name='product_id' value='".$row['product_id']."'> 
                                        <button type='submit' name='delete' style='background-color:red; color:while; width: 50px;'>Delete</button>
                                        
                                    </form>
                                </td>
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
    public function get_number_product(){

        $stmt = $this -> connect()->prepare("SELECT COUNT(*) FROM products");
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

}