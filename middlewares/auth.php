<?php
require_once 'models/login.php';
require_once 'util.php';

$auth = new Login();
$util = new Util();

// Get Current date, time
$current_time = time();
$current_date = date("Y-m-d H:i:s", $current_time);
// Set Cookie expiration for 1 month
$cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  // for 1 month
$isLoggedIn = false;
// Check if loggedin session and redirect if session exists
if (!empty($_SESSION["id-CRB"])) {
  $isLoggedIn = true;
}
// Check if loggedin session exists
else if (!empty($_COOKIE["user_login"]) && !empty($_COOKIE["random_password"]) && !empty($_COOKIE["random_selector"])) {
  // Initiate auth token verification diirective to false
  $isPasswordVerified = false;
  $isSelectorVerified = false;
  $isExpiryDateVerified = false;
  // Get token for username
  $userToken = $auth->getTokenByEmail($_COOKIE["user_login"],0);

  if(!empty($userToken)) {
    // Validate random password cookie with database
    if (password_verify($_COOKIE["random_password"], $userToken->password_hash)) {
      $isPasswordVerified = true;
    }
    // Validate random selector cookie with database
    if (password_verify($_COOKIE["random_selector"], $userToken->selector_hash)) {
      $isSelectorVerified = true;
    }
    // check cookie expiration by date
    if($userToken->expiry_date >= $current_date) {
      $isExpiryDateVerified = true;
    }      
    // Redirect if all cookie based validation retuens true
    // Else, mark the token as expired and clear cookies
    if (!empty($userToken->id) && $isPasswordVerified && $isSelectorVerified && $isExpiryDateVerified) {
      $isLoggedIn = true;
      $user = $auth->getUserByEmail($userToken->email);
      session_start();
      $_SESSION["id-CRB"] = $user->id;
      session_write_close();
      $load_lang = $user->lang;
      $lang_json = file_get_contents("assets/lang/".$load_lang.".json");
      $lang = json_decode($lang_json, true);
    } else {
      if(!empty($userToken->id)) {
        $auth->markAsExpired($userToken->id);
      }
      // clear cookies
      $util->clearAuthCookie();
    }
  }
}

?>