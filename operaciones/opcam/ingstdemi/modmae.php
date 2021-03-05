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
$maxRows_modificacion = 10;
$pageNum_modificacion = 0;
if (isset($_GET['pageNum_modificacion'])) {
  $pageNum_modificacion = $_GET['pageNum_modificacion'];
}
$startRow_modificacion = $pageNum_modificacion * $maxRows_modificacion;
$colname1_modificacion = "zzz";
if (isset($_GET['rut_cliente'])) {
  $colname1_modificacion = $_GET['rut_cliente'];
}
$colname2_modificacion = "Apertura.";
if (isset($_GET['evento'])) {
  $colname2_modificacion = $_GET['evento'];
}
$colname_modificacion = "1";
if (isset($_GET['nombre_cliente'])) {
  $colname_modificacion = $_GET['nombre_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_modificacion = sprintf("SELECT * FROM opste WHERE nombre_cliente LIKE %s and rut_cliente LIKE %s and evento = %s ORDER BY id DESC", GetSQLValueString($colname_modificacion . "%", "text"),GetSQLValueString($colname1_modificacion . "%", "text"),GetSQLValueString($colname2_modificacion, "text"));
$query_limit_modificacion = sprintf("%s LIMIT %d, %d", $query_modificacion, $startRow_modificacion, $maxRows_modificacion);
$modificacion = mysqli_query($comercioexterior, $query_limit_modificacion) or die(mysqli_error());
$row_modificacion = mysqli_fetch_assoc($modificacion);
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
<title>Modificaci&oacute;n Stand BY Emitida - Maestro</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
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
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">MODIFICACI&Oacute;N STAND BY EMITIDA - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">OPERACIONES DE CAMBIO</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Modificaci&oacute;n Stand BY Emitida</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right" valign="middle">Rut Cliente:</td>
      <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" id="nombre_cliente" size="80" maxlength="80"></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_modificacion > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle"><span class="titulocolumnas">Modificar</span>      </div></td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Banco
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Banco
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Estado
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Vcto</td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" valign="middle"><a href="moddet.php?recordID=<?php echo $row_modificacion['id']; ?>"> <img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center" valign="middle"><?php echo $row_modificacion['rut_cliente']; ?></td>
    <td align="left" valign="middle"><?php echo $row_modificacion['nombre_cliente']; ?> </td>
    <td align="center" valign="middle"><span class="Estilo8"><?php echo strtoupper($row_modificacion['nro_operacion']); ?></span> </td>
    <td align="center" valign="middle"><?php echo $row_modificacion['fecha_ingreso']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_modificacion['estado']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_modificacion['tipo_operacion']; ?></td>
    <td align="center" valign="middle"><?php echo $row_modificacion['vcto_operacion']; ?></td>
    <td align="right" valign="middle"><span class="Estilo8"><?php echo $row_modificacion['moneda_operacion']; ?></span> <strong><?php echo number_format($row_modificacion['monto_operacion'], 2, ',', '.'); ?></strong></td>
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
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../cambio.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($modificacion);
?>