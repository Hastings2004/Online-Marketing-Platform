<?php
session_start();
include '../database/database.php';
include '../classes/oders.class.php';
include '../classes/shopping-cart.class.php';
include '../classes/notification.class.php';
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

	<title>Customer Order</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<span class="text" style="margin-left: 10px; color:green;">ElectronicHub</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="home.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Home</span>
				</a>
			</li>
            <li>
				<a href="#">
					<i class='bx bxs-group' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li>
				<a href="product.php">
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
				<a href="notify.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Notification</span>
				</a>
			</li>
			<li class="active">
				<a href="order.php">
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
					<i class='bx bxs-log-out-circle' ></i>
                    <button name="logout_btn" id="logout" type="submit" class="text"><i class='bx bxs-log-out-circle' ></i>Logout</button>
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
			<a href="notify.php" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">
					<?php
						
						$unread = new Notifications();
						$unread -> get_Uread_notification();
					
					?>
				</span>
			</a>
			<a href="profile.php" class="profile">
				<img src="../usericon.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<marquee behavior="" direction="right"><h1>Welcome Customer! <?php echo   $_SESSION['first_name'];?></h1></marquee><br>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<?php
				     if(isset($_POST['place-order'])){
						$order = new Orders();
						$order -> place_order($_SESSION['user_id']);
					}
				?>
				<?php
				if(isset($_POST['delete'])){
					$product_id = $_POST['product_id'];

					$delete = new ShoppingCart();
					$delete -> delete_cart($_SESSION['user_id'],$product_id);
				}
				
				?>
				
				
			</ul>


				<?php
				$order = new Orders();
				$order -> get_browser_order($_SESSION['user_id']);
				
				?>

				
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>