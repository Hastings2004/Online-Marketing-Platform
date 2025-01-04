<?php
session_start();

include '../database/database.php';
include '../classes/notification.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../css/style.css">

	<title>Electronic Hub</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile' style="color: green;"></i>
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
					<i class='bx bxs-group'></i>
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
					<i class='bx bxs-group'></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li class="active">
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
				<form action="../includes/logout.php" method="post">
                    
                    <button name="logout_btn" id="logout" type="submit" class="text">
						<i class='bx bxs-log-out-circle' ></i>Logout
					</button>
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
			<a href="notification-admin.php" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num"><?php
						
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
							<a href="">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="">Notification</a>
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
								
								$unread = new Notifications();
								$unread -> get_Uread_notification();
							
							?>
						</h3>
						<p>New Applications</p>

					</span>
				</li>
				<li>
					<?php
						
					
						$notification = new Notifications();
						$notification -> user_notification($_SESSION['user_id']);
					
					?>
				</li>
				
			</ul>


			<div class="table-data">
				<div class="order">  						 
					<div class="head">
						<h3>Create Notification</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<div>
						<form action="notification-admin.php" method="post">
							<table>
								<tr>
									<td><span class="text">Username</span></td>
									<td><input type="text" name="username" id="product-name" class="input" >								</td>
								</tr>
								<tr>
									<td><span class="text">Email</span></td>
									<td><input type="email" name="email" class="input"></td>
								</tr>
								<tr>
									<td><span class="text">Message</span></td>
									<td><input type="text" name="message" class="input"></td>
								</tr>
								<tr>
									<td></td>
									<td><button type="submit" name="add-note">Add notification</button>  </td>
								</tr>
								
							</table>
													 
							                                   
						</form>
						<?php
						     if(isset($_POST['add-note'])){
								$username = $_POST['username'];
								$message = $_POST['message'];
								$email = $_POST['email'];

								$add = new Notifications();
								$add -> create_notification($username, $email ,$message);

							 }
						
						?>
						
					</div>
					
				</div>
				<div class="todo">
					<div class="head">
						<h3>Upate Notification</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<div>
						<form action="" method="post">
							<table>
								<tr>
									<td><span class="text">Username</span></td>
									<td><input type="text" name="Username" id="product-name" class="input" ></td>
								</tr>
								<tr>
									<td><span class="text">Message</span></td>
									<td><input type="text" name="Message" class="input"></td>
								</tr>
								<tr>
									<th></th>
									<th><button type="submit" name="upadate-note">Update</button> </th>
								</tr>
							</table>
							                                    
						</form>
					</div>
					
				</div>

				
					<!--------------all notifications will appeare here-->
			</div>
			<div class="table-data">
				<div class="order">  						 
					<div class="head">
						<h3>Delete Notification</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<div>
						<form action="" method="post">
							<table>
								<tr>
									<td><span class="text">Notification ID</span> </td>
									<td><input type="text" name="product-name" id="product-name" class="input" >	</td>
								</tr>
								<tr>
									<td></td>
									<td><button type="submit">Delete</button>   </td>
								</tr>
							</table>
							
							                                  
						</form>
					</div>

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>

	
	
