<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "TER,ADM";
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<script> 
window.print(); 
</script>
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Impresi&oacute;n - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
}
a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.Estilo10 {	font-size: 16px;
	font-weight: bold;
}
.Estilo12 {font-size: 14px; font-weight: bold; }
.Estilo9 {font-size: 24px; font-weight: bold; }
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
</head>
<body>
<table width="95%"  border="0" align="center">
  <tr>
    <td valign="middle"><img src="../../../imagenes/JPEG/logo_carta.JPG" width="219" height="61" align="left"></div>      </div></td>
  </tr>
  <tr>
    <td align="right" valign="middle"><strong>
      <?php
setlocale(LC_TIME,'sp'); 
echo strftime("Santiago, %d de %B de %Y");?>
    </strong></td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle" class="Estilo9">CAMBIOS - CREDITOS IIIB5</td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle"><?php if ($row_DetailRS1['especialista'] > $row_fuerahorario['fuera_horario']) { // Show if not first page ?>
      <span class="FueraHorario"><span class="Estilo13" >Operaci�n Ingresada FUERA DE HORARIO </span></span>
    <?php } // Show if not first page ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center" valign="middle"><?php if ($row_excepciones['plazo'] > 0) { // Show if not first page ?>
      <span class="FueraHorario"><span class="Estilo13" >Usted tiene Excepcion(es) Vencida(s) </span></span>
    <?php } // Show if not first page ?></td>
  </tr>
</table>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="controlop.php"><img src="../../../imagenes/Botones/boton_volver_1.jpg" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><strong>Comprobante de Ingreso Instrucci&oacute;n Cliente </strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">No. Folio:</div></td>
    <td align="center" valign="middle"><strong><?php echo $row_DetailRS1['id']; ?></strong></td>
    <td align="right" valign="middle">Nro Folio Caratula:</td>
    <td align="center" valign="middle"><strong><?php echo $row_DetailRS1['nro_folio']; ?></strong></td>
  </tr>
  <tr>
    <td width="20%" align="right" valign="middle">Rut Cliente:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo $row_DetailRS1['rut_cliente']; ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre Cliente:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo $row_DetailRS1['nombre_cliente']; ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Fecha Ingreso:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo $row_DetailRS1['date_espe']; ?></strong></div></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
  <td colspan="3" align="left" valign="middle"><strong><?php echo $row_DetailRS1['nro_operacion']; ?></strong></div>
        </div></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Evento:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo $row_DetailRS1['evento']; ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Especialista:</div></td>
    <td colspan="3" align="left" valign="middle" class="Estilo12"><?php echo $row_DetailRS1['territorial']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Obsevaciones:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Moneda / Monto Operaci&oacute;n:</div></td>
    <td colspan="3" align="left" valign="middle"><strong><?php echo $row_DetailRS1['moneda_operacion']; ?>&nbsp;<?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Urgente:</div></td>
    <td colspan="3" align="left" valign="middle" class="Estilo12"><?php echo $row_DetailRS1['urgente']; ?></td>
  </tr>
</table>
<br>
  <br>
  <br>
  <br>
  <table width="50%" border="0" align="center">
    <tr>
      <td class="Estilo12"><?php echo $row_DetailRS1['ne']; ?></td>
    </tr>
  </table>
<br>
  <table width="95%" border="0" align="center">
    <tr>
      <td><span class="centrado">_____________________________________</span></td>
    </tr>
    <tr>
      <td><span class="centrado"><strong>FIRMA ESPECIALISTA</strong></span></td>
    </tr>
  </table>
  <br>
<span class="centrado"><br>
</span><br>
</div>
</body>
</html><?php
mysqli_free_result($fuerahorario);
mysqli_free_result($excepciones);
mysqli_free_result($DetailRS1);
?>