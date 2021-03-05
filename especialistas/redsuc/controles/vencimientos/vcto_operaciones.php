<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "RED,ADM";
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

$colname_vcto_operaciones = "-1";
if (isset($_GET['ejecutivo_ni'])) {
  $colname_vcto_operaciones = $_GET['ejecutivo_ni'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_vcto_operaciones = sprintf("SELECT * FROM vctooperaciones nolock WHERE ejecutivo_ni = %s ORDER BY fecha_vcto ASC", GetSQLValueString($colname_vcto_operaciones, "text"));
$vcto_operaciones = mysql_query($query_vcto_operaciones, $comercioexterior) or die(mysqli_error());
$row_vcto_operaciones = mysqli_fetch_assoc($vcto_operaciones);
$totalRows_vcto_operaciones = mysqli_num_rows($vcto_operaciones);

mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_Recordset1 = "SELECT * FROM vctooperaciones nolock GROUP BY ejecutivo_ni";
$Recordset1 = mysqli_query($comercioexterior, $query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysqli_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vcto Operaciones</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../../../imagenes/JPEG/edificio_corporativo.jpg);
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
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body onload="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="95%" align="left" valign="middle" class="Estilo3">VENCIMIENTO OPEREACIONES SISTEMA PRODUCTO BKT</td>
    <td width="5%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">TERRITORIALES - RED DE SUCURSALES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" />Vencimiento Operaciones por Ejecutivo NI</td>
    </tr>
    <tr>
      <td width="22%" align="right" valign="middle">Ejecutivo NI:</td>
      <td width="78%" align="left" valign="middle"><select name="ejecutivo_ni" class="etiqueta12" id="ejecutivo_ni">
        <option value="">Seleccione un Ejecutivo NI</option>
        <?php
 while($row_Recordset1 = mysqli_fetch_assoc($Recordset1)){
  echo "<option value='".$row_Recordset1['ejecutivo_ni']."'>".$row_Recordset1['ejecutivo_ni']."</option>";
  }
 ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><input name="button" type="submit" class="boton" id="button" value="Buscar" /></td>
    </tr>
  </table>
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../redsuc.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<br />
<?php if ($totalRows_vcto_operaciones > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_rojo"><?php echo number_format($totalRows_vcto_operaciones, 0, ',', '.') ?></span> <span class="respuestacolumna_azul">Registros Total <br />
  </span><br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Operación</td>
      <td align="center" valign="middle" class="titulocolumnas">Nro Cuota</td>
      <td align="center" valign="middle" class="titulocolumnas">Moneda</td>
      <td align="center" valign="middle" class="titulocolumnas">Saldo Operacion</td>
      <td align="center" valign="middle" class="titulocolumnas">Tasa Fina Cliente</td>
      <td align="center" valign="middle" class="titulocolumnas">Fecha de Vcto</td>
      <td align="center" valign="middle" class="titulocolumnas">Nombre Ejecutivo</td>
      <td align="center" valign="middle" class="titulocolumnas">Ejecutivo NI</td>
      <td align="center" valign="middle" class="titulocolumnas">Sucursal</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['rut_cliente']; ?><a href="untitled.php?recordID=<?php echo $row_vcto_operaciones['sistema']; ?>"></a></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['nombre_cliente']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_vcto_operaciones['nro_operacion']; ?></td>
        <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_vcto_operaciones['secuencia']; ?></td>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['moneda']; ?></td>
        <td align="right" valign="middle"><?php echo number_format($row_vcto_operaciones['saldo_vigente'], 2, ',', '.'); ?></td>
        <td align="center" valign="middle"><?php echo number_format($row_vcto_operaciones['tasa_final_cliente'], 6, ',', '.'); ?></td>
        <td align="center" valign="middle"><?php echo $row_vcto_operaciones['fecha_vcto']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['nombre_ejecutivo']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['ejecutivo_ni']; ?></td>
        <td align="left" valign="middle"><?php echo $row_vcto_operaciones['sucursal']; ?></td>
      </tr>
      <?php } while ($row_vcto_operaciones = mysqli_fetch_assoc($vcto_operaciones)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysqli_free_result($vcto_operaciones);
mysqli_free_result($Recordset1);
?>