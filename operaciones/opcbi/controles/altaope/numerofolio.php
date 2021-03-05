<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "OPE,ADM";
$MM_donotCheckaccess = "false";
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 
  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}
$MM_restrictGoTo = "../../erroracceso.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
  session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  global $comercioexterior;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($comercioexterior, $theValue) : mysqli_escape_string($comercioexterior, $theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$colname_numerofolio = "Cob Imp y OPI.";
if (isset($_GET['asignador'])) {
  $colname_numerofolio = $_GET['asignador'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_numerofolio = sprintf("SELECT * FROM opmec WHERE asignador = %s ORDER BY date_asig DESC LIMIT 0,1", GetSQLValueString($colname_numerofolio, "text"));
$numerofolio = mysql_query($query_numerofolio, $comercioexterior) or die(mysqli_error());
$row_numerofolio = mysqli_fetch_assoc($numerofolio);
$colname_numerofolio = "-1";
if (isset($_SESSION['login'])) {
  $colname_numerofolio = $_SESSION['login'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_numerofolio = sprintf("SELECT * FROM opmec WHERE visador = %s ORDER BY id DESC", GetSQLValueString($colname_numerofolio, "text"));
$numerofolio = mysql_query($query_numerofolio, $comercioexterior) or die(mysqli_error());
$row_numerofolio = mysqli_fetch_assoc($numerofolio);
$totalRows_numerofolio = mysqli_num_rows($numerofolio);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nro Folio Envio OP Meco</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 36px;
	color: #00F;
	font-weight: bold;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
	font-size: 36px;
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
	font-weight: bold;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
</head>
<body>
<br />
<br />
<br />
<table width="70%" border="3" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle"> No. FOLIO<br />
    <?php echo $row_numerofolio['id']; ?></td>
  </tr>
</table>
<br />
<br />
<table width="70%" border="0" align="center">
  <tr>
    <td align="center" valign="middle"><a href="altaopmae.php"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" width="80" height="25" border="0" /></a></td>
  </tr>
</table>
<br />
<br />
</body>
</html>
<?php
mysqli_free_result($numerofolio);
?>