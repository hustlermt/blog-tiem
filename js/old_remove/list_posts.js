document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.getElementById("postTableBody");
    const messageArea = document.getElementById("message-area");
  
    function loadPosts() {
      fetch("list_posts_query.php")
        .then((response) => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          } else {
            return response.json();
          }
        })
        .then((posts) => {
          if (posts[0].hasOwnProperty("error")) {
            // If connection error is encountered
            messageArea.innerHTML = `
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      ${posts[0].error}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              `;
            return;
          }
  
          tableBody.innerHTML = "";
          posts.forEach((post) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                  <td>${post.id}</td>
                  <td><img src="${post.image_url}" alt="${post.headline}" style="height:40px;"></td>
                  <td>${post.category}</td>
                  <td>${post.post_date}</td> 
                  <td>${post.headline}</td>
                  <td>
                    <button class="mt-1 btn btn-sm btn-primary edit-btn" data-post-id="${post.id}"><i class="fas fa-edit"></i> Update</button>
  
                    <button type="button" class="mt-1 btn btn-sm btn-danger delete-btn" data-bs-toggle="modal" data-bs-target="#deleteModal" data-post-id="${post.id}">
                      <i class="far fa-trash-alt"></i> Delete
                    </button>
                  </td>
              `;
            tableBody.appendChild(row);
          });
        })
        .catch(error => {
          console.error('Error fetching posts:', error);
          messageArea.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              An error occurred while fetching posts.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `;
        });
    }
  
    // Event delegation for modal buttons
    document.body.addEventListener('click', function(event) {
      if (event.target.classList.contains('delete-btn')) {
        const postId = event.target.dataset.postId;
  
        // Update the modal body with the post headline
        const postHeadline = event.target.closest('tr').querySelector('td:nth-child(5)').textContent;
        document.getElementById('postHeadlineToDelete').textContent = postHeadline;
  
        // Get the modal and confirm delete button after the modal is shown
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
  
        // Event listener for confirm delete button (inside the modal)
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');
        confirmDeleteButton.addEventListener('click', function() {
          // Send AJAX request to delete the post
          fetch('delete_post.php?id=${postId}', { // Corrected path
            method: 'DELETE'
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Remove the row from the table
              event.target.closest('tr').remove();
              // Close the modal
              deleteModal.hide();
              // Show success message
              messageArea.innerHTML = `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  ${data.message}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              `;
            } else {
              // Show error message
              messageArea.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  ${data.message}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              `;
            }
          })
          .catch(error => {
            // Handle errors
            console.error('Error:', error);
            messageArea.innerHTML = `
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                An error occurred while processing your request.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            `;
          });
        });
      }
    });
  
    loadPosts(); // Initial loading of posts
  });
  
  