<?php

require_once '../app/config.php';

$obj = new DB;

$product_name = '';
$price = '';
$product_id = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {	

	$product_id = (isset($_GET['id'])) ? $_GET['id'] : '';
	$product_name = (isset($_POST['product_name'])) ? $_POST['product_name'] : '';

	$price = (isset($_POST['price'])) ? $_POST['price'] : '';

	$sql = "SELECT COUNT(*) AS total FROM productsbase WHERE product_name=:product_name AND status=:status AND product_id!=:product_id";
	$prepare = $obj->prepare($sql);
	$result = $prepare->execute(array(
		':product_name' => $product_name,
		':status' => 'active',
		':product_id' => $product_id
	));
	$result = $prepare->fetchColumn();

	if ($result > 0) {
		$error = "Product name: " . $product_name . " is already exist.";
		header("Location: ./edit.php?id=" . $product_id . "&error=" . $error);
	} else {
		$sql = "SET AUTOCOMMIT=0; START TRANSACTION;";
		$prepare = $obj->prepare($sql);
		$result = $prepare->execute(array());

		$sql = "UPDATE productsbase SET product_name=:product_name, price=:price WHERE product_id=:product_id";
		$prepare = $obj->prepare($sql);
		$result = $prepare->execute(array(
			':product_name' => $product_name,
			':price' => $price,
			':product_id' => $product_id
		));

		if ($result):
			$success = "Product name: " . $product_name . " is updated with price: " . $price . " <br> You can update price later.";
			$sql = "COMMIT;";
			$prepare = $obj->prepare($sql);
			$result = $prepare->execute(array());
			header("Location: ./edit.php?id=" . $product_id . "&success=" . $success);
		else:
			$error = "Something went wrong. <br> try again later.";
			$sql = "ROLLBACK;";
			$prepare = $obj->prepare($sql);
			$result = $prepare->execute(array());
			header("Location: ./edit.php?id=" . $product_id . "&error=" . $error);
		endif;
	}

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
	
	if (isset($_GET['id']) && !empty($_GET['id'])):
		$product_id = $_GET['id'];

		$sql = "SELECT * FROM productsbase WHERE product_id=:product_id AND status=:status";
		$prepare = $obj->prepare($sql);
		$result = $prepare->execute(array(
			':product_id' => $product_id,
			':status' => 'active'
		));

		$result = $prepare->fetch(PDO::FETCH_ASSOC);

		$product_name = $result['product_name'];
		$price = $result['price'];

	endif;
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<!-- Links -->
	<link rel="stylesheet" type="text/css" href="../src/thirdparty/bootstrap/bootstrap.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../src/thirdparty/fontawesome/css/all.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../src/thirdparty/DataTables/datatables.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../src/thirdparty/animate/animate.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../src/thirdparty/select2/select2.css" media="all" />

	<title>Edit - Product Base</title>
</head>
<body>

	<div class="container-fluid">
		<div class="row">
			
			<div class="col-md-12 bg-primary text-light py-3 text-center">
				<h2 class="h2">Welcome to PHP Crud</h2>
			</div>			

			<?php if (isset($_GET['error']) && !empty($_GET['error'])): ?>

				<div class="alert alert-warning alert-dismissible fade show" role="alert">
		          <?php echo $_GET['error']; ?>
		          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		        </div>

		    <?php elseif (isset($_GET['success']) && !empty($_GET['success'])): ?>
				
				<div class="alert alert-success alert-dismissible fade show" role="alert">
		          <?php echo $_GET['success']; ?>
		          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		        </div>

			<?php endif; ?>

		</div>		

		<div class="mt-5 mx-3 px-2 py-3 d-flex bg-info rounded-top justify-content-center justify-content-sm-between align-items-center">
			<h3 class="h3">Product Base</h3>

			<div class="nav-links">			
				<a href="../index.php" class="btn btn-success" title="Home">
					<i class="fa fa-home"></i>
				</a>
				<a href="./index.php" class="btn btn-success" title="Back">
					<i class="fa fa-arrow-left"></i>
				</a>
			</div>			
		</div>

		<div class="mx-3 p-3 bg-light">
			<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $product_id; ?>" method="post" name="productbasecreate" onsubmit="return validateProductForm(this);">
				<div class="row">
					<div class="col-md-6">
						<label for="product_name">Product Name <sup>*</sup></label>
						<div class="form-group">
							<input type="text" name="product_name" id="product_name" class="form-control" placeholder="Enter product name" required="" autofocus="" value="<?php echo $product_name; ?>" /> 
						</div>
					</div>

					<div class="col-md-6">
						<label for="price">Price <sup>*</sup></label>
						<div class="form-group">
							<input type="number" name="price" id="price" class="form-control" placeholder="Enter product price" required="" min="1" value="<?php echo $price ?>" />
						</div>
					</div>

					<div class="col-md-12 mt-5 d-flex justify-content-sm-between">
						<button type="submit" class="btn btn-success">Update</button>
						<button type="reset" class="btn btn-secondary">Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- Scripts -->
	<script type="text/javascript" src="../src/thirdparty/jquery/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../src/thirdparty/bootstrap/bootstrap.bundle.js"></script>
	<script type="text/javascript" src="../src/thirdparty/DataTables/datatables.js"></script>
	<script type="text/javascript" src="../src/thirdparty/select2/select2.full.js"></script>
	<script type="text/javascript" src="./productbase.js"></script>
</body>
</html>