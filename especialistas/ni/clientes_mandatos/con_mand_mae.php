<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ESP,ADM";
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
$MM_restrictGoTo = "../erroracceso.php";
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

$colname_consulmandatos = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_consulmandatos = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_consulmandatos = sprintf("SELECT * FROM cliente nolock WHERE rut_cliente = %s ORDER BY date_ingreso DESC", GetSQLValueString($colname_consulmandatos, "text"));
$consulmandatos = mysql_query($query_consulmandatos, $comercioexterior) or die(mysqli_error());
$row_consulmandatos = mysqli_fetch_assoc($consulmandatos);
$totalRows_consulmandatos = mysqli_num_rows($consulmandatos);
?>
<title>Consulta Mandato - Maestro</title><style type="text/css">
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
	font-weight: bold;
}
a:link {
	text-decoration: none;
	color: #F00;
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
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')"><table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">CONSULTA MANDATO - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">NEGOCIO INTERNACIONAL</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulo_menu">Consulta Mandato</span></td>
    </tr>
    <tr>
      <td width="19%" align="right" valign="middle">Rut Cliente:</td>
      <td width="81%" align="left" valign="middle"><label>
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="16" maxlength="16">
        <span class="rojopequeno">Sin puntos ni Guion</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar Mandato Cliente">
      </label></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_consulmandatos > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ver Registro</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ingresado Por</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="con_mand_det.php?recordID=<?php echo $row_consulmandatos['id']; ?>"><img src="../../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0"></a></td>
        <td align="center" valign="middle"><?php echo $row_consulmandatos['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consulmandatos['nombre_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consulmandatos['especialista']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consulmandatos['ing_operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulmandatos['date_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consulmandatos['estado_mandato']; ?></td>
      </tr>
      <?php } while ($row_consulmandatos = mysqli_fetch_assoc($consulmandatos)); ?>
  </table>
  <br>
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_consulmandatos > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consulmandatos=%d%s", $currentPage, 0, $queryString_consulmandatos); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_consulmandatos > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consulmandatos=%d%s", $currentPage, max(0, $pageNum_consulmandatos - 1), $queryString_consulmandatos); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_consulmandatos < $totalPages_consulmandatos) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consulmandatos=%d%s", $currentPage, min($totalPages_consulmandatos, $pageNum_consulmandatos + 1), $queryString_consulmandatos); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_consulmandatos < $totalPages_consulmandatos) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consulmandatos=%d%s", $currentPage, $totalPages_consulmandatos, $queryString_consulmandatos); ?>">Último</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br>
  Registros del<?php echo ($startRow_consulmandatos + 1) ?> al <?php echo min($startRow_consulmandatos + $maxRows_consulmandatos, $totalRows_consulmandatos) ?> de un total de <?php echo $totalRows_consulmandatos ?><br>
 
  <?php } // Show if recordset not empty ?>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="clientes_mandatos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen4','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen4" width="80" height="25" border="0"></a></td>
  </tr>
</table>
 <?php
mysqli_free_result($consulmandatos);
?>