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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_pendientes = 5000;
$pageNum_pendientes = 0;
if (isset($_GET['pageNum_pendientes'])) {
  $pageNum_pendientes = $_GET['pageNum_pendientes'];
}
$startRow_pendientes = $pageNum_pendientes * $maxRows_pendientes;
$colname1_pendientes = "Pendiente.";
if (isset($_GET['estado'])) {
  $colname1_pendientes = (get_magic_quotes_gpc()) ? $_GET['estado'] : addslashes($_GET['estado']);
}
$colname_pendientes = ".";
if (isset($_GET['evento'])) {
  $colname_pendientes = (get_magic_quotes_gpc()) ? $_GET['evento'] : addslashes($_GET['evento']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_pendientes = sprintf("SELECT * FROM optbc WHERE evento LIKE '%%%s%%' and estado = '%s' ORDER BY id ASC", $colname_pendientes,$colname1_pendientes);
$query_limit_pendientes = sprintf("%s LIMIT %d, %d", $query_pendientes, $startRow_pendientes, $maxRows_pendientes);
$pendientes = mysqli_query($comercioexterior, $query_limit_pendientes) or die(mysqli_error($comercioexterior));
$row_pendientes = mysqli_fetch_assoc($pendientes);
if (isset($_GET['totalRows_pendientes'])) {
  $totalRows_pendientes = $_GET['totalRows_pendientes'];
} else {
  $all_pendientes = mysqli_query($comercioexterior, $query_pendientes);
  $totalRows_pendientes = mysqli_num_rows($all_pendientes);
}
$totalPages_pendientes = ceil($totalRows_pendientes/$maxRows_pendientes)-1;
$queryString_pendientes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_pendientes") == false && 
        stristr($param, "totalRows_pendientes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_pendientes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_pendientes = sprintf("&totalRows_pendientes=%d%s", $totalRows_pendientes, $queryString_pendientes);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control Operaciones Pendientes Stand BY Recibidas</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
.Estilo3 {	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {	font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
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
.Estilo6 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
.Estilo9 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo16 {color: #00FF00}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="refresh" content="60" />
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONTROL OPERACIONES PENDIENTES STAND BY RECIBIDAS</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">OPERACIONES DE CAMBIO</td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../cambio.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="8" align="left" valign="middle" class="Estilo6"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Total de Operaciones Pendientes <span class="Estilo16"><?php echo $totalRows_pendientes ?></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda Monto Apertura
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><?php echo $row_pendientes['fecha_ingreso']; ?> </div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_pendientes['nro_operacion']; ?></span>      </div></td>
    <td align="center" valign="middle"><?php echo $row_pendientes['evento']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_pendientes['rut_cliente']; ?></td>
    <td align="left" valign="middle"><?php echo $row_pendientes['nombre_cliente']; ?></td>
    <td align="center" valign="middle"><?php echo $row_pendientes['operador']; ?></div></td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_pendientes['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_pendientes['monto_operacion'], 2, ',', '.'); ?></strong></td>
    <td align="center" valign="middle"><?php echo $row_pendientes['tipo_operacion']; ?></div></td>
  </tr>
  <?php } while ($row_pendientes = mysqli_fetch_assoc($pendientes)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_pendientes > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_pendientes=%d%s", $currentPage, 0, $queryString_pendientes); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_pendientes > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_pendientes=%d%s", $currentPage, max(0, $pageNum_pendientes - 1), $queryString_pendientes); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_pendientes < $totalPages_pendientes) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_pendientes=%d%s", $currentPage, min($totalPages_pendientes, $pageNum_pendientes + 1), $queryString_pendientes); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_pendientes < $totalPages_pendientes) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_pendientes=%d%s", $currentPage, $totalPages_pendientes, $queryString_pendientes); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<?php
mysqli_free_result($pendientes);
?>