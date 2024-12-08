<script>

$(document).ready(function () {
    $('.delete_user').click(function (e) {
        e.preventDefault();
        var user_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_delete_btn': true,
                'user_id': user_id,
            },
            success: function (response) {
                window.location.reload();
 }
        });
    })
});

$(document).ready(function () {
    $('.deletesupp').click(function (e) {
        e.preventDefault();
        var supplier_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_delete_supp_btn': true,
                'supplier_id': supplier_id,
            },
            success: function (response) {
                window.location.reload();
 }
        });
    })
});






$(document).ready(function () {

$('.deletesuppprod').click(function (e) {
    e.preventDefault();
    var supplier_product_id = $(this).data('id');
  

    $.ajax({
        method: "POST",
        url: "code.php",
        data: {
            'click_delete_supplier_product_btn': true,
            'supplier_product_id':supplier_product_id,
        },
        success: function (response) {
           
            window.location.reload();
              
        }
    });

})

});





$(document).ready(function () {

$('.delete_inventory').click(function (e) {
    e.preventDefault();
    var inventory_id = $(this).closest('tr').find('.inventory_id').text();
  

    $.ajax({
        method: "POST",
        url: "code.php",
        data: {
            'click_delete_inventory_btn': true,
            'inventory_id':inventory_id,
        },
        success: function (response) {
           
            window.location.reload();
              
        }
    });

})

});

$(document).ready(function () {
    $('.delete_product').click(function (e) {
        e.preventDefault();
        
        var product_id = $(this).closest('tr').find('.productid').text().trim();

        if (confirm("Are you sure you want to delete this product?")) {
            $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'click_delete_product_btn': true,
                    'productid': product_id
                },
                success: function (response) {
                    try {
                        const data = JSON.parse(response);
                        if (data.success) {
                            alert("Product deleted successfully.");
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        alert("An error occurred. Please try again.");
                    }
                },
                error: function () {
                    alert("Failed to delete the product. Please try again.");
                }
            });
        }
    })
});

</script>