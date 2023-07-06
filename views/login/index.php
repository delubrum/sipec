<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="robots" content="noindex">
    <title>Curuba</title>
    <link rel="icon" sizes="192x192" href="assets/img/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <link rel="stylesheet" href="assets/css/login.css">
    <noscript>This Site requires JavaScript! Este sitio require JavaScript!
        <style>
        form {display:none;}
        </style>
    </noscript>
</head>

<body>
    <div id="loading"></div>
    <div class="login-dark">
        <form method="post" id="login_form">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><img src="assets/img/logo.png"></div>
            <div class="form-group"><input class="form-control" type="email" name="email" placeholder="Email" autofocus required></div>
            <div class="form-group"><input class="form-control" type="password" name="pass" placeholder="Password"></div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Log In</button></div></form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<script>

$(document).on('submit','#login_form', function(e) {
    e.preventDefault();
    if (document.getElementById("login_form").checkValidity()) {
        $("#loading").show();
        $.post( "?c=Login&a=Login", $( "#login_form" ).serialize()).done(function( data ) {
            if(data.trim() != 'ok') {
                toastr.error(data.trim());
            } else {
                window.location='?c=Init&a=Index'
            }
        });
    }
});
</script>