<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE";
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
$colname1_DetailRS1 = "Despacho Doctos.";
if (isset($_GET['evento'])) {
  $colname1_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['evento'] : addslashes($_GET['evento']);
}
$colname_DetailRS1 = "1";
if (isset($_GET['fecha_valija'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['fecha_valija'] : addslashes($_GET['fecha_valija']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcci WHERE fecha_valija = '%s' and evento = '%s' ORDER BY sucursal ASC", $colname_DetailRS1,$colname1_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Nomina Correspondencia</title>
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
    <td align="center" valign="middle"><img src="../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61" align="left">      </div></td>
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
    <td align="center" valign="middle"><strong>CARTA DE CR&Eacute;DITO IMPORTACI&Oacute;N</strong></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr valign="middle" bgcolor="#999999">
    <td align="center">OFICINA</div></td>
    <td align="center">CODIGO OFICINA</div></td>
    <td align="center">SOBRE NRO </div></td>
    <td align="center">NRO OPERACI&Oacute;N</div></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><?php echo strtoupper($row_DetailRS1['despacho_doctos']); ?></td>
    <td align="center"><?php echo $row_DetailRS1['sucursal']; ?></div></td>
    <td align="center"><?php echo $row_DetailRS1['nro_sobre']; ?></div></td>
    <td align="center"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></div></td>
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
    <td align="center" valign="middle"><span class="Estilo7">Acuse recivo Correspondencia</span></div></td>
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