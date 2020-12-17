<?php
if(isset($_GET["id"]))
{
	$id=$_GET["id"];
	if(!empty($id )&& is_numeric($id))
	{
		include_once("Login/functions/function.php");
		$bdd=bdd();
		delete_User($bdd,$id);
		header("Location:ListeUsers.php");
	}
}
?>