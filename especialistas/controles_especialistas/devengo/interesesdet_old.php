<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,ESP,RED,TER,BMG,ACB";
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

$MM_restrictGoTo = "../../ni/erroracceso.php";
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

$colname_DetailRS1 = "-1";
if (isset($_SESSION['login'])) {
  $colname_DetailRS1 = $_SESSION['login'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT *,datediff(fecha_hasta,fecha_desde)as dias, (capital_original * tasa_final_cliente)as total FROM intproyec WHERE sistema = %s ORDER BY id DESC", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Intereses Proyectados Detalle</title>
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<style type="text/css">
<!--
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
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
	color: #999;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
-->
</style></head>

<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="96%" height="27" align="left" valign="middle" class="titulopaguina">INTERESES PROYECTADOS</span> DETALLE</td>
    <td width="4%" rowspan="2" align="right" valign="middle"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="left" />
      </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="titulopaguina"><span class="Estilo4">NEGOCIO INTERNACIONAL</span></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="4" align="left" bgcolor="#999999" class="titulo_menu"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0" />Detalle Intereses por Operación</td>
  </tr>
  <tr>
    <td width="16%" align="right">Rut Cliente:</td>
    <td width="48%" class="nroregistro"><?php echo $row_DetailRS1['rut_cliente']; ?></td>
    <td width="9%" align="right">Oficina:</td>
    <td width="27%" class="respuestacolumna_azul"><?php echo $row_DetailRS1['oficina']; ?></td>
  </tr>
  <tr>
    <td align="right">Nombre Cliente:</td>
    <td colspan="3" align="left" class="respuestacolumna_azul"><?php echo $row_DetailRS1['nombre_cliente']; ?></td>
  </tr>
  <tr>
    <td align="right">Nro Operacion:</td>
    <td class="respuestacolumna_azul"><?php echo $row_DetailRS1['nro_operacion']; ?></td>
    <td align="right">Secuencia:</td>
    <td class="respuestacolumna_azul"><?php echo $row_DetailRS1['secuencia']; ?></td>
  </tr>
  <tr>
    <td align="right">Moneda / Saldo Insoluto:</td>
    <td><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['moneda']; ?></span> / <span class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['capital_original'], 2, ',', '.'); ?></span></td>
    <td align="right">Saldo Cuota:</td>
    <td align="center" class="respuestacolumna_azul"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['moneda']; ?></span> /<?php echo number_format($row_DetailRS1['saldo_vigente'], 2, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="right">Tasa Final Cliente:</td>
    <td class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['tasa_final_cliente'], 6, ',', '.'); ?></td>
    <td align="right">Base Calculo:</td>
    <td class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['dife'], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="right">Fecha Desde:</td>
    <td class="respuestacolumna_azul"><?php echo $row_DetailRS1['fecha_desde']; ?></td>
    <td align="right">Fecha Hasta:</td>
    <td class="respuestacolumna_azul"><?php echo $row_DetailRS1['fecha_hasta']; ?></td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Saldo Insoluto</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Desde</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Hasta</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tasa</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Dias</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Valor Intereses</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Valor Cuota</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Total K + I</td>
  </tr>
  <tr>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['moneda']; ?></span> / <span class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['capital_original'], 2, ',', '.'); ?></span></td>
    <td align="center" class="respuestacolumna_azul"><?php echo $row_DetailRS1['fecha_desde']; ?></td>
    <td align="center" class="respuestacolumna_azul"><?php echo $row_DetailRS1['fecha_hasta']; ?></td>
    <td align="center" class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['tasa_final_cliente'], 6, ',', '.'); ?></td>
    <td align="center" class="respuestacolumna_azul"><?php echo $row_DetailRS1['dias']; ?></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['moneda']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format((($row_DetailRS1['capital_original'] * $row_DetailRS1['tasa_final_cliente'] *($row_DetailRS1['dias'])) / $row_DetailRS1['dife']), 2, ',', '.'); ?></span></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['moneda']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_DetailRS1['saldo_vigente'], 2, ',', '.'); ?></span></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['moneda']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format(((($row_DetailRS1['capital_original'] * $row_DetailRS1['tasa_final_cliente'] *($row_DetailRS1['dias'])) / $row_DetailRS1['dife']) + $row_DetailRS1['saldo_vigente']), 2, ',', '.'); ?></span></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../../ac_bei/ac_bei.php">Asistente Comercial BEI</a> <a href="../../bmg/bmg.php"> / Volver a BMG</a> / <a href="../../ni/ni.php">Volver a NI</a> / <a href="../../territorial/tr.php">Volver a Territoriales</a> / <a href="../../redsuc/redsuc.php"> Volver a Red de Sucursales</a> / <a href="interesesmae.php">Volver Atras</a></td>
  </tr>
</table>
<br />
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>