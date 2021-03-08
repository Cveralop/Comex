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
$maxRows_aceptacion = 10;
$pageNum_aceptacion = 0;
if (isset($_GET['pageNum_aceptacion'])) {
  $pageNum_aceptacion = $_GET['pageNum_aceptacion'];
}
$startRow_aceptacion = $pageNum_aceptacion * $maxRows_aceptacion;

$colname1_aceptacion = "1";
if (isset($_GET['evento'])) {
  $colname1_aceptacion = $_GET['evento'];
}
$colname_aceptacion = "1";
if (isset($_GET['nro_operacion'])) {
  $colname_aceptacion = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_aceptacion = sprintf("SELECT * FROM opcbi WHERE nro_operacion = %s and evento = %s ORDER BY id DESC", GetSQLValueString($colname_aceptacion, "text"),GetSQLValueString($colname1_aceptacion, "text"));
$query_limit_aceptacion = sprintf("%s LIMIT %d, %d", $query_aceptacion, $startRow_aceptacion, $maxRows_aceptacion);
$aceptacion = mysql_query($query_limit_aceptacion, $comercioexterior) or die(mysqli_error());
$row_aceptacion = mysqli_fetch_assoc($aceptacion);
if (isset($_GET['totalRows_aceptacion'])) {
  $totalRows_aceptacion = $_GET['totalRows_aceptacion'];
} else {
  $all_aceptacion = mysql_query($query_aceptacion);
  $totalRows_aceptacion = mysqli_num_rows($all_aceptacion);
}
$totalPages_aceptacion = ceil($totalRows_aceptacion/$maxRows_aceptacion)-1;
$queryString_aceptacion = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_aceptacion") == false && 
        stristr($param, "totalRows_aceptacion") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_aceptacion = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_aceptacion = sprintf("&totalRows_aceptacion=%d%s", $totalRows_aceptacion, $queryString_aceptacion);
?>
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
	color: #FF0000;
	font-weight: bold;
}
.Estilo8 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo14 {color: #FFFFFF; font-weight: bold; }
.Estilo15 {font-size: 12px}
.Estilo16 {color: #00FF00}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
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
//-->
</script>
</style>
<script> 
var segundos=1200
var direccion='../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<title>Modificar Aceptaci&oacute;n Protesto CBI - Maestro</title>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">MODIFICAR ACEPTACI&Oacute;N O PROTESTO COBRANZA DE IMPORTACI&Oacute;N - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COBRANZA DE IMPORTACI&Oacute;N y OPI </td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo8">Modificar Aceptaci&oacute;n o Protesto CBI </span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td width="79%" align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
        <span class="rojopequeno">I000000</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="left" valign="middle"><select name="evento" class="etiqueta12" id="evento">
        <option value="Aceptacion." selected>Aceptacion</option>
        <option value="Protesto.">Protesto</option>
        <option value="Acuse Recibo.">Acuse Recibo</option>
        <option value="Carta Compromiso.">Carta Compromiso</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_aceptacion > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="5" align="left"><span class="Estilo14"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo15">Nro Operaci&oacute;n <span class="Estilo16"><?php echo strtoupper($row_aceptacion['nro_operacion']); ?></span></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Modificar Operaci&oacute;n</td>
    <td align="center" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente
      </div>      
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="moddet.php?recordID=<?php echo $row_aceptacion['id']; ?>"> <img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center"><?php echo $row_aceptacion['fecha_ingreso']; ?></div></td>
    <td align="center"><?php echo $row_aceptacion['rut_cliente']; ?> </div></td>
    <td align="left"><?php echo $row_aceptacion['nombre_cliente']; ?>&nbsp; </div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_aceptacion['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_aceptacion['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
  </tr>
  <?php } while ($row_aceptacion = mysqli_fetch_assoc($aceptacion)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_aceptacion > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_aceptacion=%d%s", $currentPage, 0, $queryString_aceptacion); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_aceptacion > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_aceptacion=%d%s", $currentPage, max(0, $pageNum_aceptacion - 1), $queryString_aceptacion); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_aceptacion < $totalPages_aceptacion) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_aceptacion=%d%s", $currentPage, min($totalPages_aceptacion, $pageNum_aceptacion + 1), $queryString_aceptacion); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_aceptacion < $totalPages_aceptacion) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_aceptacion=%d%s", $currentPage, $totalPages_aceptacion, $queryString_aceptacion); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_aceptacion + 1) ?></strong> al <strong><?php echo min($startRow_aceptacion + $maxRows_aceptacion, $totalRows_aceptacion) ?></strong> de un total de <strong><?php echo $totalRows_aceptacion ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../cobimport.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<?php
mysqli_free_result($aceptacion);
?>