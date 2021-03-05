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
$colname1_acuserecibo = "-1";
if (isset($_GET['estado'])) {
  $colname1_acuserecibo = $_GET['estado'];
}
$colname2_acuserecibo = "-1";
if (isset($_GET['territorial'])) {
  $colname2_acuserecibo = $_GET['territorial'];
}
$colname_acuserecibo = "-1";
if (isset($_GET['id'])) {
  $colname_acuserecibo = $_GET['id'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_acuserecibo = sprintf("SELECT * FROM openvpro WHERE id LIKE %s and estado = %s and territorial LIKE %s", GetSQLValueString("%" . $colname_acuserecibo . "%", "text"),GetSQLValueString($colname1_acuserecibo, "text"),GetSQLValueString("%" . $colname2_acuserecibo . "%", "text"));
$acuserecibo = mysqli_query($comercioexterior,$query_acuserecibo) or die(mysqli_error($comercioexterior));
$row_acuserecibo = mysqli_fetch_assoc($acuserecibo);
$totalRows_acuserecibo = mysqli_num_rows($acuserecibo);
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "SELECT * FROM openvpro GROUP BY territorial";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acuse Recibo Caratula Comex - Maestro</title>
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ACUSE RECIBO CARATULA COMEX - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">TERRITORIALES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" />Acuse Recibo</td>
    </tr>
    <tr>
      <td width="18%" align="right" valign="middle">Nro Folio:</td>
      <td width="82%" align="left" valign="middle"><label>
        <input name="id" type="text" class="etiqueta12" id="id" size="15" maxlength="15" />
        <span class="rojopequeno">Ingrese Folio</span></label></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Territorial:</td>
      <td align="left" valign="middle"><select name="territorial" class="etiqueta12" id="territorial">
        <option value="">Seleccione una Territorial</option>
        <?php
 while($row_Recordset1 = mysqli_fetch_assoc($Recordset1)){
  echo "<option value='".$row_Recordset1['territorial']."'>".$row_Recordset1['territorial']."</option>";
  }
 ?>
      </select></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Estado:</td>
      <td align="left" valign="middle"><label>
        <select name="estado" class="etiqueta12" id="estado">
<option value="Enviada a Proceso." selected="selected">Enviada a Proceso</option>
          <option value="Operacion Recibida.">Operacion Recibida</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar" />
      </label></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="left" valign="middle"><a href="../tr.php" onmouseover="MM_swapImage('Imagen4','','../../../imagenes/Botones/boton_volver_2.jpg',1)" onmouseout="MM_swapImgRestore()"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
    <td align="right" valign="middle"><a href="caratulavsoperaciones.php">&lt;&lt;Buscar Nro folio en Operaciones&gt;&gt;</a>
<select name="jumpMenu" class="etiqueta12" id="jumpMenu" onchange="MM_jumpMenu('parent',this,1)">
  <option value="acuserecibomae.php">Seleccione Una Opción</option>
  <option value="../opbga/opbga.php">Boleta de Garantia</option>
  <option value="../opcbe/opcbe.php">Cobranza Extranjera de Exportación</option>
  <option value="../opcbi/opcbi.php">Cobranza Extranjera de Importación</option>
  <option value="../opcce/opcce.php">Carta de Crédito Exportación</option>
  <option value="../opcci/opcci.php">Carta de Crédito Importación</option>
  <option value="../opcdpa/opcdpa.php">Ceciones de Derecho Pago Anticipado</option>
  <option value="../opcreext/opcreext.php">Creditos Externo</option>
  <option value="../opiiib5/opiiib5.php">Creditos III B5</option>
  <option value="../opmec/opmec.php">Mercado de Corredores</option>
  <option value="../oppre/oppre.php">Prestamos</option>
  <option value="../opstbe/opste.php">Stand By Emitidos</option>
</select></td>
  </tr>
</table>
<br />
<?php if ($totalRows_acuserecibo > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_azul"><?php echo $totalRows_acuserecibo ?></span> Registros Total <br />
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Acusar Recibo</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Folio</td>
      <td align="center" valign="middle" class="titulocolumnas">Estado</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Territorial</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Ejecutivo Cuenta</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
      <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Oficina</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" class="titulocolumnas">Tipo Solicitud</td>
      <td align="center" valign="middle" class="titulocolumnas">Evento</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="acuserecibodet.php?recordID=<?php echo $row_acuserecibo['id']; ?>"><img src="../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" align="middle" /></a></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_acuserecibo['id']; ?></td>
        <td align="center" valign="middle"><?php echo $row_acuserecibo['estado']; ?></td>
        <td align="center" valign="middle"><?php echo $row_acuserecibo['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_acuserecibo['nombre_cliente']; ?></td>
        <td align="center" valign="middle"><?php echo $row_acuserecibo['territorial']; ?></td>
        <td align="left" valign="middle"><?php echo $row_acuserecibo['nombre_ejecutivo']; ?></td>
        <td align="left" valign="middle"><?php echo $row_acuserecibo['especialista']; ?></td>
        <td align="left" valign="middle"><?php echo $row_acuserecibo['ejecutivo']; ?></td>
        <td align="left" valign="middle"><?php echo $row_acuserecibo['oficina']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_acuserecibo['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_acuserecibo['tipo']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_acuserecibo['evento']; ?></td>
      </tr>
      <?php } while ($row_acuserecibo = mysqli_fetch_assoc($acuserecibo)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($acuserecibo);
mysqli_free_result($Recordset1);
?>