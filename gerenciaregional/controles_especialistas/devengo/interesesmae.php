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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO intproyec (sistema, rut_cliente, nombre_cliente, oficina, nro_operacion, secuencia, moneda, capital_original, saldo_vigente, tasa_final_cliente, dife, fecha_vcto, fecha_desde, fecha_hasta, tasa_dif) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['sistema'], "text"),
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['oficina'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['secuencia'], "int"),
                       GetSQLValueString($_POST['moneda'], "text"),
                       GetSQLValueString($_POST['capital_original'], "double"),
                       GetSQLValueString($_POST['saldo_vigente'], "double"),
                       GetSQLValueString($_POST['tasa_final_cliente'], "text"),
                       GetSQLValueString($_POST['dife'], "text"),
                       GetSQLValueString($_POST['fecha_vcto'], "date"),
                       GetSQLValueString($_POST['fecha_desde'], "date"),
                       GetSQLValueString($_POST['fecha_hasta'], "date"),
					   GetSQLValueString($_POST['tasa_dif'], "text"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));

  $insertGoTo = "interesesdet.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_proyecint = "zzzaaa";
if (isset($_GET['nro_operacion'])) {
  $colname_proyecint = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_proyecint = sprintf("SELECT *, sum(saldo_vigente) as saldo_insoluto, (case when moneda <> 'CLP' then 36000 else 3000 end)as factor_calculo  FROM vctooperaciones nonlock WHERE nro_operacion = %s GROUP BY nro_operacion ORDER BY fecha_desde ASC", GetSQLValueString($colname_proyecint, "text"));
$proyecint = mysqli_query($comercioexterior, $query_proyecint) or die(mysqli_error());
$row_proyecint = mysqli_fetch_assoc($proyecint);
$totalRows_proyecint = mysqli_num_rows($proyecint);
?>
<?php $_SESSION['rut']=$row_proyecint['rut_cliente']; ?>
<?php $_SESSION['login']=$row_proyecint['nro_operacion']; ?>
<?php $_SESSION['nro']=$row_proyecint['nro_operacion']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Intereses Proyectados Maestro</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<!-- Copyright 2000, 2001, 2002, 2003 Macromedia, Inc. All rights reserved. -->
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
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
<style type="text/css">
<!--
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
	color: #666;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="96%" height="27" align="left" valign="middle" class="titulopaguina">INTERESES PROYECTADOS</span> MAESTRO</td>
    <td width="4%" rowspan="2" align="right" valign="middle"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="left" />      </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="titulopaguina"><span class="Estilo4">GERENCIA REGIONAL</span></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Busqueda por Nro Operación</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" bgcolor="#CCCCCC">Nro Operacion:</td>
      <td width="79%" align="left" bgcolor="#CCCCCC"><label>
        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="10" maxlength="7" />
      <span class="rojopequeno">F000000 o L000000</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#CCCCCC"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<form id="form3" name="form3" method="POST" action="<?php echo $editFormAction; ?>">
  <?php if ($totalRows_proyecint > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="6" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="titulo_menu">Intereses por Operación</span></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC">Rut Cliente:</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="rut_cliente" type="text" disabled="disabled" class="etiqueta12" id="rut_cliente" value="<?php echo $row_proyecint['rut_cliente']; ?>" size="17" maxlength="12" readonly="readonly" />
        </label></td>
      <td align="right" bgcolor="#CCCCCC">Nro Operacion:</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="nro_operacion" type="text" disabled="disabled" class="etiqueta12" id="nro_operacion" value="<?php echo $row_proyecint['nro_operacion']; ?>" size="10" maxlength="7" readonly="readonly" />
        </label></td>
      <td align="right" bgcolor="#CCCCCC">Secuencia:</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="secuencia" type="text" disabled="disabled" class="etiqueta12" id="secuencia" value="<?php echo $row_proyecint['secuencia']; ?>" size="5" maxlength="3" readonly="readonly" />
        </label></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC">Nombre Cliente:</td>
      <td colspan="5" align="left" bgcolor="#CCCCCC"><label>
        <input name="nombre_cliente" type="text" disabled="disabled" class="etiqueta12" id="nombre_cliente" value="<?php echo $row_proyecint['nombre_cliente']; ?>" size="80" maxlength="80" />
        </label></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC">Moneda / Saldo Insoluto:</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="moneda" type="text" disabled="disabled" class="etiqueta12" id="moneda" value="<?php echo $row_proyecint['moneda']; ?>" size="5" maxlength="3" />
        /
        <input name="capital_original" type="text" disabled="disabled" class="etiqueta12" id="capital_original" value="<?php echo $row_proyecint['saldo_insoluto']; ?>" size="17" maxlength="15" />
        </label></td>
      <td align="right" bgcolor="#CCCCCC">Valor Cuota:</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="saldo_vigente" type="text" class="etiqueta12" id="saldo_vigente" value="<?php echo $row_proyecint['saldo_vigente']; ?>" size="17" maxlength="15" />
        </label></td>
      <td align="right" bgcolor="#CCCCCC">Vcto Cuota:</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="fecha_vcto" type="text" class="etiqueta12" id="fecha_vcto" value="<?php echo $row_proyecint['fecha_vcto']; ?>" size="12" maxlength="10" />
        </label></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC">Fecha Desde:</td>
      <td bgcolor="#CCCCCC"><label>
        <input name="fecha_desde" type="text" class="etiqueta12" id="fecha_desde" value="<?php echo $row_proyecint['fecha_desde']; ?>" size="12" maxlength="10" />
        <span class="rojopequeno">(aaaa-mm-dd)</span></label></td>
      <td align="right" bgcolor="#CCCCCC">Fecha Hasta:</td>
      <td bgcolor="#CCCCCC"><span id="sprytextfield1">
        <label>
          <input name="fecha_hasta" type="text" class="etiqueta12" id="fecha_hasta" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="10" />
          <span class="rojopequeno">(aaaa-mm-dd)</span></label>
        <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span></span></td>
      <td align="right" bgcolor="#CCCCCC">Tasa:</td>
      <td bgcolor="#CCCCCC"><input name="tasa_final_cliente" type="text" class="etiqueta12" id="tasa_final_cliente" value="<?php echo $row_proyecint['tasa_final_cliente']; ?>" size="10" maxlength="10" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#CCCCCC">Op. Tasa Variable (o + una tasa):</td>
      <td bgcolor="#CCCCCC"><input name="tasa_dif" type="text" class="destadado" id="tasa_dif" value="<?php echo $row_proyecint['tasa_dif']; ?>" size="4" maxlength="2" readonly="readonly" /></td>
      <td colspan="4" bgcolor="#CCCCCC"><input name="button2" type="submit" class="boton" id="button2" value="Enviar" /></td>
      </tr>
  </table>
    <input type="hidden" name="MM_insert" value="form3" />
    <input name="rut_cliente" type="hidden" id="rut_cliente" value="<?php echo $row_proyecint['rut_cliente']; ?>" />
    <input name="nombre_cliente" type="hidden" id="nombre_cliente" value="<?php echo $row_proyecint['nombre_cliente']; ?>" />
    <input name="nro_operacion" type="hidden" id="nro_operacion" value="<?php echo $row_proyecint['nro_operacion']; ?>" />
    <input name="secuencia" type="hidden" id="secuencia" value="<?php echo $row_proyecint['secuencia']; ?>" />
    <input name="moneda" type="hidden" id="moneda" value="<?php echo $row_proyecint['moneda']; ?>" />
    <input name="capital_original" type="hidden" id="capital_original" value="<?php echo $row_proyecint['saldo_insoluto']; ?>" />
  <input name="saldo_insoluto" type="hidden" id="saldo_insoluto" value="<?php echo $row_proyecint['saldo_insoluto']; ?>" />
    <input name="dife" type="hidden" id="dife" value="<?php echo $row_proyecint['factor_calculo']; ?>" />
    <input name="fecha_vcto" type="hidden" id="fecha_vcto" value="<?php echo $row_proyecint['fecha_vcto']; ?>" />
    <?php } // Show if recordset not empty ?>
  <input name="sistema" type="hidden" id="sistema" value="<?php echo $_SESSION['nro'];?>" size="10" maxlength="10" />
  <input name="oficina" type="hidden" id="oficina" value="<?php echo $row_proyecint['oficina']; ?>" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../../gerenciaregional.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {validateOn:["blur", "change"], format:"yyyy-mm-dd"});
//-->
</script>
</body>
</html>
<?php
mysqli_free_result($proyecint);
?>