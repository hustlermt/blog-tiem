$(document).ready(function () {

  // Initialize Summernote
  $('#blog_content').summernote({
    placeholder: 'Write your blog content here...',
    tabsize: 2,
    height: 150, // Adjust height as needed
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['insert', ['link']] 
    ]
  });
  const form = document.getElementById("addPostForm");
  // Message area element
  const messageArea = document.getElementById("message-area");

  // Form submission event listener
  document.getElementById("addPostForm").addEventListener("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    // Get HTML content from Summernote
    let blogContent = $('#blog_content').summernote('code');
    formData.append('blog_content', blogContent);
    
    // Get the file from the input field
    const imageFile = document.getElementById("cover_img").files[0];

    // Validate image upload
    if (!imageFile) {
      messageArea.innerHTML = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          Please select an image to upload.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
      return; // Stop form submission if no image is selected
    }

    formData.append("file", imageFile);

    // Fetch request
    fetch("../admin/queries/add_post_query.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        if (!response.ok) {
          // Handle HTTP errors (e.g., 404, 500)
          throw new Error(`HTTP error! Status: ${response.status}`);
        } else {
          return response.json(); // Parse the JSON response
        }
      })
      .then((data) => {
        if (data.success) {
          // Success message
          messageArea.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              ${data.message}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `;
          // Clear the form
          form.reset();
          $('#blog_content').summernote('reset'); // Clear Summernote editor
        } else {
          // Handle errors from the server
          // Assuming the server sends back an array of errors or a single error string
          const errorMessage = Array.isArray(data.message)
            ? data.message.join(", ")
            : data.message;
          messageArea.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              ${errorMessage}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `;
        }
      })
      .catch((error) => {
        // Handle network errors or other fetch errors
        messageArea.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            An error occurred while processing your request.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `;
        console.error("Error:", error);
      });
  });

});

