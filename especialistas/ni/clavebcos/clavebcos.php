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

$colname_clavebcos = "1";
if (isset($_GET['nombre_banco'])) {
  $colname_clavebcos = $_GET['nombre_banco'];
}
$colname1_clavebcos = "1";
if (isset($_GET['codigo_swift'])) {
  $colname1_clavebcos = $_GET['codigo_swift'];
}
$colname2_clavebcos = "1";
if (isset($_GET['pais'])) {
  $colname2_clavebcos = $_GET['pais'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_clavebcos = sprintf("SELECT * FROM claves_banco nolock WHERE nombre_banco LIKE %s and codigo_swift LIKE %s and pais LIKE %s ORDER BY nombre_banco ASC", GetSQLValueString($colname_clavebcos . "%", "text"),GetSQLValueString($colname1_clavebcos . "%", "text"),GetSQLValueString($colname2_clavebcos . "%", "text"));
$clavebcos = mysql_query($query_clavebcos, $comercioexterior) or die(mysqli_error());
$row_clavebcos = mysqli_fetch_assoc($clavebcos);
$totalRows_clavebcos = mysqli_num_rows($clavebcos);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Clave Bancos</title>
<style type="text/css">
<!--
@import url("../../../estilos/estilo12.css");
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
}
body {
	background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
.Estilo6 {color: #FFFFFF; font-weight: bold; }
.Estilo7 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo10 {color: #00FF00}

</style>
<script> 
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<link rel="shortcut icon" href="../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONSULTA CLAVE BANCOS</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr align="left">
    <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo7">Consulta Clave Bancos</span></td>
    </tr>
    <tr>
      <td width="21%" align="right" valign="middle">Nombre Bancos:</div></td>
      <td width="79%" align="left" valign="middle"><input name="nombre_banco" type="text" class="etiqueta12" id="nombre_banco" size="80" maxlength="80"></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Codigo Swift:</div></td>
      <td align="left" valign="middle"><input name="codigo_swift" type="text" class="etiqueta12" id="codigo_swift" size="17" maxlength="15"></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Pais:</div></td>
      <td align="left" valign="middle"><input name="pais" type="text" class="etiqueta12" id="pais" size="30" maxlength="50"></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar"></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_clavebcos > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td colspan="7" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo7">Banco Preferente <span class="Estilo10"><?php echo $row_clavebcos['canalizacion']; ?></span></span></td>
  </tr>
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Codigfo Swift </div></td>
    <td align="center" valign="middle" class="titulodetalle"><span class="titulocolumnas">Recibir
      </div>
    </span></td>
    <td align="center" valign="middle" class="titulodetalle"><span class="titulocolumnas">Enviar
      </div>
    </span></td>
    <td align="center" valign="middle" class="titulodetalle"><span class="titulocolumnas">Nombre Banco 
      </div>
    </span></td>
    <td align="center" valign="middle" class="titulodetalle"><span class="titulocolumnas">Ciudad
      </div>
    </span></td>
    <td align="center" valign="middle" class="titulodetalle"><span class="titulocolumnas">Codigo Ciudad 
      </div>
    </span></td>
    <td align="center" valign="middle" class="titulodetalle"><span class="titulocolumnas">Pa&iacute;s</div>
    </span></td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><?php echo $row_clavebcos['codigo_swift']; ?></div></td>
    <td align="center" valign="middle"><?php echo $row_clavebcos['recivir']; ?> </div></td>
    <td align="center" valign="middle"><?php echo $row_clavebcos['enviar']; ?></div></td>
    <td align="left" valign="middle"><?php echo $row_clavebcos['nombre_banco']; ?></td>
    <td align="left" valign="middle"><?php echo $row_clavebcos['ciudad']; ?> </div></td>
    <td align="center" valign="middle"><?php echo $row_clavebcos['codigo_ciudad']; ?> </div></td>
    <td align="left" valign="middle"><?php echo $row_clavebcos['pais']; ?></div></td>
  </tr>
  <?php } while ($row_clavebcos = mysqli_fetch_assoc($clavebcos)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_clavebcos > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_clavebcos=%d%s", $currentPage, 0, $queryString_clavebcos); ?>">Primero</a>
      <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_clavebcos > 0) { // Show if not first page ?>
      <a href="<?php printf("%s?pageNum_clavebcos=%d%s", $currentPage, max(0, $pageNum_clavebcos - 1), $queryString_clavebcos); ?>">Anterior</a>
      <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_clavebcos < $totalPages_clavebcos) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_clavebcos=%d%s", $currentPage, min($totalPages_clavebcos, $pageNum_clavebcos + 1), $queryString_clavebcos); ?>">Siguiente</a>
      <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_clavebcos < $totalPages_clavebcos) { // Show if not last page ?>
      <a href="<?php printf("%s?pageNum_clavebcos=%d%s", $currentPage, $totalPages_clavebcos, $queryString_clavebcos); ?>">&Uacute;ltimo</a>
      <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_clavebcos + 1) ?></strong> al <strong><?php echo min($startRow_clavebcos + $maxRows_clavebcos, $totalRows_clavebcos) ?></strong> de un total de <strong><?php echo $totalRows_clavebcos ?></strong>
<?php } // Show if recordset not empty ?> <br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../ni.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($clavebcos);
?>