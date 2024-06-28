<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>TIEM Civil and Structural Engineers Contact Details</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta
        content="civil engineering, structural engineering, architectural engineering, project management, site inspection, electrical engineering, construction, land development, infrastructure, Zimbabwe, SADC, COMESA, engineering services, building design, construction management, project planning, land development consulting, urban development"
        name="keywords">
    <meta
        content="TIEM Civil & Structural Engineers | Contact Details, Your trusted partner for comprehensive engineering solutions in Zimbabwe and beyond. We specialize in architectural, civil, and structural engineering, project management, construction, and land development, offering a one-stop shop for all your project needs. "
        name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Lato&family=Oswald:wght@200;300;400&display=swap"
        rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="page">


    <?php include 'partials/navbar.php' ?>

    <div class="contact mt-125">
        <div class="container">
            <div class="section-header">
                <p>Contact Us</p>
                <h2>Get In Touch For Any Query</h2>
            </div>
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="contact-info">
                        <div class="contact-icon">
                            <i class="fa fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h3>Office Address</h3>
                            <p>First Floor, Suite 2 - 3</p>
                            <p>Construction House</p>
                            <p>100 Leopold Takawira, Harare</p>
                        </div>
                    </div>
                    <div class="contact-info">
                        <div class="contact-icon">
                            <i class="fa fa-phone-alt"></i>
                        </div>
                        <div class="contact-text">
                            <h3>Call</h3>
                            <p>+263773 506 662</p>
                        </div>
                    </div>
                    <div class="contact-info">
                        <div class="contact-icon">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <h3>Email</h3>
                            <p>info@tiemcivilstructuralengineers.co.zw</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="contact-form">
                        <div id="form-messages"></div>
                        <form  method="POST" id="ajax-contact">
                            <div id="form-messages"></div>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="name">Your Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email">Your Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Your Email" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Phone Number" required>
                                </div>
                                <div class="col-12">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" placeholder="Leave a message here" required
                                        name="message" id="message" style="height: 100px"></textarea>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-danger w-100 py-3" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container copyright">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <a href="#">Tiem Civil & Structural Engineers</a></p>
                </div>
                <div class="col-md-6">
                    <p>Designed By <a href="https://codewand.co.zw">Codewand</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>

    <!-- Template Javascript -->
    <script>
        
        $(function () {
            var form = $('#ajax-contact');
            var formMessages = $('#form-messages');

            $(form).submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'mailer.php',
                    dataType: 'json', // Expect a JSON response
                     // Explicitly specify the URL to mailer.php
                    data: $(form).serialize()
                }).done(function (response) {
                    try {
                        const data = JSON.parse(response);
                        if (data.success) {
                            formMessages.removeClass('error');
                            formMessages.addClass('success');
                            formMessages.html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>`);
                            form.trigger("reset");
                        } else {
                            throw new Error(data.message || 'Unknown error occurred.');
                        }
                    } catch (error) {
                        formMessages.removeClass('success');
                        formMessages.addClass('error');
                        formMessages.html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${error.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
                    }
                }).fail(function () {
                    formMessages.removeClass('success');
                    formMessages.addClass('error');
                    formMessages.html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    An error occurred while sending the message. Please try again later.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
                });
            });
        });

    </script>
    <script src="js/main.js"></script>

</body>

</html>