<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP";
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opcex SET estado=%s, fecha_curse=%s, date_curse=%s, nro_operacion=%s, nro_inscripcion=%s, obs=%s, beneficiario=%s, tipo_plazo=%s, tipo_tasa=%s, tipo_salida=%s, detalle_salida=%s, detalle_salida_otro=%s, sub_estado=%s, vi=%s, iteraciones=%s, date_supe=%s, estado_visacion=%s, mandato=%s, excepcion_comision=%s, fuera_horario=%s WHERE id=%s",
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha_curse'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_inscripcion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['beneficiario'], "text"),
                       GetSQLValueString($_POST['tipo_plazo'], "text"),
                       GetSQLValueString($_POST['tipo_tasa'], "text"),
                       GetSQLValueString($_POST['tipo_salida'], "text"),
                       GetSQLValueString($_POST['detalle_salida'], "text"),
                       GetSQLValueString($_POST['detalle_salida_otro'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['vi'], "text"),
                       GetSQLValueString($_POST['iteraciones'], "int"),
                       GetSQLValueString($_POST['date_supe'], "date"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['excepcion_comision'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "altamae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$colname_DetailRS1 = "-1";
if (isset($_GET['id'])) {
  $colname_DetailRS1 = $_GET['id'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcex WHERE id = %s ORDER BY evento ASC", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "1";
if (isset($_GET['estado'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['estado'] : addslashes($_GET['estado']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM opcex  WHERE id = $recordID", $colname_DetailRS1);
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Alta Operaciones - Detalle</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
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
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
<script src="../../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="JavaScript" type="text/JavaScript">
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
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
<link href="../../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<br>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ALTA OPERACIONES SUPERVISOR - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">OPERACIONES DE CAMBIO</td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('nro_operacion','','R','fecha_curse','','R','nro_cuotas','','RinRange1:40');return document.MM_returnValue">
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="4" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="titulocolumnas"><span class="titulodetalle">Alta Operaciones Supervisor Otros Productos
        </div>
      </span></span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</td>
      <td align="center"><span id="sprytextfield1">
      <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="17" maxlength="17">
      <span class="textfieldRequiredMsg"><span class="rojopequeno">Se necesita un valor.</span></span><span class="textfieldMinCharsMsg">No se cumple el m�nimo de caracteres requerido.</span></span>        </div></td>
      <td align="right">Rut Cliente:</div></td>
      <td align="center">
        <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
      <span class="rojopequeno">Sin puntos ni Guion</span></div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nombre Cliente:</td>
      <td colspan="3" align="left"><input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Estado:</td>
      <td align="center">        
        <select name="estado" class="etiqueta12" id="estado">
          <option value="Cursada." selected>Cursada</option>
          <option value="Reparada.">Reparada</option>
          <option value="Pendiente.">Devuelta</option>
        </select>
      </div>        
        </div>      
      </div></td>
      <td align="right">Fecha Curse:</div></td>
      <td align="center">
          <input name="fecha_curse" type="text" disabled="disabled" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
            <span class="rojopequeno">(dd-mm-aaaa)</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Planillas:</td>
      <td align="center">
        <input name="nro_planillas" type="text" class="etiqueta12" id="nro_planillas" value="<?php echo $row_DetailRS1['nro_planillas']; ?>" size="6" maxlength="6">
        <span class="rojopequeno">Nro.</span>
      </div></td>
      <td align="right">Nro Inscripci&oacute;n:</div></td>
      <td align="center">
        <input name="nro_inscripcion" type="text" class="etiqueta12" id="nro_inscripcion" value="<?php echo $row_DetailRS1['nro_inscripcion']; ?>" size="10" maxlength="10">
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Plazo: </td>
      <td align="center">
        <select name="tipo_plazo" class="etiqueta12" id="tipo_plazo">
          <option value="" <?php if (!(strcmp("", $row_DetailRS1['tipo_plazo']))) {echo "SELECTED";} ?>>N/A</option>
          <option value="Vista." <?php if (!(strcmp("Vista.", $row_DetailRS1['tipo_plazo']))) {echo "SELECTED";} ?>>Vista</option>
          <option value="Plazo." <?php if (!(strcmp("Plazo.", $row_DetailRS1['tipo_plazo']))) {echo "SELECTED";} ?>>Plazo.</option>
        </select>
      </div></td>
      <td align="right">Tipo Tasa:</div></td>
      <td align="center">
        <select name="tipo_tasa" class="etiqueta12" id="tipo_tasa">
          <option value="N/A" <?php if (!(strcmp("N/A", $row_DetailRS1['tipo_tasa']))) {echo "SELECTED";} ?>>N/A</option>
          <option value="Fija." <?php if (!(strcmp("Fija.", $row_DetailRS1['tipo_tasa']))) {echo "SELECTED";} ?>>Fija</option>
          <option value="Variable." <?php if (!(strcmp("Variable.", $row_DetailRS1['tipo_tasa']))) {echo "SELECTED";} ?>>Variable</option>
        </select>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Tipo Salida: </td>
      <td align="center">
        <select name="tipo_salida" class="etiqueta12" id="tipo_salida">
          <option value="" <?php if (!(strcmp("", $row_DetailRS1['tipo_salida']))) {echo "SELECTED";} ?>>N/A</option>
          <option value="Ingreso." <?php if (!(strcmp("Ingreso.", $row_DetailRS1['tipo_salida']))) {echo "SELECTED";} ?>>Ingreso</option>
          <option value="Egreso." <?php if (!(strcmp("Egreso.", $row_DetailRS1['tipo_salida']))) {echo "SELECTED";} ?>>Egreso</option>
        </select>
      </div></td>
      <td align="right">Detalle Salida:</div></td>
      <td align="center">
        <select name="detalle_salida" class="etiqueta12" id="detalle_salida">
          <option value="" <?php if (!(strcmp("", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>N/A</option>
          <option value="Amortizacion." <?php if (!(strcmp("Amortizacion.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Amortizacion</option>
          <option value="Retornos." <?php if (!(strcmp("Retornos.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Retornos</option>
          <option value="Aporte Capital." <?php if (!(strcmp("Aporte Capital.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Aporte Capital</option>
          <option value="Inv. del Exterior." <?php if (!(strcmp("Inv. del Exterior.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Inv. del Exterior</option>
          <option value="Pago." <?php if (!(strcmp("Pago.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Pago</option>
          <option value="Venta." <?php if (!(strcmp("Venta.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Venta</option>
          <option value="Inv al Exterior." <?php if (!(strcmp("Inv al Exterior.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Inv. al Exterior</option>
          <option value="Credito al Exterior." <?php if (!(strcmp("Credito al Exterior.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Credito al Exterior</option>
          <option value="Comisiones." <?php if (!(strcmp("Comisiones.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Comisiones</option>
          <option value="Otro." <?php if (!(strcmp("Otro.", $row_DetailRS1['detalle_salida']))) {echo "SELECTED";} ?>>Otro</option>
        </select>
      </div></td>
    </tr>
    <tr valign="middle">
      <td align="right">Mandato:</td>
      <td align="center">
        <input name="mandato" type="text" class="etiqueta12" id="mandato" value="<?php echo $row_DetailRS1['mandato']; ?>" size="30" maxlength="25" readonly="readonly">
        <br>
      </td>
      <td align="right">Excepci&oacute;n Comisi&oacute;n:</td>
      <td align="center">
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['excepcion_comision'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="excepcion_comision" value="Si" id="excepcion_comision_0">
          Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['excepcion_comision'],"No"))) {echo "checked=\"checked\"";} ?> type="radio" name="excepcion_comision" value="No" id="excepcion_comision_1">
          No</label>
        <br>
      </td>
    </tr>
    <tr valign="middle">
      <td align="right">Fuera Horario:</td>
      <td colspan="3" align="left"><label>
        <input <?php if (!(strcmp($row_DetailRS1['fuera_horario'],"Si"))) {echo "checked=\"checked\"";} ?> type="radio" name="fuera_horario" value="Si">
        Si</label>
        <label>
          <input <?php if (!(strcmp($row_DetailRS1['fuera_horario'],"No"))) {echo "checked=\"checked\"";} ?> name="fuera_horario" type="radio" value="No">
      No</label></td>
    </tr>
    <tr valign="middle">
      <td align="right">Detalle Salida Otro: </td>
      <td colspan="3" align="left"><input name="detalle_salida_otro" type="text" class="etiqueta12" id="detalle_salida_otro" value="<?php echo $row_DetailRS1['detalle_salida_otro']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Beneficiario:</td>
      <td colspan="3" align="left"><input name="beneficiario" type="text" class="etiqueta12" id="beneficiario" value="<?php echo $row_DetailRS1['beneficiario']; ?>" size="122" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right">Observaci&oacute;n:</td>
      <td colspan="3" align="left"><span id="sprytextarea1">
        <textarea name="obs" cols="80" rows="4" class="etiqueta12" id="obs"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
      <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span></td>
    </tr>
    <tr align="center" valign="middle">
      <td colspan="4" align="center">
        <input type="submit" class="boton" value="Alta Supervisor">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input name="vi" type="hidden" id="vi" value="<?php echo $row_DetailRS1['vi']; ?>">
  <input name="iteraciones" type="hidden" id="iteraciones" value="<?php echo ($row_DetailRS1['iteraciones'] + $row_DetailRS1['vi']); ?>">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
  <input name="sub_estado" type="hidden" id="sub_estado" value="<?php echo $row_DetailRS1['estado']; ?>">
  <input name="date_supe" type="hidden" id="date_supe" value="<?php echo date("Y-m-d H:i:s"); ?>">
  <input name="autorizador" type="hidden" id="autorizador" value="<?php echo $_SESSION['login'];?>">
  <input name="fecha_curse" type="hidden" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>">
  <input name="date_curse" type="hidden" id="date_curse" value="<?php echo date("Y-m-d"); ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="altamae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {isRequired:false, minChars:0, maxChars:255, validateOn:["blur"], counterId:"countsprytextarea1", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {validateOn:["blur"], minChars:1});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  