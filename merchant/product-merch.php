<?php
			session_start();
			include "../database/database.php";
			include "../classes/products.class.php";
			include "../classes/notification.class.php";

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
			<span class="text" style="margin-left: 10px;">Online Marketings</span>
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
			<li class="active">
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
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
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
							<a class="active" href="#">Products</a>
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
						<h3>You products</h3>
						<form action="product-merch.php" method="post">
							<button type="submit" name="view-product" style="width: 80px;">View</button>
						</form>
					</span>
				</li>
				
			</ul>
			<?php
			   if(isset($_POST['view-product'])){
				$product = new Products();
				$product -> view_merchant_product($_SESSION['user_id']);

			   }
			   if(isset($_POST['delete'])){
					$product_id = $_POST['product_id'];

					$delete = new Products();
					$delete -> delete_product($product_id,$_SESSION['user_id']);
				}
				

				
			
			?>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Add Products</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>

					<form action="../uploads/uploads.php" method="post" enctype="multipart/form-data">
						<table >
							
								<tr>
									<td><span class="text">Product Name</span></td>
									<td> <input type="text" name="product-name" id="product-name" class="input" required></td>
								</tr>
								<tr>
									<td><span class="text">Product Description</span></td>
									<td> <input type="text" name="description" class="input" required></td>
								</tr>
								<tr>
									<td><span>Category</span> </td>
									<td>
										<select name="category" id="" style="width: 200px; border:2px solid green; padding:10px; border-radius:10px;">
											<option value="electronic">Electronic Gadgets</option>											
											<option value="clothes">Clothes</option>
											<option value="Food">Food</option>
											
										</select>
									</td>
								</tr>
								<tr>
									<td><span>Price</span></td>
									<td> <input type="number" class="input" name="product-price" required></td>
								</tr>
								<tr>
									<td><span>Image URL</span></td>
									<td><input type="file" id="Image" name="file" required></td>
								</tr>

								<tr>
									<td></td>
									<td><button type="submit" name="add-product">Add products</button> </td>
								</tr>
							
						</table>
											 
					</form>
					
				</div>
				<div class="todo">
					<div class="head">
						<h3>Delete Products</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>

					<form action="" method="post">
						<table >
							
								<tr>
									<td><span class="text">Product Name</span></td>
									<td> <input type="text" name="product-name" id="product-name" class="input" ></td>
								</tr>
								<tr>
									<td><span class="text">Product Description</span></td>
									<td> <input type="text" name="descr" class="input" ></td>
								</tr>
								<tr>
									<td><span>Price</span></td>
									<td> <input type="number" class="input" name="Price"></td>
								</tr>
								<tr>
									<td></td>
									<td><button type="submit">Delete products</button> </td>
								</tr>
							
						</table>
					</form>
					
				</div>
				
			</div>
			<div class="table-data">
				<div class="order">  						 
					<div class="head">
						<h3>Update a Product</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<div>
						<form action="../uploads/uploads.php" method="post" enctype="multipart/form-data">
							<table>
								<tr>
									<td><span class="text">Product Name</span></td>
									<td><input type="text" name="product-name" id="product-name" class="input" required ></td>
								</tr>
								<tr>
									<td><span class="text">Product Description</span></td>
									<td><input type="text" name="description" class="input" required></td>
								</tr>
								<tr>
									<td><span>Price</span> </td>
									<td><input type="number" class="input" name="product-price" required></td>
								</tr>
								<tr>
									<td><span>Category</span>  </td>
									<td>
										<select name="category" id="" style="width: 200px; border:2px solid green; padding:10px; border-radius:10px;">
											<option value="electronic">Electronic Gadgets</option>											
											<option value="clothes">Clothes</option>
											<option value="Food">Food</option>
											
										</select>
									</td>
								</tr>
								<tr>
									<td><span>Image URL</span> </td>
									<td><input type="file" id="Image" name="file" required> </td>
								</tr>
								<tr>
									<td></td>
									<td><button type="submit" name="update">Update product</button> </td>
								</tr>
							</table>
						</form>
						<?php
						/*
							if(isset($_POST['update'])){
								$product_name = $_POST['product-name'];
								$product_price = $_POST['product-price'];
								$description = $_POST['description'];
								$category = $_POST['category'];
								
						
								
								$product = new Products();

								$product -> update_product($product_name,$description, $product_price,$category,$image_url);
							}*/
						?>
					</div>
				
				
				</div>
				<div class="todo">
					<div class="head">
						<h3>View Products</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>

					<form action="" method="post" enctype="multipart/form-data">
						<table >
							
								<tr>
									<td><span class="text">Product Name</span></td>
									<td> <input type="text" name="product-name" id="product-name" class="input" ></td>
								</tr>
								<tr>
									<td><span class="text">Product Description</span></td>
									<td> <input type="text" name="description" class="input"></td>
								</tr>
								<tr>
									<td><span>Category</span> </td>
									<td><input type="text" class="input" name="category"></td>
								</tr>
								<tr>
									<td><span>Price</span></td>
									<td> <input type="number" class="input" name="Price"></td>
								</tr>

								<tr>
									<td></td>
									<td><button type="submit">View products</button> </td>
								</tr>
							
						</table>
											 
					</form>

					
				</div>				

			</div>
			
				
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../js/script.js"></script>
</body>
</html>