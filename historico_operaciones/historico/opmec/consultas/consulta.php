<?php require_once('../../../../Connections/historico_goc.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,RED,SUP,TER,OPE,ESP,BMG";
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

$MM_restrictGoTo = "../../../../consulta_operaciones/historico/erroracceso.php";
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
  global $historico_goc;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($historico_goc, $theValue) : mysqli_escape_string($historico_goc, $theValue);

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

$currentPage = $_SERVER["PHP_SELF"];

$colname_conrut = "1";
if (isset($_GET['rut_cliente'])) {
  $colname_conrut = $_GET['rut_cliente'];
}
mysqli_select_db($historico_goc, $database_historico_goc);
$query_conrut = sprintf("SELECT * FROM opmec WHERE rut_cliente = %s ORDER BY id DESC", GetSQLValueString($colname_conrut, "text"));
$conrut = mysqli_query($historico_goc, $query_conrut) or die(mysqli_error($historico_goc));
$row_conrut = mysqli_fetch_assoc($conrut);
$totalRows_conrut = mysqli_num_rows($conrut);

$queryString_conrut = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_conrut") == false && 
        stristr($param, "totalRows_conrut") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_conrut = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_conrut = sprintf("&totalRows_conrut=%d%s", $totalRows_conrut, $queryString_conrut);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones MECO - Maestro</title>
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
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}

</style>
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script>
/*<!--

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
//-->*/
</script>
<script>
/*<!--
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->*/
</script> 

<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">

<style type="text/css">
<!--
.Estilo11 {color: #00FF00}
.Estilo12 {color: #FFFFFF}

</style>
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">CONSULTAS - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">MERCADO DE CORREDORES</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Consulta por Rut Cliente</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Rut Cliente:</div></td>
      <td width="79%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15"> 
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../../historico.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_conrut > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="10" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Total de <span class="Estilo11"><?php echo $totalRows_conrut ?> <span class="Estilo12">Operaciones</span></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Ver Operaci&oacute;n </div></td>
    <td align="center" class="titulocolumnas">Rut Cliente</td>
    <td align="center" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" class="titulocolumnas">Evento</td>
    <td align="center" class="titulocolumnas">Estado</td>
    <td align="center" class="titulocolumnas">Fecha Curse</td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
    </td>
    <td align="center" class="titulocolumnas">Valuta</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Apertura 
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="consultadet.php?recordID=<?php echo $row_conrut['id']; ?>"> <img src="../../../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0"></a></div></td>
    <td align="center"><?php echo strtoupper($row_conrut['rut_cliente']); ?></div></td>
    <td align="left"><?php echo strtoupper($row_conrut['nombre_cliente']); ?></td>
    <td align="center"><?php echo $row_conrut['fecha_ingreso']; ?></div></td>
    <td align="center"><?php echo $row_conrut['evento']; ?></div></td>
    <td align="center"><?php echo $row_conrut['estado']; ?></div></td>
    <td align="center"><?php echo $row_conrut['fecha_curse']; ?></div>      </div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo (isset($row_conrut['valuta']) ? $row_conrut['valuta']:""); ?></div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_conrut['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_conrut['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
  </tr>
  <?php } while ($row_conrut = mysqli_fetch_assoc($conrut)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($conrut);
?>