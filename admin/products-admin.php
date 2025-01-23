<?php
session_start();
include '../database/database.php';
include '../classes/notification.class.php';
include '../classes/search.class.php';
include '../classes/products.class.php';

if(!isset($_SESSION['user_id'])) {
	header('location:../index.php');
}
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

	<title>Admin Products</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Online Marketing</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="admin-dash.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Home</span>
				</a>
			</li>
			<li>
				<a href="profile.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li class="active">
				<a href="products-admin.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li>
				<a href="shopping-cart.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Shopping Cart</span>
				</a>
			</li>
			<li>
				<a href="users-admin.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li>
				<a href="notification-admin.php">
					<i class='bx bxs-bell' ></i>
					<span class="text">Notification</span>
				</a>
			</li>
			<li>
				<a href="orders.php">
					<i class='bx bxs-message-dots' ></i>
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
				<a href="#" class="logout">
					<form action="../includes/logout.php" method="post">
						<i class='bx bxs-log-out-circle' ></i>
                        <button name="logout_btn" id="logout" type="submit" class="text">Logout</button>
                    </form>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			
				<select name="category"  class="nav-link" style="border: 0px;">
					<option value="">----Category-----</option>
					<option value="clothes">Clothes</option>
					<option value="electronic">Electronics</option>
				</select>
			
			<form action="products-admin.php" method="get">
				<div class="form-input">
					<input type="text" placeholder="Search..." name="search" required>
					<button type="submit" name="search-btn" class="search-btn">s<i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="notification-admin.php" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">
				<?php
						
						$unread = new Notifications();
						$unread -> get_Uread_notification();
					
					?>
				</span>
			</a>
			<a href="profile-admin.php" class="profile">
				<img src="../usericon.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
				<marquee behavior="alternate" direction="right"><h1>Welcome Admin <?php echo   $_SESSION['first_name'];?></h1></marquee>
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

			


					
				<?php
				 $products = new Products();
				/*if(isset($_GET['category'])){
					if($_GET['category'] == 'clothes'){
						$products -> list_category('clothes');
					}
					else{
						$products -> list_category('electronic');
						exit();
					}
				}*/
				if(isset($_GET['search-btn'])){
						
					$search = $_GET['search'];

					$result = new Searching();
					
					
					$result -> search_product($search);	
						  
				}
				    
					
				    
					 $products -> list_of_product();
				
				?>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>