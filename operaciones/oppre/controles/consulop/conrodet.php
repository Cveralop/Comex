<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones por Numero - Detalle</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #FF0000;
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
.Estilo5 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo6 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo7 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONSULTA OPERACIONES POR NUMERO - DETALLE </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="4" align="left"><p><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Operaciones por Numero</span></p>
    </td>
  </tr>
  <tr valign="middle">
    <td align="right">Nro Registro:</div></td>
    <td><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>      </div></td>
    <td align="right">Rut Cliente:</td>
    <td><?php echo $row_DetailRS1['rut_cliente']; ?><span class="rojopequeno"> Sin puntos ni Guion</span></div></td>
  </tr>
  <tr valign="middle">
    <td align="right">Nombre Cliente:</td>
    <td colspan="3" align="left"><?php echo $row_DetailRS1['nombre_cliente']; ?> </td>
  </tr>
  <tr valign="middle">
    <td align="right">Fecha Ingreso:</div></td>
    <td><?php echo $row_DetailRS1['fecha_ingreso']; ?> <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
    <td align="right">Fecha Curse:</div></td>
    <td><?php echo $row_DetailRS1['fecha_curse']; ?><span class="rojopequeno"> (dd-mm-aaaa)</span></div></td>
  </tr>
  <tr valign="middle">
    <td align="right">Evento:</div></td>
    <td><?php echo $row_DetailRS1['evento']; ?> </div></td>
    <td align="right">Estado:</div></td>
    <td><?php echo $row_DetailRS1['estado']; ?></div></td>
  </tr>
  <tr valign="middle">
    <td align="right">Asignador:</div></td>
    <td><?php echo $row_DetailRS1['asignador']; ?> </div></td>
    <td align="right">Operador:</div></td>
    <td><?php echo $row_DetailRS1['operador']; ?></div></td>
  </tr>
  <tr valign="middle">
    <td align="right">Nro Operaci&oacute;n / Relacionada:</div></td>
    <td><?php echo $row_DetailRS1['nro_operacion']; ?> <span class="rojopequeno">F &oacute; K 000000 / </span> </div><?php echo $row_DetailRS1['nro_operacion_relacionada']; ?> <span class="respuestacolumna_rojo">L000000</span></td>
    <td align="right">Especialista:</div></td>
    <td><?php echo $row_DetailRS1['especialista_curse']; ?></div></td>
  </tr>
  <tr valign="middle">
    <td align="right">Observaciones:</div></td>
    <td colspan="3" align="left"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></td>
  </tr>
  <tr valign="middle">
    <td align="right">Moneda / Monto Operaci&oacute;n:</div></td>
    <td><span class="Estilo6"><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></span> <strong><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
    <td align="right">Nro Cuotas:</td>
    <td><?php echo $row_DetailRS1['nro_cuotas']; ?></div></td>
  </tr>
  <tr valign="middle">
    <td align="right">Fecha Pre-Ingreso:</td>
    <td><?php echo $row_DetailRS1['date_preingreso']; ?></td>
    <td align="right">Fecha Ingreso Especialista:</td>
    <td><?php echo $row_DetailRS1['date_espe']; ?></td>
  </tr>
  <tr valign="middle">
    <td align="right">Fecha Visaci&oacute;n:</td>
    <td><?php echo $row_DetailRS1['date_visa']; ?></td>
    <td align="right">Fecha Asignaci&oacute;n:</td>
    <td><?php echo $row_DetailRS1['date_asig']; ?></td>
  </tr>
  <tr valign="middle">
    <td align="right">Fecha Alta Operador:</td>
    <td><?php echo $row_DetailRS1['date_oper']; ?></td>
    <td align="right">Fecha Alta Supervisor:</td>
    <td><?php echo $row_DetailRS1['date_supe']; ?></td>
  </tr>
  <tr valign="middle">
    <td align="right">Reparo:</td>
    <td colspan="3" align="left"><?php echo $row_DetailRS1['reparo_obs']; ?></td>
  </tr>
</table>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="conromae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>