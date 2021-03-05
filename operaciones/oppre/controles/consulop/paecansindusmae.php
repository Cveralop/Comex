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

$colname_pagopaesindus = "Pago.";
if (isset($_GET['evento'])) {
  $colname_pagopaesindus = $_GET['evento'];
}
$colname1_pagopaesindus = "N";
if (isset($_GET['dus'])) {
  $colname1_pagopaesindus = $_GET['dus'];
}
$colname2_pagopaesindus = "Cursada.";
if (isset($_GET['estado'])) {
  $colname2_pagopaesindus = $_GET['estado'];
}
$colname3_pagopaesindus = "PAE.";
if (isset($_GET['tipo_operacion'])) {
  $colname3_pagopaesindus = $_GET['tipo_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_pagopaesindus = sprintf("SELECT *,datediff(curdate(),date_curse)as dias FROM oppre nolock WHERE evento = %s and dus = %s and estado = %s and tipo_operacion = %s ORDER BY date_curse ASC", GetSQLValueString($colname_pagopaesindus, "text"),GetSQLValueString($colname1_pagopaesindus, "text"),GetSQLValueString($colname2_pagopaesindus, "text"),GetSQLValueString($colname3_pagopaesindus, "text"));
$pagopaesindus = mysql_query($query_pagopaesindus, $comercioexterior) or die(mysqli_error());
$row_pagopaesindus = mysqli_fetch_assoc($pagopaesindus);
$totalRows_pagopaesindus = mysqli_num_rows($pagopaesindus);
?>
<style type="text/css">
<!--
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
.Estilo6 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo9 {color: #FFFFFF; font-weight: bold; }
.Estilo12 {font-size: 12px}
.Estilo13 {color: #00FF00}
-->
</style><title>Operaciones Canceladas PAE Sin DUS - Maestro</title>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link href="../../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')"><table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">OPERACIONES CANCELADAS PAE SIN DUS - MAESTRO </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image4" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="8" align="left"><span class="Estilo9"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo12">Numero de Operaciones sin DUS <span class="Estilo13"><?php echo $totalRows_pagopaesindus ?></span></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Mantenci&oacute;n</div></td>
    <td align="center" class="titulocolumnas">Fecha Curse 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n</div>
    </td>
    <td align="center" class="titulocolumnas">D&iacute;as Transcurridos</div>
    </td>
    <td align="center" class="titulocolumnas">Rut Cliente
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Operador</td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n </div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"><a href="paecansindusdet.php?recordID=<?php echo $row_pagopaesindus['id']; ?>"> <img src="../../../../imagenes/ICONOS/update_2.jpg" width="18" height="18" border="0"></a></div></td>
    <td align="center"><?php echo $row_pagopaesindus['fecha_curse']; ?></div></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_pagopaesindus['nro_operacion']); ?></span>      </div></td>
    <td align="center"><?php echo $row_pagopaesindus['dias']; ?></div></td>
    <td align="center"><?php echo $row_pagopaesindus['rut_cliente']; ?></div></td>
    <td align="left"><?php echo $row_pagopaesindus['nombre_cliente']; ?> </td>
    <td align="center"><?php echo strtoupper($row_pagopaesindus['operador']); ?></td>
    <td align="center"><span class="respuestacolumna_rojo"><?php echo strtoupper($row_pagopaesindus['moneda_operacion']); ?></span>&nbsp; <strong class="respuestacolumna_azul"><?php echo number_format($row_pagopaesindus['monto_operacion'], 2, ',', '.'); ?></strong></div></td>
  </tr>
  <?php } while ($row_pagopaesindus = mysqli_fetch_assoc($pagopaesindus)); ?>
</table>
<br>
<br>
<br>
<?php
mysqli_free_result($pagopaesindus);
?>