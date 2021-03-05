<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,SUP";
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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_operador = 5000;
$pageNum_operador = 0;
if (isset($_GET['pageNum_operador'])) {
  $pageNum_operador = $_GET['pageNum_operador'];
}
$startRow_operador = $pageNum_operador * $maxRows_operador;
$colname3_operador = "Endoso Anticipado.";
if (isset($_GET['evento'])) {
  $colname3_operador = (get_magic_quotes_gpc()) ? $_GET['evento'] : addslashes($_GET['evento']);
}
$colname2_operador = "1";
if (isset($_GET['nro_operacion'])) {
  $colname2_operador = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
$colname1_operador = "Pendiente.";
if (isset($_GET['sub_estado'])) {
  $colname1_operador = (get_magic_quotes_gpc()) ? $_GET['sub_estado'] : addslashes($_GET['sub_estado']);
}
$colname_operador = "0";
if (isset($_GET['operador'])) {
  $colname_operador = (get_magic_quotes_gpc()) ? $_GET['operador'] : addslashes($_GET['operador']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_operador = sprintf("SELECT * FROM opcci WHERE operador = '%s' and sub_estado = '%s' and nro_operacion LIKE '%%%s%%' and evento = '%s' ORDER BY urgente,nro_operacion DESC", $colname_operador,$colname1_operador,$colname2_operador,$colname3_operador);
$query_limit_operador = sprintf("%s LIMIT %d, %d", $query_operador, $startRow_operador, $maxRows_operador);
$operador = mysql_query($query_limit_operador, $comercioexterior) or die(mysqli_error());
$row_operador = mysqli_fetch_assoc($operador);
if (isset($_GET['totalRows_operador'])) {
  $totalRows_operador = $_GET['totalRows_operador'];
} else {
  $all_operador = mysql_query($query_operador);
  $totalRows_operador = mysqli_num_rows($all_operador);
}
$totalPages_operador = ceil($totalRows_operador/$maxRows_operador)-1;
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_colores = "SELECT * FROM parametrocolores";
$colores = mysqli_query($comercioexterior, $query_colores) or die(mysqli_error($comercioexterior));
$row_colores = mysqli_fetch_assoc($colores);
$totalRows_colores = mysqli_num_rows($colores);
$queryString_operador = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_operador") == false && 
        stristr($param, "totalRows_operador") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_operador = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_operador = sprintf("&totalRows_operador=%d%s", $totalRows_operador, $queryString_operador);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Alta Operaciones Operador - Maestro</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
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
.Estilo5 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo11 {color: #00FF00}
-->
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
function MM_jumpMenuGo(selName,targ,restore){ //v3.0
  var selObj = MM_findObj(selName); if (selObj) MM_jumpMenu(targ,selObj,restore);
}
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">ALTA OPERACIONES OPERADOR - MAESTRO</td>
    <td width="7%" rowspan="3" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CAMBIAR A <select name="menu1" class="etiqueta12" onChange="MM_jumpMenu('parent',this,1)">
      <option selected>Seleccione Una Opci&oacute;n</option>
      <option value="../../../opcce/controles/altaope/altaopmae.php">Cartas de Cr&eacute;dito Exportaci&oacute;n</option>
      <option value="../../../opcdpa/controles/altaope/altaopmae.php">Cesiones de Derecho</option>
</select>
        <input name="Button1" type="button" class="etiqueta12" onClick="MM_jumpMenuGo('menu1','parent',1)" value="Ir">
    </td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Alta Operaciones</span></td>
    </tr>
    <tr valign="middle">
      <td width="22%" align="right" valign="middle">Operador:</div></td>
      <td width="78%" align="left" valign="middle">      <input name="operador" type="text" disabled="disabled" class="etiqueta12" id="operador" value="Op. Cero" size="20" maxlength="20">
      <input name="operador" type="hidden" id="operador" value="0"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
      <td align="left" valign="middle">        <input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7"> 
      <span class="rojopequeno">K000000</span> </td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="submit" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_operador > 0) { // Show if recordset not empty ?>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../carcreimp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image31','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image31" width="80" height="25" border="0" id="Image31"></a>
      </div></td>
  </tr>
</table>
<?php } // Show if recordset not empty ?>
</div>
<br>
  <?php if ($totalRows_operador > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="8" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo5">Total de Operaciones Pendientes <span class="Estilo11"><?php echo $totalRows_operador ?></span></span></div></td>
    </tr>
    <tr valign="middle" bgcolor="#999999">
      <td align="center" class="titulocolumnas">Cursar</div></td>
      <td align="center" class="titulocolumnas">Evento
        </div>
      </td>
      <td align="center" class="titulocolumnas">Fecha Ingreso 
        </div>
      </td>
      <td align="center" class="titulocolumnas">Nro Operaci&oacute;n</div>
      </td>
      <td align="center" class="titulocolumnas">Nombre Cliente 
        </div>
      </td>
      <td align="center" class="titulocolumnas">Urgente</td>
      <td align="center" class="titulocolumnas">Monto Apertura 
        </div>
      </td>
      <td align="center" class="titulocolumnas">Monto Negociaci&oacute;n</div>
      </td>
    </tr>
    <?php do { ?>
    <tr valign="middle">
      <td align="center"><a href="altaalzadet.php?recordID=<?php echo $row_operador['id']; ?>"> <img src="../../../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0"></a></div></td>
      <td align="center"><?php echo $row_operador['evento']; ?></div></td>
      <td align="center"><?php echo $row_operador['fecha_ingreso']; ?></div></td>
      <td align="center"> <span class="respuestacolumna_rojo"><?php echo strtoupper($row_operador['nro_operacion']); ?></span>        </div></td>
      <td align="left"><?php echo $row_operador['nombre_cliente']; ?></div></td>
      <td align="center"><?php if ($row_operador['urgente'] <> $row_colores['verdeno']) { // Show if not first page ?>
        <span class="Rojo2"><?php echo $row_operador['urgente']; ?> </span></span>        
		<?php } // Show if not first page ?>
		<?php if ($row_operador['urgente'] <> $row_colores['rojosi']) { // Show if not first page ?>
        <span class="Verde2"><?php echo $row_operador['urgente']; ?> </span></span>
      <?php } // Show if not first page ?></td>
      <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_operador['moneda_operacion']); ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_operador['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
      <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_operador['moneda_documentos']); ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_operador['monto_documentos'], 2, ',', '.'); ?></strong> </div></td>
    </tr>
    <?php } while ($row_operador = mysqli_fetch_assoc($operador)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
  <br>
</div>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../carcreimp.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($operador);
mysqli_free_result($colores);
?>