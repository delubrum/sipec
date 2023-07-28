<?php 
if(!isset($_SESSION)) { 
    session_start(); 
}
if (empty($_SESSION["id-SIPEC"])) {
    header('Location: ?c=Login&a=Index');
}
else {
$filters = "and id = " . $_SESSION["id-SIPEC"];
$user = $this->init->get('*','users',$filters);
$permissions = json_decode($user->permissions, true);
$load_lang = $user->lang;
$lang_json = file_get_contents("assets/lang/".$load_lang.".json");
$lang = json_decode($lang_json, true);
}
?>