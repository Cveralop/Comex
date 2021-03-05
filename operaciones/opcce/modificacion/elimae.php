<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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
$MM_restrictGoTo = "../erroracceso.php";
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
$maxRows_eliminar = 10;
$pageNum_eliminar = 0;
if (isset($_GET['pageNum_eliminar'])) {
  $pageNum_eliminar = $_GET['pageNum_eliminar'];
}
$startRow_eliminar = $pageNum_eliminar * $maxRows_eliminar;
$colname1_eliminar = "1";
if (isset($_GET['evento'])) {
  $colname1_eliminar = $_GET['evento'];
}
$colname_eliminar = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname_eliminar = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_eliminar = sprintf("SELECT * FROM opcce WHERE nro_operacion = %s and evento = %s ORDER BY id DESC", GetSQLValueString($colname_eliminar, "text"),GetSQLValueString($colname1_eliminar, "text"));
$query_limit_eliminar = sprintf("%s LIMIT %d, %d", $query_eliminar, $startRow_eliminar, $maxRows_eliminar);
$eliminar = mysqli_query($comercioexterior, $query_limit_eliminar) or die(mysqli_error());
$row_eliminar = mysqli_fetch_assoc($eliminar);
if (isset($_GET['totalRows_eliminar'])) {
  $totalRows_eliminar = $_GET['totalRows_eliminar'];
} else {
  $all_eliminar = mysqli_query($comercioexterior, $query_eliminar);
  $totalRows_eliminar = mysqli_num_rows($all_eliminar);
}
$totalPages_eliminar = ceil($totalRows_eliminar/$maxRows_eliminar)-1;
$queryString_eliminar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_eliminar") == false && 
        stristr($param, "totalRows_eliminar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_eliminar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_eliminar = sprintf("&totalRows_eliminar=%d%s", $totalRows_eliminar, $queryString_eliminar);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Eliminar Enmienda Exportaciones - Maestro</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo9 {color: #00FF00}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3"> ELIMINAR ENMIENDA  EXPORTACIONES - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTA DE CR&Eacute;DITO DE EXPORTACI&Oacute;N </td>
  </tr>
</table>
<br>
<form action="" method="get" name="form1">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Eliminaci&oacute;n Enmienda Exportaciones</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle"><p align="right">Nro Operaci&oacute;n:</p>
      </td>
      <td width="79%" align="left" valign="middle">        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">E000000</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="left" valign="middle"><select name="evento" class="etiqueta12" id="evento">
        <option value="Modificacion." selected>Modificacion</option>
        <option value="Anulacion.">Anulacion</option>
        <option value="Anulacion Saldo.">Anulacion Saldo</option>
        <option value="MSG-Swift.">MSG-Swift</option>
        <option value="Transferencia.">Transferencia</option>
        <option value="Traspaso.">Traspaso</option>
        <option value="Carta Original.">Carta Original</option>
        <option value="Requerimiento.">Requerimiento</option>
        <option value="Solucion Excepcion.">Solucion Excepcion</option>
        <option value="Dev Comisiones.">Dev Comisiones</option>
        <option value="No Confirmacion.">No Confirmacion</option>
        <option value="Cobro Comision.">Cobro Comision</option>
      </select></td>
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
<?php if ($totalRows_eliminar > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="5" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Numero Operaci&oacute;n <span class="Estilo9"><?php echo strtoupper($row_eliminar['nro_operacion']); ?></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Eliminar</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="elidet.php?recordID=<?php echo $row_eliminar['id']; ?>"> <img src="../../../imagenes/ICONOS/papelero.jpg" width="20" height="21" border="0"> </a></div></td>
    <td align="center" valign="middle"><?php echo $row_eliminar['fecha_ingreso']; ?> </div></td>
    <td align="center" valign="middle"><?php echo $row_eliminar['rut_cliente']; ?> </div></td>
    <td align="left" valign="middle"><?php echo $row_eliminar['nombre_cliente']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_eliminar['estado']; ?> </div></td>
  </tr>
  <?php } while ($row_eliminar = mysqli_fetch_assoc($eliminar)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_eliminar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_eliminar=%d%s", $currentPage, 0, $queryString_eliminar); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_eliminar > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_eliminar=%d%s", $currentPage, max(0, $pageNum_eliminar - 1), $queryString_eliminar); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_eliminar < $totalPages_eliminar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_eliminar=%d%s", $currentPage, min($totalPages_eliminar, $pageNum_eliminar + 1), $queryString_eliminar); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_eliminar < $totalPages_eliminar) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_eliminar=%d%s", $currentPage, $totalPages_eliminar, $queryString_eliminar); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_eliminar + 1) ?></strong> al <strong><?php echo min($startRow_eliminar + $maxRows_eliminar, $totalRows_eliminar) ?></strong> de un total de <strong><?php echo $totalRows_eliminar ?></strong>
<?php } // Show if recordset not empty ?><br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../carcreexp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($eliminar);
?>