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
$MM_restrictGoTo = "../opcbe/erroracceso.php";
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
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="shortcut icon" href="../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../imagenes/barraweb/animated_favicon1.gif">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Cobranza de Exportaci&oacute;n</title>
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
.Estilo8 {color: #FFFFFF; font-size: 12px;}
.Estilo12 {font-size: 9px; color: #FF0000; }
.Estilo13 {font-size: 10px}
.Estilo6 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo15 {color: #CCCCCC}
.Estilo16 {font-size: 12px; font-weight: bold; color: #999999; }
.Estilo161 {font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}

</style>

<!-- <script language="JavaScript" type="text/JavaScript">

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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

</script>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>  -->

</head>
<link rel="shortcut icon" href="../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="73%" align="left" valign="middle"><span class="Estilo3">COBRANZA EXTRANJERA DE EXPORTACI&Oacute;N</span></td>
    <td width="27%" rowspan="2" align="left" valign="middle">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60" align="right">
          <param name="movie" value="../../imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="../../imagenes/SWF/reloj_3.swf" width="250" height="60" align="right" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
        </object>
    </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="Estilo6">CAMBIAR A:</span>
      <select name="menu2" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
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
            <td width="50%" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"> </span><span class="titulodetalle">Registro Cobranza de Exportaci&oacute;n</span></td>
            <td width="50%" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"> <img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="titulodetalle">Reparos</span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcbe/apertura/modmae.php">Modificar Registro Cob de Export</a></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcbe/reparos/modmae.php">Ingreso o Modificaci&oacute;n Reparo</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcbe/apertura/elimae.php">Eliminar Registro Cob de Export</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcbe/reparos/elimae.php">Eliminar Reparo</a></td>
          </tr>
        </table>
        <br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td colspan="2" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="titulodetalle">Control y Estado de Operaciones</span></td>
          </tr>
          <tr bgcolor="#999999">
            <td align="center" valign="middle"><span class="Estilo6">Alta Operaciones</span><td align="center" valign="middle"><span class="Estilo6">Consulta y Control de Operaciones</span></div></td>
          </tr>
          <tr>
            <td width="50%" align="center" valign="middle">                
                  <select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                    <option selected>Seleccione Alta Operaciones</option>
                    <option value="../opcbe/controles/altaope/altaopmae.php">Alta Operaciones Ope.</option>
                    <option value="../opcbe/controles/altaope/altamae.php">Alta Operaciones Sup.</option>
                    <option value="../opcbe/controles/altaope/altareqmae.php">Alta Operaciones Req.</option>
                    <option value="../opcbe/controles/altaope/acepmae.php">Aceptacion de Documentos</option>
                    <option value="../opcbe/asignacion/ingmae.php">Asignaci&oacute;n Operaciones</option>
                  </select>
              </div>
            <td width="50%" align="center" valign="middle">
                <select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Una Consulta</option>
                  <option value="../opcbe/controles/consulop/conromae.php">Consulta Opera. Por Nro</option>
                  <option value="../opcbe/controles/consulop/corutmae.php">Consulta Opera. Por Rut</option>
                  <option value="../opcbe/controles/consulop/concurrier.php">Consulta Opera. Por Currier</option>
                  <option value="../opcbe/controles/consulop/opcursadasaper.php">Consulta Eventos CBE</option>
                  <option value="../opcbe/controles/consulop/compraventa.php">Compra Venta</option>
                  <option value="../opcbe/controles/consulop/oppendientes.php">Operaciones Pendientes</option>
                  <option value="../opcbe/controles/consulop/informeporcliente.php">Operaciones por Cliente</option>
                  <option value="../opcbe/controles/consulop/contdoctosmae.php">Control Documentos</option>
                  <option value="../opcbe/controles/reparos/imprerepmae.php">Imprimir Reparos</option>
                  <option value="../opcbe/visacion/principal.php">Visacion</option>
</select>
            </div>              
            </div></td>
          </tr>
        </table>
      <br></td>
    </tr>
  </table>
  <br>
  <table width="95%"  border="0" align="center">
    <tr>
      <td align="right" valign="middle"><a href="../principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image11','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image11" width="80" height="25" border="0"></a></div></td>
    </tr>
  </table>
</body>
</html>