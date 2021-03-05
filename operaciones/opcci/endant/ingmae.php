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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_ingreso = 10;
$pageNum_ingreso = 0;
if (isset($_GET['pageNum_ingreso'])) {
  $pageNum_ingreso = $_GET['pageNum_ingreso'];
}
$startRow_ingreso = $pageNum_ingreso * $maxRows_ingreso;
$colname_ingreso = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname_ingreso = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingreso = sprintf("SELECT * FROM opcci WHERE nro_operacion = '%s' ORDER BY id ASC", $colname_ingreso);
$query_limit_ingreso = sprintf("%s LIMIT %d, %d", $query_ingreso, $startRow_ingreso, $maxRows_ingreso);
$ingreso = mysqli_query($comercioexterior, $query_limit_ingreso) or die(mysqli_error());
$row_ingreso = mysqli_fetch_assoc($ingreso);
if (isset($_GET['totalRows_ingreso'])) {
  $totalRows_ingreso = $_GET['totalRows_ingreso'];
} else {
  $all_ingreso = mysqli_query($comercioexterior,$query_ingreso);
  $totalRows_ingreso = mysqli_num_rows($all_ingreso);
}
$totalPages_ingreso = ceil($totalRows_ingreso/$maxRows_ingreso)-1;
$queryString_ingreso = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ingreso") == false && 
        stristr($param, "totalRows_ingreso") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ingreso = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ingreso = sprintf("&totalRows_ingreso=%d%s", $totalRows_ingreso, $queryString_ingreso);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso Endoso Anticipado - Maestro</title>
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
	color: #FFFFFF;
	font-weight: bold;
	font-size: 12px;
}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
.Estilo9 {color: #00FF00}
.Estilo10 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo11 {color: #FF0000}
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
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO ENDOSO ANTICIPADO - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form action="" method="get" name="form1">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo5"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Ingreso Endoso Anticipado</span></td>
    </tr>
    <tr valign="middle">
      <td width="22%" align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
      <td width="78%" align="left" valign="middle">        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">K000000</span></td>
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
<?php if ($totalRows_ingreso > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="8" align="left"><span class="Estilo5"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Numero Operaci&oacute;n <span class="Estilo9"><?php echo strtoupper($row_ingreso['nro_operacion']); ?></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Ingresar</div></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Estado
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Documentos 
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="ingdet.php?recordID=<?php echo $row_ingreso['id']; ?>"> <img src="../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td align="center"><?php echo $row_ingreso['fecha_ingreso']; ?> </div></td>
    <td align="center"><?php echo $row_ingreso['rut_cliente']; ?> </div></td>
    <td align="left"><?php echo $row_ingreso['nombre_cliente']; ?> </td>
    <td align="center"><?php echo $row_ingreso['evento']; ?> </div></td>
    <td align="center"><?php echo $row_ingreso['estado']; ?> </div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingreso['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_ingreso['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
    <td align="right"><strong><span class="respuestacolumna_rojo"><?php echo strtoupper($row_ingreso['moneda_documentos']); ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_ingreso['monto_documentos'], 2, ',', '.'); ?></span></strong>      </div></td>
  </tr>
  <?php } while ($row_ingreso = mysqli_fetch_assoc($ingreso)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ingreso > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingreso=%d%s", $currentPage, 0, $queryString_ingreso); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ingreso > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_ingreso=%d%s", $currentPage, max(0, $pageNum_ingreso - 1), $queryString_ingreso); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingreso < $totalPages_ingreso) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingreso=%d%s", $currentPage, min($totalPages_ingreso, $pageNum_ingreso + 1), $queryString_ingreso); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ingreso < $totalPages_ingreso) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_ingreso=%d%s", $currentPage, $totalPages_ingreso, $queryString_ingreso); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_ingreso + 1) ?></strong> al <strong><?php echo min($startRow_ingreso + $maxRows_ingreso, $totalRows_ingreso) ?></strong> de un total de <strong><?php echo $totalRows_ingreso ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../carcreimp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($ingreso);
?>