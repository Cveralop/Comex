<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "TER,ADM";
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
$MM_restrictGoTo = "../../erroracceso.php";
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
$colname_opporcliente = "zzz";
if (isset($_GET['rut_cliente'])) {
  $colname_opporcliente = (get_magic_quotes_gpc()) ? $_GET['rut_cliente'] : addslashes($_GET['rut_cliente']);
}
$colname1_opporcliente = "1";
if (isset($_GET['fecha_curse'])) {
  $colname1_opporcliente = (get_magic_quotes_gpc()) ? $_GET['fecha_curse'] : addslashes($_GET['fecha_curse']);
}
$colname2_opporcliente = "1";
if (isset($_GET['evento'])) {
  $colname2_opporcliente = (get_magic_quotes_gpc()) ? $_GET['evento'] : addslashes($_GET['evento']);
}
$colname3_opporcliente = "1";
if (isset($_GET['estado'])) {
  $colname3_opporcliente = (get_magic_quotes_gpc()) ? $_GET['estado'] : addslashes($_GET['estado']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opporcliente = sprintf("SELECT * FROM opcci WHERE rut_cliente = '%s' and fecha_curse LIKE '%%%s%%' and evento LIKE '%%%s%%' and estado LIKE '%%%s%%' ORDER BY id ASC", $colname_opporcliente,$colname1_opporcliente,$colname2_opporcliente,$colname3_opporcliente);
$opporcliente = mysqli_query($comercioexterior,$query_opporcliente) or die(mysqli_error());
$row_opporcliente = mysqli_fetch_assoc($opporcliente);
$totalRows_opporcliente = mysqli_num_rows($opporcliente);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Operaciones por Cliente</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {
	color: #0000FF;
	font-weight: bold;
}
.Estilo12 {color: #00FF00}
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
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
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
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
</head>
<body onLoad="MM_preloadImages('../../../../espcomex/imagenes/Botones/boton_volver_2.jpg','../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">OPERACIONES POR CLIENTE </td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Operaciones por Cliente</span></td>
    </tr>
    <tr valign="middle">
      <td width="21%" align="right">Rut Cliente:</div></td>
      <td width="79%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Fecha Curse:</div></td>
      <td align="left"><input name="fecha_curse" type="text" class="etiqueta12" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa) - (mm-aaaa) - (aaaa) </span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Evento:</div></td>
      <td align="left"><select name="evento" class="etiqueta12" id="evento">
<option value="Apertura." selected>Apertura</option>
        <option value="Prorroga.">Prorroga</option>
        <option value="Cambio Tasa.">Cambio Tasa</option>
        <option value="Pago.">Pago</option>
        <option value="Visacion.">Visacion (DI)</option>
        <option value="Cartera Vencida.">Cartera Vencida</option>
        <option value="Requerimiento.">Requerimiento</option>
        <option value="Solucion Excepcion.">Solucion Excepcion</option>
        <option value="Dev Comisiones.">Dev Comisiones</option>
        <option value="Carta Original.">Carta Original</option>
        <option value=".">Todos</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right">Estado:</div></td>
      <td align="left"><select name="estado" class="etiqueta12" id="estado">
        <option value="Cursada." selected>Cursada</option>
        <option value="Pendiente.">Pendiente</option>
        <option value="Reparada.">Reparada</option>
        <option value=".">Todas</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
          <input name="Submit" type="submit" class="boton" value="Buscar">
          <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../oppre.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_opporcliente > 0) { // Show if recordset not empty ?>
<table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="8" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Total de&nbsp;&nbsp;<span class="Estilo12"><?php echo $totalRows_opporcliente ?></span> Operaciones </span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Numero Operaci&oacute;n </div></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Fecha Curse
      </div>
    </td>
    <td align="center" class="titulocolumnas">Rut 
      </div>
    Cliente</td>
    <td align="center" class="titulocolumnas">Nombre
      </div>
    Cliente</td>
    <td align="center" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Especialista 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>      
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opporcliente['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo $row_opporcliente['fecha_ingreso']; ?></div></td>
    <td align="center"><?php echo $row_opporcliente['fecha_curse']; ?></div></td>
    <td align="center"><?php echo $row_opporcliente['rut_cliente']; ?></div></td>
    <td align="left"><?php echo $row_opporcliente['nombre_cliente']; ?></td>
    <td align="center"><?php echo $row_opporcliente['evento']; ?></div></td>
    <td align="center"><?php echo strtoupper($row_opporcliente['especialista']); ?></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_opporcliente['moneda_operacion']); ?></span><span class="Estilo8"> <span class="respuestacolumna_azul"><?php echo number_format($row_opporcliente['monto_operacion'], 2, ',', '.'); ?></span></span>
      </div></td>
  </tr>
    <?php } while ($row_opporcliente = mysqli_fetch_assoc($opporcliente)); ?>
</table>
<?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($opporcliente);
?>