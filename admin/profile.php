<?php
session_start();
include '../database/database.php';
include '../classes/notification.class.php';
include '../classes/profile.class.php';
include '../classes/change.class.php';
include '../classes/change-contr.class.php';

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

	<title>Admin Profile</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Online Marketing</span>
		</a>
		<ul class="side-menu top">
			<li >
				<a href="admin-dash.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Home</span>
				</a>
			</li>
			<li class="active">
				<a href="profile.php">
					<i class='bx bxs-group' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li>
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
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
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
							<a href="admin-dash.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="profile-admin.php">Profile</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

		
				
					<?php
					
						if(isset($_POST['change']) ){
							$old_password = $_POST['old-password'];
							$new_password = $_POST['new-password'];
							$cpassword = $_POST['cpassword'];

							$update = new Update($_SESSION['user_id'],$_SESSION['user_email'],$old_password,$new_password,$cpassword);
							$update -> changePassword(); 

						}
						if(isset($_POST['save']) ){
							$initials = $_POST['initial'];
							$gender = $_POST['gender'];
							$title = $_POST['title'];
							$discrict = $_POST['district'];
							$village = $_POST['village'];
							$nationality = $_POST['nationality'];
							$national_id = $_POST['national-id'];
							$passport = $_POST['passport'];
							$phone = $_POST['phone'];
							$marital_status = $_POST['marital-status'];

							$profile = new Profile();
							$profile -> update_profile($_SESSION['user_id'],$initials,$gender,$nationality,$discrict,$village,$marital_status,$title,$phone,$national_id,$passport);

						}

						$profile = new Profile();
						$profile -> add_profile($_SESSION['user_id']);

				
					?>
					
			
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>