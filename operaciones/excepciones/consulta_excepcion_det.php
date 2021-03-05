<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,SUP";
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM excepciones nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Consulta Excepciones - Detalle</title>
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
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">CONSULTA EXCEPCIONES  - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">EXCEPCIONES</td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="4" align="left" bgcolor="#999999" class="titulo_menu"><span class="titulo_menu"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /></span>Detalle Excepción</td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nro Registro:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['id']; ?></td>
    <td align="right">Nro Registro:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['rut_cliente']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre Cliente:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nombre_cliente']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Ejecutivo de Cuenta:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['ejecutivo_cuenta']; ?></td>
    <td align="right">Ejecutivo NI:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['ejecutivo_ni']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Especialista NI:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['especialista_ni']; ?></td>
    <td align="right">Post Venta:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['especialista_curse']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre Oficina.</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['nombre_oficina']; ?></td>
    <td align="right">Subgerente:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['subgerente']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Segmento Comercial:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['segmento_comercial']; ?></td>
    <td align="right">Zonal:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['zonal']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Territorial:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['territorial']; ?></td>
    <td align="right">Fecha Ingreso:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_ingreso']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Evento:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['evento']; ?></td>
    <td align="right">Date ingreso:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['date_ingreso']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Producto:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['producto']; ?></td>
    <td align="right">Fecha Solucion:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_solucion']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nro Operación / Nro Operación Relacionada:</td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['nro_operacion']; ?></span> / <span class="respuestacolumna_azul"><?php echo $row_DetailRS1['nro_operacion_relacionada']; ?></span></td>
    <td align="right">Date Solución:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['date_solucion']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Observación:</td>
    <td colspan="3" align="left"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Moneda / Monto Operación:</td>
    <td colspan="3" align="left"><?php echo $row_DetailRS1['moneda_operacion']; ?><?php echo $row_DetailRS1['monto_operacion']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Excepción:</td>
    <td colspan="3" align="left"><?php echo $row_DetailRS1['excepcion']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Visador:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['visador']; ?></td>
    <td align="right" valign="middle">Autorizacion Operaciones:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['autorizacion_operaciones']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Autorización Especialista:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['autorizacion_especialista']; ?></td>
    <td align="right" valign="middle">Reponsable Excepción:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['responsable_excepcion']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Tipo Excepción:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['tipo_excepcion']; ?></td>
    <td align="right" valign="middle">Vcto Excepción:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['vcto_excepcion']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Estado Excepción:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['estado_excepcion']; ?></td>
    <td align="right" valign="middle">En Plazo / Fuera de Plazo:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['enplazo_fueraplazo']; ?></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="consulta_excepcion_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>