<?php
session_start();
include '../database/database.php';
include '../classes/notification.class.php';
include '../classes/search.class.php';
include '../classes/users.class.php';
include '../classes/oders.class.php';
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

	<title>Admin Dashboard</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Online Marketing</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="admin-dash.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Home</span>
				</a>
			</li>
			<li>
				<a href="profile.php">
					<i class='bx bx-user' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li>
				<a href="products-admin.php">
					
					<i class='bx bxl-product-hunt' ></i>
					<span class="text">Products</span>
				</a>
			</li>
			<li>
				<a href="shopping-cart.php">
					<i class='bx bx-cart'></i>
					<span class="text">Shopping Cart</span>
				</a>
			</li>
			<li>
				<a href="users-admin.php">
					<i class='bx bxs-group'></i>
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
						
                        <button name="logout_btn" id="logout" type="submit" class="text"><i class='bx bxs-log-out-circle' ></i>Logout</button>
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
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="admin-dash.php" method="get">
				<div class="form-input">
					<input type="text" placeholder="Search..." name="search" id="search-field">
					<button type="submit" class="search-btn" name="search-btn"><i class='bx bx-search' ></i></button>
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
					<marquee behavior="" direction="right"><h1>Welcome Admin <?php echo   $_SESSION['first_name'];?></h1></marquee>
					 <br>
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
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>
							<?php
							   $orders = new Orders();
							   $orders -> get_number_order();
							
							?>
						</h3>
						<p>New Order</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3> <?php
							$number = new Users();
							$number -> get_number_users();
						
						?></h3>
						<p>Users</p>
					</span>
				</li>
			</ul>
			<div id="details">
			<?php
			     	if(isset($_GET['search-btn'])){
						
						$search = $_GET['search'];

						$result = new Searching();

						$result -> search_user($search);
						$result -> search_product($search);	
							  
					}

					$users = new Users();
					$users -> get_all_users();
			?>
			</div>



		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>