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
$MM_restrictGoTo = "../opcce/erroracceso.php";
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
<title>Cartas de Cr&eacute;dito Exportaci&oacute;nes</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
.Estilo3 {	font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
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
.Estilo4 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {font-size: 9px}
.Estilo6 {	color: #FFFFFF;
	font-weight: bold;
}
.Estilo7 {color: #CCCCCC}
.Estilo16 {font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
</script>
<script>
var segundos=1200
var direccion='http://180.122.14.168:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<link rel="shortcut icon" href="../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="73%" align="left" valign="middle"><span class="Estilo3">CARTAS DE CR&Eacute;DITO EXPORTACIONES</span></td>
    <td width="27%" rowspan="2" align="left" valign="middle"><div align="right">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60" align="right">
          <param name="movie" value="../../imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="../../imagenes/SWF/reloj_3.swf" width="250" height="60" align="right" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
        </object>
    </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="Estilo6">CAMBIAR A:</span>
      <select name="menu3" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
        <option selected>Seleccione Una Opci&oacute;n</option>
        <option value="../opcbe/cobexport.php">Cobranza de Exportaci&oacute;n</option>
        <option value="../opcbi/cobimport.php">Cobranza de Importaci&oacute;n</option>
        <option value="../opcci/carcreimp.php">Carta de Cr&eacute;dito Importaci&oacute;n</option>
        <option value="../opcce/carcreexp.php">Carta de Cr&eacute;dito Exportaci&oacute;n</option>
        <option value="../opcdpa/cedeypaant.php">Cecio Dere / Pago Ant</option>
        <option value="../opcam/cambio.php">Cambio</option>
        <option value="../opmec/meco.php">Mercado Corredores</option>
    </select></td>
  </tr>
</table>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td bordercolor="#000000"><br>
      <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr>
          <td width="422" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"> Apertura Carta de Cr&eacute;dito </span></td>
          <td width="422" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"> Confirmaci&oacute;n Carta de Cr&eacute;dito </span></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/apertura/modmae.php">Modificaci&oacute;n Apertura Carta de Cr&eacute;dito</a></td>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/confirmacion/modmae.php">Modificaci&oacute;n Confirmaci&oacute;n </a></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/apertura/elimae.php">Eliminar Apertura Carta de Cr&eacute;dito</a></td>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/confirmacion/elimae.php">Eliminar Confirmaci&oacute;n </a></td>
        </tr>
      </table>
      <div align="center">
      <br>
      <br>
      <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr bgcolor="#999999">
          <td width="422" height="19" align="left" valign="middle"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"> Enmienda Carta de Cr&eacute;dito<span class="Estilo5"> (Anulaci&oacute;n - MSG Swift)</span></span></td>
          <td width="422" height="19" align="left" valign="middle"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"> Negociaci&oacute;n Carta de Cr&eacute;dito</span></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/modificacion/ingmae.php">Ingreso MSG-Swift</a></td>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/negociacion/modmae.php">Modificar Documentos de Embarque</a> / <a href="../opcce/reparos/modmae.php">Modificar Reparo </a></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/modificacion/modmae.php">Modificaci&oacute;n Enmienda Carta de Cr&eacute;dito</a></td>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/negociacion/elimae.php">Eliminar Documentos de Embarque</a> / <a href="../opcce/reparos/elimae.php">Eliminar Reparo </a></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/modificacion/elimae.php">Eliminar Enmienda Carta de Cr&eacute;dito</a></td>
          <td align="left" valign="middle">&nbsp;</td>
        </tr>
      </table>
      <br>
      <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr bgcolor="#999999">
          <td width="422" height="19" align="left" valign="middle"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"> Alzamiento / Pago / Liquidaci&oacute;n Carta de Cr&eacute;dito</span></td>
          <td width="422" height="19" align="left" valign="middle"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"> Solicitud Confirmaci&oacute;n Carta de Cr&eacute;dito</span></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/pagos/ingcontmae.php">Ingreso Pago / Liquidaci&oacute;n </a></td>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/cartas/modmae.php">Modificaci&oacute;n Solicitud  Confirmaci&oacute;n</a></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/pagos/modmae.php">Modificaci&oacute;n Alzamiento / Pago / Liquidaci&oacute;n</a></td>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/cartas/elimae.php">Eliminar Solicitud Confirmaci&oacute;n</a></td>
        </tr>
        <tr>
          <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcce/pagos/elimae.php">Eliminar Pago</a></td>
          <td align="left" valign="middle"><span class="Estilo7">.</span></td>
        </tr>
      </table>
      <br>
      <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr>
          <td colspan="2" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"> Control y Estado de Operaciones</span></td>
        </tr>
        <tr bgcolor="#999999">
          <td align="center" valign="middle"><span class="Estilo6">Alta Operaciones</span>
          <td align="center" valign="middle"><span class="Estilo6">Consulta y Control de Operaciones</span></td>
        </tr>
        <tr>
          <td width="50%" align="center" valign="middle"><select name="menu2" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
            <option selected>Seleccione Alta Operaciones</option>
            <option value="../opcce/controles/altaope/altaopmae.php">Alta Operaciones Operador</option>
            <option value="../opcce/controles/altaope/altamae.php">Alta Operaciones Supervisor</option>
            <option value="../opcce/controles/altaope/altdocdismae.php">Alta Doctos al Cobro</option>
            <option value="../opcce/asignacion/ingmae.php">Asignaci&oacute;n Operaciones</option>
          </select>
          <td width="50%" align="center" valign="middle"><select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
            <option selected>Seleccione Una Consulta</option>
            <option value="../opcce/controles/consulop/conromae.php">Consulta Opera. Por Nro</option>
            <option value="../opcce/controles/consulop/corutmae.php">Consulta Opera. Por Rut</option>
            <option value="../opcce/controles/consulop/concurrier.php">Consulta Opera. Por Currier</option>
            <option value="../opcce/controles/consulop/opcursadasaper.php">Consulta Eventos (Ape-Mod-Anu-Msg)</option>
            <option value="../opcce/controles/consulop/opcursadasnego.php">Consulta Eventos (Neg-Alz-Cont-End)</option>
            <option value="../opcce/controles/consulop/apedisc.php">Aperturas con Discrepancias</option>
            <option value="../opcce/controles/consulop/docdisc.php">Doctos con Discrepancias</option>
            <option value="../opcce/controles/consulop/oppendientes.php">Operaciones Pendientes</option>
            <option value="../opcce/controles/consulop/informeporcliente.php">Oparaciones por Cliente</option>
            <option value="../opcce/controles/impresiones/imprerepmae.php">Impresi&oacute;n Carta Confirmaci&oacute;n</option>
            <option value="../opcce/controles/reparos/imprerepmae.php">Impresi&oacute;n Carta Reparo</option>
            <option value="../opcce/visacion/principal.php">Visaci&oacute;n</option>
          </select>
          <div align="center"></div></td>
        </tr>
      </table>
      <br></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image11','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image11" width="80" height="25" border="0"></a></td>
  </tr>
</table>
</body>
</html>