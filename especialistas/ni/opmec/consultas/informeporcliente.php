<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,ADM";
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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_opporcliente = 20;
$pageNum_opporcliente = 0;
if (isset($_GET['pageNum_opporcliente'])) {
  $pageNum_opporcliente = $_GET['pageNum_opporcliente'];
}
$startRow_opporcliente = $pageNum_opporcliente * $maxRows_opporcliente;

$colname_opporcliente = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_opporcliente = $_GET['rut_cliente'];
}
$colname1_opporcliente = "-1";
if (isset($_GET['date_ini'])) {
  $colname1_opporcliente = $_GET['date_ini'];
}
$colname2_opporcliente = "-1";
if (isset($_GET['date_fin'])) {
  $colname2_opporcliente = $_GET['date_fin'];
}
$colname3_opporcliente = "-1";
if (isset($_GET['evento'])) {
  $colname3_opporcliente = $_GET['evento'];
}
$colname4_opporcliente = "-1";
if (isset($_GET['estado'])) {
  $colname4_opporcliente = $_GET['estado'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opporcliente = sprintf("SELECT * FROM opmec nolock WHERE rut_cliente = %s and date_ingreso between %s and %s and evento LIKE %s and estado LIKE %s ORDER BY id ASC", GetSQLValueString($colname_opporcliente, "text"),GetSQLValueString($colname1_opporcliente, "date"),GetSQLValueString($colname2_opporcliente, "date"),GetSQLValueString("%" . $colname3_opporcliente . "%", "text"),GetSQLValueString("%" . $colname4_opporcliente . "%", "text"));
$query_limit_opporcliente = sprintf("%s LIMIT %d, %d", $query_opporcliente, $startRow_opporcliente, $maxRows_opporcliente);
$opporcliente = mysqli_query($comercioexterior, $query_limit_opporcliente) or die(mysqli_error($comercioexterior));
$row_opporcliente = mysqli_fetch_assoc($opporcliente);
$totalRows_opporcliente = mysqli_num_rows($opporcliente);

if (isset($_GET['totalRows_opporcliente'])) {
  $totalRows_opporcliente = $_GET['totalRows_opporcliente'];
} else {
  $all_opporcliente = mysqli_query($comercioexterior, $query_opporcliente);
  $totalRows_opporcliente = mysqli_num_rows($all_opporcliente);
}
$totalPages_opporcliente = ceil($totalRows_opporcliente/$maxRows_opporcliente)-1;
$queryString_opporcliente = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_opporcliente") == false && 
        stristr($param, "totalRows_opporcliente") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_opporcliente = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_opporcliente = sprintf("&totalRows_opporcliente=%d%s", $totalRows_opporcliente, $queryString_opporcliente);

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
</head>
<body onLoad="MM_preloadImages('../../../../espcomex/imagenes/Botones/boton_volver_2.jpg','../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">OPERACIONES POR CLIENTE </td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">MERCADO DE CORREDORES</td>
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
      <td align="right">Fecha Ingreso:</div></td>
      <td align="left"><span class="respuestacolumna_rojo">Fecha Desde</span>
        <input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
        <span class="respuestacolumna_rojo">Fecha Hasta</span>
        <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">      
      <span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Evento:</div></td>
      <td align="left"><select name="evento" class="etiqueta12" id="evento">
        <option value="Enviar OP." selected>Enviar OP</option>
        <option value="Ventas.">Ventas</option>
        <option value="Compras.">Compras</option>
        <option value="Arbitraje.">Arbitraje</option>
        <option value="Emision Cheque.">Emision Cheque</option>
        <option value="Emision Planilla.">Emision Planilla</option>
        <option value="Soli Abono M/X.">Soli Abono M/X</option>
        <option value="Liq OP Recibidas.">Liq OP Recibidas</option>
        <option value="Requerimiento.">Requerimiento</option>
        <option value="Solucion Excepcion.">Solucion Excepcion</option>
        <option value="Dev Comisiones.">Dev Comisiones</option>
        <option value="Carta Original.">Carta Original</option>
        <option value=".">Todos</option>
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
    <td align="right" valign="middle"><a href="../opmec.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_opporcliente > 0) { // Show if recordset not empty ?>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="8" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Total de&nbsp;&nbsp;<span class="Estilo12"><?php echo $totalRows_opporcliente ?></span> Operaciones </span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Numero Operaci&oacute;n </div></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Fecha Curse</td>
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
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opporcliente['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo $row_opporcliente['fecha_ingreso']; ?></div></td>
    <td align="center"><?php echo $row_opporcliente['fecha_curse']; ?></div></td>
    <td align="center"><?php echo strtoupper($row_opporcliente['rut_cliente']); ?></div></td>
    <td align="left"><?php echo strtoupper($row_opporcliente['nombre_cliente']); ?></td>
    <td align="center"><?php echo $row_opporcliente['evento']; ?></div></td>
    <td align="center"><?php echo strtoupper($row_opporcliente['especialista_curse']); ?></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opporcliente['moneda_operacion']); ?></span><span class="Estilo8"> <span class="respuestacolumna_azul"><?php echo number_format($row_opporcliente['monto_operacion'], 2, ',', '.'); ?></span></span>      </div></td>
  </tr>
    <?php } while ($row_opporcliente = mysqli_fetch_assoc($opporcliente)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_opporcliente > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_opporcliente=%d%s", $currentPage, 0, $queryString_opporcliente); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_opporcliente > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_opporcliente=%d%s", $currentPage, max(0, $pageNum_opporcliente - 1), $queryString_opporcliente); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_opporcliente < $totalPages_opporcliente) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_opporcliente=%d%s", $currentPage, min($totalPages_opporcliente, $pageNum_opporcliente + 1), $queryString_opporcliente); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_opporcliente < $totalPages_opporcliente) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_opporcliente=%d%s", $currentPage, $totalPages_opporcliente, $queryString_opporcliente); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Registros del <strong><?php echo ($startRow_opporcliente + 1) ?></strong> al <strong><?php echo min($startRow_opporcliente + $maxRows_opporcliente, $totalRows_opporcliente) ?></strong> de un total de <strong><?php echo $totalRows_opporcliente ?></strong>
<?php } // Show if recordset not empty ?>
<br>
</body>
</html>
<?php
mysqli_free_result($opporcliente);
?>