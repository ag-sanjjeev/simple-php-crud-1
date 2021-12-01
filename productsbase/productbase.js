function validateProductForm(field) {

	if (field.product_name.value != "") {
		if (field.price.value >= 1) {
			return true;
		} else {
			alert('Please enter valid price');
		}
	} else {
		alert('Please enter valid product name');
	}

	return false;
}

function deleteProductBase (id) {
	if (confirm("Are you sure want to delete?")) {
		$.ajax({
			type: 'post',
			url: './list.php',
			data: {'product_id' : id, 'action' : 'delete'},
			success: function(response) {
				console.log(response);
			},
			error: function(response) {
				console.log(response);
			}
		})
	}
}

$(document).ready(function() {
    $('.datatables').DataTable( {
        "processing": true,
        "serverSide": true,
        "cache": false,
        "ordering": true,
        "ajax": {
        	"type" : "post",
        	"url" : "./list.php",
        	"data" : {
        		'action' : 'list'
        	}
        },
     	'columns': [
        	{ data: 'product_id' },
         	{ data: 'product_name' },
         	{ data: 'price' },
         	{ data: 'action' }
      	],
      	"columnDefs": [
            {
                "targets": [ 3 ],
                "visible": true,
                "ordering": false,
                "searchable": false
            }
        ]
    } );
} );