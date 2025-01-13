<?php

class ShoppingCart extends Database{
    public function add_cart($user_id, $product_id, $quantity, $price){

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


        $stmt = $this -> connect() -> prepare("INSERT INTO shopping_cart (customer_id, product_id, quantity_sold, product_price) VALUES(?,?,?,?)");

        if(!$stmt->execute(array($customer[0]['customer_id'], $product_id, $quantity, $price))){
            $stmt = null;
            echo"error in execute statement";
            exit();
        }
        echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'>You have succefully added to shopping cart!!</p>";
            
    }

    public function view_cart($user_id){
        $stmt = $this -> connect() -> prepare("SELECT * FROM customers WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo "error";
            exit();
        }
        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'> customer not found !!</p>";
            exit();
       
        }

        $customer = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this -> connect() -> prepare("SELECT * FROM shopping_cart INNER JOIN products ON shopping_cart.product_id = products.product_id WHERE customer_id = ? AND is_placed = 0");
        if(!$stmt->execute(array($customer[0]['customer_id']))){
            $stmt = null;
            echo "error";
            exit();
        }
        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'> No items found in your shopping cart!!</p>";
            exit();
       
        }
        $carts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<div class='table-data'>
				<div class='order'>  						 
					<div class='head'>
						<h3>You shopping Cart</h3>
						<i class='bx bx-search'></i>
						<i class='bx bx-filter'></i>
					</div>
                    <div>
                        <table>
                            <tr>
                                <td>Product name</td>
                                <td>Quantity</td>
                                <td>Price</td>
                                <td>Product</td>
                                <td>
                                    <form action='order.php' method='post'>
                                        <button type='submit' name='place-order' style='background-color:green; color:while; width: 80px;'>Place order</button>
                                        
                                    </form>
                                
                                </td>

                                
                            </tr>
                            

                    ";
                    foreach($carts as $row){

                    
            echo "
                    
                            <tr>
                                <td>".$row['product_name']."</td>
                                <td>".$row['quantity_sold']."</td>
                                <td>".$row['product_price']."</td>
                                <td> <img src='../uploads/upload/". $row['image_url'] ."' alt=''></td>
                                <td> 
                                    <form action='../customer/order.php' method='post'>
                                         <input type='hidden' name='product_id' value='".$row['product_id']."'> 
                                        <button type='submit' name='delete' style='background-color:red; color:while; width: 50px;'>remove</button>
                                        
                                    </form>
                                
                                </td>
                            </tr>
                          <hr />
                        
                   ";

       
            }


    }
    public function delete_cart($user_id, $product_id){
        $stmt = $this -> connect() -> prepare("SELECT * FROM customers WHERE user_id = ?");
        if(!$stmt->execute(array($user_id))){
            $stmt = null;
            echo "error";
            exit();
        }
        if($stmt -> rowCount() == 0){
            echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'> customer not found !!</p>";
            exit();
       
        }

        $customer = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = $this -> connect() -> prepare("DELETE FROM shopping_cart WHERE customer_id = ? AND product_id = ?");
        if(!$stmt->execute(array($customer[0]['customer_id'],$product_id))){
            $stmt = null;
            echo 'error';
            exit();
        }
        echo "<p style='background-color: green; color:white; boarder-radius:10px; padding:10px;'>Successfully removed!!</p>";
           
    }

    
}
