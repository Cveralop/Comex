<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
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

$colname_visacionmandatos = "Ingresado no Visado";
if (isset($_GET['estado_mandato'])) {
  $colname_visacionmandatos = $_GET['estado_mandato'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_visacionmandatos = sprintf("SELECT cliente.*,(usuarios.nombre)as opera FROM cliente, usuarios WHERE estado_mandato = %s and (cliente.ing_operador = usuarios.usuario)", GetSQLValueString($colname_visacionmandatos, "text"));
$visacionmandatos = mysql_query($query_visacionmandatos, $comercioexterior) or die(mysqli_error());
$row_visacionmandatos = mysqli_fetch_assoc($visacionmandatos);
$totalRows_visacionmandatos = mysqli_num_rows($visacionmandatos);
?>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 10px;
	color: #00F;
}
body {
	background-image: url(../../imagenes/JPEG/edificio_corporativo.jpg);
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

</style>
<title>Visacion Mandatos - Maestro</title>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')"><table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">VISACION MANDATOS - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR OPERACIONES</td>
  </tr>
</table>
<br />
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Visar Mandato</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ingresado Por</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
    <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><a href="visacion_mandatos_det.php?recordID=<?php echo $row_visacionmandatos['id']; ?>"><img src="../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0" /></a></td>
      <td align="center" valign="middle"><?php echo $row_visacionmandatos['rut_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_visacionmandatos['nombre_cliente']; ?></td>
      <td align="left" valign="middle"><?php echo $row_visacionmandatos['especialista']; ?></td>
      <td align="left" valign="middle"><?php echo $row_visacionmandatos['opera']; ?></td>
      <td align="center" valign="middle"><?php echo $row_visacionmandatos['fecha_ingreso']; ?></td>
      <td align="center" valign="middle"><?php echo $row_visacionmandatos['estado_mandato']; ?></td>
    </tr>
    <?php } while ($row_visacionmandatos = mysqli_fetch_assoc($visacionmandatos)); ?>
</table>
<br />
<?php echo $totalRows_visacionmandatos ?> Registros en Total
<?php
mysqli_free_result($visacionmandatos);
?>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="mandatos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>