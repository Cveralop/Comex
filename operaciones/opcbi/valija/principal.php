<?php
session_start();
$MM_authorizedUsers = "ADM,SUP,OPE,GER";
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Valija Cobranza de Importaci&oacute;n</title>
<style type="text/css">
<!--
.Estilo4 {	font-size: 12px;
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
.Estilo8 {
	font-size: 18px;
	color: #FFFFFF;
	font-weight: bold;
}

</style>
<script language="JavaScript" type="text/JavaScript">
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle"><span class="Estilo8">VALIJA CARTA DE COBRANZA DE IMPORTACI&Oacute;N </span></td>
    <td width="7%" align="left" valign="middle"><span class="Estilo8"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></span></td>
  </tr>
</table>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td bordercolor="#000000"><br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Valija Carta de Cobranza de Importaci&oacute;n </span></div>              
            </div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../../imagenes/GIF/check.gif" width="13" height="12"><a href="ingresomae.php">Ingreso Valija</a></div>              
            </div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../../imagenes/GIF/check.gif" width="13" height="12"><a href="modmae.php">Modificaci&oacute;n Valija</a></div>
            </div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../../imagenes/GIF/check.gif" width="13" height="12"><a href="impresionmae.php">Imprimir Valija</a></div>    
            </div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../../imagenes/GIF/check.gif" width="13" height="12"><a href="controlmae.php">Listado Acuse Recibo Pendiente</a></td>
          </tr>
        </table>
        <br>
    </div></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../cobimport.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>