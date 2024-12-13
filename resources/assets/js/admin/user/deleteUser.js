'use strict';

$(function () {
  // Handle delete action
  $(document).on('click', '.delete-btn', function () {
    var id = $(this).data('id');

    // Show SweetAlert2 confirmation dialog
    Swal.fire({
      title: 'Are you sure?',
      text: "This user will be permanently deleted!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        // Perform AJAX DELETE request
        $.ajax({
          url: `/user/delete/${id}`, // URL to your delete method in the controller
          type: 'DELETE',
          success: function (response) {
            // Refresh the DataTable after deletion
            dt_scrollableTable.ajax.reload();
            Swal.fire({
              icon: 'success',
              title: 'Deleted!',
              text: response.message,
              timer: 2000,
              showConfirmButton: false
            });
          },
          error: function (xhr) {
            if (xhr.responseJSON && xhr.responseJSON.message) {
              Swal.fire('Error!', xhr.responseJSON.message, 'error');
            } else {
              Swal.fire('Error!', 'An unexpected error occurred.', 'error');
            }
          }
        });
      }
    });
  });
});