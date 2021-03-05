<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_modificacion = 10;
$pageNum_modificacion = 0;
if (isset($_GET['pageNum_modificacion'])) {
  $pageNum_modificacion = $_GET['pageNum_modificacion'];
}
$startRow_modificacion = $pageNum_modificacion * $maxRows_modificacion;

$colname_modificacion = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_modificacion = $_GET['rut_cliente'];
}
$colname1_modificacion = "Pendiente.";
if (isset($_GET['estado_visacion'])) {
  $colname1_modificacion = $_GET['estado_visacion'];
}
$colname2_modificacion = "Preingresada.";
if (isset($_GET['estado_visacion'])) {
  $colname2_modificacion = $_GET['estado_visacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_modificacion = sprintf("SELECT * FROM oppre nolock WHERE rut_cliente = %s and (estado_visacion = %s or estado_visacion = %s) ORDER BY id DESC", GetSQLValueString($colname_modificacion, "text"),GetSQLValueString($colname1_modificacion, "text"),GetSQLValueString($colname2_modificacion, "text"));
$query_limit_modificacion = sprintf("%s LIMIT %d, %d", $query_modificacion, $startRow_modificacion, $maxRows_modificacion);
$modificacion = mysqli_query($comercioexterior, $query_limit_modificacion) or die(mysqli_error($comercioexterior));
$row_modificacion = mysqli_fetch_assoc($modificacion);
$totalRows_modificacion = mysqli_num_rows($modificacion);

if (isset($_GET['totalRows_modificacion'])) {
  $totalRows_modificacion = $_GET['totalRows_modificacion'];
} else {
  $all_modificacion = mysqli_query($comercioexterior, $query_modificacion);
  $totalRows_modificacion = mysqli_num_rows($all_modificacion);
}
$totalPages_modificacion = ceil($totalRows_modificacion/$maxRows_modificacion)-1;
$queryString_modificacion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificacion") == false && 
        stristr($param, "totalRows_modificacion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificacion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificacion = sprintf("&totalRows_modificacion=%d%s", $totalRows_modificacion, $queryString_modificacion);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Modificaci&oacute;n Instrucciones - Maestro</title>
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
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">MODIFICAR  INSTRUCCIONES - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Modificar Instrucciones Cliente</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Rut Cliente:</div></td>
      <td align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="etiqueta12" value="Buscar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_modificacion > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Modificar
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nro Folio
      </div>
    </td>
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
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Especialista Curse 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="moddet.php?recordID=<?php echo $row_modificacion['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo $row_modificacion['id']; ?></span>      </div></td>
    <td align="center"><?php echo strtoupper($row_modificacion['rut_cliente']); ?> </div></td>
    <td align="left"><?php echo strtoupper($row_modificacion['nombre_cliente']); ?> </td>
    <td align="center"><?php echo $row_modificacion['fecha_ingreso']; ?></div></td>
    <td align="center"><?php echo $row_modificacion['evento']; ?> </div></td>
    <td align="center"><?php echo $row_modificacion['estado']; ?> </div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_modificacion['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo strtoupper($row_modificacion['especialista_curse']); ?> </div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_modificacion['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_modificacion['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
  </tr>
  <?php } while ($row_modificacion = mysqli_fetch_assoc($modificacion)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_modificacion > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_modificacion=%d%s", $currentPage, 0, $queryString_modificacion); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_modificacion > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_modificacion=%d%s", $currentPage, max(0, $pageNum_modificacion - 1), $queryString_modificacion); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_modificacion < $totalPages_modificacion) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_modificacion=%d%s", $currentPage, min($totalPages_modificacion, $pageNum_modificacion + 1), $queryString_modificacion); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_modificacion < $totalPages_modificacion) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_modificacion=%d%s", $currentPage, $totalPages_modificacion, $queryString_modificacion); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_modificacion + 1) ?></strong> al <strong><?php echo min($startRow_modificacion + $maxRows_modificacion, $totalRows_modificacion) ?></strong> de un total de <strong><?php echo $totalRows_modificacion ?></strong>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../oppre.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($modificacion);
?>