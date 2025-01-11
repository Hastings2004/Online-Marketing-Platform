<?php
session_start();
include "../database/database.php";
include "../classes/products.class.php";
include "../classes/notification.class.php";
include "../classes/oders.class.php";
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

	<title>Merchant Orders</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<span class="text" style="margin-left: 10px;">Online Marketing</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="dash-merch.PHP">
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
			<li>
				<a href="product-merch.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li>
				<a href="customers.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Customers</span>
				</a>
			</li>
			<li>
				<a href="notification-merchant.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Notification</span>
				</a>
			</li>
			<li class="active">
				<a href="orders-merch.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Orders</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog'></i>
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
					<input type="text" placeholder="Search..." name="search">
					<button type="submit" class="search-btn" name="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="notification-merchant.php" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">
					<?php
						
						$unread = new Notifications();
						$unread -> get_Uread_notification();
					
					?>
				</span>
			</a>
			<a href="profile-merchant.php" class="profile">
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
							<a href="dash-merch.PHP">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="orders-merch.php">Orders</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>Product</h3>
						<p><a href="product.html">View</a></p>
					</span>
				</li>
				
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3><?php
							   $orders = new Orders();
							   $orders -> get_number_order();
							
							?></h3>
						<p>Orders</p>
					</span>
				</li>
              
			</ul>
			<?php
			if(isset($_GET['search-btn'])){
					$search = $_GET['search'];
					$search = new Searching();
					$search -> search_order($search);
				}
			if(isset($_POST['approve'])){
				$order_id = $_POST['order_id'];
				$orders = new Orders();
				$orders -> approve_order($order_id);
			}
				$orders = new Orders();
				$orders -> get_merchant_orders($_SESSION['user_id']);
				
			?>

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>