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
$colname3_nominadoctos = "Negociacion.";
if (isset($_GET['evento'])) {
  $colname3_nominadoctos = $_GET['evento'];
}
$colname1_nominadoctos = "1";
if (isset($_GET['estado_doc'])) {
  $colname1_nominadoctos = $_GET['estado_doc'];
}
$colname2_nominadoctos = "Cursada.";
if (isset($_GET['estado'])) {
  $colname2_nominadoctos = $_GET['estado'];
}
$colname4_nominadoctos = "1";
if (isset($_GET['entregado_por'])) {
  $colname4_nominadoctos = $_GET['entregado_por'];
}
$colname_nominadoctos = "1";
if (isset($_GET['date_ent_doc_val'])) {
  $colname_nominadoctos = $_GET['date_ent_doc_val'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_nominadoctos = sprintf("SELECT * FROM opcci nolock WHERE date_ent_doc_val LIKE %s and estado_doc = %s and estado = %s and evento = %s and entregado_por = %s", GetSQLValueString("%" . $colname_nominadoctos . "%", "text"),GetSQLValueString($colname1_nominadoctos, "text"),GetSQLValueString($colname2_nominadoctos, "text"),GetSQLValueString($colname3_nominadoctos, "text"),GetSQLValueString($colname4_nominadoctos, "text"));
$nominadoctos = mysqli_query($comercioexterior, $query_nominadoctos) or die(mysqli_error());
$row_nominadoctos = mysqli_fetch_assoc($nominadoctos);
$totalRows_nominadoctos = mysqli_num_rows($nominadoctos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Nomina Estado Documentos CCI</title>
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
.Estilo9 {color: #FFFFFF; font-weight: bold; }
.Estilo12 {font-size: 12px}
.Estilo13 {color: #00FF00}
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
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">NOMINA  DOCUMENTOS ENTREGADOS / RECHAZADOS</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Documentos Valorados</span></td>
    </tr>
    <tr valign="middle" bgcolor="#CCCCCC">
      <td width="17%" align="right">Fecha Curse:</div></td>
      <td width="83%" align="left"><input name="date_ent_doc_val" type="text" class="etiqueta12" id="date_ent_doc_val" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
        <span class="rojopequeno">(aaaa-mm-dd)
        <input name="entregado_por" type="hidden" id="entregado_por" value="<?php echo $_SESSION['login'];?>">
        </span></td>
    </tr>
    <tr valign="middle" bgcolor="#CCCCCC">
      <td align="right">Estado:</div></td>
      <td align="left"><select name="estado_doc" class="etiqueta12" id="estado_doc">
        <option value="Entregado." selected>Documentos Entregados</option>
        <option value="Rechazado.">Documentos Rechazados</option>
      </select></td>
    </tr>
    <tr valign="middle" bgcolor="#CCCCCC">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">      
        <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opcci.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_nominadoctos > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="9" align="left"><span class="Estilo9"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo12">Total de <span class="Estilo13"><?php echo $totalRows_nominadoctos ?></span> Negociaciones</span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Fecha Curse
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Documentos
      </div>
    </td>
    <td align="center" class="titulocolumnas">Tipo Negociaci&oacute;n</div>
    </td>
    <td align="center" class="titulocolumnas">Estado Doctos
      </div>
    </td>
    <td align="center" class="titulocolumnas">Entregado Por
      </div>
    </td>
    <td align="center" class="titulocolumnas">Fecha Entrega Doctos </div></td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><?php echo strtoupper($row_nominadoctos['rut_cliente']); ?> </div></td>
    <td align="left"><?php echo strtoupper($row_nominadoctos['nombre_cliente']); ?> </div></td>
    <td align="center"><?php echo $row_nominadoctos['fecha_curse']; ?> </div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_nominadoctos['nro_operacion']); ?></span>      </div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_nominadoctos['moneda_documentos']); ?></span>&nbsp;<strong class="respuestacolumna_azul"><?php echo number_format($row_nominadoctos['monto_documentos'], 2, ',', '.'); ?></strong></div></td>
    <td align="center"><?php echo $row_nominadoctos['tipo_negociacion']; ?> </div></td>
    <td align="center"><?php echo $row_nominadoctos['estado_doc']; ?></div></td>
    <td align="center"><?php echo $row_nominadoctos['entregado_por']; ?> </div></td>
    <td align="center"><?php echo $row_nominadoctos['date_ent_doc_val']; ?> </div></td>
  </tr>
  <?php } while ($row_nominadoctos = mysqli_fetch_assoc($nominadoctos)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($nominadoctos);
?>