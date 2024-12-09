function openNav() {
  document.getElementById("sidenav").style.width = "290px";
  document.getElementById("main").style.marginLeft = "300px";
  document.getElementById("low_stock_products").style.marginLeft = "1000px";
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
  document.getElementById("main").style.marginRight= "480px";
  document.getElementById("low_stock_products").style.marginLeft= "0";
  document.getElementById("low_stock_products").style.marginRight= "850px";
}

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}

function formatNumberWithCommas(number) {
  return number.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

var row = 1;
var productsInfo = [];
var productName;
var qty;

function addProduct() {
  var selectedProduct = document.getElementById("product_list");
  productName = selectedProduct.options[selectedProduct.selectedIndex].value;
  qty = document.getElementById("product_qty").value;

  if (!productName) {
    BootstrapDialog.alert({
      type: BootstrapDialog.TYPE_DANGER,
      message: 'Invalid product.',
    });
  } else if (!qty || qty < 1) {
    BootstrapDialog.alert({
      type: BootstrapDialog.TYPE_DANGER,
      message: 'Invalid product quantity.',
    });
  } else {
    var table = document.getElementById('display');
    var rows = table.rows;

    var existingRow = null;
    
    for (var i = 1; i < rows.length; i++) {
      if (rows[i].cells[0].textContent === productName) {
        existingRow = rows[i];
        break;
      }
    }

    if (existingRow) {
      var cell3 = existingRow.cells[2];
      var existingQty = parseInt(cell3.textContent.replace(/,/g, ''), 10);
      existingQty += parseInt(qty, 10);
      cell3.textContent = Math.trunc(existingQty);

      var cell2 = parseFloat(existingRow.cells[1].textContent.replace(/,/g, ''));
      existingRow.cells[3].textContent = formatNumberWithCommas(cell2 * existingQty);
    } else {
      fetchProductPrice(productName, function (price) {
        var newRow = table.insertRow();

        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);

        cell1.innerHTML = productName;
        cell2.innerHTML = formatNumberWithCommas(price); 
        cell3.innerHTML = Math.trunc(qty); 
        cell4.innerHTML = formatNumberWithCommas(price * parseInt(qty, 10));
        cell5.innerHTML = '<button type="button" class="delete" onclick="removeItem(this)">Delete</button>';

        row++;

        updateTotalPrice();
        document.getElementById('product_qty').value = '';
      });
    }
    updateTotalPrice();
    document.getElementById('product_qty').value = '';
    document.getElementById('searchInput').value = '';
  }
  var productInfo = {
    name: productName,
    quantity: qty
  };

  productsInfo.push(productInfo);
}

function fetchProductPrice(productName, callback) {
  $.ajax({
    url: 'database/get_base_price.php',
    method: 'POST',
    data: { product_name: productName },
    success: function (response) {
      var price = parseFloat(response);
      callback(price);
    },
    error: function () {
      alert('Error fetching product price.');
    },
  });
}

function removeItem(button) {
  var row = button.parentNode.parentNode;
  var table = document.getElementById('display');
  var rows = table.rows;
  var rowIndex = row.rowIndex; 

  if (rowIndex > 0) { 
    var cell2 = parseFloat(rows[rowIndex].cells[1].textContent.replace(/,/g, '')); 
    var cell3 = parseFloat(rows[rowIndex].cells[2].textContent);
    var product = cell2 * cell3;

    table.deleteRow(rowIndex); 

    updateTotalPrice(-product); 
  }
}

var totalPriceElement;
var totalPrice;
var payment;
var change = 0; 
var supplierName = ""; 

function updateTotalPrice(change) {
  totalPriceElement = document.getElementById('total_price');
  totalPrice = parseFloat(totalPriceElement.textContent.replace(/,/g, '')); 

  totalPriceElement.textContent = formatNumberWithCommas(totalPrice); 
}

function updateTotalPrice() {
  var table = document.getElementById('display');
  var rows = table.rows;
  totalPrice = 0;

  for (var i = 1; i < rows.length; i++) {
    var cell2 = parseFloat(rows[i].cells[1].textContent.replace(/,/g, '')); 
    var cell3 = parseFloat(rows[i].cells[2].textContent);
    var product = cell2 * cell3;
    rows[i].cells[3].textContent = formatNumberWithCommas(product); 
    totalPrice += product;
  }

  document.getElementById('total_price').textContent = formatNumberWithCommas(totalPrice); 
  document.getElementById('totalPriceInput').value = formatNumberWithCommas(totalPrice); 
}

function isTableEmpty() {
  var table = document.getElementById('display');
  return table.rows.length <= 1; 
}

function show(){

  if (isTableEmpty()) {
    BootstrapDialog.alert({
      type: BootstrapDialog.TYPE_DANGER,
      message: 'Add product first.',
    });
  }else{
    popupForm.style.display = "block";
  }
}

document.addEventListener("DOMContentLoaded", function () {
  totalPriceElement = $('#total_price');
  totalPrice = parseFloat(totalPriceElement.text().replace(/,/g, ''));
  
  const continueBtnn = document.getElementById("continue-btn");
  const popupForm = document.getElementById("popupForm");
  const closeForm = document.getElementById("closeForm");

  window.addEventListener("click", function (event) {
    if (event.target === popupForm) {
      closePopupForm(); 
    }
  });

  closeForm.addEventListener("click", function () {
    closePopupForm(); 
  });

  popupCancel.addEventListener("click", function () {
    closePopupForm();
  });

});

function cancelTransaction(){
  var rowCount = display.rows.length;
  
  for (var i = rowCount - 1; i > 0; i--) {
    display.deleteRow(i);
  }

  document.getElementById('total_price').textContent = '0.00';
  
}

function closePopupForm(){
  const popupForm = document.getElementById("popupForm");

  popupForm.style.display = "none";
}

function searchSelect() {
  var input, filter, select, options, i;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  select = document.getElementById("product_list");
  options = select.getElementsByTagName("option");

  for (i = 0; i < options.length; i++) {
    if (options[i].textContent.toUpperCase().indexOf(filter) > -1) {
      options[i].style.display = "";
    } else {
      options[i].style.display = "none";
    }
  }

  select.style.display = "block";
}

function selectItem() {
  var select = document.getElementById("product_list");
  var input = document.getElementById("searchInput");
  var selectedOption = select.options[select.selectedIndex].text;
  input.value = selectedOption;
  select.style.display = "none";
}

window.onclick = function(event) {
  var select = document.getElementById("product_list");
  var input = document.getElementById("searchInput");
  if (event.target !== input && event.target !== select) {
    select.style.display = 'none';
  }
}

document.addEventListener("DOMContentLoaded", function() {
  var continueBtn = document.getElementById('continue-btn');
  if (continueBtn) {
    continueBtn.addEventListener('click', confirm_btn);
  }

  var confirmBtn = document.getElementById('confirm_btn');
  if (confirmBtn) {
    confirmBtn.addEventListener('click', saveTransaction);
  }
});


function saveTransaction() {
  var transactionNumber = document.getElementById('transactionNumber').textContent;
  var transactionDate = document.getElementById('transactionDate').textContent;
  var accId = document.getElementById('user_name').textContent;
  var totalAmount = parseFloat(document.getElementById('total_price').textContent.replace(/,/g, ''));

  var selectedSupplierInput = document.getElementById('searchSupplierInput');
  var selectedSupplierName = selectedSupplierInput.value;

  if (!selectedSupplierName) {
    BootstrapDialog.alert({
      type: BootstrapDialog.TYPE_DANGER,
      message: 'Please select a supplier.',
    });
    return;
  }

  $.ajax({
    url: 'database/save_po.php',
    method: 'POST',
    data: {
      save_data: true,
      transactionNumber: transactionNumber,
      productName: productName,
      transactionDate: transactionDate,
      quantity: qty,
      supplierName: selectedSupplierName,
      accId: accId,
      totalAmount: totalAmount,
      productsInfo: JSON.stringify(productsInfo),
    },
    success: function (response) {
      console.log(response);
      var result = JSON.parse(response);
      if (result.success) {
        BootstrapDialog.alert({
          type: BootstrapDialog.TYPE_SUCCESS,
          message: result.message,
          callback: function () {
            window.location.href = 'prchse_ord.php';
          },
        });
      } else {
        BootstrapDialog.alert({
          type: BootstrapDialog.TYPE_DANGER,
          message: result.message,
        });
      }
    },
    error: function () {
      BootstrapDialog.alert({
        type: BootstrapDialog.TYPE_DANGER,
        message: 'Error saving transaction.',
      });
    },
  });
}


function searchSupplier() {
  var input, filter, select, options, i;
  input = document.getElementById("searchSupplierInput");
  filter = input.value.toUpperCase();
  select = document.getElementById("supplier_list");
  options = select.getElementsByTagName("option");

  for (i = 0; i < options.length; i++) {
    if (options[i].textContent.toUpperCase().indexOf(filter) > -1) {
      options[i].style.display = "";
    } else {
      options[i].style.display = "none";
    }
  }

  select.style.display = "block";
}

function selectSupplierItem() {
  var select = document.getElementById("supplier_list");
  var input = document.getElementById("searchSupplierInput");
  supplierName = select.options[select.selectedIndex].text; 
  input.value = supplierName;
  select.style.display = "none";
}


window.onclick = function (event) {
  var select = document.getElementById("supplier_list");
  var input = document.getElementById("searchSupplierInput");
  if (event.target !== input && event.target !== select) {
    select.style.display = 'none';
  }
};
