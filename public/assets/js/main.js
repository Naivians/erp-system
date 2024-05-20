
function toggleSidebar() {
    var sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("move");
}
var csrfToken = $('meta[name="csrf-token"]').attr("content");
function deleteUser(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/deleteUser/" + id, ///deleteUser/{id}
                method: "GET",
                data: {
                    _token: csrfToken, // Include CSRF token as a parameter
                },
                success: (res) => {
                    if (res.status != 200) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: res.message,
                        });
                    } else {
                        setInterval(function () {
                            window.location.reload();
                        }, 1500);
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                },
            });
        }
    });
}

// category

function deleteCategory(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/deleteCategory/" + id, ///deleteUser/{id}
                method: "GET",
                data: {
                    _token: csrfToken, // Include CSRF token as a parameter
                },
                success: (res) => {
                    if (res.status != 200) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: res.message,
                        });
                    } else {
                        setInterval(function () {
                            window.location.reload();
                        }, 1500);
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                },
            });
        }
    });
}

// deleteInventory
function deleteInventory(id) {
    var redirects = "{{ route('Admins.InventoryHome')}}";

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/deleteInventory/" + id,
                method: "GET",
                data: {
                    _token: csrfToken, // Include CSRF token as a parameter
                },
                success: (res) => {
                    if (res.status != 200) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: res.message,
                        });
                    } else {
                        setInterval(function () {
                           window.location.reload()
                        }, 1500);
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                },
            });
        }
    });
}


