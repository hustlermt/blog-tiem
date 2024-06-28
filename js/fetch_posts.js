$(document).ready(function() {
    function fetchPosts() {
        $.ajax({
            url: "queries/list_posts_query.php",  
            type: "GET",
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    displayPosts(response.posts);
                } else {
                    $("#postTableBody").html("<tr><td colspan='6'>No posts found.</td></tr>");
                }
            },
            error: function(xhr, status, error) {
                $("#postTableBody").html("<tr><td colspan='6'>Error fetching posts.</td></tr>");
            }
        });
    }

    function fetchPostData(postId) {
        $.ajax({
            type: 'GET',
            url: 'queries/fetch_post_by_id.php',
            data: { post_id: postId }, // Use post_id for consistency
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    const post = response.post;
                    $('#post_id').val(postId);  // Ensure correct ID
                    $('#headline').val(post.headline);
                    $('#category').val(post.category_id);
                    $('#blog_content').summernote('code', post.blog_content); // Use summernote's code function
                    $('#old_image').val(post.image_name);
                    if (post.image_name) {
                        $('#imagePreview').attr('src', '../img/blog/' + post.image_name);
                        $('#imagePreview').show();
                    } else {
                        $('#imagePreview').hide();
                    }
                    $('#editPostModal').modal('show');
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert("Error fetching post data.");
            }
        });
    }

    function displayPosts(posts) {
        let tableRows = '';
        let count = 1;
        for (let post of posts) {
            const formattedDate = new Date(post.post_date).toLocaleDateString('en-ZW', { year: 'numeric', month: 'short', day: 'numeric' });

            tableRows += `
                <tr>
                    <td>${count}</td>
                    <td><img src="../img/blog/${post.image_name}" alt="${post.headline}" height="40px"></td> 
                    <td>${post.category}</td>
                    <td>${formattedDate}</td>
                    <td>${post.headline}</td>
                    <td class="flex">
                        <button class="btn btn-sm btn-primary edit-post-btn" data-post-id="${post.id}">
                            <i class="far fa-edit"></i> Update
                        </button>
                        <button class="btn btn-sm btn-danger delete-post-btn" data-post-id="${post.id}">
                            <i class="far fa-trash-alt"></i> Delete
                        </button>
                    </td>
                </tr>
            `;
            count++;
        }
        $("#postTableBody").html(tableRows);
    }

    $(document).on('click', '.edit-post-btn', function() {
        var postId = $(this).data('post-id');
        fetchPostData(postId);
    });

    fetchPosts();
});
