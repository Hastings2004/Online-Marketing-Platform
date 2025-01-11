<?php
session_start();
include("../database/database.php");
include '../classes/oders.class.php';
include "../classes/products.class.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../css/style.css">

	<title>Merchant Products</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<span class="text" style="margin-left: 10px;">ElectronicHub</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="../merchant/dash-merch.PHP">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Home</span>
				</a>
			</li>
            <li>
				<a href="../merchant/profile.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li>
				<a href="../merchant/product-merch.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Customers</span>
				</a>
			</li>
			<li>
				<a href="../merchant/notification-merchant.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Notification</span>
				</a>
			</li>
			<li>
				<a href="../merchant/orders-merch.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Orders</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				
				<form action="../includes/logout.php" method="post">
					
                    <button name="logout_btn" id="logout" type="submit" class="text"><i class='bx bxs-log-out-circle' ></i>
						Logout</button>
                </form>
				
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' >N</i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="../usericon.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Welcome Merchant <?php echo   $_SESSION['first_name'];?></h1>
					 <br>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Products</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>



			<div class="table-data">
            <?php

              
                
				if(isset($_POST['update'])){
					$product_name = $_POST['product-name'];
                        $product_price = $_POST['product-price'];
                        $description = $_POST['description'];
                        $category = $_POST['category'];
					
                        $file = $_FILES['file'];
                        $file_name = $_FILES['file']['name'];
                        $file_tmp = $_FILES['file']['tmp_name'];
                        $file_type = $_FILES['file']['type'];
                        $file_size = $_FILES['file']['size'];
                        $file_error = $_FILES['file']['error'];

                        $file_ex = explode(".",$file_name);
                        $fileActualEx = strtolower(end($file_ex));

                        $allowed = array('jpg','jpeg', 'png','pdf');

                        if(in_array($fileActualEx, $allowed)){
                            if($file_error === 0){
                            // if(file_exists($file_tmp)) 
                                if($file_size < 10000000){
                                    $fileNewName = $product_name. ".".$fileActualEx;

                                    $fileFolder = 'upload/'. $fileNewName;
                                    move_uploaded_file($file_tmp, $fileFolder);
                                    $product = new Products();
						

									$product -> update_product($product_name,$description,$product_price,$category,$fileNewName);
									echo "<p style='background-color: green; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                        Product updated successfully</p>";
								                 
                                }
                                    else{
                                        echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                                file is too large try again</p>";
                                                                exit();
                                                            
                                    }
                                }
                                else{
                                    echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                    An error occur during upload</p>";
                                    exit();
                                }
                            }
                        else{
                            echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                Invalid file format</p>";
                                                exit();
                            }

                        

				}
				/*f(isset($_POST["receipt"])){
					$payment_amount = $_POST["payment-amount"];
					$payment_date = $_POST["payment-date"];

					$file = $_FILES['file'];
                        $file_name = $_FILES['file']['name'];
                        $file_tmp = $_FILES['file']['tmp_name'];
                        $file_type = $_FILES['file']['type'];
                        $file_size = $_FILES['file']['size'];
                        $file_error = $_FILES['file']['error'];

                        $file_ex = explode(".",$file_name);
                        $fileActualEx = strtolower(end($file_ex));

                        $allowed = array('jpg','jpeg', 'png','pdf');

                        if(in_array($fileActualEx, $allowed)){
                            if($file_error === 0){
                            // if(file_exists($file_tmp)) 
                                if($file_size < 10000000){
                                    $fileNewName = "receipt from ".$_SESSION['first_name'].".".$fileActualEx;

                                    $payment = new Orders();
						

									$payment -> payment_order($_SESSION['user_id'],$payment_amount,$payment_date,$fileNewName);
									
                                    $fileFolder = 'upload/'. $fileNewName;
                                    move_uploaded_file($file_tmp, $fileFolder);

									
                                }
                                    else{
                                        echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                                file is too large try again</p>";
                                                                exit();
                                                            
                                    }
                                }
                                else{
                                    echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                    An error occur during upload</p>";
                                    exit();
                                }
                            }
                        else{
                            echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                Invalid file format</p>";
                                                exit();
                            }

                            

                        } 
                        
				*/


                    if(isset($_POST['add-product'])){
                        $product_name = $_POST['product-name'];
                        $product_price = $_POST['product-price'];
                        $description = $_POST['description'];
                        $category = $_POST['category'];
					
                        $file = $_FILES['file'];
                        $file_name = $_FILES['file']['name'];
                        $file_tmp = $_FILES['file']['tmp_name'];
                        $file_type = $_FILES['file']['type'];
                        $file_size = $_FILES['file']['size'];
                        $file_error = $_FILES['file']['error'];

                        $file_ex = explode(".",$file_name);
                        $fileActualEx = strtolower(end($file_ex));

                        $allowed = array('jpg','jpeg', 'png','pdf');

                        if(in_array($fileActualEx, $allowed)){
                            if($file_error === 0){
                            // if(file_exists($file_tmp)) 
                                if($file_size < 10000000){
                                    $fileNewName = $product_name. ".".$fileActualEx;

                                    $fileFolder = 'upload/'. $fileNewName;
                                    move_uploaded_file($file_tmp, $fileFolder);
                                    $product = new Products();
						

									$product -> add_product($product_name, $description, $category,$fileNewName,$product_price);
									echo "<p style='background-color: green; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                        Product added successfully</p>";
								                 
                                }
                                    else{
                                        echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                                file is too large try again</p>";
                                                                exit();
                                                            
                                    }
                                }
                                else{
                                    echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                    An error occur during upload</p>";
                                    exit();
                                }
                            }
                        else{
                            echo "<p style='background-color: red; color:white; padding-left:30px; padding:10px; border-radius: 10px;'>
                                                Invalid file format</p>";
                                                exit();
                            }

                            

                        } 
                        
                    ?>
                                                

			</div>
			
				
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>

   

                    
    




                       