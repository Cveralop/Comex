<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,MAN";
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

$colname_arqueomandato = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_arqueomandato = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_arqueomandato = sprintf("SELECT * FROM cliente nolock WHERE rut_cliente = %s", GetSQLValueString($colname_arqueomandato, "text"));
$arqueomandato = mysql_query($query_arqueomandato, $comercioexterior) or die(mysqli_error());
$row_arqueomandato = mysqli_fetch_assoc($arqueomandato);
$totalRows_arqueomandato = mysqli_num_rows($arqueomandato);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Arqueo Mandato - Maestro</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="96%" align="left" class="Estilo3">ARQUEO MANDATO - MAESTRO</td>
    <td width="4%" rowspan="2" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">COMERCIO EXTERIOR OPERACIONES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Busqueda por Rut Cliente</span></td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Rut Cliente:</td>
      <td width="82%" align="left" valign="middle"><label>
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15" />
      <span class="rojopequeno">Sin Puntos ni Guion</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="mandatos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_arqueomandato > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_azul"><?php echo $totalRows_arqueomandato ?></span> Registros en Total <br />
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td class="titulocolumnas">Validar Arqueo</td>
      <td class="titulocolumnas">Rut Cliente</td>
      <td class="titulocolumnas">Nombre Cliente</td>
      <td class="titulocolumnas">Tipo Mandato (N=Nuevo, A=Antiguo)</td>
      <td class="titulocolumnas">Ingresado Por</td>
      <td class="titulocolumnas">Fecha Ingreso</td>
      <td class="titulocolumnas">Fecha mandato</td>
      <td class="titulocolumnas">Visador</td>
      <td class="titulocolumnas">Fecha Visación</td>
      <td class="titulocolumnas">Estado Mandato</td>
      <td class="titulocolumnas">Arqueo Fisico</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><a href="arqueomand_det.php?recordID=<?php echo $row_arqueomandato['id']; ?>"><img src="../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" align="middle" /></a></td>
        <td class="respuestacolumna_rojo"><?php echo $row_arqueomandato['rut_cliente']; ?></td>
        <td align="left"><?php echo $row_arqueomandato['nombre_cliente']; ?></td>
        <td><?php echo $row_arqueomandato['tipo_mandato']; ?></td>
        <td><?php echo $row_arqueomandato['ing_operador']; ?></td>
        <td><?php echo $row_arqueomandato['fecha_ingreso']; ?></td>
        <td><?php echo $row_arqueomandato['fecha_mandato']; ?></td>
        <td><?php echo $row_arqueomandato['visador']; ?></td>
        <td><?php echo $row_arqueomandato['fecha_visacion']; ?></td>
        <td><?php echo $row_arqueomandato['estado_mandato']; ?></td>
        <td><?php echo $row_arqueomandato['arqueo_fisico']; ?></td>
      </tr>
      <?php } while ($row_arqueomandato = mysqli_fetch_assoc($arqueomandato)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($arqueomandato);
?>