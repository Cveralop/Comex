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

$colname_opporcliente = "zzz";
if (isset($_GET['rut_cliente'])) {
  $colname_opporcliente = $_GET['rut_cliente'];
}
$colname1_opporcliente = "1";
if (isset($_GET['fecha_curse'])) {
  $colname1_opporcliente = $_GET['fecha_curse'];
}
$colname2_opporcliente = "1";
if (isset($_GET['evento'])) {
  $colname2_opporcliente = $_GET['evento'];
}
$colname3_opporcliente = "1";
if (isset($_GET['estado'])) {
  $colname3_opporcliente = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opporcliente = sprintf("SELECT * FROM oppre nolock WHERE rut_cliente = %s and fecha_curse LIKE %s and evento LIKE %s and estado LIKE %s ORDER BY id ASC", GetSQLValueString($colname_opporcliente, "text"),GetSQLValueString("%" . $colname1_opporcliente . "%", "text"),GetSQLValueString("%" . $colname2_opporcliente . "%", "text"),GetSQLValueString("%" . $colname3_opporcliente . "%", "text"));
$opporcliente = mysqli_query($comercioexterior,$query_opporcliente) or die(mysqli_error());
$row_opporcliente = mysqli_fetch_assoc($opporcliente);
$totalRows_opporcliente = mysqli_num_rows($opporcliente);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Operaciones por Cliente</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {
	color: #0000FF;
	font-weight: bold;
}
.Estilo12 {color: #00FF00}

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
    <td width="93%" align="left" valign="middle" class="Estilo3">OPERACIONES POR CLIENTE </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Operaciones por Cliente</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Rut Cliente:</div></td>
      <td width="79%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Fecha Curse:</div></td>
      <td align="left"><input name="fecha_curse" type="text" class="etiqueta12" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa) - (mm-aaaa) - (aaaa) </span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Evento:</div></td>
      <td align="left"><select name="evento" class="etiqueta12" id="evento">
        <option value="Apertura." selected>Apertura</option>
        <option value="Prorroga.">Prorroga</option>
        <option value="Cambio Tasa.">Cambio Tasa</option>
        <option value="Pago.">Pago</option>
        <option value="Visacion.">Visaci&oacute;n</option>
        <option value="Carta Original.">Carta Original</option>
        <option value="Requerimiento.">Requerimiento</option>
        <option value="Solucion Excecpion.">Solucion Excepcion</option>
        <option value="Dev Comisiones.">Dev Comisiones</option>
        <option value=".">Todas</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right">Estado:</div></td>
      <td align="left"><select name="estado" class="etiqueta12" id="estado">
        <option value="Cursada." selected>Cursada</option>
        <option value="Pendiente.">Pendiente</option>
        <option value="Reparada.">Reparada</option>
        <option value=".">Todas</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
          <input name="Submit" type="submit" class="boton" value="Buscar">
          <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_opporcliente > 0) { // Show if recordset not empty ?>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="12" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Total de&nbsp;&nbsp;<span class="Estilo12"><?php echo $totalRows_opporcliente ?></span> Operaciones </span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Numero Operaci&oacute;n </div></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Fecha Curse
      </div>
    </td>
    <td align="center" class="titulocolumnas">Rut 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre
      </div>
    </td>
    <td align="center" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Especialista 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Documentos
      </div>
    </td>
    <td align="center" class="titulocolumnas">Pais 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Banco Destino
      </div>
    </td>
    <td align="center" class="titulocolumnas">Forward
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><strong class="respuestacolumna_rojo"><?php echo strtoupper($row_opporcliente['nro_operacion']); ?></strong></div></td>
    <td align="center"><?php echo $row_opporcliente['fecha_ingreso']; ?></div></td>
    <td align="center"><?php echo $row_opporcliente['fecha_curse']; ?></div></td>
    <td align="center"><?php echo $row_opporcliente['rut_cliente']; ?></div></td>
    <td align="left"><?php echo $row_opporcliente['nombre_cliente']; ?></td>
    <td align="center"><?php echo $row_opporcliente['evento']; ?></div></td>
    <td align="center"><?php echo $row_opporcliente['especialista']; ?></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opporcliente['moneda_operacion']); ?></span><span class="Estilo8"> <span class="respuestacolumna_azul"><?php echo number_format($row_opporcliente['monto_operacion'], 2, ',', '.'); ?></span></span>      </div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opporcliente['moneda_documentos']);  ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_opporcliente['monto_documentos'], 2, ',', '.');  ?></strong></div></td>
    <td align="center"><?php echo $row_opporcliente['pais']; ?></div></td>
    <td align="left"><?php echo $row_opporcliente['banco_destino']; ?></td>
    <td align="center"><?php echo $row_opporcliente['forward']; ?></div></td>
  </tr>
    <?php } while ($row_opporcliente = mysqli_fetch_assoc($opporcliente)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($opporcliente);
?>