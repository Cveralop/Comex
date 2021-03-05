<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,ADM";
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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcci nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aviso Plazo Proveedor</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #000;
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo8 {color: #666666}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<script> 
window.print(); 
</script>
</head>
<body>
<table width="90%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle"><img src="../../../imagenes/JPEG/logo_carta.jpg" alt="" width="190" height="65" /></td>
    <td align="right" valign="top"><a href="impavisoplapro_mae.php">&lt;&lt;Volver&gt;&gt;</a></td>
  </tr>
  <tr>
    <td width="100%" colspan="2" align="left" valign="middle" class="NegrillaCartaReparo"> Cartas de Credito Importación</td>
  </tr>
  <tr>
    <td colspan="2" align="right" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['finplapro']; ?></td>
  </tr>
</table>
<br />
<table width="90%"  border="0" align="center">
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"> Se&ntilde;or(es)</td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"><span class="Estilo10"><span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></span></span></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"><span class="Estilo12">Rut : <span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></span></span></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="left" valign="middle"><strong>Presente</strong></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="right" valign="middle">Ref.: <span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></span> //Nro Neg.:<span class="NegrillaCartaReparo"> <?php echo strtoupper($row_DetailRS1['numero_neg']); ?> </span> //Nro Col.: <span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['nro_operacion_relacionada']); ?></span></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="right" valign="middle">&nbsp;</td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td align="center" valign="middle" class="NegrillaCartaReparo">Aviso Vencimiento Plazo Proveedor</td>
  </tr>
</table>
<br />
<table width="90%"  border="0" align="center">
  <tr>
    <td colspan="5" align="left" valign="middle">Estimado Cliente:</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">Informamos a Usted que hemos dado curso a la siguiente operación:</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle" bgcolor="#333333" class="titulo_menu" id="titulo_menu">Antecedentes del Plazo Proveedor</td>
  </tr>
  <tr>
    <td width="39%" align="left" valign="middle">Inicio Pago Intereses</td>
    <td width="2%" align="center" valign="middle"> :</td>
    <td width="59%" colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['iniplapro']; ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Fecha Vcto de la Operación</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['finplapro']; ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Moneda / Monto Plazo Proveedor</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_documentos']; ?> <?php echo number_format($row_DetailRS1['monto_documentos'], 2, ',', '.'); ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Moneda / Monto Gto Corresponsal</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_gtocorr']; ?> <?php echo number_format($row_DetailRS1['monto_gtocorr'], 2, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Tipo Tasa:</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['tipo_tasa']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Tasa Plazo Proveedor</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['tasa_pla_pro']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">T/C</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['tipo_cambio'], 2, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Paridad</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['paridad'], 6, ',', '.'); ?></td>
  </tr>
  <tr>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle" bgcolor="#333333" class="titulo_menu">Antecendentes Financiamiento Banco</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Inicio Pago de Intereses</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['inifinbco']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Vencimiento de la Operación</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['vcto_operacion']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Moneda / Monto Negociación</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_negociacion']; ?> <?php echo number_format($row_DetailRS1['monto_negociacion'], 2, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Tipo de Tasa</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['tipo_tasa']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Tasa Final</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['tasa_final']; ?></td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle" bgcolor="#333333" class="titulo_menu">Gastos Incurridos en Moneda Nacional</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Monto Intereses Plazo Proveedor</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['monto_inte'], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Gastos del Corresponsal</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['gto_corr'], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Comisión de Discrepancias</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['con_disc'], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Total</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo number_format(($row_DetailRS1['monto_inte'] + $row_DetailRS1['gto_corr'] + $row_DetailRS1['con_disc']), 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Cta Cte Nro.</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['origen_fondos']; ?></td>
  </tr>
</table>
<br />
<br />
<table width="90%" border="0" align="center">
  <tr>
    <td class="NegrillaCartaReparo">p.p. BANCO SANTANDER</td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>