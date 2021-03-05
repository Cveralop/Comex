<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,RED";
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
if (isset($_GET['evento'])) {
  $colname1_conrut = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_conrut = sprintf("SELECT * FROM opbga nolock WHERE rut_cliente LIKE %s and evento LIKE %s ORDER BY id DESC", GetSQLValueString($colname_conrut . "%", "text"),GetSQLValueString("%" . $colname1_conrut . "%", "text"));
$conrut = mysqli_query($comercioexterior, $query_conrut) or die(mysqli_error());
$row_conrut = mysqli_fetch_assoc($conrut);
$totalRows_conrut = mysqli_num_rows($conrut);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones CAMBIO - Maestro</title>
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONSULTAS - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIO - BOLETA DE GARANT&Iacute;A</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Consulta por Rut Cliente</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Rut Cliente:</div></td>
      <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15"> 
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="left" valign="middle"><select name="evento" class="etiqueta12" id="evento">
        <option value="Apertura." selected>Apertura</option>
        <option value="Modificacion.">Modificacion</option>
        <option value="Anulacion.">Anulacion</option>
        <option value="Ejecucion.">Ejecucion</option>
        <option value="Requerimiento.">Requerimiento</option>
        <option value="Solucion Excepcion.">Solucion Excecpion</option>
        <option value="Dev Comisiones.">Dev Comisiones</option>
        <option value="Carta Original.">Carta Original</option>
        <option value=".">Todos</option>
      </select>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../redsuc.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_conrut > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="10" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Total de <span class="Estilo11"><?php echo $totalRows_conrut ?> <span class="Estilo12">Operaciones</span></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Ver Operaci&oacute;n</span></div></td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Evento </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Estado </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse </div>   
    </td>

    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Valuta</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Apertura </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="consultadet.php?recordID=<?php echo $row_conrut['id']; ?>"> <img src="../../../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0"></a></div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_conrut['rut_cliente']); ?></div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_conrut['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><?php echo $row_conrut['fecha_ingreso']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_conrut['evento']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_conrut['estado']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_conrut['fecha_curse']; ?></div>      </div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo (isset($row_conrut['valuta'])?$row_conrut['valuta']:""); ?></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_conrut['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
  </tr>
  <?php } while ($row_conrut = mysqli_fetch_assoc($conrut)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($conrut);
?>