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
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "1";
if (isset($_GET['reparo_obs'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['reparo_obs'] : addslashes($_GET['reparo_obs']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM opcce  WHERE id = $recordID", $colname_cartareparo);
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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Carta Reparo</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
.Estilo5 {font-size: 18px;
	font-weight: bold;
}
.Estilo8 {font-size: 9px;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
}
.Estilo10 {
	font-size: 14px
}
.Estilo12 {
	font-size: 14px
}
.Estilo13 {font-size: 12px; font-weight: bold; }
-->
</style>
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body>
<table width="90%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle"><img src="../../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61"></td>
  </tr>
  <tr>
    <td align="left" valign="middle">
      <span class="Estilo13"><span class="NegrillaCartaReparo">Carta de Cr&eacute;dito Exportaciones</span></span></div>
    </div></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?></td>
  </tr>
</table>
<br>
<br>
<table width="90%"  border="0" align="center">
  <tr bordercolor="#CCCCCC">
    <td width="100%" align="left" valign="middle"> Se&ntilde;or(a)</td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle">    Especialista Comercio Exterior</td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"><strong>Presente</strong></td>
  </tr>
</table>
<br>
<table width="90%"  border="0" align="center">
  <tr bordercolor="#CCCCCC">
    <td width="13%" align="left" valign="middle"><span class="Estilo10">Asunto</span></td>
    <td width="5%" align="center" valign="middle">:</div></td>
    <td width="82%" align="left" valign="middle"><span class="Estilo12">Aviso de reparo, <strong class="NegrillaCartaReparo"><?php echo $row_DetailRS1['evento']; ?></strong> de Carta de Cr&eacute;dito de Exportaci&oacute;n.</span></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"><span class="Estilo10">Referencia</span></td>
    <td align="center" valign="middle"><span class="Estilo12">:</span></div></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['nro_operacion']; ?></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"><span class="Estilo10">Cliente</span></td>
    <td align="center" valign="middle">:</div></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['nombre_cliente']; ?></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"><span class="Estilo10">Rut</span></td>
    <td align="center" valign="middle">:</td>
    <td align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['rut_cliente']; ?></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle" class="Estilo12">Moneda Monto</td>
    <td align="center" valign="middle"><span class="Estilo12">:</span></div></td>
    <td align="left" valign="middle"><span class="Estilo12"><strong><?php echo $row_DetailRS1['moneda_operacion']; ?></strong> <strong><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong> </span></td>
  </tr>
</table>
<br>
<br>
<table width="90%"  border="0" align="center">
  <tr>
    <td width="100%" align="left" valign="middle">De nuestra consideraci&oacute;n:</td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Por intermedio de la presente informarnos a Uds. que debido a las observaciones detalladas m&aacute;s abajo, no ha sido posible el curse de vuestra instrucci&oacute;n.</div></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><p align="justify">Detalle de Observaciones:</p></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><p><?php echo $row_DetailRS1['reparo_obs']; ?></p></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Solicitamos vuestra gesti&oacute;n con el fin de dar curse a la brevedad. Sin otro particular nos es grato saludarle muy atentamente, </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><st1:PersonName ProductID="LA SOLUCI&Oacute;N DEL" w:st="on">Nota</st1:PersonName>
      <span class="MsoNormal Estilo14">
      <st1:PersonName ProductID="LA SOLUCI&Oacute;N DEL" w:st="on"></st1:PersonName>
      </span>
      <st1:PersonName ProductID="LA SOLUCI&Oacute;N DEL" w:st="on">: La soluci&oacute;n del reparo debe ser ingresada por conducto regular, no se considerar&aacute;n instrucciones v&iacute;a mail.</st1:PersonName>
      <o:p></o:p>
      <span class="MsoNormal Estilo14">
      <st1:PersonName ProductID="LA SOLUCI&Oacute;N DEL" w:st="on"></st1:PersonName>
    </span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle"><strong>Banco Santander</strong></div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><SPAN class=265052114-13052009 Estilo15><strong>Carta de Cr&eacute;dito de Exportaci&oacute;n</strong></SPAN></div></td>
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
    <td align="left" valign="middle">CC: <?php echo $_SESSION['login'];?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">ESP: <?php echo $row_DetailRS1['especialista_curse']; ?></td>
  </tr>
</table>
<script> 
window.print(); 
</script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>