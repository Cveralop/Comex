<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,ESP";
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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Negocio Internacional Post Venta</title>
<style type="text/css">

.Estilo3 {font-size: 24px;
	color: #FFFFFF;
	font-weight: bold;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #FFF;
	font-weight: bold;
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
.Estilo4 {	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	color: #0000FF;
	font-weight: bold;
}

</style>
<script language="JavaScript" type="text/JavaScript">

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
/
</script>

<script>
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='../../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>

<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td align="left" valign="middle"><span class="Estilo3"> </span><span class="Estilo3"> NEGOCIO INTERNACIONAL POST VENTA</span></td>
    <td rowspan="2" align="right" valign="middle">
        <!-- <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="250" height="60">
          <param name="movie" value="../../imagenes/SWF/reloj_3.swf">
          <param name="quality" value="high">
          <embed src="../../imagenes/SWF/reloj_3.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="250" height="60"></embed>
        </object> -->
    </div></td>
  </tr>
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000">OPERADOR: (<?php echo strtoupper($row_usuario['nombre']);?>) &AacuteREA: (<?php echo strtoupper($row_usuario['segmento']);?>)</td>
  </tr>
</table>
<br>
<table width="95%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td bordercolor="#000000"><br>
        <table width="90%"  border="0" align="center">
          <tr>
            <td width="32%" valign="middle"><a href="opcci/opcci.php"><img src="../../imagenes/Botones/ccimportacion.jpg" width="150" height="40" border="0"></a></div></td>
            <td width="2%" valign="middle">&nbsp;</td>
            <td width="32%" valign="middle"><a href="opmec/opmec.php"><img src="../../imagenes/Botones/meco.jpg" width="150" height="40" border="0"></a></div></td>
            <td width="2%" valign="middle"></div></td>
            <td width="31%" valign="middle"><a href="opcbi/opcbi.php"><img src="../../imagenes/Botones/cbi_opi.jpg" width="150" height="40" border="0"></a></div></td>
          </tr>
          <tr>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td valign="middle"><a href="opcce/opcce.php"><img src="../../imagenes/Botones/ccexportacion.jpg" width="150" height="40" border="0"></a></div></td>
            <td valign="middle"></div></td>
            <td valign="middle"><a href="oppre/oppre.php"><img src="../../imagenes/Botones/prestamos.jpg" width="150" height="40" border="0"></a></div></td>
            <td valign="middle"></div></td>
            <td valign="middle"><a href="opcbe/opcbe.php"><img src="../../imagenes/Botones/cobexportacion.jpg" width="150" height="40" border="0"></a></div></td>
          </tr>
          <tr>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td valign="middle"><a href="opstbe/opste.php"><img src="../../imagenes/Botones/standbtemitidas.jpg" width="150" height="40" border="0"></a></div></td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle"><a href="opbga/opbga.php"><img src="../../imagenes/Botones/boleta_garantia.jpg" width="150" height="40" border="0"></a></div></td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle"><a href="opcreext/opcreext.php"><img src="../../imagenes/Botones/cambio_otros.jpg" width="150" height="40" border="0"></a></div></td>
          </tr>
          <tr>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td valign="middle"><a href="opiiib5/opiiib5.php"><img src="../../imagenes/Botones/creditos_iiib5.jpg" width="150" height="40" border="0"></a></div></td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle"><a href="clientes_mandatos/clientes_mandatos.php"><img src="../../imagenes/Botones/cliente.jpg" width="150" height="40" border="0"></a></td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle"><a href="clavebcos/clavebcos.php"><img src="../../imagenes/Botones/bcos_con_clave.jpg" width="150" height="40" border="0"></a></td>
          </tr>
          <tr>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
          </tr>
          <tr>
            <td valign="middle"><a href="../controles_especialistas/excepciones/excepciones.php"><img src="../../imagenes/Botones/solucion_excepcion.jpg" width="150" height="40" border="0"></a></td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle">&nbsp;</td>
            <td valign="middle"><a href="../controles_especialistas/convenioweb/convenioweb.php"><img src="../../imagenes/Botones/convenioweb.jpg" width="150" height="40" border="0"></a></td>
          </tr>
        </table>
<br>
        <table width="90%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
          <tr>
            <td height="19" align="left" valign="middle" bgcolor="#999999"><span class="Estilo4"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"> Control Operaciones</span></td>
          </tr>
          <tr>
            <td align="left" valign="middle"><select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
              <option value="ni.php">Seleccione Una Opci&oacute;n</option>
              <option value="controles/controlop.php">Control Operaciones</option>
              <option value="controles/controles_acb/controlop_acbei.php">Asistente Comercial BEI</option>
              <option value="controles/controlop_postventa.php">Control Post Venta</option>
              <option value="../../archivos/msgswift/msgswiftni.php">MSG Swift</option>
              <option value="../redsuc/controles/redsucxrutcliente.php">Operaciones Territoriales</option>
              <option value="ni.php">--- Avisos ---</option>
              <option value="controles/avisocuotas/apertura/impavisomae.php">Impresion Avisos Apertura</option>
              <option value="controles/avisocuotas/impavicuomae.php">Impresi&oacute;n Aviso Cuotas</option>
              <option value="../../archivos/carpeta_virtual/prestamo/ver_aviso_cuota.php">Prestamos Avisos Cuotas</option>
              <option value="../../archivos/carpeta_virtual/cambio/cambio_ni.php">Avisos Cambios Internaciones</option>
              <option value="informes/impavisoplapro_mae.php">Avisos Plazo Proveedor</option>
              <option value="ni.php">--- Consultas ---</option>
              <option value="../controles_especialistas/devengo/interesesmae.php">Proyeccion de Intereses</option>
              <option value="../controles_especialistas/pagareparagua/modpagmae.php">Consulta Pagare Paragua</option>
              <option value="ni.php">--- Informes NI ---</option>
              <option value="informes/operaciones.php">Flujo por Segmento</option>
              <option value="informes/estadooperacionesmae.php">Estado Operaciones</option>
              <option value="informes/nomina_vcto_operaciones.php">Vcto Operaciones Total</option>
              <option value="informes/nomina_vcto_opera_mae.php">Vcto Operaciones por Rango Fecha</option>
              <option value="informes/operacionesingresadasmae.php">Operaciones Ingresadas</option>
              <option>--- SAC ---</option>
              <option value="sac/subirarchivo.php">Subir Archivo SAC</option>
              <option value="sac/cargasac.php">Cargar Archivo SAC</option>
              <option value="sac/sacpendientes">Consulta SAC Pendientes</option>
              <option>--- Estadistica Post Venta ---</option>
              <option value="controles/estadistica/operaciones_postventa_mae.php">Curse Diario</option>
              <option value="controles/estadistica/estadistica_postventa_mae.php">Curse x Rango de Fecha</option>
            </select></td>
          </tr>
      </table>
        <br>
    </div></td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../ingreso.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($usuario);
?>