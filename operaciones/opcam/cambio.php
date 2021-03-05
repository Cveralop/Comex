<?php
session_start();
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
$MM_restrictGoTo = "../opcam/erroracceso.php";
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
<title>Cambios</title>
<style type="text/css">
<!--
@import url("../../estilos/estilo12.css");
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
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo17 {font-size: 9px}
.Estilo16 {font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="73%" align="left" valign="middle"><span class="Estilo3">CAMBIOS</span></td>
    <td width="27%" align="left" valign="middle">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60" align="right">
          <param name="movie" value="../../imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="../../imagenes/SWF/reloj_3.swf" width="250" height="60" align="right" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
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
            <td width="50%" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Ingreso Cartas de Cr&eacute;dito Stand By Recibidas</span></div></td>
            <td width="50%" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"> <img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Otros Eventos Carta de Cr&eacute;dito Stand By Recibidas <span class="Estilo17">(</span><span class="Estilo17">Modificaci&oacute;n - Msg Swift - Anulaci&oacute;n -&nbsp; Prorroga - Comisiones - Pago)</span></span></div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingstdreci/ingmae.php">Ingreso CCS Recibidas</a></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otrostdreci/ingmae.php">Ingreso Otros CCS Recibidas</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingstdreci/modmae.php">Modificaci&oacute;n CCS Recibidas</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otrostdreci/modmae.php">Modificaci&oacute;n Otros CCS Recibidas</a></div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingstdreci/elimae.php">Eliminar CCS Recibidas</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otrostdreci/elimae.php">Eliminar Otros CCS Recibidas</a></div></td>
          </tr>
        </table>
<br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td width="50%" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Ingreso Cartas de Cr&eacute;dito Stand By Emitidas</span></div></td>
            <td width="50%" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"> <img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Otros Eventos Carta de Cr&eacute;dito Stand By Emitidas <span class="Estilo17">(</span><span class="Estilo17">Modificaci&oacute;n - Msg Swift - Anulaci&oacute;n -&nbsp; Prorroga - Comisiones - Pago)</span></span></div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingstdemi/ingmae.php">Ingreso CCS Emitidas</a></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otrostdemi/ingmae.php">Ingreso Otros CCS Emitidas</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingstdemi/modmae.php">Modificaci&oacute;n CCS Emitidas</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otrostdemi/modmae.php">Modificaci&oacute;n Otros CCS Emitidas</a></div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingstdemi/elimae.php">Eliminar CCS Emitidas</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otrostdemi/elimae.php">Eliminar Otros CCS Emitidas</a></div></td>
          </tr>
        </table>
    <br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td width="50%" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Otorgamiento Cr&eacute;dito III B5</span></div></td>
            <td width="50%" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"> <img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo4">Prorroga, Cambio Tasa, Pago Cr&eacute;dito III B5</span></span></div></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otorgatbc/ingmae.php">Otorgamiento Cr&eacute;dito III B5</a></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/modifitbc/ingmae.php">Ingreso Modificaci&oacute;n Cr&eacute;dito III B5</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otorgatbc/modmae.php">Modificaci&oacute;n Cr&eacute;dito III B5</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/modifitbc/modmae.php">Modificaci&oacute;n Cr&eacute;dito III B5</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/otorgatbc/elimae.php">Eliminar Cr&eacute;dito III B5</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/modifitbc/elimae.php">Eliminar Cr&eacute;dito III B5</a></td>
          </tr>
        </table>
<br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td width="50%" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Ingreso Boleta de Garant&iacute;a<span class="Estilo17"></span></span></div></td>
            <td width="50%" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Modificaci&oacute;n, Anulaci&oacute;n, Ejecuci&oacute;n, Boleta de Garant&iacute;a</span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingboleta/ingmae.php">Ingreso Boleta</a></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/modboleta/ingmae.php">Ingreso Modificaci&oacute;n Boleta</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingboleta/modmae.php">Modificaci&oacute;n Boleta</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/modboleta/modmae.php">Modificaci&oacute;n  Boleta</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingboleta/elimae.php">Eliminar Boleta</a></div></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/modboleta/elimae.php">Eliminar  Boleta</a></td>
          </tr>
        </table>
<br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr valign="middle" bgcolor="#999999">
            <td width="50%" height="16" align="left" valign="middle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="titulodetalle">Otros Productos (Cr&eacute;dito Externo - Capitulo XII - Capitulo XIV - DL600) </div>
            </div>
            </span></td>
            <td width="50%" align="left" valign="middle"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Carta Reparo - Documentos Valorados</span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingcredext/ingmae.php">Ingreso Otros Productos</a></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../opcam/cartareparo/imgrep.php">Ingreso Reparos</a></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingcredext/modmae.php">Modificaci&oacute;n Otros Productos</a></td>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><strong><a href="../opcam/docvalo/docvalo.php">Envio y Control Doctos Valorados</a></strong></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../opcam/ingcredext/elimae.php">Eliminar Otros Productos</a></div></td>
            <td align="left" valign="middle" bgcolor="#CCCCCC">&nbsp;</td>
          </tr>
      </table>
  <br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" colspan="2" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Control y Estado de Operaciones</span></td>
          </tr>
          <tr bgcolor="#999999">
            <td align="center" valign="middle"><span class="Estilo6">Alta Operaciones</span><td align="center" valign="middle"><span class="Estilo6">Consulta y Control de Operaciones</span></div></td>
          </tr>
          <tr>
            <td width="50%" align="center" valign="middle">
                <select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione Alta Operaciones</option>
                  <option value="../opcam/controles/altasup/altamae.php">Alta Operaciones Sup.</option>
                  <option value="../opcam/oppendientes/visamae.php">Operaciones Pendientes</option>
</select>
</div>
          <td width="50%" align="center" valign="middle">
                <select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                  <option selected>Seleccione una Consulta</option>
                  <option value="../../archivos/carpeta_virtual/cambio/cambio.php">Carpeta Virtual</option>
                  <option value="../opcam/visacion/visamae.php">Visaci&oacute;n</option>
                  <option value="../opcam/controles/reparos/imprerepmae.php">Imprimir Carta Reparo</option>
                  <option>Seleccione Una Consulta</option>
                  <option>--- Stand By Recibidas ---</option>
                  <option value="../opcam/controles/consulop/stdrconromae.php">Consulta Opera. Por Nro</option>
                  <option value="../opcam/controles/consulop/stdrcorutmae.php">Consulta Opera. Por Rut</option>
                  <option value="../opcam/controles/consulop/stdropcursadas.php">Consulta Eventos STR</option>
                  <option value="../opcam/controles/consulop/stdroppendientes.php">Operaciones Pendientes</option>
                  <option value="../opcam/controles/consulop/stdrcomisionmae.php">Control Cobro Comisiones</option>
                  <option>--- Stand By Emitidas ---</option>
                  <option value="../opcam/controles/consulop/stdeconromae.php">Consulta Opera. Por Nro</option>
                  <option value="../opcam/controles/consulop/stdecorutmae.php">Consulta Opera. Por Rut</option>
                  <option value="../opcam/controles/consulop/stdeopcursadas.php">Consulta Eventos STE</option>
                  <option value="../opcam/controles/consulop/stdeoppendientes.php">Operaciones Pendientes</option>
                  <option value="../opcam/controles/consulop/stdepagarecustmae.php">Nomina Pagares</option>
                  <option value="../opcam/controles/consulop/stdecomisionmae.php">Control Cobro Comisiones</option>
                  <option> --- III B5 ---</option>
                  <option value="../opcam/controles/consulop/tbcconromae.php">Consulta Opera. Por Nro</option>
                  <option value="../opcam/controles/consulop/tbccorutmae.php">Consulta Opera. Por Rut</option>
                  <option value="../opcam/controles/consulop/tbcopcursadas.php">Consulta Eventos III B5</option>
                  <option value="../opcam/controles/consulop/tbcoppendientes.php">Operaciones Pendientes</option>
                  <option value="../opcam/controles/consulop/tbcpagarecustmae.php">Nomina Pagares</option>
                  <option value="../opcam/controles/consulop/tbctasavariablemae.php">Tasa Variable</option>
                  <option>--- Otros Productos ---</option>
                  <option value="../opcam/controles/consulop/creconromae.php">Consulta Opera. Por Nro</option>
                  <option value="../opcam/controles/consulop/crecorutmae.php">Consulta Opera. Por Rut</option>
                  <option value="../opcam/controles/consulop/creopcursadas.php">Consulta Eventos Otros Prod.</option>
                  <option value="../opcam/controles/consulop/creoppendientes.php">Operaciones Pendientes</option>
                  <option>--- Boletas de Gt&iacute;a ---</option>
                  <option value="../opcam/controles/consulop/bgaconromae.php">Consulta Opera. Por Nro</option>
                  <option value="../opcam/controles/consulop/bgacorutmae.php">Consulta Opera. Por Rut</option>
                  <option value="../opcam/controles/consulop/bgaopcursadas.php">Consulta Eventos Boletas</option>
                  <option value="../opcam/controles/consulop/bgaoppendientes.php">Operaciones Pendientes</option>
                  <option value="../opcam/controles/consulop/bgafoliomae.php">Folio Boletas (Mantenedor)</option>
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
    <td align="right" valign="middle"><a href="../principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image18','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image18" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     