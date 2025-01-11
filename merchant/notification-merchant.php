<?php
session_start();
include '../database/database.php';
include '../classes/notification.class.php';
include '../classes/oders.class.php';
include '../classes/search.class.php';
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

	<title>Merchant Notification</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<span class="text" style="margin-left: 10px; color: green;">Online Marketing</span>
		</a>
		<ul class="side-menu top">
			<li >
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
			<li class="active">
				<a href="notification-merchant.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Notification</span>
				</a>
			</li>
			<li>
				<a href="orders-merch.php">
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
			<form action="notification-merchant.php" method="get">
				<div class="form-input">
					<input type="text" placeholder="Search notifications ..." name="search" id="search-field">
					<button type="submit" class="search-btn" name="search-btn"><i class='bx bx-search' >S</i></button>
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
							<a class="active" href="#">Notification</a>
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
							   $newoders = new Orders();
							   $newoders -> get_number_order();
							?>

						</h3>
						<p>New Orders</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3>2834</h3>
						<p>Customers</p>
					</span>
				</li>
				
			</ul>
			<div style="margin-top: 20px ;">
				<?php
						
					
						$notification = new Notifications();
						$notification -> user_notification($_SESSION['user_id']);
					
					?>
			</div>
			<?php
				 if(isset($_POST['add-notification'])){
					$username = $_POST['username'];
					$message = $_POST['message'];
					$email = $_POST['email'];
				

					$add = new Notifications();
					$add -> create_notification($username, $email ,$message);

				}
						
			?>
			

			<div class="table-data">
				<?php
			     	if(isset($_GET['search-btn'])){
						
						$search = $_GET['search'];

						$result = new Searching();
						
						$result -> search_notification($search);		  
					}
			?>
				<li>
					<div class="notification">
						<form action="notification-merchant.php" method="post">
							<h3>Create Notification</h3>
							<span class="text">Username</span> <br>
							<input type="text" name="username" id="product-name" class="input" ><br>
							<span class="text">Email</span> <br>
							<input type="email" name="email" id="product-name" class="input" ><br>
							<span class="text">Message</span> <br>
							<input type="text" name="message" class="input"> <br>
							<button type="submit" name="add-notification">Add notification</button>                                     
						</form>
					</div>
					
				</li>
				<li>
					<div class="notification">
						<form action="" method="post">
							<h3>Upate Notification</h3>
							<span class="text">Username</span> <br>
							<input type="text" name="product-name" id="product-name" class="input" ><br>
							<span class="text">Message</span> <br>
							<input type="text" name="descr" class="input"> <br>
							<button type="submit">Update</button>                                     
						</form>
					</div>
					
				</li>
								
				
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>