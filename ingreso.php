<?php require_once('Connections/comercioexterior.php'); ?>
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
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{

  global $comercioexterior;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($comercioexterior, $theValue) : mysqli_escape_string($comercioexterior, $theValue);
  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($comercioexterior, $theValue) : mysqli_escape_string($comercioexterior, $theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$colname_usuario = "-1";
if (isset($_SESSION['login'])) {
  $colname_usuario = $_SESSION['login'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_usuario = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_usuario, "text"));
$usuario = mysqli_query($comercioexterior, $query_usuario) or die(mysqli_error($comercioexterior));
$row_usuario = mysqli_fetch_assoc($usuario);
$totalRows_usuario = mysqli_num_rows($usuario);

$colname_ultimoacceso = "-1";
if (isset($_SESSION['login'])) {
  $colname_ultimoacceso = $_SESSION['login'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ultimoacceso = sprintf("SELECT * FROM controlacceso WHERE usuario = %s ORDER BY id DESC LIMIT 1,1", GetSQLValueString($colname_ultimoacceso, "text"));
$ultimoacceso = mysqli_query($comercioexterior, $query_ultimoacceso) or die(mysqli_error($comercioexterior));
$row_ultimoacceso = mysqli_fetch_assoc($ultimoacceso);
$totalRows_ultimoacceso = mysqli_num_rows($ultimoacceso);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Gestor Operaciones Comex</title>
<style type="text/css">

@import url("estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo5 {
	font-size: 24px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo16 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo13 {font-size: 9px}
.Estilo4 {color: #0000FF; font-weight: bold; font-size: 10px; }

</style>

<script>

/*Script original de KarlanKas para forosdelweb.com  */
//'http://pdpto38:8303/comex/index.php' 
var segundos=10
var direccion='cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);



function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
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

</script> 

</head>
<link rel="shortcut icon" href="../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../comex/imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('imagenes/Botones/boton_salir_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="43" align="left" valign="middle"><img src="imagenes/GIF/erde016.gif" width="43" height="43" align="left"></td>
    <td width="717" align="left" valign="middle"><span class="Estilo5">COMERCIO EXTERIOR</span></td>
    <td width="250" rowspan="2" valign="middle"><div align="right">
      <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60" align="right">
          <param name="movie" value="imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="imagenes/SWF/reloj_3.swf" width="250" height="60" align="right" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
      </object>
    </div></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="middle"><span class="Estilo16">OPERADOR: (<?php echo strtoupper($row_usuario['nombre']);?>) ÁREA: (<?php echo strtoupper($row_usuario['segmento']);?>)</span></td>
  </tr>
</table>
<br>
<br>
<link rel="shortcut icon" href="favicon.ico">
<link rel="icon" type="image/gif" href="animated_favicon1.gif">
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td><br>
      <table width="90%"  border="0" align="center">
        <tr>
          <td colspan="5" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="imagenes/GIF/led_verde.gif" width="13" height="13"> Operaciones Comercio Exterior</td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td width="32%" valign="middle"></div>
          <a href="operaciones/principal.php"><img src="imagenes/Botones/operaciones_comex.jpg" width="200" height="70" border="0" align="middle"></a></td>
          <td width="1%" valign="middle"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div></td>
          <td width="33%" align="center" valign="middle"></div>
            <a href="control_interno/controlinterno.php"><img src="imagenes/Botones/control_interno.jpg" width="200" height="70" border="0" align="middle"></a>
          <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div>            <div align="center"></div></td>
          <td width="1%" align="center" valign="middle">&nbsp;</td>
          <td width="33%" align="center" valign="middle"><a href="gestiondeinformes/gestiondeinformes.php"><img src="imagenes/Botones/gestion_de_informes.jpg" width="200" height="70" border="0" align="middle"></a></td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td valign="middle"><a href="especialistas/ni/ni.php"><img src="imagenes/Botones/negocio_internacional.jpg" width="200" height="70" border="0" align="middle"></a></td>
          <td valign="middle">&nbsp;</td>
          <td align="center" valign="middle"><a href="especialistas/territorial/tr.php"><img src="imagenes/Botones/operaciones_territoriales.jpg" width="200" height="70" border="0" align="middle"></a></td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle"><a href="especialistas/bmg/bmg.php"><img src="imagenes/Botones/operaciones_bmg.jpg" width="200" height="70" border="0" align="middle"></a></td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="left" valign="middle" bgcolor="#999999"><span class="titulo_menu"><img src="imagenes/GIF/led_rojo.gif" alt="" width="13" height="13"> Red de Sucursales, Ejecutivos de Negocio Internacional</span></td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="left" valign="middle" bgcolor="#999999"><span class="titulo_menu"><img src="imagenes/GIF/led_amarillo.gif" alt="" width="13" height="13"> Acceso Goc Historico</span></td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td valign="middle"><a href="especialistas/redsuc/redsuc.php"><img src="imagenes/Botones/red_sucursales.jpg" width="200" height="70" border="0" align="top"></a></td>
          <td valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle"><a href="historico_operaciones/historico.php"><img src="imagenes/Botones/goc_historico.jpg" width="200" height="70" border="0"></a></td>
        </tr>
        <tr>
          <td valign="middle">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
          <td align="center" valign="middle">&nbsp;</td>
        </tr>
      </table>
<br></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="cierre.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen10','','imagenes/Botones/boton_salir_2.jpg',1)"><img src="imagenes/Botones/boton_salir_1.jpg" alt="Salir" name="Imagen10" width="80" height="25" border="0"></a>      </div></td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="left" valign="middle"><span class="respuestacolumna_azul">ULTIMO ACCESO =</span> <span class="respuestacolumna_rojo"><?php echo $row_ultimoacceso['fecha_acceso'];?></span></td>
  </tr>
  <tr>
    <td align="left" valign="middle"><span class="Estilo4"><img src="imagenes/ICONOS/llave.jpg" alt="" width="15" height="15"> <span class="Estilo13">Cambio de Password</span>
        <select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
          <option selected>Seleccione Una Opci&oacute;n</option>
          <option value="usuarios/cambiopassword/cambiopassword.php">Cambio de Password</option>
        </select>
    </span></td>
  </tr>
</table>
<?php
mysqli_free_result($usuario);
mysqli_free_result($ultimoacceso);
?>