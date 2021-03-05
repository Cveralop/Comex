<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
  session_start();
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
$query_DetailRS1 = sprintf("SELECT convenioweb.*,(usuarios.nombre)as ne FROM convenioweb, usuarios WHERE convenioweb.id = %s and (convenioweb.especialista_curse = usuarios.usuario)", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Carta Reparo Convenio WEB</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #000;
	font-weight: bold;
}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body>
<table width="90%"  border="0" align="center">
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/JPEG/logo_carta.jpg" alt="" width="190" height="65" /></td>
  </tr>
  <tr>
    <td width="100%" align="left" valign="middle" class="NegrillaCartaReparo"> Departamento Control Contable</td>
  </tr>
  <tr>
    <td align="right" valign="middle"><?php
setlocale(LC_TIME,'sp'); 
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
    <td align="left" valign="middle"> Especialista Comercio Exterior</td>
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
    <td width="82%" align="left" class="Estilo10"><span class="Estilo12">Aviso de reparo. </span></td>
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
    <td align="left" class="Estilo10"><span class="Estilo12"><strong><?php echo strtoupper($row_DetailRS1['moneda_pagare']); ?></strong> <strong><?php echo number_format($row_DetailRS1['monto_pagare'], 2, ',', '.'); ?></strong></span></td>
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
    <td align="left" valign="middle"><p align="justify">Detalle de Observaciones:</p></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><p><?php echo $row_DetailRS1['obs_reparo']; ?></p></td>
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
      <st1:PersonName ProductID="LA SOLUCIÓN DEL" w:st="on"><span class="Estilo13">Nota: La soluci&oacute;n del reparo debe ser ingresada por conducto regular, no se considerar&aacute;n instrucciones v&iacute;a mail.</span></st1:PersonName>
      <o:p></o:p>
      </span>
      </div></td>
  </tr>
  <tr>
    <td height="22" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle"><strong>Banco Santander</strong>
      </div></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><span class="265052114-13052009" estilo15="Estilo15"><strong>Departamento Control Contable</strong></span></td>
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
    <td align="left" valign="middle"><span class="Estilo8"><span class="Negrillapequeno">CC: <?php echo $_SESSION['login'];?></span></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle">ESP: <?php echo strtoupper($row_DetailRS1['ne']); ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>