<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
  session_start();
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  global $comercioexterior;

  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($comercioexterior, $theValue) : mysqli_escape_string($comercioexterior, $theValue);
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
$rutcliente=$_GET['rut_cliente'];
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_cliente = 10;
$pageNum_cliente = 0;
if (isset($_GET['pageNum_cliente'])) {
  $pageNum_cliente = $_GET['pageNum_cliente'];
}
$startRow_cliente = $pageNum_cliente * $maxRows_cliente;
$colname_cliente = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_cliente = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cliente = sprintf("SELECT * FROM cliente WHERE rut_cliente = %s", GetSQLValueString($colname_cliente, "text"));
$query_limit_cliente = sprintf("%s LIMIT %d, %d", $query_cliente, $startRow_cliente, $maxRows_cliente);
$cliente = mysql_query($query_limit_cliente, $comercioexterior) or die(mysqli_error());
$row_cliente = mysqli_fetch_assoc($cliente);
if (isset($_GET['totalRows_cliente'])) {
  $totalRows_cliente = $_GET['totalRows_cliente'];
} else {
  $all_cliente = mysql_query($query_cliente);
  $totalRows_cliente = mysqli_num_rows($all_cliente);
}
$totalPages_cliente = ceil($totalRows_cliente/$maxRows_cliente)-1;
$queryString_cliente = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_cliente") == false && 
        stristr($param, "totalRows_cliente") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_cliente = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_cliente = sprintf("&totalRows_cliente=%d%s", $totalRows_cliente, $queryString_cliente);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Envio Operaciones a Curse - Maestro</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
}
a {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #F00;
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
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
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
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">INGRESO OPERACIONES PARA ENVIO A CURSE - MAESTRO</td>
    <td width="5%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">RED DE SUCURSALES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulodetalle">Ingreso Caratula Operaciones de Comercio Exterior</span></td>
    </tr>
    <tr>
      <td width="18%" align="right">Rut Cliente:</td>
      <td width="82%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15" />
      <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input name="button" type="submit" class="boton" id="button" value="Buscar" />
      <input name="button2" type="reset" class="boton" id="button2" value="Limpiar" /></td>
    </tr>
  </table>
</form>
<br />
<?php if ($totalRows_cliente > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Ingresar Registro</td>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Ejecutivo</td>
      <td align="center" valign="middle" class="titulocolumnas">Especialista NI</td>
      <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
      <td align="center" valign="middle" class="titulocolumnas">Oficina</td>
      <td align="center" valign="middle" class="titulocolumnas">Sucursal</td>
      <td align="center" valign="middle" class="titulocolumnas">Territorial</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="ingcaratdet.php?recordID=<?php echo $row_cliente['id']; ?>"><img src="../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0" align="middle" /></a></td>
        <td align="center" valign="middle"><?php echo $row_cliente['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_cliente['nombre_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_cliente['nombre_ejecutivo']; ?></td>
        <td align="left" valign="middle"><?php echo $row_cliente['especialista']; ?></td>
        <td align="left" valign="middle"><?php echo $row_cliente['ejecutivo']; ?></td>
        <td align="left" valign="middle"><?php echo $row_cliente['oficina']; ?></td>
        <td align="center" valign="middle"><?php echo $row_cliente['sucursal']; ?></td>
        <td align="left" valign="middle"><?php echo $row_cliente['territorial']; ?></td>
      </tr>
      <?php } while ($row_cliente = mysqli_fetch_assoc($cliente)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_cliente > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cliente=%d%s", $currentPage, 0, $queryString_cliente); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cliente > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cliente=%d%s", $currentPage, max(0, $pageNum_cliente - 1), $queryString_cliente); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_cliente < $totalPages_cliente) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cliente=%d%s", $currentPage, min($totalPages_cliente, $pageNum_cliente + 1), $queryString_cliente); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_cliente < $totalPages_cliente) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cliente=%d%s", $currentPage, $totalPages_cliente, $queryString_cliente); ?>">Último</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del<span class="respuestacolumna_azul"><?php echo ($startRow_cliente + 1) ?></span> al <span class="respuestacolumna_azul"><?php echo min($startRow_cliente + $maxRows_cliente, $totalRows_cliente) ?></span> de un total de <span class="respuestacolumna_azul"><?php echo $totalRows_cliente ?></span>
  <?php } // Show if recordset not empty ?>
<br />
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../gerenciaregional.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
</body>
</html>
<?php
mysqli_free_result($cliente);
?>