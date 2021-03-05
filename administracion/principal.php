<?php
session_start();
$MM_authorizedUsers = "ADM,MOX";
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
<title>Administraci&oacute;n Operaciones</title>
<style type="text/css">
<!--
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {font-size: 9px}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../imagenes/JPEG/edificio_corporativo.jpg);
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
-->
</style>
<script>
/*<!--
//Script original de KarlanKas para forosdelweb.com 


var segundos=1800
var direccion='http://pdpto38:8303/comex/' 


milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);

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
//-->*/
</script> 
</head>
<link rel="shortcut icon" href="../../../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../comex/imagenes/barraweb/animated_favicon1.gif">
</head>

<body onLoad="MM_preloadImages('../imagenes/Botones/boton_volver_2.jpg')">

<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="73%"><span class="Estilo3">ADMINISTRACI&Oacute;N DE OPERACIONES</span></td>
    <td width="27%"><div align="right">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
          <param name="movie" value="../imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
        </object>
    </div></td>
  </tr>
</table>
<br>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td bordercolor="#000000"><br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" bgcolor="#999999"><div align="left"><span class="Estilo4"><img src="../imagenes/GIF/1bolaama-thumb.gif" width="13" height="13"> Administraci&oacute;n de Operaciones</span></div>              
              <div align="left"></div></td>
          </tr>
          <tr>
            <td><div align="left"><img src="../imagenes/GIF/check.gif" width="13" height="12"><a href="operaciones/opccimae.php">Administraci&oacute;n Operaciones de Carta de Cr&eacute;dito de Importaci&oacute;n.</a></div>              
              <div align="left"></div></td>
          </tr>
          <tr>
            <td><img src="../imagenes/GIF/check.gif" width="13" height="12"><a href="operaciones/opccemae.php">Administraci&oacute;n de Operaciones de Carta de Cr&eacute;dito de Exportaci&oacute;n.</a></td>
          </tr>
          <tr>
            <td><img src="../imagenes/GIF/check.gif" width="13" height="12">Administraci&oacute;n de Operaciones de Cobranzas de Importaci&oacute;n.</td>
          </tr>
        </table>
        <div align="center">            <br>
      </div></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td><div align="right"><a href="../operaciones/principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
