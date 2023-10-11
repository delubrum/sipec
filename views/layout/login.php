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
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="assets/plugins/toastr/toastr.min.js"></script>
    <link rel="stylesheet" href="assets/css/login.css">
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
          <i class="fa fa-user" style="color:#333"></i>
        </div>
        <div>
            
            <input type="text" class="input" placeholder="email" name="email" autofocus required>
        </div>
        </div>
        <div class="input-div two ">
           <div class="i">
          <i class="fa fa-eye-slash eye show" style="cursor:pointer;color:#333"></i>
        </div>
        <div>
            
            <input type="password" class="input" placeholder="pass" name="pass" id="password">

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
        $.post( "?c=Home&a=Login", $( "#login_form" ).serialize()).done(function( data ) {
            if(data.trim() != 'ok') {
                toastr.error(data.trim());
            } else {
                window.location='?c=Home&a=Index';
            }
        });
    }
});

document.querySelector('.eye').addEventListener('click', e => {
    const passwordInput = document.querySelector('#password');
    if (e.target.classList.contains('show')) {
        e.target.classList.remove('show');
        e.target.classList.remove('fa-eye-slash');
        e.target.classList.add('fa-eye');
        passwordInput.type = 'text';
    } else {
        e.target.classList.add('show');
        passwordInput.type = 'password';
        e.target.classList.remove('fa-eye');
        e.target.classList.add('fa-eye-slash');
    }
});

</script>
</body>
</html>