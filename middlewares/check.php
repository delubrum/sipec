<?php 
session_start();
$user = $this->init->get('*','users',$_SESSION["id-SIPEC"]);
$permissions = json_decode($user->permissions, true);
$load_lang = $user->lang;
$lang_json = file_get_contents("assets/lang/".$load_lang.".json");
$lang = json_decode($lang_json, true);
if (empty($_SESSION["id-SIPEC"])) {
    header('Location: ?c=Login&a=Index');
}
?>