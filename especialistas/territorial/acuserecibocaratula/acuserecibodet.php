<?php require_once('../../../Connections/comercioexterior.php'); ?>
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
  $updateSQL = sprintf("UPDATE openvpro SET tipo=%s, evento=%s, estado=%s, obs=%s, date_recibo=%s, date_rec=%s, fuera_horario=%s WHERE id=%s",
                       GetSQLValueString($_POST['tipo'], "text"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['date_recibo'], "date"),
                       GetSQLValueString($_POST['date_rec'], "date"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "acuserecibomae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM openvpro  WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acuse Recibo Caratula Comex - Detalle</title>
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
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
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
<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ACUSE RECIBO CARATULA COMEX - DETALLE </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">TERRITORIALES</td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" nowrap="nowrap" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulodetalle">Detalle Acuse Recibo</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Nro Registro:</td>
      <td align="center" valign="middle" class="nroregistro"><?php echo $row_DetailRS1['id']; ?></td>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['rut_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="17" maxlength="15" readonly="readonly" />
      <span class="rojopequeno">Sin Puntos ni Guion</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['nombre_cliente'], ENT_COMPAT, 'utf-8'); ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Fecha Ingreso</td>
      <td align="center" valign="middle"><input name="date_ingreso" type="text" class="etiqueta12" value="<?php echo htmlentities($row_DetailRS1['date_ingreso'], ENT_COMPAT, 'utf-8'); ?>" size="25" maxlength="25" /></td>
      <td align="right" valign="middle">Tipo:</td>
      <td align="center" valign="middle"><label>
        <select name="tipo" class="etiqueta12" id="tipo">
          <option value="Primera Solicitud." <?php if (!(strcmp("Primera Solicitud.", $row_DetailRS1['tipo']))) {echo "selected=\"selected\"";} ?>>Primera Solicitud</option>
<option value="Solucion de Reparo." <?php if (!(strcmp("Solucion de Reparo.", $row_DetailRS1['tipo']))) {echo "selected=\"selected\"";} ?>>Solucion de Reparo</option>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Evento:</td>
      <td align="center" valign="middle"><select name="evento" class="etiqueta12" id="evento">
        <option value="Envio OP." selected="selected" <?php if (!(strcmp("Envio OP.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Envio OP</option>
        <option value="Compra." <?php if (!(strcmp("Compra.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Compra</option>
        <option value="Venta." <?php if (!(strcmp("Venta.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Venta</option>
        <option value="Arbitraje." <?php if (!(strcmp("Arbitraje.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Arbitraje</option>
        <option value="Liq Op. Recivida." <?php if (!(strcmp("Liq Op. Recivida.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Liq Op. Recivida</option>
        <option value="Emision Planilla." <?php if (!(strcmp("Emision Planilla.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Emision Planilla</option>
        <option value="Otorgamiento Prestamo." <?php if (!(strcmp("Otorgamiento Prestamo.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Otorgamiento Prestamo</option>
        <option value="Prorroga y Pago Prestamo." <?php if (!(strcmp("Prorroga y Pago Prestamo.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga y Pago Prestamo</option>
        <option value="Prorroga Prestamo." <?php if (!(strcmp("Prorroga Prestamo.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Prorroga Prestamo</option>
        <option value="Pago Prestamo." <?php if (!(strcmp("Pago Prestamo.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago Prestamo</option>
        <option value="Apertura Cart. Cred. Import." <?php if (!(strcmp("Apertura Cart. Cred. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura Cart. Cred. Import.</option>
        <option value="Modificacion Cart. Cred. Import." <?php if (!(strcmp("Modificacion Cart. Cred. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Modificacion Cart. Cred. Import.</option>
        <option value="Pago Cart. Cred. Import." <?php if (!(strcmp("Pago Cart. Cred. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago Cart. Cred. Import.</option>
        <option value="Liq. de Retorno." <?php if (!(strcmp("Liq. de Retorno.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Liq. de Retorno</option>
        <option value="Apertura Cob. Import." <?php if (!(strcmp("Apertura Cob. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura Cob. Import.</option>
        <option value="Modificacion Cob. Import." <?php if (!(strcmp("Modificacion Cob. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Modificacion Cob. Import.</option>
        <option value="Pago Cob. Import." <?php if (!(strcmp("Pago Cob. Import.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago Cob. Import.</option>
        <option value="Apertura y Pago OPI." <?php if (!(strcmp("Apertura y Pago OPI.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura y Pago OPI</option>
        <option value="Apertura OPI." <?php if (!(strcmp("Apertura OPI.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Apertura OPI</option>
        <option value="Modificacion OPI." <?php if (!(strcmp("Modificacion OPI.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Modificacion OPI</option>
        <option value="Pago OPI." <?php if (!(strcmp("Pago OPI.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Pago OPI</option>
        <option value="Boleta de Garantia." <?php if (!(strcmp("Boleta de Garantia.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Boleta de Garantia</option>
        <option value="Stand By Emitida." <?php if (!(strcmp("Stand By Emitida.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Stand By Emitida</option>
        <option value="Credito IIIB5." <?php if (!(strcmp("Credito IIIB5.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Credito IIIB5</option>
<option value="Otro." <?php if (!(strcmp("Otro.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Otro</option>
      </select></td>
      <td align="right" valign="middle">Fuera Horario:</td>
      <td align="center" valign="middle"><select name="fuera_horario" class="etiqueta12" id="fuera_horario">
        <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['fuera_horario']))) {echo "selected=\"selected\"";} ?>>Si</option>
<option value="No" <?php if (!(strcmp("No", $row_DetailRS1['fuera_horario']))) {echo "selected=\"selected\"";} ?>>No</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Estado:</td>
      <td align="center" valign="middle"><select name="estado" class="etiqueta12" id="estado">
  <option value="Operacion Recibida.">Operacion Recibida</option>
  <option value="Rechazada.">Rechazada</option>
      </select></td>
      <td align="right" valign="middle">Hora Acuse Recibo:</td>
      <td align="center" valign="middle"><input name="date_recibo" type="text" class="etiqueta12" value="<?php echo date("Y-m-d H:i:s"); ?>" size="25" maxlength="25" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle" nowrap="nowrap">Observación:</td>
      <td colspan="3" align="left" valign="middle"><textarea name="obs" cols="80" rows="4" class="etiqueta12"><?php echo htmlentities($row_DetailRS1['obs'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle" nowrap="nowrap"><input type="submit" class="boton" value="Acusar Recibo" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>" />
  <label>
    <input name="date_rec" type="hidden" id="date_rec" value="<?php echo date("Y-m-d H:i:s"); ?>" />
  </label>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="acuserecibomae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volber" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>