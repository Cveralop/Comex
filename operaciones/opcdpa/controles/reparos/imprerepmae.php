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

$colname1_cartareparo = "xxx";
if (isset($_GET['rut_cliente'])) {
  $colname1_cartareparo = $_GET['rut_cliente'];
}
$colname2_cartareparo = "zzz";
if (isset($_GET['nro_operacion'])) {
  $colname2_cartareparo = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cartareparo = sprintf("SELECT * FROM opcdpa nolock WHERE rut_cliente LIKE %s and nro_operacion LIKE %s and sub_estado = 'Reparada.' ORDER BY id DESC", GetSQLValueString($colname1_cartareparo . "%", "text"),GetSQLValueString($colname2_cartareparo . "%", "text"));
$cartareparo = mysqli_query($comercioexterior, $query_cartareparo) or die(mysqli_error());
$row_cartareparo = mysqli_fetch_assoc($cartareparo);
$totalRows_cartareparo = mysqli_num_rows($cartareparo);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Carta Reparo - Maestro</title>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
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
.Estilo6 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo9 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CARTA  REPARO - MAESTRO</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">CESI&Oacute;N DE DERECHO Y/O PAGO ANTICIPADO</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="2" align="left" valign="middle"><span class="Estilo8"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21">Carta Reparo Impresi&oacute;n</span></td>
    </tr>
    <tr>
      <td width="22%" align="right" valign="middle">Rut Cliente:</div></td>
      <td width="78%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="15">
        <span class="rojopequeno">Sin puntos ni Guion</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nro Operaci&oacute;n: </div></td>
      <td align="left" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="15" maxlength="7">
        <span class="rojopequeno">F 000000</span> </td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="middle">
        <input name="Submit" type="submit" class="boton" value="Buscar">
        <input name="Submit" type="reset" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<?php if ($totalRows_cartareparo > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr bgcolor="#999999">
    <td align="center" valign="middle" class="titulocolumnas">Imprimir</div></td>
    <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Fecha Ingreso
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" valign="middle" class="titulocolumnas">Especialista
      </div>
    </td>
  </tr>
  <?php do { ?>
  <tr>
    <td align="center" valign="middle"><a href="imprerepdet.php?recordID=<?php echo $row_cartareparo['id']; ?>"> <img src="../../../../imagenes/ICONOS/impresora_2.jpg" width="27" height="21" border="0"></a></div></td>
    <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_cartareparo['nro_operacion']; ?></span> </div></td>
    <td align="center" valign="middle"><?php echo $row_cartareparo['fecha_ingreso']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cartareparo['rut_cliente']; ?></td>
    <td align="left" valign="middle"><?php echo $row_cartareparo['nombre_cliente']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cartareparo['evento']; ?></td>
    <td align="center" valign="middle"><?php echo $row_cartareparo['especialista']; ?></td>
  </tr>
  <?php } while ($row_cartareparo = mysqli_fetch_assoc($cartareparo)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_cartareparo > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cartareparo=%d%s", $currentPage, 0, $queryString_cartareparo); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_cartareparo > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_cartareparo=%d%s", $currentPage, max(0, $pageNum_cartareparo - 1), $queryString_cartareparo); ?>">Anterior</a>
        <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_cartareparo < $totalPages_cartareparo) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cartareparo=%d%s", $currentPage, min($totalPages_cartareparo, $pageNum_cartareparo + 1), $queryString_cartareparo); ?>">Siguiente</a>
        <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_cartareparo < $totalPages_cartareparo) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_cartareparo=%d%s", $currentPage, $totalPages_cartareparo, $queryString_cartareparo); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_cartareparo + 1) ?></strong> al <strong><?php echo min($startRow_cartareparo + $maxRows_cartareparo, $totalRows_cartareparo) ?></strong> de un total de <strong><?php echo $totalRows_cartareparo ?></strong>
<?php } // Show if recordset not empty ?>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../cedeypaant.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($cartareparo);
?>