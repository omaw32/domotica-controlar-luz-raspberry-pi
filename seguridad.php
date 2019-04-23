<?
@session_start();

if($_SESSION["autentica"] != "SIP"){
	header("Location: index.php");
	exit();
}
?>
