<script>
$(document).ready(function () {
    $('.edit_data').click(function (e) {
        e.preventDefault();
        var user_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_edit_btn': true,
                'user_id': user_id,
            },
            success: function (response) {
                $.each(response, function (Key, value) {
                    $('#id').val(value['id']);
                    $('[name="firstname"]').val(value['first_name']);
                    $('[name="lastname"]').val(value['last_name']);
                    $('[name="email"]').val(value['email']);
                    $('[name="password"]').val(''); // Clear password field
                    $('[name="role"]').val(value['role']);
                });
                $('#editData').modal('show');
            }
        });
    })
});

$(document).ready(function () {
    $('.editsupp').click(function (e) {
        e.preventDefault();
        var supplier_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_edit_supp_btn': true,
                'supplier_id': supplier_id,
            },
            success: function (response) {
                $.each(response, function (Key, value) {
                    $('#id').val(value['id']);
                    $('[name="suppliername"]').val(value['supplier_name']);
                    $('[name="contactnumber"]').val(value['contact_number']);
                    $('[name="status"]').val(value['status']);
                   ;
                });
                $('#editSupplierModal').modal('show');
            }
        });
    })
});
                                       






$(document).ready(function () {

$('.edit_supplier_products').click(function (e) {
    e.preventDefault();
    var supplier_product_id = $(this).closest('tr').find('.supplier_product_id').text();



    $.ajax({
        method: "POST",
        url: "code.php",
        data: {
            'click_edit_supplier_products_btn': true,
            'supplier_product_id': supplier_product_id,
        },
        success: function (response) {
            

            $.each(response, function (Key, value) {
                $('#id').val(value['id']);
                $('[name="supplier"]').val(value['supplier']);
                $('[name="product_name"]').val(value['product_name']);
                $('[name="price"]').val(value['price']);
                $('[name="category"]').val(value['category']);
              
            });
            $('#editData').modal('show');
        }
    });

})

});



$(document).ready(function () {

$('.edit_inventory').click(function (e) {
    e.preventDefault();
    var inventory_id = $(this).closest('tr').find('.inventory_id').text();



    $.ajax({
        method: "POST",
        url: "code.php",
        data: {
            'click_edit_inventory_btn': true,
            'inventory_id': inventory_id,
        },
        success: function (response) {
            

            $.each(response, function (Key, value) {
                $('#id').val(value['id']);
                $('[name="supplier"]').val(value['supplier']);
                $('[name="product_name"]').val(value['product_name']);
                $('[name="package_quantity"]').val(value['package_quantity']);
                $('[name="measurement_per_package"]').val(value['measurement_per_package']);
                $('[name="total_measurement"]').val(value['total_measurement']);
                $('[name="unit"]').val(value['unit']);
                $('[name="Expiry_Date"]').val(value['Expiry_Date']);
                
              
            });
            $('#editData').modal('show');
        }
    });

})

});
$(document).ready(function () {
    $('.edit_product').click(function (e) {
        e.preventDefault();
        var product_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_edit_btn': true,
                'product_id': product_id,
            },
            success: function (response) {
                $.each(response, function (Key, value) {
                    $('#id').val(value['id']);
                    $('[name="supplier_name"]').val(value['supplier_name']);
                    $('[name="contact_number"]').val(value['contact_number']);
                    $('[name="status"]').val(value['status']);
                   
                });
                $('#editData').modal('show');
            }
        });
    })
});

$(document).ready(function () {
    $('.edit_product').click(function (e) {
        e.preventDefault();
        
        var product_id = $(this).closest('tr').find('.productid').text().trim();

        $.ajax({
            method: "POST",
            url: "code.php",
            data: {
                'click_edit_product_btn': true,
                'product_id': product_id
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.message) {
                        alert(data.message);
                    } else {
                        $('#editProductId').val(data.product_id);
                        $('#editProductName').val(data.product_name);
                        $('#editPrice').val(data.price);
                        $('#editCategory').val(data.category);
                        $('#editImagePreview').attr('src', data.image).show();
                        $('#edit-ingredients-container').empty();
                        
                        // Populate ingredients
                        data.ingredients.forEach(function(ingredient, index) {
                            $('#edit-ingredients-container').append(`
                                <div class="ingredient-field mb-2" id="ingredient_${index + 1}">
                                    <label for="ingredient_name_${index + 1}">Select Ingredient:</label>
                                    <select class="form-control fw-medium" id="ingredient_name_${index + 1}" name="ingredient_name[]" required>
                                        <option value="">-- Select Ingredient --</option>
                                        ${data.ingredientOptions}
                                    </select>
                                    <label for="quantity_${index + 1}">Quantity:</label>
                                    <input type="number" class="form-control" id="quantity_${index + 1}" name="quantity[]" value="${ingredient.quantity}" required>
                                    <label for="unit_${index + 1}">Unit:</label>
                                    <select class="form-control fw-medium" id="unit_${index + 1}" name="unit[]" required>
                                        <option value="">-- Select Unit --</option>
                                        <option value="milliliter" ${ingredient.unit === 'milliliter' ? 'selected' : ''}>milliliter</option>
                                        <option value="grams" ${ingredient.unit === 'grams' ? 'selected' : ''}>grams</option>
                                    </select>
                                    <button type="button" class="btn btn-danger remove-ingredient">Remove</button>
                                </div>
                            `);
                        });
                        $('#editProductModal').modal('show');
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                    alert('An error occurred. Please try again.');
                }
            },
            error: function () {
                alert('Failed to fetch product data. Please try again.');
            }
        });
    })
});


</script>