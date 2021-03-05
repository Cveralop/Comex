<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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
$maxRows_currier = 10;
$pageNum_currier = 0;
if (isset($_GET['pageNum_currier'])) {
  $pageNum_currier = $_GET['pageNum_currier'];
}
$startRow_currier = $pageNum_currier * $maxRows_currier;
$colname_currier = "���";
if (isset($_GET['currier'])) {
  $colname_currier = (get_magic_quotes_gpc()) ? $_GET['currier'] : addslashes($_GET['currier']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_currier = sprintf("SELECT * FROM opcci WHERE currier = '%s' ORDER BY id DESC", $colname_currier);
$query_limit_currier = sprintf("%s LIMIT %d, %d", $query_currier, $startRow_currier, $maxRows_currier);
$currier = mysql_query($query_limit_currier, $comercioexterior) or die(mysqli_error());
$row_currier = mysqli_fetch_assoc($currier);
if (isset($_GET['totalRows_currier'])) {
  $totalRows_currier = $_GET['totalRows_currier'];
} else {
  $all_currier = mysql_query($query_currier);
  $totalRows_currier = mysqli_num_rows($all_currier);
}
$totalPages_currier = ceil($totalRows_currier/$maxRows_currier)-1;
$queryString_currier = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_currier") == false && 
        stristr($param, "totalRows_currier") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_currier = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_currier = sprintf("&totalRows_currier=%d%s", $totalRows_currier, $queryString_currier);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones Currier</title>
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
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo10 {color: #FFFFFF; font-weight: bold; }
.Estilo11 {color: #00FF00}
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
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONSULTA OPERACIONES POR CURRIER</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo6"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo6">Consulta por  Nro de Currier</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right" valign="middle">Nro Currier:</div></td>
      <td width="79%" align="left" valign="middle"><input name="currier" type="text" class="etiqueta12" id="currier" size="50" maxlength="50"></td>
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
<?php if ($totalRows_currier > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="5" align="left"><span class="Estilo6"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo6">Numero Currier <span class="Estilo11"><?php echo $row_currier['currier']; ?></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Fecha Ingreso</div></td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Documentos
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><?php echo $row_currier['fecha_ingreso']; ?> </td>
    <td align="center"> <span class="respuestacolumna_rojo"><?php echo strtoupper($row_currier['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo $row_currier['rut_cliente']; ?> </td>
    <td align="left"><?php echo strtoupper($row_currier['nombre_cliente']); ?> </td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_currier['moneda_documentos']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_currier['monto_documentos'], 2, ',', '.'); ?></strong></div></td>
  </tr>
  <?php } while ($row_currier = mysqli_fetch_assoc($currier)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_currier > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_currier=%d%s", $currentPage, 0, $queryString_currier); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_currier > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_currier=%d%s", $currentPage, max(0, $pageNum_currier - 1), $queryString_currier); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_currier < $totalPages_currier) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_currier=%d%s", $currentPage, min($totalPages_currier, $pageNum_currier + 1), $queryString_currier); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_currier < $totalPages_currier) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_currier=%d%s", $currentPage, $totalPages_currier, $queryString_currier); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_currier + 1) ?></strong> al <strong><?php echo min($startRow_currier + $maxRows_currier, $totalRows_currier) ?></strong> de un total de <strong><?php echo $totalRows_currier ?>
</strong>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../carcreimp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($currier);
?>