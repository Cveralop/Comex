<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE,GER";
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
$MM_restrictGoTo = "../erroracceso.php";
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
$colname1_DetailRS1 = "Despacho Doctos.";
if (isset($_GET['evento'])) {
  $colname1_DetailRS1 = $_GET['evento'];
}
$colname_DetailRS1 = "1";
if (isset($_GET['fecha_valija'])) {
  $colname_DetailRS1 = $_GET['fecha_valija'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcbi WHERE fecha_valija = %s and evento = %s ORDER BY sucursal ASC", GetSQLValueString($colname_DetailRS1, "text"),GetSQLValueString($colname1_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Carta Correspondencia</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #000000;
}
body {
	background-image: url();
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo2 {color: #FFFFFF; font-weight: bold; }
.Estilo7 {font-size: 10px; font-weight: bold; }
.Estilo9 {font-size: 24px; font-weight: bold; }
-->
</style>
<script> 
window.print(); 
</script>			
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body>
<table width="95%"  border="0" align="center">
  <tr>
    <td valign="middle"><img src="../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61" align="left">
    </div>      </div></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center" valign="middle">ENVIO DE CORRESPONDENCIA A PROVINCIA </div></td>
  </tr>
  <tr>
    <td align="center" valign="middle">RED II </div></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center" valign="middle"><strong>UNIDAD DE SERVICIOS COMERCIO EXTERIOR</strong></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><strong>COBRANZA DE IMPORTACI&Oacute;N</strong></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr bgcolor="#999999">
    <td align="center" valign="middle">OFICINA</div></td>
    <td align="center" valign="middle">CODIGO OFICINA</div></td>
    <td align="center" valign="middle">SOBRE NRO </div></td>
    <td align="center" valign="middle">NRO OPERACI&Oacute;N</div></td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['despacho_doctos']); ?></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['sucursal']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['nro_sobre']; ?></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></div></td>
  </tr>
  <?php } while ($row_DetailRS1 = mysqli_fetch_assoc($DetailRS1)); ?>
</table>
<p><br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
</p>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="center" valign="middle"><span class="Estilo7">Hecho por: <?php echo $_SESSION['login'];?></span></td>
    <td align="center" valign="middle"><span class="Estilo7">Acuse recibo Correspondencia</span></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="Estilo7">Bandera 237 Piso 3 Comercio exterior</span></td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
</table>
<p><br>
  <br>
  <br>
  <br>
</p>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>