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
$MM_restrictGoTo = "../oppre/erroracceso.php";
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
<title>Prestamos</title>
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
	color: #FFF;
}
.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo6 {color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo17 {font-size: 9px}
-->
</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
</script>
</head>
<link rel="shortcut icon" href="../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="73%" align="left" valign="middle"><span class="Estilo3">PR&Eacute;STAMOS STAND ALONE</span></td>
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
          <tr valign="middle">
            <td width="50%" height="19" align="left" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="titulodetalle">Registro Pr&eacute;stamos Stand Alone</span></td>
            <td width="50%" align="left" bgcolor="#999999"><span class="Estilo4"> <img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Reparos</span></td>
          </tr>
          <tr valign="middle">
            <td align="left"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../oppre/apertura/modmae.php">Modificar  Registro Prestamos</a></td>
            <td align="left"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../oppre/reparos/modmae.php">Modificaci&oacute;n Reparo</a></td>
          </tr>
          <tr valign="middle">
            <td align="left"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../oppre/apertura/elimae.php">Eliminar Registro Prestamos</a></div></td>
            <td align="left"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="../oppre/reparos/elimae.php">Eliminar Reparo</a></td>
          </tr>
      </table>
        <br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr valign="middle">
            <td height="19" colspan="2" align="left" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"></span><span class="titulodetalle">Aviso en Cuotas Apertura - Pagos</span></td>
          </tr>
          <tr valign="middle">
            <td width="50%" align="center" bgcolor="#00CC00" class="NegrillaCartaReparo">Avisos de Apertura en Cuotas</td>
            <td width="50%" align="center" bgcolor="#00CC00" class="NegrillaCartaReparo">Avisos de Pago en Cuotas</td>
          </tr>
          <tr valign="middle">
            <td align="left"><a href="ingavicuomae.php"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12" border="0"></a><a href="controles/avisocuotas/apertura/autoavisomae.php">Autorizar Aviso Apertura en Cuotas</a></td>
            <td align="left"><a href="controles/avisocuotas/pago/ingavicuomae.php"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12" border="0">Asignaci&oacute;n Aviso de Pago en Cuotas</a></td>
          </tr>
          <tr valign="middle">
            <td align="left"><a href="ingavicuomae.php"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12" border="0"></a><a href="controles/avisocuotas/apertura/impavisomae.php">Impresi&oacute;n Aviso Apertura en Cuotas</a></td>
            <td align="left"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12" border="0"><a href="controles/avisocuotas/pago/avicuomae.php">Confecci&oacute;n Aviso de Pago en Cuotas</a></td>
          </tr>
          <tr valign="middle">
            <td align="left">&nbsp;</td>
            <td align="left"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12" border="0"><a href="controles/avisocuotas/pago/impavicuomae.php">Impresi&oacute;n Aviso de Pago en Cuotas</a></td>
          </tr>
        </table>
    <br>
    <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
      <tr valign="middle">
            <td height="19" colspan="2" align="left" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Control y Estado de Operaciones</span></td>
          </tr>
          <tr valign="middle" bgcolor="#999999">
            <td align="center" class="titulocolumnas">Alta Operaciones<td align="center" class="titulocolumnas">Consulta y Control de Operaciones</td>
          </tr>
          <tr valign="middle">
            <td width="50%" align="center">
                <form name="form1" method="post" action="">
                  <select name="menu3" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                    <option value="prestamos.php" selected>Seleccione Alta Operaciones</option>
                    <option value="../oppre/controles/altaope/altaopmae.php">Alta Operaciones Ope.</option>
                    <option value="../oppre/controles/altaope/altamae.php">Alta Operaciones Sup.</option>
                    <option value="../oppre/asignacion/ingmae.php">Asignaci&oacute;n Operaciones</option>
                    <option>--- OP MECO ---</option>
                    <option value="../oppre/envioop/envioopmae.php">Enviar OP a MECO</option>
                    <option value="../oppre/envioop/envioopconsulta.php">Consulta Envio OP MECO</option>
                    <option>--- Tecnica ---</option>
                    <option value="../oppre/controles/tecnica/ingtecnicamae.php">Asignaci&oacute;n Tecnica</option>
                  </select>
                  <input name="Button2" type="button" class="etiqueta12" onClick="MM_jumpMenuGo('menu1','parent',1)" value="Ir">
                </form>
            <td width="50%" align="center">
                <form name="form2" method="post" action="">
                  <select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
                    <option value="prestamos.php" selected>Seleccione Una Consulta</option>
                    <option value="../oppre/controles/consulop/conromae.php">Consulta Opera. Por Nro</option>
                    <option value="../oppre/controles/consulop/corutmae.php">Consulta Opera. Por Rut</option>
                    <option value="../oppre/controles/consulop/opcursadas.php">Consulta Eventos Prestamos</option>
                    <option value="../oppre/controles/consulop/compraventa.php">Compra Venta</option>
                    <option value="../oppre/controles/consulop/oppendientes.php">Operaciones Pendientes</option>
                    <option value="../oppre/controles/consulop/informeporcliente.php">Operaciones por Cliente</option>
                    <option value="../oppre/controles/consulop/opcanceladas.php">Operaciones Canceladas</option>
                    <option value="../oppre/controles/consulop/opnocursadas.php">Operaciones no Cursadas</option>
                    <option value="../oppre/controles/consulop/opasignadas.php">Operaciones Asignadas</option>
                    <option value="../oppre/controles/consulop/paecansindusmae.php">PAE Sin DUS</option>
                    <option value="../oppre/controles/reparos/imprerepmae.php">Impresi&oacute;n Carta Reparo</option>
                    <option value="../oppre/visacion/principal.php">Visaci&oacute;n</option>
                    <option>--- Cobex ---</option>
                    <option value="../oppre/controles/consulop/paecobexvigente.php">Operaciones Cobex Cursadas</option>
                    <option>---Pagare Custodia---</option>
                    <option value="../oppre/controles/consulop/pagaremantemae.php">Mantenci&oacute;n Pagar&eacute; Custodia</option>
                    <option value="../oppre/controles/consulop/pagarecustmae.php">Pagare a Custodia</option>
                    <option>---Avisos en Cuotas---</option>
                    <option value="../../archivos/carpeta_virtual/prestamo/aviso_cuota.php">Subir Avisos en Cuotas</option>
                    <option>--- Pago Automatico ---</option>
                    <option value="../oppre/controles/pago_automatico/ing_pago_auto_mae.php">Ingreso Pago Automatico</option>
                    <option value="../oppre/controles/pago_automatico/mod_pago_auto_mae.php">Modificacion Pago Automatico</option>
                    <option value="../devengo/devengo_nomina_pa.php">Nomina Pago Automatico</option>
                    <option>--- Intereses ---</option>
                    <option value="../devengo/devengo_mae.php">Intereses Operaciones</option>
                    <option value="controles/resumen/cuadropagocuotas.php">Cuadro Pago Cuotas</option>
                  </select>
                  <input name="Button1" type="button" class="etiqueta12" onClick="MM_jumpMenuGo('menu1','parent',1)" value="Ir">
                </form></td>
          </tr>
      </table>
    <br></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../principal.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image14','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image14" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>