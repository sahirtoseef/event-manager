$(document).ready(function() {
  $("#select-avatar-image").click(function() {
    $("#avatar").trigger("click");
  });
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $("#select-avatar-image").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#avatar").change(function() {
    readURL(this);
  });

  $(".event-avatar-click").click(function() {
    $("#event-avatar").trigger("click");
  });
  function readURL1(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $("#actual-image-event").attr("src", e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#event-avatar").change(function() {
    readURL1(this);
  });

  $(".delete-user").click(function() {
    const btnReference = $(this);
    var user_id = $(this).attr("id");

    swal(
      {
        title: "Are you sure?",
        text: "Do you want to deleted this user?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajaxSetup({
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
          });

          $.ajax({
            type: "DELETE",
            url: "/admin/deleteClientManager/" + user_id,
            data: {
              id: user_id
            },
            contentType: false,
            cache: false,
            success: function(data, status, jqXHR) {
              if (!data.error) {
                swal(
                  {
                    title: "Successfull",
                    text: "User has been deleted...",
                    type: "success",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                  },
                  function(isConfirm) {
                    if (isConfirm) {
                      btnReference.closest("tr").remove();
                      btnReference.closest(".col-xl-6.mt-4").remove();
                    }
                  }
                );
              } else {
                swal("Cancelled", "Something went wrong...", "error");
              }
            },
            error: function(jqXHR, status) {
              swal("Cancelled", "Admin is not deleted...", "error");
              console.log("ERR status: " + status);
              console.log("ERR xhr text: " + jqXHR.responseText);
            }
          });
        } else {
          swal("Cancelled", "Admin is not deleted...", "error");
        }
      }
    );
  });

  $(".delete-event").click(function() {
    const btnReference = $(this);
    var event_id = $(this).attr("id");

    swal(
      {
        title: "Are you sure?",
        text: "Do you want to deleted this event?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajaxSetup({
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            }
          });

          $.ajax({
            type: "DELETE",
            url: "/admin/deleteEvent/" + event_id,
            data: {
              id: event_id
            },
            contentType: false,
            cache: false,
            success: function(data, status, jqXHR) {
              if (!data.error) {
                swal(
                  {
                    title: "Successfull",
                    text: "Event has been deleted...",
                    type: "success",
                    confirmButtonText: "Ok",
                    closeOnConfirm: true
                  },
                  function(isConfirm) {
                    if (isConfirm) {
                      btnReference.closest("tr").remove();
                      btnReference.closest(".col-xl-6.mt-4").remove();
                    }
                  }
                );
              } else {
                swal("Cancelled", "Something went wrong...", "error");
              }
            },
            error: function(jqXHR, status) {
              swal("Cancelled", "Admin is not deleted...", "error");
              console.log("ERR status: " + status);
              console.log("ERR xhr text: " + jqXHR.responseText);
            }
          });
        } else {
          swal("Cancelled", "Event is not deleted...", "error");
        }
      }
    );
  });
});
