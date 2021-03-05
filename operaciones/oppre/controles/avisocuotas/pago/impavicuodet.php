<?php require_once('../../../../../Connections/comercioexterior.php'); ?>
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

$colname_DetailRS1 = "1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM oppre nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="shortcut icon" href="../../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Carta Aviso Cuota</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
<link href="../../../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../../imagenes/barraweb/animated_favicon1.gif">
<body>
<table width="90%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle"><img src="../../../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61"></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="middle" class="NegrillaCartaReparo">
      Departamento Pr&eacute;stamos</div>
    </div></td>
  </tr>
  <tr>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['fecha_pago']; ?></td>
  </tr>
</table>
<br>
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
    <td width="29%" align="left" valign="middle">Ref.: <span class="NegrillaCartaReparo"><?php echo strtoupper($row_DetailRS1['nro_operacion']); ?></span></td>
  </tr>
</table>
<br>
<table width="90%"  border="0" align="center">
  <tr>
    <td colspan="5" align="left" valign="middle">Estimado Cliente:</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">De acuerdo a lo solicitado por Ud. hemos efectuado Pago de Prestamo de acuerdo al siguiente detalle:</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td width="24%" align="left" valign="middle">Saldo Antes del Pago</td>
    <td width="2%" align="center" valign="middle"> :</td>
    <td width="74%" colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_saldo_insoluto']; ?></span> <span class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['saldo_insoluto'], 2, ',', '.'); ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Valor Cuota Capital</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_valor_cuota']; ?></span> <span class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['valor_cuota'], 2, ',', '.'); ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Intereses</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle"><span class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_intereses']; ?></span> <span class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['intereses'], 2, ',', '.'); ?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Impuestos</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo">CLP <?php echo number_format($row_DetailRS1['impuestos'], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Comisiones</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['moneda_comisiones']; ?> <?php echo number_format($row_DetailRS1['comisiones'], 0, ',', '.'); ?></td>
  </tr>
  <tr>
    <td align="left" valign="middle">T/C</td>
    <td align="center" valign="middle">:</td>
    <td colspan="3" align="left" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['tipo_cambio'], 2, ',', '.'); ?></td>
  </tr>
</table>
<br>
<table width="90%"  border="0" align="center">
  <tr>
    <td width="24%" align="left" valign="middle">Cargo Cta Cte M/N</td>
    <td width="2%" align="center" valign="middle">:</td>
    <td width="20%" align="center" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['cta_cte_mn']; ?></td>
    <td width="27%" align="right" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['importe_cta_cte_mn'], 2, ',', '.'); ?></td>
    <td width="27%" align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle">Cargo Cta Cte M/X</td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['cta_cte_mx']; ?></td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['importe_cta_cte_mx'], 2, ',', '.'); ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="MsoNormal Estilo14">
      <st1:PersonName ProductID="LA SOLUCI&Oacute;N DEL" w:st="on">Cheque</st1:PersonName>
    </span></td>
    <td align="center" valign="middle">:</td>
    <td align="center" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['cheque_otro']; ?></td>
    <td align="right" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['importe_cheque'], 2, ',', '.'); ?></td>
    <td align="left" valign="middle" class="NegrillaCartaReparo">&nbsp;</td>
  </tr>
</table>
<br>
<table width="90%"  border="0" align="center">
  <tr>
    <td height="22" colspan="4" align="center" valign="middle" class="NegrillaCartaReparo">Detalle intereses</td>
  </tr>
  <tr>
    <td width="26%" height="22" align="center" valign="middle">Fecha Desde</td>
    <td height="22" align="center" valign="middle">Fecha Hasta</td>
    <td width="18%" height="22" align="center" valign="middle">Tasa</td>
    <td width="30%" align="center" valign="middle">Monto Inter&eacute;s</td>
  </tr>
  <tr>
    <td align="center" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['fecha_desde']; ?></td>
    <td align="center" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['fecha_hasta']; ?></td>
    <td align="center" valign="middle" class="NegrillaCartaReparo"><?php echo $row_DetailRS1['tasa']; ?></td>
    <td align="center" valign="middle" class="NegrillaCartaReparo"><?php echo number_format($row_DetailRS1['intereses'], 2, ',', '.'); ?></td>
  </tr>
  <tr>
    <td height="22" colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle">Observaci&oacute;n:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['obs_avisopago']; ?></td>
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
    <td colspan="4" align="center" valign="middle"><SPAN class=265052114-13052009 Estilo15><strong>Departamento Pr&eacute;stamos</strong></SPAN>
      </div></td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left" valign="middle">&nbsp;</td>
  </tr>
</table>
<script> 
window.print(); 
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>