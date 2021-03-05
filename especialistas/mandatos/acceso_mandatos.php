<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}
$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "perfil";
  $MM_redirectLoginSuccess = "mandatos.php";
  $MM_redirectLoginFailed = "../../erroracceso.php";
  $MM_redirecttoReferrer = false;
  
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $LoginRS__query=sprintf("SELECT usuario, password, perfil FROM usuarios WHERE usuario=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
  $LoginRS = mysqli_query($comercioexterior, $LoginRS__query) or die(mysqli_error($comercioexterior));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
    $loginStrGroup  = mysql_result($LoginRS,0,'perfil');
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
<!--
.Estilo3 {color: #0000FF; font-weight: bold; }
.Estilo7 {	font-size: 24px;
	color: #FF0000;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
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
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body>
<form action="<?php echo $loginFormAction; ?>" method="POST" name="form1" id="form1">
  <table width="600"  border="0" align="center" bordercolor="#666666">
    <tr bgcolor="#FFFFFF">
      <td colspan="3" align="center"><span class="Estilo7">ACCESO MANDATOS</span></td>
    </tr>
    <tr>
      <td width="103" rowspan="3" align="center" valign="middle">&nbsp;</td>
      <td colspan="2" align="right" valign="middle"><span class="Estilo3"> <img src="../../imagenes/ICONOS/usuario.jpg" alt="" width="20" height="20" border="0" />
        <input name="usuario" type="text" class="etiqueta12" id="usuario" size="15" maxlength="8" />
      </span><span class="rojopequeno">(8 carateres) </span></td>
    </tr>
    <tr>
      <td colspan="2" align="right" valign="middle"><span class="Estilo3"> <img src="../../imagenes/ICONOS/llave.jpg" alt="" width="20" height="20" />
        <input name="password" type="password" class="etiqueta12" id="password" size="15" maxlength="8" />
      </span><span class="rojopequeno">(8 carateres)</span></td>
    </tr>
    <tr>
      <td width="307" class="rojopequeno">Comercio Exterior</td>
      <td width="176" align="right" valign="middle"><input name="Submit" type="submit" class="boton" value="Ingresar" />
        <input name="Submit" type="reset" class="boton" value="Limpiar" /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right">Volver a <a href="../bmg/bmg.php">BMG</a> / <a href="../ni/ni.php">NEGOCIO INTERNACIONAL</a> / <a href="../territorial/tr.php">TERRITORIAL</a></td>
  </tr>
</table>
<br />
</body>
</html>