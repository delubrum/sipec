<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="robots" content="noindex">
    <title>SIPEC</title>
    <link rel="icon" sizes="192x192" href="assets/img/logo.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <link rel="stylesheet" href="assets/css/login2.css">
    <noscript>This Site requires JavaScript! Este sitio require JavaScript!
        <style>
        form {display:none;}
        </style>
    </noscript>
</head>

<body>
     
    <div class="container">
    <div class="img">
    <img src="assets/img/intro.png" alt="">
    </div>    
    <div class="login-container">
    <form method="post" id="login_form">
        <img src="assets/img/logo2.png" alt="" class="avatar" >
         <h2></h2>
          <div class="input-div one">
           <div class="i">
          <i class="fa fa-user"></i>
        </div>
        <div>
            
            <input type="text" class="input" placeholder="email" name="email" autofocus required>
        </div>
        </div>
        <div class="input-div two ">
           <div class="i">
          <i class="fa fa-lock"></i>
        </div>
        <div>
            
            <input type="password" class="input" placeholder="pass" name="pass">
        </div>
        </div>
        
        <input type="submit" class="btn" style="background:#004240" value="Login">
        </form>
    </div>
    
    </div>
    <script>

$(document).on('submit','#login_form', function(e) {
    e.preventDefault();
    if (document.getElementById("login_form").checkValidity()) {
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
</body>
</html>