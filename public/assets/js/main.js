var csrfToken = $('meta[name="csrf-token"]').attr("content");

// stock in operatio
$("#searchBtn").on("click", () => {
    productCodeSearch();
});

function productCodeSearch() {
    if ($("#product_code").val() == "") {
        alert("empty fields");
    } else {
        $.ajax({
            url: "/searchItemCode/",
            method: "GET",
            data: {
                query: $("#product_code").val(),
            },
            success: function (res) {
                if (res.status != 200) {
                    $("#product_code").val("");
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: res.message,
                    });
                } else {
                    $("#product_code").val("");
                    displayData(res.product);
                    console.log(res);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    }
}

function displayData(products) {
    $("#searchTableBody").empty();

    $.each(products, function (index, item) {
        var row = `<tr>
                        <td>${item.code}</td>
                        <td>${item.category}</td>
                        <td>${item.name}</td>
                        <td>${item.description}</td>
                        <td>${item.price}</td>
                        <td class="d-flex justify-content-center">
                            <input type="text" name="qty[]" value="${item.qty}" class="form-control text-center" style="width: 50px;">
                            <input type="hidden" name="category[]" value="${item.category}">
                            <input type="hidden" name="name[]" value="${item.name}">
                            <input type="hidden" name="price[]" value="${item.price}">
                            <input type="hidden" name="description[]" value="${item.description}">
                            <input type="hidden" name="code[]" value="${item.code}">
                        </td>
                        <td><i class='bx bx-trash btn btn-outline-danger' onclick="deleteItemCodes('${item.code}', 'stockin')"></i></td>
                    </tr>`;
        // Append the row to the table body
        $("#searchTableBody").append(row);
    });
}

// delete
function deleteItemCodes(itemCode, model) {
    $.ajax({
        url: "/deleteItemcode/" + itemCode, ///deleteUser/{id}
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
                refreshPage();
            }
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.error(xhr.responseText);
        },
    });
}

//save stocks
function saveStocks() {
    const formData = new FormData(document.querySelector("form"));

    const formDataObject = {};

    formData.forEach(function (value, key) {
        if (formDataObject.hasOwnProperty(key)) {
            if (Array.isArray(formDataObject[key])) {
                formDataObject[key].push(value);
            } else {
                formDataObject[key] = [formDataObject[key], value];
            }
        } else {
            formDataObject[key] = value;
        }
    });

    // console.log(formDataObject)

    $.ajax({
        url: "/stockin/saveForm",
        method: "POST",
        // dataType: 'json',
        data: formDataObject,
        success: function (res) {
            // console.log(res)

            if (res.status === 200) {
                window.location.href = res.url;
            } else {
                Swal.fire({
                    icon: "error",
                    title: res.message,
                });
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

// end stock in

function refreshPage() {
    $.ajax({
        type: "GET",
        url: "/search/refresh",
        dataType: "json",
        success: function (res) {
            // console.log(res);

            if (res.status != 200) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: res.message,
                });
            } else {
                $("#product_code").val();
                displayData(res.product);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        },
    });
}

function toggleSidebar() {
    var sidebar = document.querySelector(".sidebar");
    sidebar.classList.toggle("move");
}

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
