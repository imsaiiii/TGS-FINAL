$(document).ready(function () {

    /* VIEW DATA */
    $('.view_data').click(function (e) {
        e.preventDefault();
        var user_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "po_action.php",
            data: {
                'click_view_btn': true,
                'user_id': user_id,
            },
            success: function (response) {
                $('.view_item_data').html(response);
                $('#viewitemModal').modal('show');
            }
        });
    });

    /* EDIT DATA */
    $('#myTable').on('click', '.edit_data', function (e) {
        e.preventDefault();
        var po_detail_id = $(this).data('po-detail-id');

        $.ajax({
            method: "POST",
            url: "po_action.php",
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

    /* DELETE USER */
    $('.delete_user').click(function (e) {
        e.preventDefault();
        var user_id = $(this).data('id');

        $.ajax({
            method: "POST",
            url: "po_action.php",
            data: {
                'click_delete_btn': true,
                'user_id': user_id,
            },
            success: function (response) {
                window.location.reload();
            }
        });
    });

});
