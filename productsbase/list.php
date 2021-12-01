<?php

require_once '../app/config.php';
$obj = new DB;

$product_name = '';

$price = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['action']) && !empty($_POST['action'])):
		$action = $_POST['action'];
	endif;
}

switch ($action) {
	case 'list':			

		$draw = $_POST['draw'];
		$row = $_POST['start'];
		$rowperpage = $_POST['length']; // Rows display per page
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc	
		$search = stripslashes($_POST['search']['value']);

		$condition = '';

		$sql = "SELECT COUNT(*) AS total FROM productsbase WHERE status=:status";

		$prepare = $obj->prepare($sql);
		$result = $prepare->execute(array(':status' => 'active'));
		$result = $prepare->fetchColumn();
		$totalRecords = $result;

		if (!empty($search)):
			$condition .= " AND (product_name LIKE '%" . $search . "%' OR price LIKE '%" . $search . "%')";		
		elseif (!empty($columnName) && !empty($columnSortOrder)):
			$condition .= " ORDER BY '" . $columnName . "' " . strtoupper($columnSortOrder);	
		endif;

		$condition .= " LIMIT ". $row .", " . $rowperpage;

		$prepare = $obj->prepare($sql . $condition);
		$result = $prepare->execute(array(':status' => 'active'));
		$result = $prepare->fetchColumn();

		$totalRecordwithFilter = $result;

		$sql = "SELECT * FROM productsbase WHERE status=:status";

		$prepare = $obj->prepare($sql . $condition);
		$result = $prepare->execute(array(':status' => 'active'));
		$result = $prepare->fetchAll(PDO::FETCH_ASSOC);

		

		$data = array();

		foreach ($result as $key => $value) {
			
			$actionHtml = '<a href="./edit.php?id=' . $value['product_id'] . '" class="btn btn-warning mx-3"><i class="fa fa-edit"></i></a>';
			$actionHtml .= '<a href="#" class="btn btn-danger mx-3" onclick="deleteProductBase(' . $value['product_id'] . ')"><i class="fa fa-trash"></i></a>';
			$data[] = array(
				'product_id' => $value['product_id'],
				'product_name' => ucfirst($value['product_name']),
				'price' => number_format($value['price'], 2),
				'action' => $actionHtml
			);
		}

		$response = array(
		  "draw" => intval($draw),
		  "iTotalRecords" => $totalRecords,
		  "iTotalDisplayRecords" => $totalRecordwithFilter,
		  "aaData" => $data
		);

		echo json_encode($response);
		break;
	
	case 'delete':
		
		$product_id = $_POST['product_id'];

		$sql = "SET AUTOCOMMIT=0; START TRANSACTION;";
		$prepare = $obj->prepare($sql);
		$result = $prepare->execute(array());

		$sql = "UPDATE productsbase SET status=:status WHERE product_id=:product_id AND status=:status";
		$prepare = $obj->prepare($sql);
		$result = $prepare->execute(array(
			':status' => 'inactive',
			':product_id' => $product_id,
			':status' => 'active'
		));

		if ($result) {
			$sql = "COMMIT;";
			$prepare = $obj->prepare($sql);
			$result = $prepare->execute(array());
			return true;
		} else {
			$sql = "ROLLBACK;";
			$prepare = $obj->prepare($sql);
			$result = $prepare->execute(array());
			return false;
		}

		break;
	default:
		# code...
		break;
}

?>