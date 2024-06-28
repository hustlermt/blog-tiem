document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = this; 
    const successDiv = document.getElementById('success'); // Get success message container
  
    fetch(form.action, {
      method: form.method,
      body: new FormData(form)
    })
      .then(response => {
        if (response.ok) {
          return response.json(); // If response status is 200
        } else {
          throw new Error("Error: " + response.status); // If not, throw an error
        }
      })
      .then(data => {
        if (data.success) {
          // Success message
          successDiv.innerHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              ${data.message}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
            </div>
          `;
          form.reset(); // Clear the form
        } else {
          // Error message
          successDiv.innerHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              ${data.message}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
            </div>
          `;
        }
      })
      .catch(error => {
        successDiv.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            An unexpected error occurred. Please try again later.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">&times;</button>
          </div>
        `;
        console.error(error); // Log the error to the console
      });
  });
  