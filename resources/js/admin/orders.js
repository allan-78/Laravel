document.addEventListener('DOMContentLoaded', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function openStatusModal(orderId, currentStatus) {
        $('#orderId').val(orderId);
        $('#status').val(currentStatus);
        $('#statusModal').modal('show');
    }

    function updateStatus() {
        const orderId = $('#orderId').val();
        const status = $('#status').val();

        $.ajax({
            url: `/admin/orders/${orderId}/status`,
            type: 'PUT',
            data: {
                status: status
            },
            success: function(response) {
                $('#statusModal').modal('hide');
                $('#orders-table').DataTable().ajax.reload();
                
                // Show success message
                const alert = $('<div class="alert alert-success alert-dismissible fade show" role="alert">')
                    .text('Status updated successfully! Email sent to customer.')
                    .append('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                
                $('.top-header').after(alert);
                
                // Remove alert after 3 seconds
                setTimeout(() => alert.alert('close'), 3000);
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'Error updating status. Please try again.';
                
                // Show error message
                const alert = $('<div class="alert alert-danger alert-dismissible fade show" role="alert">')
                    .text(errorMessage)
                    .append('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                
                $('.top-header').after(alert);
                
                // Remove alert after 3 seconds
                setTimeout(() => alert.alert('close'), 3000);
            }
        });
    }

    // Make functions globally available
    window.openStatusModal = openStatusModal;
    window.updateStatus = updateStatus;
});