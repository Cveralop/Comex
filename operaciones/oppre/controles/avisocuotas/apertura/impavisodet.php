<?php require_once('../../../../../Connections/comercioexterior.php'); ?>
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
$MM_restrictGoTo = "../../../erroracceso.php";
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
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imprimir Aviso Cuota Apertura - Aviso</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #000;
}

H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
-->
</style>
<link href="../../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body>
<table width="90%"  border="0" align="center">
  <tr>
    <td colspan="2" align="left" valign="middle"><img src="../../../../../imagenes/JPEG/logo_carta.JPG" alt="" width="219" height="61" /></td>
  </tr>
  <tr>
    <td width="71%" align="right" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
    <td width="29%" align="right" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['fecha_ingreso']; ?></td>
  </tr>
</table>
<br />
<table width="90%"  border="0" align="center">
  <tr bordercolor="#CCCCCC">
    <td colspan="2" align="left" valign="middle"> Se&ntilde;or(es)</td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td colspan="2" align="left" valign="middle"><span class="Estilo10"><span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['nombre_cliente']); ?></span></span></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td colspan="2" align="left" valign="middle"><span class="Estilo12">Rut : <span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?></span></span></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td colspan="2" align="left" valign="middle"><strong>Presente</strong></td>
  </tr>
  <tr bordercolor="#CCCCCC">
    <td width="71%" align="right" valign="middle">&nbsp;</td>
    <td width="29%" align="right" valign="middle">Ref.: <span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></span></td>
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
    <td colspan="5" align="left" valign="middle">Nos es muy grato confirmarles que hoy hemos otorgado el siguiente financiamiento <?php echo $row_DetailRS1['tipo_operacion']; ?> el cual ha sido acreditado conforme a sus instrucciones:</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td width="24%" align="left" valign="middle">Nuestra Referencia</td>
    <td width="2%" align="center" valign="middle"> :</td>
    <td width="74%" colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['nro_operacion']; ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Moneda / Monto </td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_operacion']; ?></span> <span class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Tasa Interes</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['tasa_final'], 6, ',', '.'); ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Nro de Cuotas</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['nro_cuotas']; ?></span></td>
  </tr>
  <tr>
  </tr>
</table>
<br />
<table width="90%"  border="0" align="center">
  <tr>
    <td colspan="5" align="left" valign="middle" bgcolor="#999999">Detalle de Comisiones y Gastos</td>
  </tr>
  <tr>
    <td width="24%" align="left" valign="middle">Notario</td>
    <td width="2%" align="center" valign="middle">:</td>
    <td width="20%" align="center" valign="middle" class="NegrillaCartaReparo">$</td>
    <td width="27%" align="right" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['notario'], 0, ',', '.'); ?></td>
    <td width="27%" align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Impuesto</td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo">$</td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['impuestos'], 0, ',', '.'); ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="MsoNormal Estilo14">
      <st1:PersonName ProductID="LA SOLUCIÓN DEL" w:st="on">Comisión</st1:PersonName></span></td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo">$</td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['comisiones'], 0, ',', '.'); ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Total Gastos</td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo">$</td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['importe_cargo'], 0, ',', '.'); ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Cuenta Corriente Nro.</td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['cta_cte_cargo']; ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
</table>
<br />
<table width="90%"  border="0" align="center">
  <tr>
    <td colspan="5" align="left" valign="middle" bgcolor="#999999">Destino de los Fondos</td>
  </tr>
  <tr>
    <td width="24%" align="left" valign="middle">Moneda</td>
    <td width="2%" align="center" valign="middle">:</td>
    <td width="20%" align="center" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
    <td width="27%" align="right" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_abono']; ?></td>
    <td width="27%" align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="MsoNormal Estilo14">Importe</span></td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['importe_abono'], 2, ',', '.'); ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="MsoNormal Estilo14">
      <st1:PersonName ProductID="LA SOLUCIÓN DEL" w:st="on">Cuenta Corriente Nro.</st1:PersonName></span></td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['cta_cte_abono']; ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Otro Destino</td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['otro_abono']; ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
</table>
<br />
<table width="90%"  border="0" align="center">
  <tr>
    <td width="24%" align="center" valign="middle">Observaci&oacute;n:</td>
    <td width="76%" colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['obs_avisopago']; ?></td>
  </tr>
  <tr>
    <td height="22" colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" colspan="4" align="left" valign="middle">Saluda a Uds. muy atentamente.</td>
  </tr>
  <tr>
    <td height="22" colspan="4" align="center" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" colspan="4" align="center" valign="middle"><strong>Banco Santander</strong>
      </div></td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="middle"><span class="265052114-13052009" estilo15="Estilo15"><strong>Departamento Pr&eacute;stamos</strong></span>
      </div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>