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

	<title>PHP Crud - Product Base</title>
</head>
<body>

	<div class="container-fluid">
		<div class="row">
			
			<div class="col-md-12 bg-primary text-light py-3 text-center">
				<h2 class="h2">Welcome to PHP Crud</h2>
			</div>			

		</div>

		<div class="mt-5 mx-3 px-2 py-3 d-flex bg-info rounded-top justify-content-center justify-content-sm-between align-items-center">
			<h3 class="h3">Product Base</h3>

			<div class="nav-links">
				<a href="../index.php" class="btn btn-success" title="Home">
					<i class="fa fa-home"></i>
				</a>

				<a href="../productsbase/create.php" class="btn btn-success" title="Create">
					<i class="fa fa-plus-circle"></i>
				</a>

			</div>			
		</div>

		<div class="mx-3 mt-3 pb-3">
			<table class="datatables table table-primary" id="billentry-list">
				<thead>
					<tr>
						<th width="10%">S.No</th>	
						<th width="60%">Product Name</th>
						<th>Price</th>
						<th width="20%">Actions</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td colspan="4" align="center">No data found</td>
					</tr>
				</tbody>
			</table>
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