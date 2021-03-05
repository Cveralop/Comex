<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "RED,ADM";
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
$MM_restrictGoTo = "erroracceso.php";
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
  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($comercioexterior, $theValue) : mysqli_escape_string($comercioexterior, $theValue);

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

$colname_usuario = "-1";
if (isset($_SESSION['login'])) {
  $colname_usuario = $_SESSION['login'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_usuario = sprintf("SELECT * FROM usuarios nolock WHERE usuario = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysqli_query($comercioexterior, $query_usuario) or die(mysqli_error($comercioexterior));
$row_usuario = mysqli_fetch_assoc($usuario);
$totalRows_usuario = mysqli_num_rows($usuario);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Red de Sucursales</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFF;
	font-weight: bold;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo4 {	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<link rel="shortcut icon" href="../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">RED DE SUCURSALES</span></td>
    <td rowspan="2" align="right" valign="middle">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
          <param name="movie" value="../../imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="../../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
        </object>
    </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000">OPERADOR: (<?php echo strtoupper($row_usuario['nombre']);?>) &Aacute;REA: (<?php echo strtoupper($row_usuario['segmento']);?>)</td>
  </tr>
</table>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td bordercolor="#000000"><br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"> Estado Operaciones Enviadas a Curse</span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="controles/redsucxterritorial.php">Consulta Operaciones por Territorial</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="controles/redsucxrutcliente.php">Consulta Operaciones por Rut Cliente</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="controles/redsucxterritorial_old.php">Consulta Operaciones hasta del 26 de Noviembre del 2013</a></td>
          </tr>
      </table>
      <br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Intereses - Pagare Paraguas</span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../controles_especialistas/devengo/interesesmae.php">Intereses del D&iacute;a o Proyectados</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="pagareparagua/pagareparagua_mae.php">Consulta Pagare Paragua</a></td>
          </tr>
                  </table>
        <br>
      <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Consulta Operaciones</span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="controles/avisocuotas/impavicuomae.php">Aviso Pago Cuotas Operaciones Prestamos</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opbga/consultas/consulta.php">Consulta Operaciones Boletas de Garantias</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opcbe/consultas/consulta.php">Consulta Operaciones Cobranza Extranjera de Exportacion</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opcbi/consultas/consulta.php">Consulta Operaciones Cobranza Extranjera de Importacion y OPI</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opcce/consultas/consulta.php">Consulta Operaciones de Cartas de Credito de Exportaci&oacute;n</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opcci/consultas/consulta.php">Consulta Operaciones de Cartas de Credito de Importaci&oacute;n</a> // y // <a href="opcci/consultas/consultaneg.php">Operaciones Negociadas</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opcreext/consultas/consulta.php">Consulta Operaciones Creditos Externos</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opiiib5/consultas/consulta.php">Consulta Operaciones de Creditos IIIB5</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opmec/consultas/consulta.php">Consulta Operaciones de Mercado de Corredores</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="oppre/consultas/consulta.php">Consulta Operaciones de Prestamos</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="opstbe/consultas/consulta.php">Consulta Operaciones Stand Bye Emitidas</a></td>
          </tr>
      </table>
      <br>
    </div></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../ingreso.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($usuario);
?>