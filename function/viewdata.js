<script>

$(document).ready(function () {
    $('.view_data').click(function (e) {
        e.preventDefault();
        var user_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_view_btn': true,
                'user_id': user_id,
            },
            success: function (response) {
                $('.view_item_data').html(response);
                $('#viewitemModal').modal('show');
            }
        });
    })
});

$(document).ready(function () {
    $('.viewsupp').click(function (e) {
        e.preventDefault();
        var supplier_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_view_supp_btn': true,
                'supplier_id': supplier_id,
            },
            success: function (response) {
                $('.view_item_data').html(response);
                $('#viewitemModal').modal('show');
            }
        });
    })
});




$(document).ready(function () {

$('.view_supplier_products').click(function (e) {
    e.preventDefault();
    var supplier_product_id = $(this).closest('tr').find('.supplier_product_id').text();
   


    $.ajax({
        method: "POST",
        url: "code.php",
        data: {
            'click_view_supplier_product_btn': true,
            'supplier_product_id':supplier_product_id,
        },
        success: function (response) {
            $('.view_item_data').html(response);
            $('#viewitemModal').modal('show');    
        }
    });

})

});

$(document).ready(function () {

$('.view_inventory').click(function (e) {
    e.preventDefault();
    var inventory_id = $(this).closest('tr').find('.inventory_id').text();
   


    $.ajax({
        method: "POST",
        url: "code.php",
        data: {
            'click_view_inventory_btn': true,
            'inventory_id':inventory_id,
        },
        success: function (response) {
            $('.view_item_data').html(response);
            $('#viewitemModal').modal('show');    
        }
    });

})

});
$(document).ready(function () {
    $('.view_product').click(function (e) {
        e.preventDefault();
        
        var product_id = $(this).closest('tr').find('.productid').text().trim();

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_view_product_btn': true,
                'product_id': product_id
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        $('#viewProductName').text(data.data.product_name);
                        $('#viewPrice').text(data.data.price);
                        $('#viewCategory').text(data.data.category);
                        $('#viewImage').attr('src', data.data.image);
                        $('#viewIngredients').empty();
                        data.data.ingredients.forEach(function(ingredient) {
                            $('#viewIngredients').append(`<li>${ingredient.ingredient_name} - ${ingredient.quantity} ${ingredient.unit}</li>`);
                        });
                        $('#viewProductModal').modal('show');
                    } else {
                        alert(data.message);
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                    alert("An error occurred. Please try again.");
                }
            },
            error: function () {
                alert("Failed to retrieve product details. Please try again.");
            }
        });
    })
});

</script>