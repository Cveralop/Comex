﻿<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,TER";
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

$colname_swift_openviada = "-1";
if (isset($_GET['date_ini'])) {
  $colname_swift_openviada = $_GET['date_ini'];
}
$colname2_swift_openviada = "-1";
if (isset($_GET['rut_ordenante'])) {
  $colname2_swift_openviada = $_GET['rut_ordenante'];
}
$colname1_swift_openviada = "-1";
if (isset($_GET¨['date_fin'])) {
  $colname1_swift_openviada = $_GET¨['date_fin'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_swift_openviada = sprintf("SELECT * FROM swift_openviada WHERE date_ingreso between %s and %s and rut_ordenante = %s ORDER BY date_ingreso ASC", GetSQLValueString($colname_swift_openviada, "date"),GetSQLValueString($colname1_swift_openviada, "date"),GetSQLValueString($colname2_swift_openviada, "text"));
$swift_openviada = mysqli_query($comercioexterior, $query_swift_openviada) or die(mysqli_error($comercioexterior));
$row_swift_openviada = mysqli_fetch_assoc($swift_openviada);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SWIFT Op Enviada - Maestro</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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

</style>
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
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

<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">SWIFT OP ENVIADA - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">MERCADO DE CORREDORES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" bgcolor="#CCCCCC" class="titulocolumnas"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Buscar OP Enviada</span></td>
    </tr>
    <tr>
      <td width="26%" align="right">Fecha Ingreso:</td>
      <td width="74%" align="left"><input name="date_ini" type="text" class="etiqueta12" id="date_ini" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="12" /> 
        <span class="rojopequeno">Desde</span><label>
          <input name="date_fin" type="text" class="etiqueta12" id="date_fin" value="<?php echo date("Y-m-d"); ?>" size="12" maxlength="12" />
        <span class="rojopequeno">Hasta </span></label></td>
    </tr>
    <tr>
      <td align="right">Rut Ordenante:</td>
      <td align="left"><label>
        <input name="rut_ordenante" type="text" class="etiqueta12" id="rut_ordenante" size="20" maxlength="20" />
      <span class="rojopequeno">Sin puntos mi guión</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
<input name="button2" type="reset" class="boton" id="button2" value="Limpiar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../opmec.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen5','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen5" width="80" height="25" border="0" id="Imagen5" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_swift_openviada > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_rojo"><?php echo $totalRows_swift_openviada ?></span> Registros Total<br />
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="12" align="left" valign="middle" class="titulocolumnas"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" /><span class="titulo_menu">Rut Cliente </span><span class="tituloverde"><?php echo $row_swift_openviada['rut_ordenante']; ?></span><span class="titulo_menu"> Nombre Cliente </span><span class="tituloverde"><?php echo $row_swift_openviada['nombre_ordenante']; ?></span></td>
    </tr>
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Ver Detalle</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Monto Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación Relacionada</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Ordenante</td>
      <td align="center" valign="middle" class="titulocolumnas">Cuenta Beneficiario</td>
      <td align="center" valign="middle" class="titulocolumnas">Cod Banco Corresponsal</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Banco</td>
      <td align="center" valign="middle" class="titulocolumnas">Tipo Swift Enviado</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Valuta</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="openviada_det.php?recordID=<?php echo $row_swift_openviada['id']; ?>"><img src="../../../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0" align="middle" /></a></td>
        <td align="center" valign="middle"><?php echo $row_swift_openviada['date_ingreso']; ?></td>
        <td align="left" valign="middle"><?php echo $row_swift_openviada['moneda_operacion']; ?></td>
        <td align="right" valign="middle"><?php echo number_format($row_swift_openviada['monto_operacion'], 2, ',', '.'); ?></td>
        <td align="center" valign="middle"><?php echo $row_swift_openviada['nro_operacion']; ?></td>
        <td align="center" valign="middle"><?php echo $row_swift_openviada['nro_operacion_relacionada']; ?></td>
        <td align="left" valign="middle"><?php echo $row_swift_openviada['nombre_ordenante']; ?></td>
        <td align="right" valign="middle"><?php echo $row_swift_openviada['cuenta_beneficiario']; ?></td>
        <td align="center" valign="middle"><?php echo $row_swift_openviada['cod_bco_corresponsal']; ?></td>
        <td align="left" valign="middle"><?php echo $row_swift_openviada['nombre_banco']; ?></td>
        <td align="center" valign="middle"><?php echo $row_swift_openviada['tipo_swift']; ?></td>
        <td align="center" valign="middle"><?php echo $row_swift_openviada['fecha_valuta']; ?></td>
      </tr>
      <?php } while ($row_swift_openviada = mysqli_fetch_assoc($swift_openviada)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($swift_openviada);
?>