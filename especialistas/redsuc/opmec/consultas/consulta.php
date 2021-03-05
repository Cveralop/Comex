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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_conrut = 10;
$pageNum_conrut = 0;
if (isset($_GET['pageNum_conrut'])) {
  $pageNum_conrut = $_GET['pageNum_conrut'];
}
$startRow_conrut = $pageNum_conrut * $maxRows_conrut;

$colname_conrut = "1";
if (isset($_GET['rut_cliente'])) {
  $colname_conrut = $_GET['rut_cliente'];
}
$colname1_conrut = "zzz";
if (isset($_GET['evento'])) {
  $colname1_conrut = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_conrut = sprintf("SELECT * FROM opmec nolock WHERE rut_cliente LIKE '%s%%' and evento LIKE '%%%s%%' ORDER BY id DESC", $colname_conrut,$colname1_conrut);
$query_limit_conrut = sprintf("%s LIMIT %d, %d", $query_conrut, $startRow_conrut, $maxRows_conrut);
$conrut = mysqli_query($comercioexterior, $query_limit_conrut) or die(mysqli_error($comercioexterior));
$row_conrut = mysqli_fetch_assoc($conrut);
$totalRows_conrut = mysqli_num_rows($conrut);

if (isset($_GET['totalRows_conrut'])) {
  $totalRows_conrut = $_GET['totalRows_conrut'];
} else {
  $all_conrut = mysqli_query($comercioexterior, $query_conrut);
  $totalRows_conrut = mysqli_num_rows($all_conrut);
}
$totalPages_conrut = ceil($totalRows_conrut/$maxRows_conrut)-1;


$queryString_conrut = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_conrut") == false && 
        stristr($param, "totalRows_conrut") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_conrut = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_conrut = sprintf("&totalRows_conrut=%d%s", $totalRows_conrut, $queryString_conrut);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones MECO - Maestro</title>
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
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">CONSULTAS - MAESTRO</td>
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
      <td colspan="2" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Consulta por Rut Cliente</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Rut Cliente:</div></td>
      <td width="79%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15"> 
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
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
      </select>
      </td>
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
    <td align="right" valign="middle"><a href="../../redsuc.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_conrut > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="10" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Total de <span class="Estilo11"><?php echo $totalRows_conrut ?> <span class="Estilo12">Operaciones</span></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Ver Operaci&oacute;n </div></td>
    <td align="center" class="titulocolumnas">Rut Cliente</td>
    <td align="center" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Estado</td>
    <td align="center" class="titulocolumnas">Fecha Curse</td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Valuta</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Apertura 
      </div>
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
    <td align="center"><?php echo $row_conrut['fecha_curse']; ?></div>      </div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo (isset($row_conrut['valuta']) ? $row_conrut['valuta']:""); ?></div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_conrut['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
  </tr>
  <?php } while ($row_conrut = mysqli_fetch_assoc($conrut)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_conrut > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_conrut=%d%s", $currentPage, 0, $queryString_conrut); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_conrut > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_conrut=%d%s", $currentPage, max(0, $pageNum_conrut - 1), $queryString_conrut); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_conrut < $totalPages_conrut) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_conrut=%d%s", $currentPage, min($totalPages_conrut, $pageNum_conrut + 1), $queryString_conrut); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_conrut < $totalPages_conrut) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_conrut=%d%s", $currentPage, $totalPages_conrut, $queryString_conrut); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Registros del <strong><?php echo ($startRow_conrut + 1) ?></strong> al <strong><?php echo min($startRow_conrut + $maxRows_conrut, $totalRows_conrut) ?></strong> de un total de <strong><?php echo $totalRows_conrut ?></strong>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($conrut);
?>