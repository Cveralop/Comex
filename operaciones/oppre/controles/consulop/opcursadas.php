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

$colname_cursada = "1";
if (isset($_GET['evento'])) {
  $colname_cursada = $_GET['evento'];
}
$colname1_cursada = "1";
if (isset($_GET['estado'])) {
  $colname1_cursada = $_GET['estado'];
}
$colname2_cursada = "1";
if (isset($_GET['fecha_curse'])) {
  $colname2_cursada = $_GET['fecha_curse'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_cursada = sprintf("SELECT * FROM oppre nolock WHERE evento LIKE %s and estado LIKE %s and fecha_curse LIKE %s ORDER BY id DESC", GetSQLValueString("%" . $colname_cursada . "%", "text"),GetSQLValueString("%" . $colname1_cursada . "%", "text"),GetSQLValueString("%" . $colname2_cursada . "%", "text"));
$cursada = mysqli_query($comercioexterior, $query_cursada) or die(mysqli_error());
$row_cursada = mysqli_fetch_assoc($cursada);
$totalRows_cursada = mysqli_num_rows($cursada);
?>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
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
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo6 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo10 {color: #00FF00}
.Estilo11 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo12 {
	color: #0000FF;
	font-weight: bold;
}
-->
</style><title>Operaciones Cursadas Cobranzas de Exportaci&oacute;n</title>
<script> 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')"><table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3"> OPERACIONES CURSADAS CUBRANZAS DE EXPORTACI&Oacute;N </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">PR&Eacute;STAMOS</td>
  </tr>
</table>
<br>
<form name="form1" method="get" action="">
  <table width="95%"  border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="middle" bgcolor="#999999">
      <td colspan="6" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Estado Operaciones</span></td>
    </tr>
    <tr valign="middle">
      <td align="right">Fecha Curse:</td>
      <td align="center">
        <input name="fecha_curse" type="text" class="etiqueta12" id="fecha_curse" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10">
      <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right">Evento:</div></td>
      <td align="center">
        <select name="evento" class="etiqueta12" id="evento">
          <option value="Apertura." selected>Apertura</option>
          <option value="Prorroga.">Prorroga</option>
          <option value="Cambio Tasa.">Cambio Tasa</option>
          <option value="Pago.">Pago</option>
          <option value="Visacion.">Visaci&oacute;n</option>
          <option value="Carta Original.">Carta Original</option>
          <option value="Requerimiento.">Requerimiento</option>
          <option value="Solucion Excepcion.">Solucion Excepcion</option>
          <option value="Dev Comisiones.">Dev Comisiones</option>
          <option value=".">Todas</option>
        </select>
      </div></td>
      <td align="right">Estado:</div></td>
      <td align="center">
        <select name="estado" class="etiqueta12" id="estado">
          <option value="Cursada." selected>Cursada</option>
          <option value="Pendiente.">Pendiente</option>
          <option value="Reparada.">Reparada</option>
          <option value=".">Todas</option>
        </select>
      </div></td>
    </tr>
    <tr valign="middle">
      <td colspan="6" align="center">
        <input name="Submit" type="submit" class="boton" value="Buscar">
      </div></td>
    </tr>
  </table>
</form>
<br>
<?php if ($totalRows_cursada > 0) { // Show if recordset not empty ?>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr valign="middle" bgcolor="#999999">
    <td colspan="11" align="left"><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0">Total Operaciones <span class="Estilo10"><?php echo $totalRows_cursada ?></span></span></td>
  </tr>
  <tr valign="middle" bgcolor="#999999">
    <td align="center" class="titulocolumnas">Nro Operaci&oacute;n</div></td>
    <td align="center" class="titulocolumnas">Fecha Ingreso
      </div>
    </td>
    <td align="center" class="titulocolumnas">Fecha Curse 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Rut Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Nombre Cliente 
      </div>
    </td>
    <td align="center" class="titulocolumnas">Operador
      </div>
    </td>
    <td align="center" class="titulocolumnas">Evento
      </div>
    </td>
    <td align="center" class="titulocolumnas">Estado
      </div>      
      </div>      
      </td>
    <td align="center" class="titulocolumnas">Observaciones
      </div>
    </td>
    <td align="center" class="titulocolumnas">Especialista
      </div>
    </td>
    <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</div>
    </td>
  </tr>
  <?php do { ?>
  <tr valign="middle">
    <td align="center"> <span class="respuestacolumna_rojo"><?php echo strtoupper($row_cursada['nro_operacion']); ?></span>  </div></td>
    <td align="center"><?php echo $row_cursada['fecha_ingreso']; ?> </div></td>
    <td align="center"><?php echo $row_cursada['fecha_curse']; ?> </div></td>
    <td align="center"><?php echo $row_cursada['rut_cliente']; ?> </div></td>
    <td align="left"><?php echo $row_cursada['nombre_cliente']; ?> </td>
    <td align="center"><?php echo $row_cursada['operador']; ?></div></td>
    <td align="center"><?php echo $row_cursada['evento']; ?></div></td>
    <td align="center"><?php echo $row_cursada['estado']; ?></td>
    <td align="center"><?php echo $row_cursada['obs']; ?> </td>
    <td align="center"><?php echo strtoupper($row_cursada['especialista']); ?></div></td>
    <td align="right">
      <span class="respuestacolumna_rojo"><?php echo strtoupper($row_cursada['moneda_operacion']); ?></span><span class="Estilo6"><span class="respuestacolumna_azul"> <?php echo number_format($row_cursada['monto_operacion'], 2, ',', '.'); ?></span></span>
      </div>      
      </div></td>
  </tr>
  <?php } while ($row_cursada = mysqli_fetch_assoc($cursada)); ?>
</table>
<strong> 
</strong>
<?php } // Show if recordset not empty ?>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../../prestamos.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
<?php
mysqli_free_result($cursada);
?>