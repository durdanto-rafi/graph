function numberValidate(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode == 8 || event.keyCode == 46 ||
        event.keyCode == 37 || event.keyCode == 39) {
        return true;
    } else if (key < 48 || key > 57) {
        return false;
    } else return true;
};

$('button.delete-btn').on('click', function (e) {
    e.preventDefault();
    var self = $(this);
    swal({
            title: "Are you sure?",
            text: "You will not be able to recover this Item !",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, Cancel delete!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {
                swal("Deleted !", "This item has been deleted", "success");
                setTimeout(function () {
                    self.parents(".frmDelete").submit();
                }, 2000); //2 second delay (2000 milliseconds = 2 seconds)
            } else {
                swal("Cancelled", "This item is safe", "error");
            }
        });
});


