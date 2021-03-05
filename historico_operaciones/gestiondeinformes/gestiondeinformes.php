<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM";
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Gestion de Informes</title>
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
.Estilo6 {	color: #FFFFFF;
	font-weight: bold;
}
.Estilo4 {	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {font-size: 10px}
.Estilo8 {font-size: 10px; font-weight: bold; color: #FFFFFF; }
.Estilo9 {color: #CCCCCC}
.Estilo10 {color: #0000FF}
-->
</style>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<script language="JavaScript" type="text/JavaScript">
<!--
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
//-->
</script>
</head>

<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="5%" valign="middle"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="left"></td>
    <td width="66%" align="left" valign="middle"><span class="Estilo3">GESTI&Oacute;N DE INFORMES</span></td>
    <td width="29%" valign="middle">
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
    <td bordercolor="#000000">
<br>
            <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
              <tr>
                <td width="100%" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Registro Log's de Procesos Automaticos</span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" width="13" height="12"><a href="logdeprocesos/logsprocesosautomaticos.php">Log's Procesos Automaticos</a><a href="../../gestiondeinformes/usuarios/ingreso.php"></a></td>
              </tr>
            </table>
<br>
<table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
              <tr>
                <td width="100%" height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Informes de Control y Gesti&oacute;n</span></td>
              </tr>
              <tr>
                <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/operacionesreparadasdet.php">Operaciones Reparadas</a></tr>
              <tr>
                <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/operacionesingresadasmae.php">Operaciones Ingresadas Por Rango de Fecha</a></tr>
              <tr>
                <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/resumencurseoperacionesmae.php">Resumen Estadistica Curse Operaciones</a></tr>
              <tr>
                <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/panel_control_mae.php">Panel de Control (Productividad por rango de fechas)</a>                
        </tr>
              <tr>
                <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="informegestion/ciclos_panel_control_mae.php">Panel de Control (Ciclos)                              </a>                
        </tr>
            </table>
<br>
<table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td height="19" colspan="2" align="left" valign="middle" bgcolor="#FF3300"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Informe Dashboard (Operaciones Nuevas)</span></td>
    </tr>
  <tr>
    <td width="50%" align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/panel_control_mae.php">DASHBOARD por Rango de Fechas (Total)</a></td>
    <td width="50%" align="left" valign="middle"><span class="Estilo4"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/ciclos_panel_control_mae.php">DASHBOARD por  CICLOS Ultimos 3 Dias (Total)</a></span></td>
    </tr>
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/panel_control_mae_bei.php">DASCHBOARD por Rango de Fecha (BEI)</a></td>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/ciclos_panel_control_mae_bei.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BEI)</a></td>
    </tr>
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/panel_control_mae_bc.php">DASCHBOARD por Rango de Fecha (BCA Comercial)</a></td>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/ciclos_panel_control_mae_bc.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BCA Comercial)</a></td>
    </tr>
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/panel_control_mae_bmg.php">DASCHBOARD por Rango de Fecha (BMG)</a></td>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/ciclos_panel_control_mae_bmg.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BMG)</a></td>
    </tr>
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/panel_control_mae_pyme.php">DASCHBOARD por Rango de Fecha (PYME)</a></td>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_nuevas_operaciones/ciclos_panel_control_mae_pyme.php">DASCHBOARD por CICLOS Ultimos 3 Dias (PYME)</a></td>
    </tr>
</table>
<br>
<table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td height="19" colspan="2" align="left" valign="middle" bgcolor="#FF6600"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0">Informe Dashboard (Todos Los Eventos)</span></td>
  </tr>
  <tr>
    <td width="50%" align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/panel_control_mae.php">DASHBOARD por Rango de Fechas (Total)</a></td>
    <td width="50%" align="left" valign="middle"><span class="Estilo4"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/ciclos_panel_control_mae.php">DASHBOARD por  CICLOS Ultimos 3 Dias (Total)</a></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/panel_control_mae_bei.php">DASCHBOARD por Rango de Fecha (BEI)</a></td>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/ciclos_panel_control_mae_bei.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BEI)</a></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/panel_control_mae_bc.php">DASCHBOARD por Rango de Fecha (BCA Comercial)</a></td>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/ciclos_panel_control_mae_bc.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BCA Comercial)</a></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/panel_control_mae_bmg.php">DASCHBOARD por Rango de Fecha (BMG)</a></td>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/ciclos_panel_control_mae_bmg.php">DASCHBOARD por CICLOS Ultimos 3 Dias (BMG)</a></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/panel_control_mae_pyme.php">DASCHBOARD por Rango de Fecha (PYME)</a></td>
    <td align="left" valign="middle"><img src="../../imagenes/GIF/check.gif" alt="" width="13" height="12"><a href="../dashboard_todoslos_eventos/ciclos_panel_control_mae_pyme.php">DASCHBOARD por CICLOS Ultimos 3 Dias (PYME)</a></td>
  </tr>
</table>
<br>
<br>
<br>
      </td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../historico.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>