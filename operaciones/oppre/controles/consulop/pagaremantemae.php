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

$colname1_manpagcust = "1";
if (isset($_GET['nro_operacion'])) {
  $colname1_manpagcust = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_manpagcust = sprintf("SELECT * FROM oppre nolock WHERE nro_operacion = %s", GetSQLValueString($colname1_manpagcust, "text"));
$manpagcust = mysql_query($query_manpagcust, $comercioexterior) or die(mysqli_error());
$row_manpagcust = mysqli_fetch_assoc($manpagcust);
$totalRows_manpagcust = mysqli_num_rows($manpagcust);
?>
<style type="text/css">
<!--
@import url("../../../../estilos/estilo12.css");
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo5 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo7 {color: #FFFFFF; font-weight: bold; }
.Estilo8 {font-size: 9px}
.Estilo9 {font-size: 9px; font-weight: bold; }
.Estilo10 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style><title>Mantenci&oacute;n Pagar&eacute; Envio a Custodia</title>

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
  <tr valign="middle">
    <td width="93%" align="left" class="Estilo3">MANTENCI&Oacute;N ENVIO PAGARE A CUSTODIA</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo10">Burcar Operaci&oacute;n para Mantenci&oacute;n</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Nro Operaci&oacute;n:</div></td>
  <td width="79%" align="left"><input name="nro_operacion" type="text" class="etiqueta12" id="nro_operacion" size="17" maxlength="12">
          <span class="rojopequeno">F000000</span></td>
    </tr>
    <tr valign="middle">
      <td colspan="2" align="center">
          <input name="Submit" type="submit" class="boton" value="Buscar">
          <input name="Submit" type="submit" class="boton" value="Limpiar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<?php if ($totalRows_manpagcust > 0) { // Show if recordset not empty ?>
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td align="center" class="titulocolumnas">Mantenci&oacute;n
        </div></td>
      <td align="center" class="titulocolumnas">Fecha Curse
        </div></td>
      <td align="center" class="titulocolumnas">Nro Operaci&oacute;n
        </div></td>
      <td align="center" class="titulocolumnas">Rut Cliente
        </div></td>
      <td align="center" class="titulocolumnas">Nombre Cliente
        </div></td>
      <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n
        </div></td>
      <td align="center" class="titulocolumnas">Pagar&eacute;</td>
      <td align="center" class="titulocolumnas">Tipo Operaci&oacute;n
        </div></td>
    </tr>
    <?php do { ?>
      <tr valign="middle">
        <td align="center"><a href="pagaremantedet.php?recordID=<?php echo $row_manpagcust['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a>
          </div></td>
        <td align="center"><?php echo $row_manpagcust['fecha_curse']; ?>
          </div></td>
        <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_manpagcust['nro_operacion']); ?></span>
          </div></td>
        <td align="center"><?php echo $row_manpagcust['rut_cliente']; ?>
          </div></td>
        <td align="left"><?php echo $row_manpagcust['nombre_cliente']; ?></td>
        <td align="right"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_manpagcust['moneda_operacion']); ?></span> <strong class="respuestacolumna_azul"><?php echo number_format($row_manpagcust['monto_operacion'], 2, ',', '.'); ?></strong>
          </div></td>
        <td align="center"><?php echo $row_manpagcust['pagare']; ?>
          </div></td>
        <td align="center"><?php echo $row_manpagcust['tipo_operacion']; ?>
          </div></td>
      </tr>
      <?php } while ($row_manpagcust = mysqli_fetch_assoc($manpagcust)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_manpagcust > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_manpagcust=%d%s", $currentPage, 0, $queryString_manpagcust); ?>">Primero</a>
        <?php } // Show if not first page ?>
    </td>
  
    <td width="31%" align="center"><?php if ($pageNum_manpagcust > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_manpagcust=%d%s", $currentPage, max(0, $pageNum_manpagcust - 1), $queryString_manpagcust); ?>">Anterior</a>
        <?php } // Show if not first page ?></td>
    <td width="23%" align="center"><?php if ($pageNum_manpagcust < $totalPages_manpagcust) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_manpagcust=%d%s", $currentPage, min($totalPages_manpagcust, $pageNum_manpagcust + 1), $queryString_manpagcust); ?>">Siguiente</a>
        <?php } // Show if not last page ?></td>
    <td width="23%" align="center"><?php if ($pageNum_manpagcust < $totalPages_manpagcust) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_manpagcust=%d%s", $currentPage, $totalPages_manpagcust, $queryString_manpagcust); ?>">&Uacute;ltimo</a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<br>
Registros del <strong><?php echo ($startRow_manpagcust + 1) ?></strong> al <strong><?php echo min($startRow_manpagcust + $maxRows_manpagcust, $totalRows_manpagcust) ?></strong> de un toptal de <strong><?php echo $totalRows_manpagcust ?></strong>
<br>
<?php
mysqli_free_result($manpagcust);
?>