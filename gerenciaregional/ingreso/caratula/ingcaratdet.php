<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO openvpro (rut_cliente, nombre_cliente, territorial, nombre_ejecutivo, especialista, ejecutivo, sucursal, oficina, date_ingreso, date_ing, tipo, evento, obs, fuera_horario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['territorial'], "text"),
                       GetSQLValueString($_POST['nombre_ejecutivo'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['ejecutivo'], "text"),
                       GetSQLValueString($_POST['sucursal'], "text"),
                       GetSQLValueString($_POST['oficina'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['date_ing'], "date"),
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "imprecaratuladet.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT *,(case when CURTIME() > '14:14:59' then 'Si' else 'No' end)as fuerahorario FROM cliente WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
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
<?php $_SESSION['rut']=$row_DetailRS1['rut_cliente']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Envio Operaciones a Curse - Detalle</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
#form1 table tr td #sprytextarea1 {
	color: #F00;
}
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script src="../../../SpryAssets/SpryValidationRadio.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationRadio.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
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
//-->
</script>
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">INGRESO OPERACIONES PARA ENVIO A CURSE - DETALLE</td>
    <td width="5%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">RED DE SUCURSALES</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulocolumnas"><span class="titulodetalle">Ingreso Caratula</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" />
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
      <td align="right" valign="middle">Fecha Ingreso:</td>
      <td align="center" valign="middle"><input name="date_ingreso" type="text" class="etiqueta12" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="80" maxlength="80" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle"><select name="evento" class="destadado" id="evento">
        <option value="Sin Dato." selected="selected">Seleccione una Opcion</option>
        <option value="Envio OP.">Envio OP</option>
        <option value="Compra.">Compra</option>
        <option value="Venta.">Venta</option>
        <option value="Arbitraje.">Arbitraje</option>
        <option value="Liq Op. Recibida.">Liq Op. Recibida</option>
        <option value="Emision Planilla.">Emision Planilla</option>
        <option value="Otorgamiento Prestamo.">Otorgamiento Prestamo</option>
        <option value="Prorroga y Pago Prestamo.">Prorroga y Pago Prestamo</option>
        <option value="Prorroga Prestamo.">Prorroga Prestamo</option>
        <option value="Pago Prestamo.">Pago Prestamo</option>
        <option value="Apertura Cart. Cred. Import.">Apertura Cart. Cred. Import.</option>
        <option value="Modificacion Cart. Cred. Import.">Modificacion Cart. Cred. Import.</option>
        <option value="Pago Cart. Cred. Import.">Pago Cart. Cred. Import.</option>
        <option value="Liq. de Retorno.">Liq. de Retorno</option>
        <option value="Apertura Cob. Import.">Apertura Cob. Import.</option>
        <option value="Modificacion Cob. Import.">Modificacion Cob. Import.</option>
        <option value="Pago Cob. Import.">Pago Cob. Import.</option>
        <option value="Apertura y Pago OPI.">Apertura y Pago OPI</option>
        <option value="Apertura OPI.">Apertura OPI</option>
        <option value="Modificacion OPI.">Modificacion OPI</option>
        <option value="Pago OPI.">Pago OPI</option>
        <option value="Boleta de Garantia.">Boleta de Garantia</option>
        <option value="Stand By Emitida.">Stand By Emitida</option>
        <option value="Credito IIIB5.">Credito IIIB5</option>
        <option value="Otro.">Otro</option>
      </select></td>
      <td align="right" valign="middle">Tipo:</td>
      <td align="center" valign="middle"><span id="spryradio1">
        <label>
          <input type="radio" name="tipo" value="Primera Solicitud." id="tipo_0" />
          Primera Solicitud</label>
        <label>
          <input type="radio" name="tipo" value="Solucion de Reparo." id="tipo_1" />
          Solucion de Reparo</label>
        <br />
      <span class="radioRequiredMsg">Realice una selección.</span></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Observaciones:</td>
      <td colspan="3" align="left" valign="middle"><span id="sprytextarea1">
        <textarea name="obs" cols="85" rows="5" class="etiqueta12"></textarea>
      <span class="respuestacolumna_rojo"><span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span><span id="countsprytextarea1">&nbsp;</span></span></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="right" valign="middle" bgcolor="#999999" class="titulodetalle">Pagaré original sin enmendaduras, corrector ni perforaciones en custodia temporal de la sucursal:</td>
      <td align="center" valign="middle"><label>
        <input type="checkbox" name="checkbox" id="checkbox" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="right" valign="middle" bgcolor="#999999" class="titulodetalle">Tiene la firma del cliente:</td>
      <td align="center" valign="middle"><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="3" align="right" valign="middle" bgcolor="#999999" class="titulodetalle">Esta el V B y Timbre del ejecutivo:</td>
      <td align="center" valign="middle"><input type="checkbox" name="checkbox3" id="checkbox3" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Ingresar Caratula" /></td>
    </tr>
  </table>
<input type="hidden" name="MM_insert" value="form1" />
  <input name="nombre_ejecutivo" type="hidden" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_ejecutivo']; ?>" size="32" />
  <input name="especialista" type="hidden" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="32" />
  <input name="ejecutivo" type="hidden" class="etiqueta12" value="<?php echo $row_DetailRS1['ejecutivo']; ?>" size="32" />
  <input name="oficina" type="hidden" class="etiqueta12" value="<?php echo $row_DetailRS1['oficina']; ?>" size="32" />
  <input name="territorial" type="hidden" class="etiqueta12" value="<?php echo $row_DetailRS1['territorial']; ?>" size="32" readonly="readonly" />
  <input name="sucursal" type="hidden" class="etiqueta12" value="<?php echo $row_DetailRS1['sucursal']; ?>" size="32" />
  <input name="fuera_horario" type="hidden" id="fuera_horario" value="<?php echo $row_DetailRS1['fuerahorario']; ?>" size="5" maxlength="2" />
  <input name="date_ing" type="hidden" id="date_ing" value="<?php echo date("Y-m-d H:i:s"); ?>" />
</form><br />
<td><a href="imprecaratuladet.php?recordID=<?php echo $row_inpresion['id']; ?>"> <?php echo $row_inpresion['id']; ?>&nbsp; </a></td>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="ingcaratmae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"], counterId:"countsprytextarea1", counterType:"chars_remaining", isRequired:false, minChars:0, maxChars:255});
var spryradio1 = new Spry.Widget.ValidationRadio("spryradio1", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>