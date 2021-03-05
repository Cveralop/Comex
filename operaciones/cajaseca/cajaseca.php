<?php
if (!isset($_SESSION)) {
  session_start();
}
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Caja Seca Ingreso y Control</title>
<style type="text/css">
<!--
.Estilo3 {
	font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
	font-family: Verdana, Geneva, sans-serif;
}
.Estilo6 {	color: #FFFFFF;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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
-->
</style>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo4 {	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body onload="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="79%" align="left" valign="middle"><span class="Estilo3">CAJA SECA INGRESO Y CONTROL</span></td>
    <td width="21%" align="left" valign="middle"><div align="right">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60" align="right">
        <param name="movie" value="../../imagenes/SWF/reloj_3.swf" />
        <param name="quality" value="high" />
        <embed src="../../imagenes/SWF/reloj_3.swf" width="250" height="60" align="right" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
      </object>
    </div></td>
  </tr>
</table>
<br />
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td bordercolor="#000000"><br />
      <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr>
          <td height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0" />Registro Operaciones MECO</span></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12" /><a href="cajaseca_ing_mae.php">Ingreso Instrucciones Caja Seca</a></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12" /><a href="cajaseca_curse_mae.php">Alta Instrucciones Cajero</a></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12" /><a href="cajaseca_sup.php">Control Supervisor Caja</a></td>
        </tr>
      </table>
    <br /></td>
  </tr>
</table>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../principal.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0" id="Imagen4" /></a></td>
  </tr>
</table>
</body>
</html>