<?php require_once('Connections/comercioexterior.php'); ?>
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

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO controlacceso (usuario) VALUES (%s)",
                       GetSQLValueString($_POST['usuario'], "text"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
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
  $MM_redirectLoginSuccess = "ingreso.php";
  $MM_redirectLoginFailed = "acceso.php";
  $MM_redirecttoReferrer = false;
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  	
  $LoginRS__query=sprintf("SELECT usuario, password, perfil FROM usuarios WHERE usuario=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysqli_query($comercioexterior, $LoginRS__query) or die(mysqli_error($comercioexterior));
  $loginFoundUser = mysqli_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysqli_result($LoginRS,0,'perfil');
    
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
<link rel="shortcut icon" href="../../../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../comex/imagenes/barraweb/animated_favicon1.gif">
<br>
<?php $_SESSION['login']=$loginUsername; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Gestor de Operaciones Comex</title>
<style type="text/css">
<!--
@import url("estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #0000FF;
}
body {
	background-image: url();
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FF0000;
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
.Estilo3 {color: #0000FF; font-weight: bold; }
.Estilo6 {font-size: 9px; font-weight: bold; color: #FF0000; }
.Estilo7 {
	font-size: 24px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {font-size: 9px; font-weight: bold; color: #0099CC; }
-->
</style></head>

<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function scrollit(seed) {
var m1  = "Banco Santander";
var m2  = "     Bienvenidos al Gestor de Operaciones Comex";
var m3  = "     Ambiente Producci�n";
var m4  = "";
var msg=m1+m2+m3+m4;
var out = " ";
var c   = 1;
if (seed > 100) {
seed--;
cmd="scrollit("+seed+")";
timerTwo=window.setTimeout(cmd,100);
}
else if (seed <= 100 && seed > 0) {
for (c=0 ; c < seed ; c++) {
out+=" ";
}
out+=msg;
seed--;
window.status=out;
cmd="scrollit("+seed+")";
timerTwo=window.setTimeout(cmd,100);
}
else if (seed <= 0) {
if (-seed < msg.length) {
out+=msg.substring(-seed,msg.length);
seed--;
window.status=out;
cmd="scrollit("+seed+")";
timerTwo=window.setTimeout(cmd,100);
}
else {
window.status=" ";
timerTwo=window.setTimeout("scrollit(100)",75);
      }
   }
}
// End -->
</SCRIPT>
<BODY BGCOLOR=#ffffff vlink=#0000ff onLoad="scrollit(100)">
<form ACTION="<?php echo $editFormAction; ?><?php echo $loginFormAction; ?>" name="form1" method="POST">
  <table width="600"  border="0" align="center" bordercolor="#666666">
    <tr bgcolor="#FFFFFF">
      <td colspan="3"><span class="Estilo7">GESTOR DE OPERACIONES COMEX (GOC)</span></td>
    </tr>
    <tr>
      <td colspan="3" align="center" valign="middle"><div align="center"><img src="imagenes/JPEG/ImagenComercioExterior_Inicio_comex.jpg" width="483" height="336"></div></td>
    </tr>
    <tr>
      <td width="103" rowspan="3" align="center" valign="middle"><img src="imagenes/GIF/globe3.gif" width="80" height="80"></td>
      <td colspan="2" align="right" valign="middle"><span class="Estilo3">
        <img src="imagenes/ICONOS/usuario.jpg" alt="" width="20" height="20" border="0">
        <input name="usuario" type="text" class="etiqueta12" id="usuario" size="15" maxlength="8">
</span><span class="rojopequeno">(8 carateres) </span> </td>
    </tr>
    <tr>
      <td colspan="2" align="right" valign="middle"><span class="Estilo3">
        <img src="imagenes/ICONOS/llave.jpg" alt="" width="20" height="20">
        <input name="password" type="password" class="etiqueta12" id="password" size="15" maxlength="8">
</span><span class="rojopequeno">(8 carateres)</span></td>
    </tr>
    <tr>
      <td width="307" class="rojopequeno">Comercio Exterior</td>
      <td width="176" align="right" valign="middle"><input name="Submit" type="submit" class="boton" value="Ingresar">
      <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>
