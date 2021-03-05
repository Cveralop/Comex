<?php require_once('../../../../Connections/comercioexterior.php'); ?>
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

$colname_consultanro = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname_consultanro = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_consultanro = sprintf("SELECT * FROM oppre nolock WHERE nro_operacion = %s ORDER BY id DESC", GetSQLValueString($colname_consultanro, "text"));
$consultanro = mysql_query($query_consultanro, $comercioexterior) or die(mysqli_error());
$row_consultanro = mysqli_fetch_assoc($consultanro);
$totalRows_consultanro = mysqli_num_rows($consultanro);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones por Numero - Maestro</title>
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
	color: #FF0000;
	font-weight: bold;
}
.Estilo6 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 12px;
}
.Estilo8 {color: #FFFFFF; font-weight: bold; }
.Estilo11 {color: #00FF00}
.Estilo13 {color: #0000FF; font-weight: bold; }
-->
</style>
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
    <td width="93%" align="left" class="Estilo3">CONSULTA OPERACIONES POR NUMERO - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><span class="Estilo6"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo6">Consulta por Numero Operaci&oacute;n </span></td>
    </tr>
    <tr valign="middle">
      <td width="22%" align="right">Nro Operaci&oacute;n:</td>
      <td width="78%" align="left"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
      <span class="rojopequeno">F-L 000000</span></td>
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
<?php if ($totalRows_consultanro > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="9" align="left"><span class="Estilo6"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo6">Numero Operaci&oacute;n <span class="Estilo11"><?php echo $row_consultanro['nro_operacion']; ?></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Consultar</div></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Estado
      </div>
    </td>
    <td align="center" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" class="titulocolumnas">Monto Apertura
      </div>      
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Cuotas </td>
    <td align="center" valign="middle" class="titulocolumnas">Tipo Operaci&oacute;n</td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="conrodet.php?recordID=<?php echo $row_consultanro['id']; ?>"> <img src="../../../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0"></a></div></td>
    <td align="center"><?php echo $row_consultanro['fecha_ingreso']; ?> </div></td>
    <td align="left"><?php echo $row_consultanro['nombre_cliente']; ?> </td>
    <td align="center"><?php echo $row_consultanro['evento']; ?> </div></td>
    <td align="center"><?php echo $row_consultanro['estado']; ?> </div></td>
    <td align="center"><?php echo $row_consultanro['operador']; ?></div></td>
    <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_consultanro['moneda_operacion']); ?></span><span class="Estilo5"><span class="respuestacolumna_azul"> <?php echo number_format($row_consultanro['monto_operacion'], 2, ',', '.'); ?></span></span>
      </div></td>
    <td align="center"><?php echo $row_consultanro['nro_cuotas']; ?></td>
    <td align="center"><?php echo $row_consultanro['tipo_operacion']; ?></td>
  </tr>
  <?php } while ($row_consultanro = mysqli_fetch_assoc($consultanro)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_consultanro > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consultanro=%d%s", $currentPage, 0, $queryString_consultanro); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_consultanro > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consultanro=%d%s", $currentPage, max(0, $pageNum_consultanro - 1), $queryString_consultanro); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_consultanro < $totalPages_consultanro) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consultanro=%d%s", $currentPage, min($totalPages_consultanro, $pageNum_consultanro + 1), $queryString_consultanro); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_consultanro < $totalPages_consultanro) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consultanro=%d%s", $currentPage, $totalPages_consultanro, $queryString_consultanro); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_consultanro + 1) ?></strong> al <strong><?php echo min($startRow_consultanro + $maxRows_consultanro, $totalRows_consultanro) ?></strong> de un total de <strong><?php echo $totalRows_consultanro ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($consultanro);
?>