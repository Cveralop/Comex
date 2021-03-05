<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
  header('Content-type: text/vnd.ms-excel'); 
header("Content-Disposition: attachment;filename=arqueo_doctos_bmg.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");
}
$MM_authorizedUsers = "BMG,ADM";
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
?>
<?php
$colname1_nominadoctos = "Negociacion.";
if (isset($_GET['evento'])) {
  $colname1_nominadoctos = $_GET['evento'];
}
$colname2_nominadoctos = "Recibido.";
if (isset($_GET['estado_doc'])) {
  $colname2_nominadoctos = $_GET['estado_doc'];
}
$colname_nominadoctos = "Cursada.";
if (isset($_GET['estado'])) {
  $colname_nominadoctos = $_GET['estado'];
}
$colname4_nominadoctos = "BMG";
if (isset($_GET['recibido_por_segmento'])) {
  $colname4_nominadoctos = $_GET['recibido_por_segmento'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_nominadoctos = sprintf("SELECT * FROM opcci WHERE estado_doc = %s and estado = %s and evento = %s and recibido_por_segmento = %s ORDER BY date_rec_doc_val ASC", GetSQLValueString($colname2_nominadoctos, "text"),GetSQLValueString($colname_nominadoctos, "text"),GetSQLValueString($colname1_nominadoctos, "text"),GetSQLValueString($colname4_nominadoctos, "text"));
$nominadoctos = mysqli_query($comercioexterior, $query_nominadoctos) or die(mysqli_error($comercioexterior));
$row_nominadoctos = mysqli_fetch_assoc($nominadoctos);
$totalRows_nominadoctos = mysqli_num_rows($nominadoctos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Nomina Documentos Pendientes de Entrega</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #000;
}
body {
	background-image: url();
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
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
<body>
<?php if ($totalRows_nominadoctos > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="8" align="left" bgcolor="#FFFFFF" class="NegrillaCartaReparo">Total de <?php echo $totalRows_nominadoctos ?> Documentos Pendientes de Entrega</td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" bgcolor="#FFFFFF">Rut Cliente 
      </div>    </td>
    <td align="center" bgcolor="#FFFFFF">Nombre Cliente 
      </div>    </td>
    <td align="center" bgcolor="#FFFFFF">Fecha Curse
      </div>    </td>
    <td align="center" bgcolor="#FFFFFF">Nro Operaci&oacute;n </div>    </td>
    <td align="center" bgcolor="#FFFFFF">Moneda / Monto Documentos
      </div>    </td>
    <td align="center" bgcolor="#FFFFFF">Tipo Negociaci&oacute;n</div>    </td>
    <td align="center" bgcolor="#FFFFFF">Fecha Recepci&oacute;n Doctos</td>
    <td align="center" bgcolor="#FFFFFF">Recibido Por</td>
    </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center" bgcolor="#FFFFFF"><?php echo strtoupper($row_nominadoctos['rut_cliente']); ?> </div></td>
    <td align="left" bgcolor="#FFFFFF"><?php echo strtoupper($row_nominadoctos['nombre_cliente']); ?> </div></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_nominadoctos['fecha_curse']; ?> </div></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo strtoupper($row_nominadoctos['nro_operacion']); ?>      </div></td>
    <td align="right" bgcolor="#FFFFFF"><?php echo strtoupper($row_nominadoctos['moneda_documentos']); ?>&nbsp;<?php echo number_format($row_nominadoctos['monto_documentos'], 2, ',', '.'); ?></div></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_nominadoctos['tipo_negociacion']; ?> </div></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_nominadoctos['date_rec_doc_val']; ?></td>
    <td align="center" bgcolor="#FFFFFF"><?php echo $row_nominadoctos['recibido_por']; ?> </div></td>
    </tr>
  <?php } while ($row_nominadoctos = mysqli_fetch_assoc($nominadoctos)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($nominadoctos);
?>