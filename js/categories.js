$(document).ready(function() {
    // Function to fetch and display categories
    function fetchCategories() {
        $.ajax({
            url: "queries/list_categories_query.php",
            type: 'GET',
            dataType: 'json', // Expect a JSON response
            success: function(response) {
                if (response.status === 'success') {
                    displayCategories(response.categories);
                } else {
                    // Handle error if no categories are found
                    $("#message-area").html('<div class="alert alert-info alert-dismissible fade show" role="alert">' + response.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                }
            },
            error: function(xhr, status, error) {
                // Handle AJAX errors
                console.error("AJAX Error:", error);
                $("#message-area").html('<div class="alert alert-danger alert-dismissible fade show" role="alert">An error occurred while fetching categories.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            }
        });
    }

    $('#addCategoryForm').submit(function(event) {
        event.preventDefault();
        const categoryName = $('#newCategoryName').val().trim();

        $.ajax({
            url: "queries/add_category_query.php",
            type: 'POST',
            data: { categoryName: categoryName },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Success - refresh categories and display success message
                    fetchCategories(); 
                    $('#addCategoryModal').modal('hide');
                    toastr.success(response.message, 'Success!');
                } else {
                    // Display error in modal
                    $('#addCategoryMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                // Display AJAX error
                $('#addCategoryMessage').html('<div class="alert alert-danger">An error occurred while adding the category.</div>');
            }
        });
    });

    // Function to display categories in the table
    function displayCategories(categories) {
        let tableRows = '';
        let count = 1;
        for (let category of categories) {
            tableRows += `
                <tr>
                    <td>${count}</td>
                    <td>${category.category}</td>
                    <td class='flex'>
                        <button class='btn btn-sm btn-primary edit-category-btn' data-toggle='modal' data-target='#editCategoryModal' data-category-id='${category.id}'>
                            <i class='fas fa-edit'></i> Update
                        </button>
                        <button class='btn btn-sm btn-danger delete-category-btn' data-toggle='modal' data-target='#deleteCategoryModal' data-category-id='${category.id}'>
                            <i class='far fa-trash-alt'></i> Delete
                        </button>
                    </td>
                </tr>
            `;
            count++;
        }
        $("#latestPostContainer").html(tableRows);
    }

    $(document).on('click', '.edit-category-btn', function() {
        var categoryId = $(this).data('category-id');

        // Fetch the category data
        $.ajax({
            url: "queries/fetch_category_by_id.php", // PHP script to fetch category by ID
            type: 'GET',
            data: { categoryId: categoryId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Populate the modal with the retrieved data
                    $('#editCategoryName').val(response.category.category);
                    $('#editCategoryId').val(response.category.id);

                    // Show the modal
                    $('#editCategoryModal').modal('show');
                } else {
                    alert(response.message); // Or show an error toastr
                }
            },
            error: function() {
                alert("Error fetching category data.");
            }
        });
    });

    // Update Category Form Submission
    $('#editCategoryForm').submit(function(event) {
        event.preventDefault();

        var updatedCategoryId = $('#editCategoryId').val();
        var updatedCategoryName = $('#editCategoryName').val().trim();

        $.ajax({
            url: "queries/update_category_query.php",
            type: 'POST',
            data: { 
                categoryId: updatedCategoryId, 
                categoryName: updatedCategoryName 
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Refresh the category list, hide the modal, and show success message
                    fetchCategories();
                    $('#editCategoryModal').modal('hide');
                    toastr.success(response.message, 'Success!');
                } else {
                    // Display error in modal
                    $('#editCategoryMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#editCategoryMessage').html('<div class="alert alert-danger">An error occurred while updating the category.</div>');
            }
        });
    });


    // Delete Category Modal Handling
    $(document).on('click', '.delete-category-btn', function() {
        const categoryId = $(this).data('category-id');
        
        // Fetch the category name to display in the modal (optional)
        $.ajax({
            url: "queries/fetch_category_name.php", // PHP script to fetch category name
            type: 'GET',
            data: { categoryId: categoryId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#deleteCategoryName').text(response.category);
                    $('#deleteCategoryId').val(categoryId); 
                    $('#deleteCategoryModal').modal('show'); // Show the modal
                } else {
                    alert(response.message); // Or show an error toastr
                }
            },
            error: function() {
                alert("Error fetching category name.");
            }
        });
    });
    // ... your existing Add Category Form Submission function ...
    // Delete Category Confirmation
    $('#confirmDeleteCategory').click(function() {
        const categoryId = $('#deleteCategoryId').val();

        $.ajax({
            url: "queries/delete_category_query.php",
            type: 'POST',
            data: { categoryId: categoryId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    // Refresh the category list and hide the modal
                    fetchCategories();
                    $('#deleteCategoryModal').modal('hide');
                    toastr.success(response.message, 'Success!');
                } else {
                    // Display error in modal
                    $('#deleteCategoryMessage').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#deleteCategoryMessage').html('<div class="alert alert-danger">An error occurred while deleting the category.</div>');
            }
        });
    });

    // Fetch categories when the page loads
    fetchCategories();
});
