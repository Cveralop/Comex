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

$colname_impresion = "-1";
if (isset($_GET['especialista_curse'])) {
  $colname_impresion = $_GET['especialista_curse'];
}
$colname1_impresion = "-1";
if (isset($_GET['date_ingreso'])) {
  $colname1_impresion = $_GET['date_ingreso'];
}
$colname3_impresion = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname3_impresion = $_GET['rut_cliente'];
}
$colname4_impresion = "-1";
if (isset($_GET['evento'])) {
  $colname4_impresion = $_GET['evento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_impresion = sprintf("SELECT * FROM opcbi nolock WHERE especialista_curse = %s and date_ingreso = %s and rut_cliente = %s and evento = %s ORDER BY id DESC", GetSQLValueString($colname_impresion, "text"),GetSQLValueString($colname1_impresion, "date"),GetSQLValueString($colname3_impresion, "text"),GetSQLValueString($colname4_impresion, "text"));
$impresion = mysqli_query($comercioexterior, $query_impresion) or die(mysqli_error($comercioexterior));
$row_impresion = mysqli_fetch_assoc($impresion);
$totalRows_impresion = mysqli_num_rows($impresion);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores nolock";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Impresi&oacute;n - Maestro</title>
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
.Estilo6 {color: #FFFFFF; font-weight: bold; }
.Estilo7 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo10 {font-size: 16px; font-weight: bold; color: #FFFFFF; }
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script> 
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">IMPRESI&Oacute;N - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COBRANZA DE IMPORTACI&Oacute;N y OPI </td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo7">Impresi&oacute;n Instrucci&oacute;n Cliente</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Especialista:</div></td>
      <td width="79%" align="left" valign="middle"><input name="especialista_curse" type="text" class="etiqueta12" id="especialista_curse" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20" readonly="readonly"></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="left" valign="middle"><input name="date_ingreso" type="text" class="etiqueta12" id="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10"></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="left" valign="middle">
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="15" maxlength="12">
        <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="left" valign="middle">
        <select name="evento" class="etiqueta12" id="evento">
          <option value="Apertura." selected>Apertura</option>
          <option value="Apertura y Pago.">Apertura y Pago</option>
          <option value="Modificacion.">Modificacion</option>
          <option value="Aceptacion.">Aceptacion</option>
          <option value="Carta Compromiso.">Carta Compromiso</option>
          <option value="Pago.">Pago</option>
          <option value="Visacion.">Visacion (DI)</option>
          <option value="Requerimiento.">Requerimiento</option>
          <option value="Solucion Excepcion.">Solucion Excepcion</option>
          <option value="Dev Comsiones">Dev Comisiones</option>
          <option value=".">Todos</option>
          </select>
      </div></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opcbi.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_impresion > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr align="center" valign="middle" bgcolor="#999999">
    <td colspan="9" align="center"><span class="Estilo10">COBRANZA DE IMPORTACI&Oacute;N y OPI</span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Nro Folio</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha&nbsp; Ingreso</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Urgente
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_impresion['id']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_impresion['date_espe']; ?> </div></td>
    <td align="center" valign="middle"><?php echo strtoupper($row_impresion['rut_cliente']); ?></div></td>
    <td align="left" valign="middle"><?php echo strtoupper($row_impresion['nombre_cliente']); ?></td>
    <td align="center" valign="middle"><?php echo $row_impresion['evento']; ?> </div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_impresion['nro_operacion']); ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_impresion['tipo_operacion']; ?></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_impresion['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_impresion['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
    <td colspan="2" align="center" valign="middle"><?php if ($row_impresion['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_impresion['urgente']; ?> </span>        
		<?php } // Show if not first page ?>
        <?php if ($row_impresion['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
    	<span class="Verde2"><?php echo $row_impresion['urgente']; ?> </span>
	    <?php } // Show if not first page ?></td>
</tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Observaciones:</td>
    <td colspan="4" align="left" valign="middle"><?php echo $row_impresion['obs']; ?></td>
    <td align="right" valign="middle" class="titulocolumnas">Mandato / Imp. Operar / Passport:</td>
    <td align="center" valign="middle"><?php echo $row_impresion['mandato']; ?> / <?php echo $row_impresion['impedido_operar']; ?> / <span class="respuestacolumna_rojo"><?php echo $row_impresion['cliente_passport']; ?></span></td>
    <td align="right" valign="middle" bgcolor="#999999" class="titulocolumnas">Sucursal:</td>
    <td align="center" valign="middle"><?php echo $row_impresion['sucursal']; ?></td>
    </tr>
  <?php } while ($row_impresion = mysqli_fetch_assoc($impresion)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_impresion > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_impresion=%d%s", $currentPage, 0, $queryString_impresion); ?>">Primero</a>
      <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_impresion > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_impresion=%d%s", $currentPage, max(0, $pageNum_impresion - 1), $queryString_impresion); ?>">Anterior</a>
      <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_impresion < $totalPages_impresion) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_impresion=%d%s", $currentPage, min($totalPages_impresion, $pageNum_impresion + 1), $queryString_impresion); ?>">Siguiente</a>
      <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_impresion < $totalPages_impresion) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_impresion=%d%s", $currentPage, $totalPages_impresion, $queryString_impresion); ?>">&Uacute;ltimo</a>
      <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_impresion + 1) ?></strong> al <strong><?php echo min($startRow_impresion + $maxRows_impresion, $totalRows_impresion) ?></strong> de un total de <strong><?php echo $totalRows_impresion ?></strong>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($impresion);
mysqli_free_result($colores);
?>