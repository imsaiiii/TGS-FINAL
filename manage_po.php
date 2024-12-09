<?php
session_start();

if (!isset($_SESSION['user'])) header('location: login.php');
$_SESSION['table'] = 'tbl_users';
$user = $_SESSION['user'];

$qty_received = isset($_POST['qty_received']) ? $_POST['qty_received'] : null;

$conn = mysqli_connect("localhost", "root", "", "db_bariso");

$query = "SELECT tbl_po.*, tbl_po_details.*
          FROM tbl_po
          LEFT JOIN tbl_po_details ON tbl_po.po_id = tbl_po_details.po_id";
$query_run = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/inventory.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cutive+Mono&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  
  <!--for pagination-->
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

</head>
<body>

<div id = "sidenav" class="wrapper">
  
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&#9776;</a>
    
    <div class = "logo">
      <p class = "bariso"> Bariso </p> 
      <p class = "wr"> Wholesale and Retail</p>
    </div>

  <ul>
    <li> <a href="dashboard.php" class="home">
      <span class="icon"> 
        <img src="images/home.png" width="45px" height="45px">
      </span>

      <span class="item"> HOME </span>
      </a> 
    </li> 

    <li> <a href="product_page.php">
      <span class="icon"> 
        <img src="images/prodc.png" width="45px" height="45px">
      </span>
            
      <span class="item"> Products </span>
      </a> 
    </li>


    <li> <a href="inventory.php">
      <span class="icon">
        <img src="images/inv.png" width="45px" height="45px">
      </span>
      
      <span class="item"> Inventory </span>
      </a> 
    </li>

    <li> <a href="category.php">
      <span class="icon">
        <img src="images/category.png" width="45px" height="45px">
      </span>
      
      <span class="item"> Category </span>
      </a> 
    </li>


    <li> <a href="sales.php">
      <span class="icon">
        <img src="images/sales.png" width="45px" height="45px">
      </span>

      <span class="item"> Sales </span>
      </a> 
    </li>

    <li> <a href="sales_report.php">
      <span class="icon">
        <img src="images/Transaction.png" width="45px" height="45px">
      </span>

      <span class="item"> Sales Report</span>
      </a> 
    </li>

    <li> <a href="Audit.php">
      <span class="icon">
        <img src="images/audit.png" width="45px" height="45px">
      </span>

      <span class="item"> Audit Trail </span>
      </a> 
    </li>

    <li> <a href="supplier.php">
      <span class="icon">
        <img src="images/supp.png" width="45px" height="45px">
      </span>

      <span class="item"> Supplier </span>
      </a> 
    </li>

    <li> <a href="prchse_ord.php">
      <span class="icon">
        <img src="images/inv.png" width="45px" height="45px">
      </span>

      <span class="item"> Purchase Order </span>
      </a> 
    </li>

    <li> <a href="manage_po.php">
      <span class="icon">
        <img src="images/manage_po.png" width="45px" height="45px">
      </span>

      <span class="item"> Manage Purchase Order </span>
      </a> 
    </li>


    <li> <a href="accounts.php">
      <span class="icon">
        <img src="images/user.png" width="45px" height="45px">
      </span>

      <span class="item"> Account </span>
      </a> 
    </li>

    <li> <a href="database/logout.php">
      <span class="icon">
        <img src="images/logout.png" width="45px" height="45px">
      </span>

      <span class="item"> Log Out </span>
      </a> 
    </li>


  </ul>

<!-- White line under the menu option -->
  <div class="line"></div>
</div>
<!-- TOP BAR -->
<div class="section">
  <div class="top" id = "myHeader">
    <a href="javascript:void(0)" class="openNav" onclick="openNav()">&#9776;
    </a>

    <div class="user-bell-icons">
      <div class="text">
        <a href="profile.php"><span class="sadmin_text"> <?= $user['first_name']?> </span></a>
        <a href="profile.php">
          <i class="fa-solid fa-user-tie fa-2x"></i>
        </a>
      </div>

    </div>
  </div>
</div>

<!-- EDIT NG DATA SA DATABASE -->
<div class="modal fade" id="editdata" tabindex="-1" aria-labelledby="editdataLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editdataLabel"> EDIT DATA </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="manage_po_con.php" method="POST" onsubmit="return validateForm()">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">PO ID</label>
                                <input type="text" class="form-control" id="user_id" name="po_id" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Qty Ordered</label>
                                <input type="NUMBER" class="form-control" pattern="[0-9]+(\.[0-9]{1,2})?" name="quantity" id = "quantity" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="">Qty Received</label>
                                <input type="NUMBER" class="form-control" id="qty_received" name="qty_received" value="<?php echo $qty_received; ?>" min="1">
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Supplier</label>
                                <input type="text" class="form-control" id="supplier_name" name="supplier_name" readonly>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Status</label>
                                <input type="text" class="form-control" name="status" id="status" readonly="">
                            </div>

                        </div>
                    </div>
                </div>
                
                <input type="hidden" id="po_detail_id" name="po_detail_id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update_data" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT NG DATA SA DATABASE -->

<!-- VIEW NG DATA SA DATABASE -->
<div class="modal fade" id="viewusermodal" tabindex="-1" aria-labelledby="viewusermodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="viewusermodalLabel">VIEW PURCHASE ORDER</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="view_user_data">
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- VIEW NG DATA SA DATABASE -->

<!--ITO YONG BUTTON -->
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card" style="width: 95rem;">
        <div class="card-header">
          <h4 align="center">MANAGE PURCHASE ORDER</h4>
        </div>
      
        <div class="card-body">
          <table id="myTable" class="table table-striped table-bordered table-secondary">
            <a href="manage_po.php" class="btn btn-secondary resetzinv">Reset</a><br> <br>
    <thead>
      <tr>
        <th scope="col" hidden>Product ID</th>
        <th scope="col">PO Number</th>
        <th scope="col">Product Name</th>
        <th scope="col">Qty Ordered</th>
        <th scope="col">Qty Received</th>
        <th scope="col">Supplier</th>
        <th scope="col">Status</th>
        <th scope="col">Ordered By</th>
        <th scope="col">Created Date</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php
      if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
          $status = $row['status'];
          $disableEdit = $status === 'complete' ? 'disabled' : '';
          $rowColorClass = '';

          switch ($status) {
            case 'complete':
            $rowColorClass = 'table-success';
            break;
            case 'incomplete':
            $rowColorClass = 'table-incomplete';
            break;
            case 'pending':
            $rowColorClass = 'table-pending';
            break;
            default:
            $rowColorClass = '';
          }
          ?>
          <tr class="<?= $rowColorClass ?>">
            <td class="user_id" hidden><?= $row['po_id'] ?></td>
            <td> <a href="invoice_po.php?po_id=<?= $row['po_id'] ?>" target="_blank">
                                <?= $row['po_number'] ?>
                            </a></td>
            <td data-po-detail-id="<?= $row['po_detail_id'] ?>"><?= $row['product_name'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['qty_received'] ?></td>
            <td><?= $row['supplier_name'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['acc_id'] ?></td>
            <td><?= $row['po_datetime'] ?></td>

            <td class="text-end">
              <div class="d-flex justify-content-end">
                <?php if ($disableEdit === '') { ?>
                  <a href="#" class="btn btn-info btn-sm view_data me-2">View</a>
                  <a href="#" class="btn btn-success btn-sm edit_data me-2" data-po-detail-id="<?= $row['po_detail_id'] ?>">Edit</a>
                <?php } else { ?>
                  <a href="#" class="btn btn-info btn-sm view_data me-2">View</a>
                  <!-- Add a disabled class for styling purposes -->
                  <a href="#" class="btn btn-success btn-sm edit_data me-2 disabled" disabled>Edit</a>
                <?php } ?>
              </div>
            </td>
          </tr>
          <?php
        }
      } else {
        ?>
        <tr>
          <td>NO RECORD FOUND.</td>
          <td hidden></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <?php
      }
      ?>
    </tbody>

  </table>
        </div>

        <?php include('database/footer.php'); ?>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function () {
    $('#myTable').DataTable({
      "pagingType": "full_numbers",
      "lengthMenu": [
      [10, 25, 50, 100, 200, -1],
      [10, 25, 50, 100, 200, "All"]
      ],
      responsive: true
    });
  });

function openNav() {   
  document.getElementById("sidenav").style.width = "290px";
  document.getElementById("main").style.marginLeft = "135px";
  var clr = document.createElement("div");
  clr.id="bg";
  clr.style.position="fixed";
  clr.style.width="100%";
  clr.style.height="100%";
  clr.style.top="0";
}

function closeNav() {  
  document.getElementById("sidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.getElementById("main").style.marginRight= "510px"; 
}

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}

  /*VIEW DATA*/
$(document).on('click', '.view_data', function(e){
  e.preventDefault();

  console.log("View button clicked");

  var user_id = $(this).closest('tr').children('td:first').text();
  console.log("User ID:", user_id);

  $.ajax({
    method: "POST",
    url: "manage_po_con.php",
    data: {
      'click_view_btn': true,
      'user_id': user_id
    },
    success: function(response){
      console.log("AJAX success:", response);
      $('.view_user_data').html(response);
      $('#viewusermodal').modal('show');
    },
    error: function(xhr, status, error) {
      console.error("AJAX error:", error);
    }
  });
});

  /*VIEW DATA*/

/*EDIT DATA*/
    $(document).ready(function (){
$('#myTable').on('click', '.edit_data', function (e) {
        e.preventDefault();

        var po_detail_id = $(this).data('po-detail-id');

        $.ajax({
            method: "POST",
            url: "manage_po_con.php",
            data: {
                'click_edit_btn': true,
                'po_detail_id': po_detail_id,
            },
            success: function (response) {
                $.each(response, function (Key, value) {
                    $('#user_id').val(value['po_id']);
                    $('#product_name').val(value['product_name']);
                    $('#quantity').val(value['quantity']);
                    $('#qty_received').val(value['qty_received']);
                    $('#supplier_name').val(value['supplier_name']);
                    $('#status').val(value['status']);

                    $('#po_detail_id').val(value['po_detail_id']);
                });

                $('#editdata').modal('show');
            }
        });
    });
});
   /*EDIT DATA*/

function validateForm() {
  var qtyOrdered = parseInt(document.getElementById('quantity').value, 10);
  var qtyReceived = parseInt(document.getElementById('qty_received').value, 10);

  if (qtyReceived > qtyOrdered) {
    alert("Error: Qty Received cannot be more than Qty Ordered.");
    return false;
  }

  return true;
}
</script>
</body>
</html>