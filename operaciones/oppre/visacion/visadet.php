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

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores nolock";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS2 = "SELECT pagareparagua.* FROM oppre INNER JOIN pagareparagua ON oppre.rut_cliente=pagareparagua.rut_cliente WHERE oppre.id = $recordID";
$query_limit_DetailRS2 = sprintf("%s LIMIT %d, %d", $query_DetailRS2, $startRow_DetailRS2, $maxRows_DetailRS2);
$DetailRS2 = mysqli_query($comercioexterior, $query_limit_DetailRS2, ) or die(mysqli_error($comercioexterior));
$row_DetailRS2 = mysqli_fetch_assoc($DetailRS2);

$colname1_excepciones = "Si";
if (isset($_GET['excepcion'])) {
  $colname1_excepciones = $_GET['excepcion'];
}
$colname_excepciones = "-1";
if (isset($_SESSION['espe_curse'])) {
  $colname_excepciones = $_SESSION['espe_curse'];
}
$colname2_excepciones = "Pendiente.";
if (isset($_GET['estado_excepcion'])) {
  $colname2_excepciones = $_GET['estado_excepcion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_excepciones = sprintf("SELECT *,timestampdiff(day,solucion_excepcion,current_timestamp)as dias FROM oppre nolock WHERE especialista_curse = %s and excepcion = %s and estado_excepcion = %s", GetSQLValueString($colname_excepciones, "text"),GetSQLValueString($colname1_excepciones, "text"),GetSQLValueString($colname2_excepciones, "text"));
$excepciones = mysqli_query($comercioexterior, $query_excepciones) or die(mysqli_error($comercioexterior));
$row_excepciones = mysqli_fetch_assoc($excepciones);
$totalRows_excepciones = mysqli_num_rows($excepciones);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE oppre SET evento=%s, estado=%s, asignador=%s, operador=%s, nro_operacion=%s, nro_operacion_relacionada=%s, obs=%s, moneda_operacion=%s, monto_operacion=%s, nro_cuotas=%s, sub_estado=%s, date_visa=%s, date_asig=%s, reparo_obs=%s, estado_visacion=%s, visador=%s, mandato=%s, excepcion=%s, autorizacion_operaciones=%s, autorizacion_especialista=%s, responsable_excepcion=%s, tipo_excepcion=%s, solucion_excepcion=%s, urgente=%s, fuera_horario=%s WHERE id=%s",
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['nro_cuotas'], "int"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['excepcion'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especialista'], "text"),
                       GetSQLValueString($_POST['responsable_excepcion'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['solucion_excepcion'], "date"),
                       GetSQLValueString($_POST['urgente'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "visamae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Visaci&oacute;n -  Detalle</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo5 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {
	font-size: 16px;
	color: #FF0000;
	font-weight: bold;
}
.Estilo7 {font-size: 14px}
.Estilo8 {font-size: 14px}
-->
</style>
<script src="../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
<link href="../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<?php $_SESSION['espe_curse']=$row_DetailRS1['especialista_curse']; ?>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">VISACI&Oacute;N - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="visamae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a>
      </div></td>
  </tr>
</table>
<br>
<form name="form2" method="post" action="">
  <?php if ($totalRows_DetailRS2 > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="9" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulo_menu">PAGARE PARAGUA - VISACI&Oacute;N</span></td>
    </tr>
    <tr valign="middle" bgcolor="#999999">
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Tipo Documentos</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Pagar&eacute;</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Moneda / Monto Convenio</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 1</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 2</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 3</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Aval 4</td>
    </tr>
    <?php do { ?>
      <tr valign="middle">
        <td align="center" valign="middle"><?php echo $row_DetailRS2['estado']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><span class="rojopequeno"><?php echo $row_DetailRS2['doc1']; ?></span> / <span class="rojopequeno"><?php echo $row_DetailRS2['doc2']; ?></span> / <span class="rojopequeno"><?php echo $row_DetailRS2['doc3']; ?></span> / <span class="rojopequeno"><?php echo $row_DetailRS2['doc4']; ?></span> / <span class="rojopequeno"><?php echo $row_DetailRS2['doc5']; ?></span></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo strtoupper($row_DetailRS2['rut_cliente']); ?></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS2['moneda_pagare']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_DetailRS2['monto_pagare'], 2, ',', '.'); ?></span></td>
        <td align="right" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS2['moneda_convenio']; ?></span> <span class="respuestacolumna_azul"><?php echo number_format($row_DetailRS2['monto_convenio'], 2, ',', '.'); ?></span></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS2['aval_rut_1']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS2['aval_rut_2']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS2['aval_rut_3']); ?></td>
        <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS2['aval_rut_4']); ?></td>
        <?php } while ($row_DetailRS2 = mysqli_fetch_assoc($DetailRS2)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</form>
<br>
<?php if ($totalRows_DetailRS2 == 0) { // Show if recordset empty ?>
  <table width="95%" border="0" align="center">
    <tr>
      <td align="left" valign="middle" class="NegrillaCartaReparo">No existe pagare paragua ingresado para este cliente</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
<br>
<?php if ($totalRows_excepciones > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="7" align="left" valign="middle" bgcolor="#999999" class="titulocolumnas"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulo_menu">EXCEPCIONES VIGENTES</span></td>
    </tr>
    <tr valign="middle" bgcolor="#999999">
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nro Operaci&oacute;n</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Solucion Excepcion</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Dias</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista</td>
    </tr>
    <?php do { ?>
      <tr valign="middle">
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_excepciones['rut_cliente']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_excepciones['nombre_cliente']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_excepciones['nro_operacion']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_excepciones['solucion_excepcion']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_excepciones['dias']; ?></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC"><?php if ($row_excepciones['dias'] > 0) { // Show if not first page ?>
          <span class="respuestacolumna">Fuera de Plazo</span>
          <?php } // Show if not first page ?>
          <?php if ($row_excepciones['dias'] <= 0 ) { // Show if not first page ?>
          <span class="respuestacolumna">En Plazo</span>
          <?php } // Show if not first page ?>
          </span></td>
        <td align="center" valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo"><?php echo $row_excepciones['especialista_curse']; ?></td>
        <?php } while ($row_excepciones = mysqli_fetch_assoc($excepciones)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br>
<?php if ($totalRows_excepciones == 0) { // Show if recordset empty ?>
  <table width="95%" border="0" align="center">
    <tr>
      <td align="left" valign="middle" class="NegrillaCartaReparo">No existen excepciones pendientes para este cliente</td>
    </tr>
  </table>
  <?php } // Show if recordset empty ?>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../../certificado_matrimonio/consulta_certifi_matri.php" target="_blank"><img src="../../../imagenes/Botones/ver_avales.jpg" alt="" width="80" height="25" border="0" align="middle"></a></td>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Visaci&oacute;n Operaci&oacute;n</div>
      </span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Registro:</td>
      <td align="center" valign="middle"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>        </div></td>
      <td align="right" valign="middle">Rut Cliente:</div></td>
      <td align="center" valign="middle">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="12" readonly>
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle">
        <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10" readonly>
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="center" valign="middle">        <select name="evento" class="etiqueta12" id="evento">
        <option value="Apertura." <?php if (!(strcmp("Apertura.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura</option>
        <option value="Prorroga." <?php if (!(strcmp("Prorroga.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga</option>
        <option value="Prorroga y Pago." <?php if (!(strcmp("Prorroga y Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga y Pago</option>
  <option value="Cambio Tasa." <?php if (!(strcmp("Cambio Tasa.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Cambio Tasa</option>
        <option value="Pago." <?php if (!(strcmp("Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago</option>
        <option value="Visacion." <?php if (!(strcmp("Visacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Visacion (DI)</option>
        <option value="Cartera Vencida." <?php if (!(strcmp("Cartera Vencida.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Cartera Vencida</option>
        <option value="Carta Original." <?php if (!(strcmp("Carta Original.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Carta Original</option>
        <option value="Requerimiento." <?php if (!(strcmp("Requerimiento.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Requerimiento</option>
        <option value="Solucion Excepcion." <?php if (!(strcmp("Solucion Excepcion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Solucion Excepcion</option>
  <option value="Dev Comisiones." <?php if (!(strcmp("Dev Comisiones.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Dev Comisiones</option>
        <option value="Tecnica." <?php if (!(strcmp("Tecnica.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Tecnica</option>
        <option value="Mandato PAC." <?php if (!(strcmp("Mandato PAC.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Mandato PAC</option>
        <option value="Restructuracion." <?php if (!(strcmp("Restructuracion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Restructuracion</option>
        <option value="Redenominacion." <?php if (!(strcmp("Redenominacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Redenominacion</option>
        </select>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Operador:</td>
      <td colspan="3" align="left" valign="middle"><select name="operador" class="etiqueta12" id="operador">
        <option value="0" selected>Seleccion un Operador</option>
        <option value="MTOROB">Veronica Toro</option>
        <option value="SCHAVEZ">Sebastian Chavez Vasquez</option>
        <option value="FFARINAS">Francisco Farinas</option>
        <option value="CLEYTON">Carlos Leyton Gatica</option>
        <option value="FMUNOZ">Felipe Munoz Perez </option>
        <option value="KAGUIRRE">Katherine Aguirre</option>
        <option value="CZAMBRAN">Cynthia Zambrano Leiva</option>
        <option value="JCASTILL">Javiera Castillo Mena</option>
        <option value="IVARGAS">Ives Vargas Perez</option>
        <option value="IIBACET">Ingrid Ibaceta Vidal</option>
        <option value="PPRE1">Practica PRE 1</option>
        <option value="PPRE2">Practica PRE 2</option>
        <option value="PPRE3">Practica PRE 3</option>
        <option value="ROBOT1">Robot 1</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Observaciones:</div></td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno"><span id="countsprytextarea1">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td align="center" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">
      <span class="rojopequeno">F &oacute; K000000 </span><span class="etiqueta12">/
<input name="nro_operacion_relacionada" type="text" class="etiqueta12" id="nro_operacion_relacionada" value="<?php echo $row_DetailRS1['nro_operacion_relacionada']; ?>" size="15" maxlength="7">
      </span><span class="rojopequeno">      L000000</span></td>
      <td align="right" valign="middle">Mandato:</td>
      <td align="center" valign="middle"><input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS1['mandato']; ?>"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Moneda / <br>
      Monto Operaci&oacute;n:</td>
      <td align="center" valign="middle">
              <select name="moneda_operacion" class="etiqueta12" id="moneda_operacion">
                <option value="CLP" <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CLP</option>
                <option value="DKK" <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>DKK</option>
                <option value="NOK" <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>NOK</option>
                <option value="SEK" <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>SEK</option>
                <option value="USD" <?php if (!(strcmp("USD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>USD</option>
                <option value="CAD" <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CAD</option>
                <option value="AUD" <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>AUD</option>
                <option value="HKD" <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>HKD</option>
                <option value="EUR" <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>EUR</option>
                <option value="CHF" <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>CHF</option>
                <option value="GBP" <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>GBP</option>
                <option value="ZAR" <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>ZAR</option>
                <option value="JPY" <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_operacion']))) {echo "SELECTED";} ?>>JPY</option>
              </select> 
              <span class="rojopequeno">/</span>        
            <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15">
      </div></td>
      <td align="right" valign="middle">       Nro Cuotas:</div></td>
      <td align="center" valign="middle"><span id="sprytextfield3">
      <label>
        <input name="nro_cuotas" type="text" class="etiqueta12" id="nro_cuotas" value="<?php echo $row_DetailRS1['nro_cuotas']; ?>" size="6" maxlength="3">
      </label>
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span><span class="textfieldMinCharsMsg">No se cumple el m&iacute;nimo de caracteres requerido.</span><span class="textfieldMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al m&aacute;ximo permitido.</span><span class="textfieldMinValueMsg"><span class="rojopequeno">El valor introducido es inferior al m&iacute;nimo permitido.</span></span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Urgente:</td>
      <td align="center" valign="middle"><label>
        <input <?php if (!(strcmp($row_DetailRS1['urgente'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="urgente" value="Si">
        Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['urgente'],"No"))) {echo "checked=\"checked\"";} ?> name="urgente" type="radio" value="No">
          No</label>
      </div></td>
      <td align="right" valign="middle">Fuera Horario:</div></td>
      <td align="center" valign="middle"><label>
        <input type="radio" name="fuera_horario" value="Si">
        Si</label>
        <label>
          <input name="fuera_horario" type="radio" value="No" checked>
      No</label></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulodetalle">Excepci&oacute;n Operaci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td rowspan="3" align="right" valign="middle">Excepci&oacute;n:</td>
      <td rowspan="3" align="center" valign="middle"><label>
        <input type="radio" name="excepcion" value="Si">
        Si</label>
        <label>
          <input name="excepcion" type="radio" value="No" checked>
      No</label></td>
      <td align="right" valign="middle">Auto. Opera.:</div></td>
      <td align="center" valign="middle">
        <input name="autorizacion_operaciones" type="text" class="etiqueta12" size="30" maxlength="50">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Auto. Espe.:</td>
      <td align="center" valign="middle"><input name="autorizacion_especialista" type="text" class="etiqueta12" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Resp. Excepci&oacute;n:</td>
      <td align="center" valign="middle"></div>
        <label for="responsable_excepcion"></label>
      <input name="responsable_excepcion" type="text" class="etiqueta12" id="responsable_excepcion" size="30" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Tipo Excepci&oacute;n:</td>
      <td align="center" valign="middle"><select name="tipo_excepcion" class="etiqueta12" id="tipo_excepcion">
        <option value="N/A." selected>N/A</option>
        <option value="Sin Mandato.">Sin Mandato</option>
        <option value="Sin DI.">Sin DI</option>
        <option value="Sin Declaracion Jurada.">Sin Declaraci&oacute;n Jurada</option>
        <option value="Declaracion Jurada es Copia.">Declaracion Jurada es Copia</option>
        <option value="Carta Solicitud en Fotocopia.">Carta Solicitud en Fotocopia</option>
        <option value="Articulo 85 Vencido.">Articulo 85 Vencido</option>
        <option value="Linea Sobregirada.">Linea Sobregirada</option>
        <option value="Pagare.">Pagare</option>
</select></td>
      <td align="right" valign="middle">Solucion Excepcion:</div></td>
      <td align="center" valign="middle"><span id="sprytextfield1">
        <input name="solucion_excepcion" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span class="titulodetalle">Reparo</span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Estado Visaci&oacute;n:</div></td>
      <td colspan="3" align="left" valign="middle"><label>
        <input name="estado" type="radio" id="estado_0" value="Pendiente." checked>
        Enviada a Curse</label>
        <label>
          <input name="estado" type="radio" class="respuestacolumna_rojo" id="estado_1" value="Reparada.">
        <span class="respuestacolumna_rojo">Reparada</span></label>
        <br>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Observaci&oacute;n Reparo:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea2">
        <textarea name="reparo_obs" cols="80" rows="6" class="etiqueta12" id="reparo_obs"></textarea>
      <span class="rojopequeno"><span id="countsprytextarea2">&nbsp;</span></span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></div></td>
    </tr>
    <tr valign="middle">
      <td colspan="4" align="center" valign="middle">
          <input type="submit" class="boton" value="Visar Operaci&oacute;n">
      </div>        </div>        </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="date_visa" type="hidden" id="date_visa" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Cursada.">
  <input name="visador" type="hidden" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="visamae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
/*<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:450, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "integer", {validateOn:["blur"], minChars:1, maxChars:3, maxValue:999, minValue:1});
//-->*/
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($colores);
mysqli_free_result($DetailRS2);
mysqli_free_result($excepciones);
?>