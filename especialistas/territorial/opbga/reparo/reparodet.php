<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,TER";
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
$maxRows_DetailRS1 = 30;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opbga WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_limit_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carta Reparo</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #000;
}
body {
	background-image: url();
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
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
-->
</style>
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<script> 
window.print(); 
</script> 
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="90%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle"><img src="../../../../imagenes/JPEG/logo_carta.jpg" width="201" height="60" /></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="middle" class="NegrillaCartaReparo"> Soporte Negocio Internacional</td>
  </tr>
  <tr>
    <td align="right" valign="middle"><?php
setlocale(LC_TIME,'spanish'); 
echo strftime("Santiago, %d de %B de %Y");?></td>
  </tr>
</table>
<br />
<br />
<table width="90%"  border="0" align="center">
  <tr bordercolor="#CCCCCC">
    <td width="100%" align="left" valign="middle"> Se&ntilde;or(a)</td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"> Ejecutivo(a) Cuenta y/o Atención Cliente</td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"><strong>Presente</strong></td>
  </tr>
</table>
<br />
<table width="90%"  border="0" align="center">
  <tr valign="middle" bordercolor="#CCCCCC">
    <td width="13%" align="left" class="Estilo12"><span class="Estilo10">Asunto</span></td>
    <td width="5%" align="center" class="Estilo10">:
      </div></td>
    <td width="82%" align="left" class="Estilo10"><span class="Estilo12">Aviso de reparo, <strong><?php echo $row_DetailRS1['evento']; ?></strong> de Boletas de Garantía.</span></td>
  </tr>
  <tr valign="middle" bordercolor="#CCCCCC">
    <td align="left" class="Estilo12"><span class="Estilo10">Referencia</span></td>
    <td align="center" class="Estilo10">:
      </div></td>
    <td align="left" class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></td>
  </tr>
  <tr valign="middle" bordercolor="#CCCCCC">
    <td align="left" class="Estilo12"><span class="Estilo10">Cliente</span></td>
    <td align="center" class="Estilo10">:
      </div></td>
    <td align="left" class="Estilo10"><span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></span>
      </div></td>
  </tr>
  <tr valign="middle" bordercolor="#CCCCCC">
    <td align="left" class="Estilo12">Rut</td>
    <td align="center" class="Estilo10">:</td>
    <td align="left" class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></td>
  </tr>
  <tr valign="middle" bordercolor="#CCCCCC">
    <td align="left" class="Estilo12"><span class="Estilo10">Moneda Monto</span></td>
    <td align="center" class="Estilo10"><span class="Estilo12">:</span>
      </div></td>
    <td align="left" class="Estilo10"><span class="Estilo12"><strong><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></strong> <strong><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></span></td>
  </tr>
</table>
<br />
<br />
<table width="90%"  border="0" align="center">
  <tr>
    <td width="100%" align="left" valign="middle">De nuestra consideraci&oacute;n:</td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Por intermedio de la presente informarnos a Uds. que debido a las observaciones detalladas m&aacute;s abajo, no ha sido posible el curse de vuestra instrucci&oacute;n.
      </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Detalle de Observaciones:</td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['reparo_obs']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Solicitamos vuestra gesti&oacute;n con el fin de dar curse a la brevedad. Sin otro particular nos es grato saludarle muy atentamente,
      </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="MsoNormal Estilo14">
      <st1:PersonName ProductID="LA SOLUCIÓN DEL" w:st="on"><span class="Estilo13">Nota: </span></st1:PersonName></span><span class="MsoNormal Estilo14">
      <st1:PersonName ProductID="LA SOLUCIÓN DEL" w:st="on"><span class="Estilo13">La soluci&oacute;n del reparo debe ser ingresada por conducto regular vía buz&oacute;n de la territorial correspondiente indicando claramente en observaci&oacute;n de caratula Comex que corresponde a &quot;SOLUCION DE REPARO&quot;</span></st1:PersonName>
      </span></td>
  </tr>
  <tr>
    <td height="22" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle"><strong>Banco Santander</strong>
      </div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><strong>Soporte Negocio Internacional</strong></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="Estilo8"><span class="Negrillapequeno">CC: </span></span><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['territorial']; ?></span></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>