<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,ESP";
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

$colname_conrut = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_conrut = $_GET['rut_cliente'];
}
$colname1_conrut = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname1_conrut = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_conrut = sprintf("SELECT * FROM opcci nolock WHERE rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString("%" . $colname_conrut . "%", "text"),GetSQLValueString("%" . $colname1_conrut . "%", "text"));
$conrut = mysqli_query($comercioexterior, $query_conrut) or die(mysqli_error());
$row_conrut = mysqli_fetch_assoc($conrut);
$totalRows_conrut = mysqli_num_rows($conrut);$colname_conrut = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_conrut = $_GET['rut_cliente'];
}
$colname1_conrut = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname1_conrut = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_conrut = sprintf("SELECT * FROM opcci nolock WHERE rut_cliente LIKE %s and nro_operacion LIKE %s ORDER BY id DESC", GetSQLValueString("%" . $colname_conrut . "%", "text"),GetSQLValueString("%" . $colname1_conrut . "%", "text"));
$conrut = mysqli_query($comercioexterior, $query_conrut) or die(mysqli_error());
$row_conrut = mysqli_fetch_assoc($conrut);
$totalRows_conrut = mysqli_num_rows($conrut);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones CCI - Maestro</title>
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
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<style type="text/css">
<!--
.Estilo11 {color: #00FF00}
.Estilo12 {color: #FFFFFF}
-->
</style>
</head>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">CONSULTAS - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Consulta por Rut o Operaci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Rut Cliente:</div></td>
      <td width="79%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15"> 
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</div></td>
      <td align="left"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">K000000</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opcci.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_conrut > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="12" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Total de <span class="Estilo11"><?php echo $totalRows_conrut ?>  <span class="Estilo12">Operaciones</span></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center"><span class="titulocolumnas">Ver Operaci&oacute;n </span>      </div></td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Fecha Ingreso
      </div>
    </td>
    <td align="center" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Estado
      </div>
    </td>
    <td align="center" class="titulocolumnas">Fecha Curse 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Nro Operacion Relacionada</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Apertura 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Noneda / Monto Negociaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Tipo Negociaci&oacute;n </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="consultadet.php?recordID=<?php echo $row_conrut['id']; ?>"> <img src="../../../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0"></a></div></td>
    <td align="center"><?php echo strtoupper($row_conrut['rut_cliente']); ?></div></td>
    <td align="left"><?php echo strtoupper($row_conrut['nombre_cliente']); ?></td>
    <td align="center"><?php echo $row_conrut['fecha_ingreso']; ?></div></td>
    <td align="center"><?php echo $row_conrut['evento']; ?></div></td>
    <td align="center"><?php echo $row_conrut['estado']; ?></div></td>
    <td align="center"><?php echo $row_conrut['fecha_curse']; ?></div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['nro_operacion']); ?></span>      </div></td>
    <td align="center" class="respuestacolumna_azul"><?php echo strtoupper($row_conrut['nro_operacion_relacionada']); ?></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_conrut['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['moneda_documentos']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_conrut['monto_documentos'], 2, ',', '.'); ?></strong></td>
    <td align="center"><?php echo $row_conrut['tipo_negociacion']; ?></div></td>
  </tr>
  <?php } while ($row_conrut = mysqli_fetch_assoc($conrut)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($conrut);
?>