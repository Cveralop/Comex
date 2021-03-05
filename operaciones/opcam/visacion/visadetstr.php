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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opstr SET evento=%s, fecha_curse=%s, date_curse=%s, asignador=%s, operador=%s, nro_operacion=%s, obs=%s, especialista=%s, moneda_operacion=%s, monto_operacion=%s, banco=%s, rut_banco=%s, pais=%s, referencia=%s, tipo_operacion=%s, folio_boleta=%s, estado_comision=%s, vcto_operacion=%s, otros_ben=%s, ordenante=%s, plazo=%s, gastos=%s, vcto_boleta=%s, responsabilidad=%s, moneda_contra=%s, monto_contra=%s, periodisidad=%s, sub_estado=%s, date_visa=%s, date_asig=%s, date_oper=%s, reparo_obs=%s, estado_visacion=%s, visador=%s, mandato=%s, excepcion=%s, excepcion_comision=%s, autorizacion_operaciones=%s, autorizacion_especialista=%s, responsable_excepcion=%s, solucion_excepcion=%s, urgente=%s, fuera_horario=%s WHERE id=%s",
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['fecha_curse'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['banco'], "text"),
                       GetSQLValueString($_POST['rut_banco'], "text"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($_POST['referencia'], "text"),
                       GetSQLValueString($_POST['tipo_operacion'], "text"),
                       GetSQLValueString($_POST['folio_boleta'], "text"),
                       GetSQLValueString($_POST['estado_comision'], "text"),
                       GetSQLValueString($_POST['vcto_operacion'], "date"),
                       GetSQLValueString($_POST['otros_ben'], "text"),
                       GetSQLValueString($_POST['ordenante'], "text"),
                       GetSQLValueString($_POST['plazo'], "text"),
                       GetSQLValueString($_POST['gastos'], "text"),
                       GetSQLValueString($_POST['vcto_boleta'], "date"),
                       GetSQLValueString($_POST['responsabilidad'], "text"),
                       GetSQLValueString($_POST['moneda_contra'], "text"),
                       GetSQLValueString($_POST['monto_contra'], "double"),
                       GetSQLValueString($_POST['periodisidad'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['excepcion'], "text"),
                       GetSQLValueString($_POST['excepcion_comision'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especialista'], "text"),
                       GetSQLValueString($_POST['responsable_excepcion'], "text"),
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
$colname_DetailRS1 = "1";
if (isset($_GET['id'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opstr WHERE id = %s", $colname_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = "SELECT * FROM opstr WHERE id = $recordID";
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
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
<script language="JavaScript" type="text/JavaScript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
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
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">VISACI&Oacute;N - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIOS - STAND BY RECIBIDAS</td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../../certificado_matrimonio/consulta_certifi_matri.php" target="_blank"><img src="../../../imagenes/Botones/ver_avales.jpg" alt="" width="80" height="25" border="0" align="middle"></a></td>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="6" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulodetalle">Visaci&oacute;n Operaci&oacute;n</div>
      </span></td>
    </tr>
    <tr valign="baseline">
      <td width="19%" align="right" valign="middle">Nro Registro: </td>
      <td width="33%" align="center" valign="middle"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>        </div></td>
      <td width="12%" align="right" valign="middle">Rut Cliente:</div></td>
      <td width="36%" colspan="3" align="center" valign="middle">
        <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="12" readonly="readonly">
        <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="5" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120" readonly="readonly"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle">
        <input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10" readonly="readonly">
        <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Evento:</div></td>
      <td colspan="3" align="center" valign="middle">        
        <select name="evento" class="etiqueta12" id="evento">
          <option value="Apertura." <?php if (!(strcmp("Apertura.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura</option>
          <option value="Modificacion." <?php if (!(strcmp("Modificacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Modificacion</option>
          <option value="MSG-Swift." <?php if (!(strcmp("MSG-Swift.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>MSG-Swift</option>
          <option value="Anulacion." <?php if (!(strcmp("Anulacion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Anulacion</option>
          <option value="Pago." <?php if (!(strcmp("Pago.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago</option>
          <option value="Pago Comision." <?php if (!(strcmp("Pago Comision.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago Comision</option>
          <option value="Aviso Vcto." <?php if (!(strcmp("Aviso Vcto.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Aviso Vcto</option>
          <option value="Nota de Cobro." <?php if (!(strcmp("Nota de Cobro.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Nota de Cobro</option>
          <option value="Carta Original." <?php if (!(strcmp("Carta Original.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Carta Original</option>
          <option value="Requerimiento." <?php if (!(strcmp("Requerimiento.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Requerimiento</option>
          <option value="Solucion Excepcion." <?php if (!(strcmp("Solucion Excepcion.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Solucion Excepcion</option>
          <option value="Dev Comisiones." <?php if (!(strcmp("Dev Comisiones.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Dev comisiones</option>
        </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</td>
      <td align="center" valign="middle"><span id="sprytextfield2">
      <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="20" maxlength="20">
      <span class="textfieldRequiredMsg"><span class="rojopequeno">Se necesita un valor.</span></span><span class="textfieldMinCharsMsg">No se cumple el m�nimo de caracteres requerido.</span></span>        </div></td>
      <td align="right" valign="middle">Especialista:</div></td>
      <td align="center" valign="middle">
        <input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista_curse']; ?>" size="20" maxlength="50">
      </div></td>
      <td align="right" valign="middle">Tipo Operaci&oacute;n:</div></td>
      <td align="center" valign="middle">
        <select name="tipo_operacion" class="etiqueta12" id="tipo_operacion">
          <option value="Avisaje." <?php if (!(strcmp("Avisaje.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Avisaje</option>
          <option value="Confirmada." <?php if (!(strcmp("Confirmada.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Confirmada</option>
          <option value="Facilidad Crediticia." <?php if (!(strcmp("Facilidad Crediticia.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Facilidad Crediticia</option>
          <option value="Boleta Garantia." <?php if (!(strcmp("Boleta Garantia.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Boleta Garantia</option>
          <option value="Enterada en Efectivo." <?php if (!(strcmp("Enterada en Efectivo.", $row_DetailRS1['tipo_operacion']))) {echo "SELECTED";} ?>>Enterada en Efectivo</option>
        </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observaci&oacute;n:</div></td>
      <td colspan="5" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Moneda / <br>
      Monto Operaci&oacute;n:</td>
      <td align="center" valign="middle"><label>
        <input name="moneda_operacion" type="text" class="etiqueta12" id="moneda_operacion" value="<?php echo $row_DetailRS1['moneda_operacion']; ?>" size="5" maxlength="5">
      </label>
        <span class="rojopequeno">/</span>        
          <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15">
      </div></td>
      <td rowspan="2" align="right" valign="middle">Visador:</div></td>
      <td colspan="3" rowspan="2" align="center" valign="middle">
          <input name="visador" type="text" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20">
        </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Urgente:</td>
      <td align="center" valign="middle"><label>
        <input <?php if (!(strcmp($row_DetailRS1['urgente'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="urgente" value="Si">
        Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['urgente'],"No"))) {echo "checked=\"checked\"";} ?> name="urgente" type="radio" value="No">
          No</label>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span class="titulodetalle">Excepciones Operaci&oacute;n</span></td>
    </tr>
    <tr valign="baseline">
      <td rowspan="3" align="right" valign="middle">Excepci&oacute;n:</div></td>
      <td rowspan="3" align="center" valign="middle"><label>          <input type="radio" name="excepcion" value="Si">
  Si</label>
          <label>
          <input name="excepcion" type="radio" value="No" checked>
  No</label>
      </div>        
      </div></td>
      <td align="right" valign="middle">Auto. Opera.:</td>
      <td colspan="3" align="center" valign="middle">
        <input name="autorizacion_operaciones" type="text" class="etiqueta12" size="30" maxlength="50">
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Auto. Espe.:</td>
      <td colspan="3" align="center" valign="middle"><input name="autorizacion_especialista" type="text" class="etiqueta12" size="30" maxlength="50"></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Resp. Excepci&oacute;n:</td>
      <td colspan="3" align="center" valign="middle"><label for="responsable_excepcion"></label>
      <input name="responsable_excepcion" type="text" class="etiqueta12" id="responsable_excepcion" size="30" maxlength="50">        </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Tipo Excepci&oacute;n:</td>
      <td colspan="5" align="left" valign="middle">
        <select name="tipo_excepcion" class="etiqueta12" id="tipo_excepcion">
          <option value="N/A." selected>N/A</option>
            <option value="Art 85 Vencido.">Art 85 Vencido</option>
            <option value="Linea de Credito sobregirada.">Linea de Credito sobregirada</option>
            <option value="Falta Autorizacion de Riesgos.">Falta Autorizacion de Riesgos</option>
            <option value="Aprobaci&oacute;o puntual de Riesgos no incluye tolerancia.">Aprobacion puntual de Riesgos no incluye tolerancia</option>
            <option value="Falta minuta de Credito.">Falta minuta de Credito</option>
            <option value="Firma disconforme.">Firma disconforme</option>
            <option value="Falta VB&ordm; poderes y firmas.">Falta VB&ordm; poderes y firmas</option>
            <option value="Falta mail Sucursal por pagare en custodia.">Falta mail Sucursal por pagare en custodia</option>
            <option value="Pagare sin llenar.">Pagare sin llenar</option>
            <option value="Pagare no corresponde.">Pagare no corresponde</option>
            <option value="Pagare version antigua.">Pagare version antigua</option>
            <option value="Falta pagare para aumento de valor de operacion.">Falta pagare para aumento de valor de operacion</option>
            <option value="Falta informe de fiscalia para avales sociedad anonima.">Falta informe de fiscalia para avales sociedad anonima</option>
            <option value="Avales no corresponde en pagare seg&uacute;n lo solicitado por riesgo.">Avales no corresponde en pagare seg&uacute;n lo solicitado por riesgo</option>
            <option value="Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos.">Certificado de matrimonio avales vencidos o no se encuentra en nuestros archivos</option>
            <option value="Falta constitucion de garantias.">Falta constitucion de garantias</option>
</select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Solucion Excepcion:</td>
      <td align="center" valign="middle"><span id="sprytextfield1">
      <input name="solucion_excepcion" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10">
      <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no v�lido.</span></span></td>
      <td align="right" valign="middle">Mandato:</td>
      <td align="center" valign="middle"><input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS1['mandato']; ?>" size="30" maxlength="25" readonly="readonly"></td>
      <td align="right" valign="middle">Excepci&oacute;n Comision:</td>
      <td align="center" valign="middle"><label>
        <input type="radio" name="excepcion_comision" value="Si" id="excepcion_comision_0">
        Si</label>
        <label>
          <input name="excepcion_comision" type="radio" id="excepcion_comision_1" value="No" checked>
      No</label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Estado Visaci&oacute;n:</div></td>
      <td align="center" valign="middle">
      <span class="Estilo8">
      <select name="estado" class="etiqueta12" id="estado">
        <option value="Cursada." selected>Cursada</option>
        <option value="Reparada.">Reparada</option>
      </select>
</span></td>
      <td align="right" valign="middle">Fuera Horario:</div></td>
      <td colspan="3" align="center" valign="middle">        
          <label>
          <input <?php if (!(strcmp($row_DetailRS1['fuera_horario'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="fuera_horario" value="Si">
  Si</label>
          <label>
          <input <?php if (!(strcmp($row_DetailRS1['fuera_horario'],"No"))) {echo "checked=\"checked\"";} ?> name="fuera_horario" type="radio" value="No">
No</label>
          <br>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observaci&oacute;n Reparo:</td>
      <td colspan="5" align="left" valign="middle"><span id="sprytextarea2">
        <textarea name="reparo_obs" cols="80" rows="6" class="etiqueta12" id="reparo_obs"></textarea>
      <span class="rojopequeno" id="countsprytextarea2">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="left" valign="middle" bgcolor="#999999" class="Estilo5"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21">Cursar Operaci&oacute;n</td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Vcto Operaci&oacute;n:</td>
      <td align="center" valign="middle"><input name="vcto_operacion" type="text" class="etiqueta12" id="vcto_operacion" value="0000-00-00" size="12" maxlength="10">
      <span class="rojopequeno">(aaaa-mm-dd)</span></td>
      <td align="right" valign="middle">Vcto Boleta:</td>
      <td align="center" valign="middle"><span class="rojopequeno">
        <input name="vcto_boleta" type="text" class="etiqueta12" id="vcto_boleta" value="0000-00-00" size="12" maxlength="10">
(aaaa-mm-dd)</span></td>
      <td align="right" valign="middle">Periodisidad:</td>
      <td align="center" valign="middle"><span class="rojopequeno">
        <select name="periodisidad" class="etiqueta12" id="periodisidad">
          <option value="0" selected>No Aplica</option>
          <option value="30">Mensual</option>
          <option value="60">Bimensual</option>
          <option value="90">Trimestral</option>
          <option value="120">Cuatrimestral</option>
          <option value="180">Semestral</option>
          <option value="360">Anual</option>
        </select>
      </span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Rut Beneficiario: </td>
      <td align="center" valign="middle"><input name="rut_banco" type="text" class="etiqueta12" id="rut_banco" value="<?php echo $row_DetailRS1['rut_banco']; ?>" size="15" maxlength="12">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
      <td align="right" valign="middle">Tipo Operaci&oacute;n:</td>
      <td align="center" valign="middle"><select name="tipo_operacion2" class="etiqueta12" id="tipo_operacion2">
        <option value="Avisaje." selected>Avisaje</option>
        <option value="Confirmada.">Confirmada</option>
        <option value="Facilidad Crediticia.">Facilidad Crediticia</option>
        <option value="Boleta Garantia.">Boleta Garantia</option>
      </select></td>
      <td align="right" valign="middle">Referencia:</td>
      <td align="center" valign="middle"><input name="referencia" type="text" class="etiqueta12" id="referencia" value="<?php echo $row_DetailRS1['referencia']; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre Beneficiario:</td>
      <td colspan="5" align="left" valign="middle"><input name="banco" type="text" class="etiqueta12" id="banco" value="<?php echo $row_DetailRS1['banco']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Folio Boleta:</td>
      <td align="center" valign="middle"><input name="folio_boleta" type="text" class="destadado" id="folio_boleta" size="15" maxlength="15"></td>
      <td align="right" valign="middle">Estado Comisi&oacute;n:</td>
      <td align="center" valign="middle"><select name="estado_comision" class="etiqueta12" id="estado_comision">
        <option value="Pendiente." selected>Pendiente</option>
        <option value="Pagada.">Pagada</option>
      </select></td>
      <td align="right" valign="middle">Contravalor / <br>
Monto Operaci&oacute;n:</td>
      <td align="center" valign="middle"><select name="moneda_contra" class="etiqueta12" id="moneda_contra">
        <option value="CLP">CLP</option>
        <option value="DKK">DKK</option>
        <option value="NOK">NOK</option>
        <option value="SEK">SEK</option>
        <option value="USD" selected>USD</option>
        <option value="CAD">CAD</option>
        <option value="AUD">AUD</option>
        <option value="HKD">HKD</option>
        <option value="EUR">EUR</option>
        <option value="CHF">CHF</option>
        <option value="GBP">GBP</option>
        <option value="ZAR">ZAR</option>
        <option value="JPY">JPY</option>
        <option value="FRS">FRS</option>
      </select>
        <span class="rojopequeno">/</span>
      <input name="monto_contra" type="text" class="etiqueta12" id="monto_contra" size="17" maxlength="15"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Pais de Origen:</td>
      <td colspan="2" align="center" valign="middle">
        <input name="pais" type="text" class="etiqueta12" id="pais" value="<?php echo $row_DetailRS1['pais']; ?>" size="20" maxlength="20">
      </div></td>
      <td colspan="2" align="right" valign="middle">Responsabilidad:</td>
      <td align="center" valign="middle">
        <label>
          <input type="radio" name="responsabilidad" value="Si.">
          Si</label>
        <label>
          <input type="radio" name="responsabilidad" value="No.">
          No</label>
        <br>
      </td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Otro Beneficiario:</td>
      <td colspan="5" align="left" valign="middle"><span id="sprytextarea3">
        <textarea name="otros_ben" cols="80" rows="4" class="etiqueta12"><?php echo $row_DetailRS1['otros_ben']; ?></textarea>
        <span class="rojopequeno" id="countsprytextarea3">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nombre  Ordenante:</td>
      <td colspan="5" align="left" valign="middle"><input name="ordenante" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['ordenante']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Plazo</td>
      <td colspan="2" align="center" valign="middle"><label>
        <input <?php if (!(strcmp($row_DetailRS1['plazo'],"(+1)"))) {echo "CHECKED";} ?> name="plazo" type="radio" class="etiqueta12" value="(+1)">
        + 1 a&ntilde;o</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['plazo'],"(-1)"))) {echo "CHECKED";} ?> name="plazo" type="radio" class="etiqueta12" value="(-1)">
          -1 a&ntilde;o</label></td>
      <td colspan="2" align="right" valign="middle">Gastos:</td>
      <td align="center" valign="middle"><label>
        <input <?php if (!(strcmp($row_DetailRS1['gastos'],"BEN"))) {echo "CHECKED";} ?> name="gastos" type="radio" class="etiqueta12" value="BEN">
        Beneficiario</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['gastos'],"OUR"))) {echo "CHECKED";} ?> name="gastos" type="radio" class="etiqueta12" value="OUR">
          Aplicante </label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="center" valign="middle"><input type="submit" class="boton" value="Visar / Cursar Operaci&oacute;n"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="date_visa" type="hidden" id="date_visa" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="estado_visacion" type="hidden" id="estado_visacion" value="Cursada.">
  <input name="operador" type="hidden" id="operador" value="<?php echo $_SESSION['login'];?>">
  <input name="date_curse" type="hidden" id="date_curse" value="<?php echo date("Y-m-d"); ?>">
  <input name="fecha_curse" type="hidden" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="visamae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {isRequired:false, minChars:0, maxChars:450, validateOn:["blur"], counterId:"countsprytextarea2", counterType:"chars_remaining"});
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea3", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {format:"yyyy-mm-dd", validateOn:["blur"]});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"], minChars:1});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
mysqli_free_result($colores);
?>