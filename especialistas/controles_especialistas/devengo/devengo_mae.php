﻿<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,BMG,TER,ADM,ACB";
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

$MM_restrictGoTo = "../../bmg/erroracceso.php";
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

$colname_devengo_resumen = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_devengo_resumen = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_devengo_resumen = sprintf("SELECT *, count(distinct(secuencia))as cuotas, sum(importe_com)as total_interes FROM devengo WHERE nro_operacion LIKE %s group by nro_operacion", GetSQLValueString("%" . $colname_devengo_resumen . "%", "text"));
$devengo_resumen = mysqli_query($comercioexterior, $query_devengo_resumen) or die(mysqli_error($comercioexterior));
$row_devengo_resumen = mysqli_fetch_assoc($devengo_resumen);
$totalRows_devengo_resumen = mysqli_num_rows($devengo_resumen);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">

.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
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

</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
/*<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->*/
</script>
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
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}

</style></head>

<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">DEVENGO - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">DEVENGO POR NRO OPERACION</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="titulo_menu">Devengo por Nro Operación</span></td>
    </tr>
    <tr>
      <td width="19%" align="right" bgcolor="#CCCCCC">Nro Operación:</td>
      <td width="81%" align="left" bgcolor="#CCCCCC"><label>
        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="12" maxlength="7" />
        <span class="rojopequeno">F000000 o L000000</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../../bmg/bmg.php">Volver a BMG</a> / <a href="../../ni/ni.php">Volver a NI</a> /<a href="../../territorial/tr.php"> Volver a Territoriales</a> / <a href="../../redsuc/redsuc.php">Vover a Red de Sucursales</a></td>
  </tr>
</table>
<?php if ($totalRows_devengo_resumen > 0) { // Show if recordset not empty ?>
  <br />
  <table width="95%" border="0" align="center">
    <tr>
      <td class="titulo_menu"><span class="nroregistro">RESUMEN INTERESES</span></td>
    </tr>
  </table>
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="10" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulocolumnas"><span class="subtitulopaguina">Nombre Cliente</span></span> <span class="tituloverde"><?php echo $row_devengo_resumen['nombre_cliente']; ?></span>&nbsp; <span class="subtitulopaguina">Rut Cliente</span> <span class="tituloverde"><?php echo $row_devengo_resumen['rut_cliente']; ?></span> <span class="subtitulopaguina">Nro de Cuotas Faltantes</span> <span class="tituloverde"><?php echo $row_devengo_resumen['cuotas']; ?></span></td>
    </tr>
    <tr>
      <td bgcolor="#999999" class="titulocolumnas">Nro Operación</td>
      <td bgcolor="#999999" class="titulocolumnas">Moneda</td>
      <td bgcolor="#999999" class="titulocolumnas">Capital Original</td>
      <td bgcolor="#999999" class="titulocolumnas">Saldo Vigente</td>
      <td bgcolor="#999999" class="titulocolumnas">Fecha Vcto</td>
      <td bgcolor="#999999" class="titulocolumnas">Tasa Interes</td>
      <td bgcolor="#999999" class="titulocolumnas">Fecha Desde</td>
      <td bgcolor="#999999" class="titulocolumnas">Intereses al</td>
      <td bgcolor="#999999" class="titulocolumnas">Total Interes</td>
      <td bgcolor="#999999" class="titulocolumnas">Total</td>
    </tr>
    <?php do { ?>
      <tr>
        <td class="respuestacolumna_azul"> <?php echo $row_devengo_resumen['nro_operacion']; ?></td>
        <td class="rojopequeno"><?php echo $row_devengo_resumen['moneda']; ?></td>
        <td align="right"><?php echo number_format($row_devengo_resumen['capital_original'], 2, ',', '.'); ?></td>
        <td align="right"><?php echo number_format($row_devengo_resumen['saldo_vigente'], 2, ',', '.'); ?></td>
        <td><?php echo $row_devengo_resumen['fecha_vcto']; ?></td>
        <td><?php echo number_format($row_devengo_resumen['tasa_final_cliente'], 6, ',', '.'); ?></td>
        <td><?php echo $row_devengo_resumen['fecha_desde']; ?></td>
        <td><?php echo $row_devengo_resumen['intereses_al']; ?></td>
        <td align="right"><?php echo number_format($row_devengo_resumen['total_interes'], 2, ',', '.'); ?></td>
        <td align="right" class="respuestacolumna_rojo"><?php echo number_format(($row_devengo_resumen['saldo_vigente'] + $row_devengo_resumen['total_interes']), 2, ',', '.'); ?></td>
      </tr>
      <?php } while ($row_devengo_resumen = mysqli_fetch_assoc($devengo_resumen)); ?>
  </table>
  <br />
  <hr />
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($devengo_resumen);
?>