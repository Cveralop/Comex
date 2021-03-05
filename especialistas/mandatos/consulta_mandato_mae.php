<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,MAN";
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

$colname_consultamandatos = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_consultamandatos = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_consultamandatos = sprintf("SELECT * FROM cliente WHERE rut_cliente = %s", GetSQLValueString($colname_consultamandatos, "text"));
$consultamandatos = mysql_query($query_consultamandatos, $comercioexterior) or die(mysqli_error());
$row_consultamandatos = mysqli_fetch_assoc($consultamandatos);
$totalRows_consultamandatos = mysqli_num_rows($consultamandatos);
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
-->
</style>
<title>Consulta Mandatos - Maestro</title>
<link href="../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')"><table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONSULTA MANDATOS - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR OPERACIONES</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Consulta Mandatos</span></td>
    </tr>
    <tr>
      <td width="19%" align="right" valign="middle">Rut Cliente:</td>
      <td width="81%" align="left" valign="middle"><label>
        <input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="16" maxlength="16" />
        <span class="rojopequeno">Sin puntos ni Guion</span></label></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle"><label>
        <input name="button" type="submit" class="boton" id="button" value="Buscar Mandato" />
      </label></td>
    </tr>
  </table>
</form>
<?php if ($totalRows_consultamandatos > 0) { // Show if recordset not empty ?>
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ver Detalle</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Rut Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Nombre Cliente</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Especialista NI</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Ingresado Por</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Fecha Ingreso</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Visado Por</td>
      <td align="center" valign="middle" bgcolor="#999999" class="titulocolumnas">Estado</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center" valign="middle"><a href="consulta_mandato_det.php?recordID=<?php echo $row_consultamandatos['id']; ?>"><img src="../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0" /></a></td>
        <td align="center" valign="middle"><?php echo $row_consultamandatos['rut_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consultamandatos['nombre_cliente']; ?></td>
        <td align="left" valign="middle"><?php echo $row_consultamandatos['especialista']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consultamandatos['ing_operador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consultamandatos['fecha_ingreso']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consultamandatos['visador']; ?></td>
        <td align="center" valign="middle"><?php echo $row_consultamandatos['estado_mandato']; ?></td>
      </tr>
      <?php } while ($row_consultamandatos = mysqli_fetch_assoc($consultamandatos)); ?>
  </table>
  <br />
  <table width="50%" border="0" align="center">
    <tr>
      <td><?php if ($pageNum_consultamandatos > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consultamandatos=%d%s", $currentPage, 0, $queryString_consultamandatos); ?>">Primero</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_consultamandatos > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_consultamandatos=%d%s", $currentPage, max(0, $pageNum_consultamandatos - 1), $queryString_consultamandatos); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
      <td><?php if ($pageNum_consultamandatos < $totalPages_consultamandatos) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consultamandatos=%d%s", $currentPage, min($totalPages_consultamandatos, $pageNum_consultamandatos + 1), $queryString_consultamandatos); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
      <td><?php if ($pageNum_consultamandatos < $totalPages_consultamandatos) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_consultamandatos=%d%s", $currentPage, $totalPages_consultamandatos, $queryString_consultamandatos); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
    </tr>
  </table>
  <br />
  Registros del<?php echo ($startRow_consultamandatos + 1) ?> al <?php echo min($startRow_consultamandatos + $maxRows_consultamandatos, $totalRows_consultamandatos) ?> de un total de<?php echo $totalRows_consultamandatos ?><br />
  <?php } // Show if recordset not empty ?>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="mandatos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
<?php
mysqli_free_result($consultamandatos);
?>