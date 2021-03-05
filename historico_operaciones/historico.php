<?php
if (!isset($_SESSION)) {
  session_start();
}
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
<title>Historico Operaciones</title>
<style type="text/css">
<!--
@import url("../estilos/estilo12.css");
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
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
<script language="JavaScript" type="text/JavaScript">
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
<link rel="shortcut icon" href="../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3">HISTORICO OPERACIONES</span></td>
    <td align="right" valign="middle">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
          <param name="movie" value="../imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
        </object>
    </div></td>
  </tr>
</table>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td bordercolor="#000000"><br>
      <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Consulta Operaciones</span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/controles/avisocuotas/impavicuomae.php">Aviso Pago Cuotas Operaciones Prestamos</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opbga/consultas/consulta.php">Consulta Operaciones Boletas de Garantias</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opcbe/consultas/consulta.php">Consulta Operaciones Cobranza Extranjera de Exportacion</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opcbi/consultas/consulta.php">Consulta Operaciones Cobranza Extranjera de Importacion y OPI</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opcce/consultas/consulta.php">Consulta Operaciones de Cartas de Credito de Exportaci&oacute;n</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opcci/consultas/consulta.php">Consulta Operaciones de Cartas de Credito de Importaci&oacute;n</a> // y // <a href="historico/opcci/consultas/consultaneg.php">Operaciones Negociadas</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opcreext/consultas/consulta.php">Consulta Operaciones Creditos Externos</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opiiib5/consultas/consulta.php">Consulta Operaciones de Creditos IIIB5</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opmec/consultas/consulta.php">Consulta Operaciones de Mercado de Corredores</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/oppre/consultas/consulta.php">Consulta Operaciones de Prestamos</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="historico/opstbe/consultas/consulta.php">Consulta Operaciones Stand Bye Emitidas</a></td>
          </tr>
      </table>
      <br>
      <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr>
          <td height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Gesti&oacute;n de Informes</span></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="gestiondeinformes/gestiondeinformes.php">Informes de Gesti&oacute;n</a></td>
        </tr>
      </table>
<br>
    </td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../ingreso.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen16','','../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen16" width="80" height="25" border="0" align="middle"></a></div></td>
  </tr>
</table>
<br>
</body>
</html>