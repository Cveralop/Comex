<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "1";
if (isset($_GET['nro_operacion'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM opcci  WHERE id = $recordID", $colname_imprimir);
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
<title>Impresion Docto Valorado - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
.Estilo1 {
	font-size: 10px;
	font-weight: bold;
}
.Estilo3 {font-size: 12px; font-weight: bold; }
.Estilo6 {font-size: 9px}
.Estilo7 {
	font-size: 9px;
	font-weight: bold;
}
.Estilo8 {color: #666666}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
//-->
</script> 
<script> 
window.print(); 
</script>
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body>
<table width="95%"  border="0" align="center">
  <tr>
    <td><span class="Estilo3"><img src="../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61"><br> 
    </span></td>
    <td width="11%" align="right" valign="top"><a href="ingmae.php" class="Estilo8">&lt;&lt;Volver&gt;&gt;</a></td>
  </tr>
</table>
<br>
  <table width="95%"  border="0" align="center">
    <tr>
      <td align="center"><strong>DOCUMENTOS VALORADOS DEPTO. CR&Eacute;DITO DOCUMENTARIO </strong></td>
    </tr>
  </table>
  <table width="95%"  border="0" align="center">
    <tr>
      <td align="right" valign="middle"><strong><?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?>
      </strong></td>
    </tr>
  </table>
<br>
  <table width="95%"  border="1" align="center" bordercolor="#000000">
    <tr align="center" valign="middle">
      <td colspan="4"><strong>DETALLE ENTREGA DOCUMENTO </strong></td>
    </tr>
    <tr valign="middle">
      <td width="18%" align="left">A Oficina</td>
      <td align="left"><strong><?php echo strtoupper($row_DetailRS1['despacho_doctos']); ?></strong></div></td>
      <td width="19" align="left">Nro Negociaci&oacute;n</div></td>
      <td align="center"><strong><?php echo $row_DetailRS1['numero_neg']; ?></strong></td>
    </tr>
    <tr valign="middle">
      <td align="left">Cliente</td>
      <td colspan="3" align="left"><strong><?php echo $row_DetailRS1['rut_cliente']; ?></strong> <strong><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></strong> </td>
    </tr>
    <tr valign="middle">
      <td align="left">Especialista</td>
      <td align="left"><strong><?php echo strtoupper($row_DetailRS1['especialista']); ?></strong></td>
      <td align="left">Nro Operaci&oacute;n</td>
      <td align="center"><strong><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></strong></td>
    </tr>
    <tr valign="middle">
      <td align="left">Moneda Monto / Operaci&oacute;n</td>
      <td align="center"><strong><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></strong> <strong><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></td>
      <td align="left">Fecha Negociaci&oacute;n</td>
      <td align="center"><strong><?php echo $row_DetailRS1['fecha_neg']; ?></strong></td>
    </tr>
    <tr valign="middle">
      <td align="left">Moneda / <br>
Monto Negociaci&oacute;n</td>
      <td align="center"><strong><?php echo strtoupper($row_DetailRS1['moneda_documentos']); ?></strong> <strong><?php echo number_format($row_DetailRS1['monto_documentos'], 2, ',', '.'); ?></strong> </td>
      <td align="left">Referencia</td>
      <td align="center"><strong><?php echo $row_DetailRS1['referencia']; ?></strong></td>
    </tr>
  </table>
<br>
  <table width="95%"  border="1" align="center" bordercolor="#000000">
    <tr>
      <td align="left" valign="middle"><strong><img src="../../../imagenes/GIF/check.gif" width="13" height="12">Situaci&oacute;n de los Documentos</strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle">Tipo negociaci&oacute;n <strong><?php echo $row_DetailRS1['tipo_negociacion']; ?></strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong><img src="../../../imagenes/GIF/check.gif" width="13" height="12">Alzamiento</strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle">Endoso de documentos efectuado el <strong><?php echo $row_DetailRS1['fecha_endoso']; ?></strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong><img src="../../../imagenes/GIF/check.gif" width="13" height="12">Garant&iacute;as para liberaci&oacute;n de los documentos</strong></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><strong><?php echo $row_DetailRS1['garantia']; ?></strong></td>
    </tr>
  </table>
<br>
  <table width="95%"  border="1" align="center" bordercolor="#000000">
    <tr>
      <td colspan="2" align="center" valign="middle"><strong>DOCUMENTOS ENVIADOS POR EL CORRESPONSAL</strong></td>
    </tr>
    <tr>
      <td width="18%" align="center" valign="middle"><?php echo $row_DetailRS1['can1']; ?>/<?php echo $row_DetailRS1['can11']; ?> </td>
      <td width="82%" align="left" valign="middle"><?php echo $row_DetailRS1['doc1']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can2']; ?>/<?php echo $row_DetailRS1['can12']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc2']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can3']; ?>/<?php echo $row_DetailRS1['can13']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc3']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can4']; ?>/<?php echo $row_DetailRS1['can14']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc4']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can5']; ?>/<?php echo $row_DetailRS1['can15']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc5']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can6']; ?>/<?php echo $row_DetailRS1['can16']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc6']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can7']; ?>/<?php echo $row_DetailRS1['can17']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc7']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can8']; ?>/<?php echo $row_DetailRS1['can18']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc8']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can9']; ?>/<?php echo $row_DetailRS1['can19']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc9']; ?></td>
    </tr>
    <tr>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['can10']; ?>/<?php echo $row_DetailRS1['can20']; ?></td>
      <td align="left" valign="middle"><?php echo $row_DetailRS1['doc10']; ?></td>
    </tr>
  </table>
</div>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td><strong>NOTA: Este acuse de recibo deber&aacute; ser firmado por el cliente en se&ntilde;al de recepci&oacute;n conforme de los documentos de embarque adjunto. Este documento debe quedar en custodia de la oficina correspondiente.</strong></div></td>
  </tr>
</table>
<br>
<hr>
<table width="95%"  border="0" align="center">
  <tr valign="middle">
    <td width="17%" rowspan="9" valign="top"><span class="Estilo6">Retiro Conforme</span></td>
    <td colspan="2" align="center"><strong>ACUSE DE RECIBO </strong></td>
  </tr>
  <tr valign="middle">
    <td width="9%" rowspan="2" align="right">Firma&nbsp;&nbsp;&nbsp; </td>
    <td width="74%">&nbsp;</td>
  </tr>
  <tr valign="middle">
    <td>:<strong>..............................................................................................................................</strong></td>
  </tr>
  <tr valign="middle">
    <td rowspan="2" align="right">Nombre</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="middle">
    <td>:<strong>..............................................................................................................................</strong></td>
  </tr>
  <tr valign="middle">
    <td rowspan="2" align="right">R.U.T.&nbsp;&nbsp; </td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="middle">
    <td>:<strong>..............................................................................................................................</strong></td>
  </tr>
  <tr valign="middle">
    <td rowspan="2" align="right">Fecha&nbsp;&nbsp; </td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="middle">
    <td>:<strong>..............................................................................................................................</strong></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td><span class="Estilo7">Operador: <?php echo $row_DetailRS1['ope_doc_val']; ?> // Nro Operaci&oacute;n: <strong><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?> // <?php echo strtoupper($row_DetailRS1['moneda_documentos']); ?> <?php echo number_format($row_DetailRS1['monto_documentos'], 2, ',', '.'); ?> </strong></span></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>