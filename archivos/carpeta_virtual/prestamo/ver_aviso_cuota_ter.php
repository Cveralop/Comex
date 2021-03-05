<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,ESP,TER";
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
$MM_restrictGoTo = "../../../erroracceso.php";
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
<html> 
<head> 
<title>Avisos en Cuotas</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
@import url("../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
.Estilo1 {
	font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
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
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<link rel="shortcut icon" href="../../../../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../comex/imagenes/barraweb/animated_favicon1.gif">
</head> 
<?php 
if($REQUEST_METHOD<>"POST"){ 
?><body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')"> 
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%"><span class="Estilo1">AVISOS EN CUOTAS</span></td>
    <td width="7%" rowspan="2"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td><span class="Estilo4">COMERCIO EXTERIOR</span></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../../especialistas/ni/ni.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></td>
  </tr>
</table>
<br>
  </tr>
</table>
<?php
   } 
    else{ 
    $directorio="D:\\appserv\\www\\comex\\archivos\\carpeta_virtual\\prestamo\\"; 
         copy ($archivo1,$directorio.$archivo1_name); 
    echo  "El archivo: ".$archivo1_name."<br>Fu&eacute; subido al servidor.<br>";  
   } 
?>
<br>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td><?
$sizekb = 0.0 ;
$sizemb = 0.0 ;
$dir=opendir('.');
while ($file = readdir($dir))
{ 
if($file != "ver_aviso_cuota.php" AND $file != "erroracceso.php" AND $file != "aviso_cuota.php" AND $file != "..") {
  {
   if((filesize($file) < 1024) AND (filesize($file) > 1)){ $sizekb = filesize($file);
   echo"<a href=\"$file\">&nbsp;$file</a> @ $sizekb bytes<br>"; }
   if((filesize($file) > 1024) AND (filesize($file) < 1024000)){ $sizekb = round(filesize($file)/1024,2);
   echo"<a href=\"$file\">&nbsp;$file</a> @ $sizekb Kb<br>"; }
   if(filesize($file) > 1024000){ $sizekb = round(filesize($file)/1024000,2);
   echo"<a href=\"$file\">&nbsp;$file</a> @ $sizekb Mb<br>"; }
  }
}
}
closedir($dir) ;
?></td>
  </tr>
</table>
<br>
<tr>
</body> 
</html> 