<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM";
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
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_consulta = 10;
$pageNum_consulta = 0;
if (isset($_GET['pageNum_consulta'])) {
  $pageNum_consulta = $_GET['pageNum_consulta'];
}
$startRow_consulta = $pageNum_consulta * $maxRows_consulta;

$colname_consulta = "1";
if (isset($_GET['nombre'])) {
  $colname_consulta = $_GET['nombre'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_consulta = sprintf("SELECT * FROM usuarios nolock WHERE nombre LIKE %s ORDER BY nombre ASC", GetSQLValueString($colname_consulta . "%", "text"));
$query_limit_consulta = sprintf("%s LIMIT %d, %d", $query_consulta, $startRow_consulta, $maxRows_consulta);
$consulta = mysqli_query($comercioexterior, $query_limit_consulta) or die(mysqli_error($comercioexterior));
$row_consulta = mysqli_fetch_assoc($consulta);
$totalRows_consulta = mysqli_num_rows($consulta);

if (isset($_GET['totalRows_consulta'])) {
  $totalRows_consulta = $_GET['totalRows_consulta'];
} else {
  $all_consulta = mysqli_query($comercioexterior, $query_consulta);
  $totalRows_consulta = mysqli_num_rows($all_consulta);
}
$totalPages_consulta = ceil($totalRows_consulta/$maxRows_consulta)-1;

$queryString_consulta = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_consulta") == false && 
        stristr($param, "totalRows_consulta") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_consulta = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_consulta = sprintf("&totalRows_consulta=%d%s", $totalRows_consulta, $queryString_consulta);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Usuarios - Maestro</title>
<style type="text/css">
<!--
@import url("../../gestionmedios/estilos/estilo12.css");
@import url("../../estilos/estilo12.css");
.Estilo3 {font-size: 16px;
	font-weight: bold;
	color: #FFFFFF;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #0000FF;
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
.Estilo5 {color: #FFFFFF; font-weight: bold; }
.Estilo6 {
	font-size: 12px;
	color: #FFFFFF;
}

</style>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script> 
</head>
<link rel="shortcut icon" href="../../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../comex/imagenes/barraweb/animated_favicon1.gif">
</head>
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000" class="titulopaguina">CONSULTA  DE USUARIOS - MAESTRO</div></td>
    <td width="43" align="left" valign="middle" bgcolor="#FF0000"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"> </div></td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><strong><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo6">Consulta Usuarios</span></strong></td>
    </tr>
    <tr>
      <td width="17%" align="right" valign="middle">Nombre:</div></td>
      <td width="83%" align="left" valign="middle"><input name="nombre" type="text" class="etiqueta12" id="nombre" size="80" maxlength="80"></td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
          <input name="Submit" type="submit" class="boton" value="Buscar">
          <input name="Submit" type="reset" class="boton" value="Limpiar">
        </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_consulta > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td valign="middle" class="titulocolumnas">Consultar</div></td>
    <td valign="middle" class="titulocolumnas">Nombre Usuario 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Segmento</td>
    <td align="center" valign="middle" class="titulocolumnas">Perfil</td>
    <td align="center" valign="middle" class="titulocolumnas">&nbsp;</td>
  </tr>
  <?php do { ?>
  <tr>
    <td valign="middle"><a href="consultadet.php?recordID=<?php echo $row_consulta['id']; ?>"> <img src="../../imagenes/ICONOS/ver_registro_2.jpg" width="22" height="19" border="0"></a></div></td>
    <td align="left" valign="middle"><?php echo $row_consulta['nombre']; ?> </td>
    <td align="center" valign="middle"><?php echo $row_consulta['segmento']; ?></td>
    <td align="center" valign="middle"><?php echo $row_consulta['perfil']; ?></td>
    <td align="center" valign="middle">&nbsp;</td>
  </tr>
    <?php } while ($row_consulta = mysqli_fetch_assoc($consulta)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_consulta > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, 0, $queryString_consulta); ?>">Primero</a>
            <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_consulta > 0) { // Show if not first page ?>
            <a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, max(0, $pageNum_consulta - 1), $queryString_consulta); ?>">Anterior</a>
            <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_consulta < $totalPages_consulta) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, min($totalPages_consulta, $pageNum_consulta + 1), $queryString_consulta); ?>">Siguiente</a>
            <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_consulta < $totalPages_consulta) { // Show if not last page ?>
            <a href="<?php printf("%s?pageNum_consulta=%d%s", $currentPage, $totalPages_consulta, $queryString_consulta); ?>">&Uacute;ltimo</a>
            <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<p>Registros del <strong><?php echo ($startRow_consulta + 1) ?></strong> al <strong><?php echo min($startRow_consulta + $maxRows_consulta, $totalRows_consulta) ?></strong> de un total de <strong><?php echo $totalRows_consulta ?></strong></p>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../gestiondeinformes.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($consulta);
?>