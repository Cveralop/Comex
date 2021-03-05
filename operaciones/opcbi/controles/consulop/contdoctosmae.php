<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE,GER";
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
$colname4_controldoctos = "Apertura.";
if (isset($_GET['evento'])) {
  $colname4_controldoctos = (get_magic_quotes_gpc()) ? $_GET['evento'] : addslashes($_GET['evento']);
}
$colname3_controldoctos = "1";
if (isset($_GET['nro_operacion'])) {
  $colname3_controldoctos = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
$colname1_controldoctos = "CBI.";
if (isset($_GET['tipo_operacion'])) {
  $colname1_controldoctos = (get_magic_quotes_gpc()) ? $_GET['tipo_operacion'] : addslashes($_GET['tipo_operacion']);
}
$colname2_controldoctos = "Pendiente.";
if (isset($_GET['estado_aceptacion'])) {
  $colname2_controldoctos = (get_magic_quotes_gpc()) ? $_GET['estado_aceptacion'] : addslashes($_GET['estado_aceptacion']);
}
$colname_controldoctos = "1";
if (isset($_GET['aceptacion'])) {
  $colname_controldoctos = (get_magic_quotes_gpc()) ? $_GET['aceptacion'] : addslashes($_GET['aceptacion']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_controldoctos = sprintf("SELECT * FROM opcbi WHERE aceptacion LIKE '%%%s%%' and tipo_operacion = '%s' and estado_aceptacion = '%s' and nro_operacion LIKE '%%%s' and evento = '%s' ORDER BY id ASC", $colname_controldoctos,$colname1_controldoctos,$colname2_controldoctos,$colname3_controldoctos,$colname4_controldoctos);
$controldoctos = mysql_query($query_controldoctos, $comercioexterior) or die(mysqli_error());
$row_controldoctos = mysqli_fetch_assoc($controldoctos);
$totalRows_controldoctos = mysqli_num_rows($controldoctos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Control Documentos - Maestro</title>
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
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo9 {color: #FFFFFF; font-weight: bold; }
.Estilo12 {font-size: 12px}
.Estilo13 {color: #00FF00}
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
    <td width="93%" align="left" valign="middle" class="Estilo3">CONTROL DOCUMENTOS - MAESTRO </td>
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
      <td colspan="2" align="left" valign="middle"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo6">Control Documentos</span></td>
    </tr>
    <tr>
      <td width="19%" align="right" valign="middle">Tipo Documentos:</div></td>
      <td width="81%" align="left" valign="middle">        <select name="aceptacion" class="etiqueta12" id="aceptacion">
        <option value="CA.">Contra Aceptaci&oacute;n</option>
        <option value="CP.">Contra Pago</option>
        <option value="." selected>Todas</option>
        </select>      </td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
      <td align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
        <span class="rojopequeno">I000000</span></td>
    </tr>
    <tr>
      <td height="16" colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="etiqueta12" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../cobimport.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_controldoctos > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="10" align="left" valign="middle"><span class="Estilo9"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo12">Total de Operaciones <span class="Estilo13"><?php echo $totalRows_controldoctos ?></span></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Aceptar Doctos</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Curse 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Aceptaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Sucursal
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Observaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>      
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr align="left" valign="middle">
    <td align="center" valign="middle"><a href="contdoctosdet.php?recordID=<?php echo $row_controldoctos['id']; ?>"> <img src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div></td>
    <td align="center" valign="middle"><?php echo $row_controldoctos['fecha_curse']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_controldoctos['rut_cliente']; ?> </td>
    <td align="left" valign="middle"><?php echo $row_controldoctos['nombre_cliente']; ?></div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_controldoctos['nro_operacion']); ?> </span></td>
    <td align="center" valign="middle"><?php echo $row_controldoctos['aceptacion']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_controldoctos['especialista']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_controldoctos['sucursal']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_controldoctos['obs']; ?> </td>
    <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_controldoctos['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_controldoctos['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
  </tr>
  <?php } while ($row_controldoctos = mysqli_fetch_assoc($controldoctos)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($controldoctos);
?>