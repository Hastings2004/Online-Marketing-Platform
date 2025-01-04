<?php
session_start();
include '../database/database.php';
include '../classes/notification.class.php';
include '../classes/roles.class.php';
include '../classes/search.class.php';
include '../classes/users.class.php';
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

	<title>Electronic Hub</title>
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
			<li class="active">
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
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="users-admin.php" method="post">
				<div class="form-input">
					<input type="text" placeholder="Search users" name="search">
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
				<img src="img/people.png">
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
							<a class="active" href="#">Users</a>
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
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3><?php
							$number = new Users();
							$number -> get_number_users();
						
						?></h3>
						<p>Users</p>
						<form action="" method="post">
							<button type="submit" style="padding: 5px;">view</button>
						</form>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>View Roles</h3>
						<p>
							<form action="users-admin.php" method="post">
								<button name="view-role" type="submit">view</button>
							</form>
						</p>
					</span>
				</li>
				
			</ul>
			


			<div class="table-data">
				<div class="order">  						 
					<div class="head">
						<h3>Assign Roles</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<div>
						<form action="" method="post">
							<table>
								<tr>
									<td> <span class="text">Username</span></td>
									<td> <input type="text" name="username" id="product-name" class="input" required></td>
								</tr>
								<tr>
									<td><span class="text">User Id</span></td>
									<td><input type="number" name="uid" class="input" required></td>
								</tr>
								<tr>
									<th><span class="text">Role Name</span></th>
									<td><input type="text" name="role_name" class="input" required></td>
								</tr>
								<tr>
									<th><span class="text">Role Id</span></th>
									<td><input type="number" name="rid" min="1" max="3" class="input" required></td>
								</tr>
								<tr>
									<td></td>
									<th><button type="submit" name="add-role">Assign a role</button> </th>
								</tr>
							</table>                                                            
						</form>
					
						<?php
							if(isset($_POST['add-role'])){
								$username = $_POST['username'];
								$user_id = $_POST['uid'];
								$role = $_POST['rid'];
								$role_name = $_POST['role_name'];

								$roles = new  Roles();

								$roles -> assign_roles($user_id, $role,$role_name, $username);
			
							
							}
						?>						
					</div>
				</div>
				<div class="todo">
					<div class="head">
						<h3>Update Roles</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
	
					<form action="users-admin.php" method="post">
						<table >				
							<tr>
								<td><span class="text">Username</span></td>
								<td> <input type="text" name="username" id="product-name" class="input"></td>
							</tr>
							<tr>
								<td><span class="text">User ID</span></td>
								<td> <input type="number" name="uid" class="input"></td>
							</tr>
							<tr>
								<td><span class="text">Role name</span></td>
								<td> <input type="text" name="role_name" class="input"></td>
							</tr>
							<tr>
								<td><span class="text">Role ID</span></td>
								<td> <input type="text" name="role-id" class="input"></td>
							</tr>		
							<tr>
								<td></td>
								<td><button type="submit" name="Update-role">Update-role</button> </td>
							</tr>
								
							</table>
												 
						</form>
						<?php
							if(isset($_POST['update-role'])){
								$username = $_POST['username'];
								$user_id = $_POST['uid'];
								$role = $_POST['role-id'];
								$role_name = $_POST['role_name'];

								$roles = new  Roles();

								$roles -> update_roles($user_id, $role,$role_name, $username);
			
							
							}
						?>		
					</div>				
				</div>
			</div>
			<?php
							if(isset($_POST['view-role'])) {
								$role = new Roles();
								$role -> view_roles();
							}
						?>
			<?php
			      if(isset($_POST['search-btn'])){
					$search = $_POST['search'];

					$result = new Searching();
					$result -> search_user($search);
				  }
			
			?>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>

	
	
	
	