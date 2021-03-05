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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM usuarios nolock WHERE id = %s ORDER BY nombre ASC", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuarios SET nombre=%s, usuario=%s, password=%s, perfil=%s, segmento=%s, grupo=%s, anexo=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['perfil'], "text"),
                       GetSQLValueString($_POST['segmento'], "text"),
                       GetSQLValueString($_POST['grupo'], "text"),
					   GetSQLValueString($_POST['anexo'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "modmae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
$colname_DetailRS1 = "1";
if (isset($_GET['nombre'])) {
  $colname_DetailRS1 = $_GET['nombre'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Modificar Usuarios - Detalle</title>
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
.Estilo5 {
	font-size: 12px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo6 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}
-->
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
<link rel="shortcut icon" href="../../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../comex/imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td align="left" valign="middle" bgcolor="#FF0000" class="titulopaguina">MODIFICAR USUARIO - DETALLE</div></td>
    <td width="43" align="left" valign="middle" bgcolor="#FF0000"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"> </div></td>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="6" align="left" valign="middle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo5">Modificar Usuarios</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nro Registro: </td>
      <td colspan="5" align="left" valign="middle">
        <span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Usuario:</td>
      <td colspan="5" align="left" valign="middle"><input name="nombre" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre']; ?>" size="120" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Segmento:</td>
      <td align="center" valign="middle"><label>
        <select name="segmento" class="etiqueta12" id="segmento">
          <option value="" <?php if (!(strcmp("", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>NO APLICA</option>
          <option value="OPE COMEX" <?php if (!(strcmp("OPE COMEX", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>OPE COMEX</option>
          <option value="RED DE SUCURSALES" <?php if (!(strcmp("RED DE SUCURSALES", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>RED DE SUCURSALES</option>
          <option value="BANCA EMPRESA" <?php if (!(strcmp("BANCA EMPRESA", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>BANCA EMPRESA</option>
          <option value="BANCA GRANDES EMPRESAS" <?php if (!(strcmp("BANCA GRANDES EMPRESAS", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>BANCA GRANDES EMPRESAS</option>
          <option value="EMPRESAS METRO" <?php if (!(strcmp("EMPRESAS METRO", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>EMPRESAS METRO</option>
          <option value="BMG" <?php if (!(strcmp("BMG", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>BMG</option>
          <option value="REGIONAL" <?php if (!(strcmp("REGIONAL", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>REGIONAL</option>
          <option value="TERRITORIAL" <?php if (!(strcmp("TERRITORIAL", $row_DetailRS1['segmento']))) {echo "selected=\"selected\"";} ?>>TERRITORIAL</option>
          </select>
      </label></td>
      <td colspan="2" align="right" valign="middle">Grupo:</td>
      <td colspan="2" align="center" valign="middle"><select name="grupo" class="etiqueta12" id="grupo">
        <option value="N/A" <?php if (!(strcmp("N/A", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>No Aplica Grupo</option>
        <option value="Banca Grandes Empresas GRP2" <?php if (!(strcmp("Banca Grandes Empresas GRP2", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Grandes Empresas GRP2</option>
        <option value="Banca Grandes Empresas GRP3 + Inmob" <?php if (!(strcmp("Banca Grandes Empresas GRP3 + Inmob", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Grandes Empresas GRP3 + Inmob</option>
        <option value="Banca Empresas GRP5" <?php if (!(strcmp("Banca Empresas GRP5", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Empresas GRP5</option>
        <option value="Banca Grandes Empresas GRP4" <?php if (!(strcmp("Banca Grandes Empresas GRP4", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Grandes Empresas GRP4</option>
        <option value="Banca Empresas GRP2" <?php if (!(strcmp("Banca Empresas GRP2", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Empresas GRP2</option>
        <option value="Banca Grandes Empresas GRP1" <?php if (!(strcmp("Banca Grandes Empresas GRP1", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Grandes Empresas GRP1</option>
  <option value="Banca Empresas GRP3" <?php if (!(strcmp("Banca Empresas GRP3", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Empresas GRP3</option>
  <option value="Banca Grandes Empresas GRP5 + Institucional" <?php if (!(strcmp("Banca Grandes Empresas GRP5 + Institucional", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Grandes Empresas GRP5 + Institucional</option>
  <option value="Banca Empresas GRP4" <?php if (!(strcmp("Banca Empresas GRP4", $row_DetailRS1['grupo']))) {echo "selected=\"selected\"";} ?>>Banca Empresas GRP4</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle"><img src="../../imagenes/ICONOS/usuario.jpg" width="20" height="20" border="0"></td>
      <td align="center" valign="middle">
        <input name="usuario" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['usuario']; ?>" size="10" maxlength="8">
      </div></td>
      <td align="right" valign="middle"><img src="../../imagenes/ICONOS/llave.jpg" width="20" height="20" border="0"></div></td>
      <td align="center" valign="middle">
        <input name="password" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['password']; ?>" size="10" maxlength="8">
      </div></td>
      <td align="right" valign="middle">Perfil:</div></td>
      <td align="center" valign="middle"><select name="perfil" class="etiqueta12" id="perfil">
        <option value="" <?php if (!(strcmp("", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Seleccione un Perfil</option>
        <option value="ADM" <?php if (!(strcmp("ADM", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Administrador</option>
        <option value="ESP" <?php if (!(strcmp("ESP", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Especialista NI</option>
        <option value="BMG" <?php if (!(strcmp("BMG", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Especilaista BMG</option>
        <option value="OPE" <?php if (!(strcmp("OPE", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Operador Operaciones</option>
        <option value="TATA" <?php if (!(strcmp("TATA", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Operador TATA</option>
        <option value="REG" <?php if (!(strcmp("REG", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Regional</option>
        <option value="RED" <?php if (!(strcmp("RED", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Red Sucursales</option>
        <option value="SUP" <?php if (!(strcmp("SUP", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Supervisor Operaciones</option>
        <option value="TER" <?php if (!(strcmp("TER", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Territorial</option>
        <option value="CUS" <?php if (!(strcmp("CUS", $row_DetailRS1['perfil']))) {echo "selected=\"selected\"";} ?>>Custodia</option>
      </select>        </div></td>
    </tr>
    <tr valign="baseline" bgcolor="#CCCCCC">
      <td align="right" valign="middle">Anexo:</td>
      <td colspan="5" align="left" valign="middle"><input name="anexo" type="text" class="etiqueta12" id="anexo" value="<?php echo $row_DetailRS1['anexo']; ?>" size="10" maxlength="10"></td>
    </tr>
    <tr valign="baseline" bgcolor="#CCCCCC">
      <td colspan="6" align="center" valign="middle"><input type="submit" class="boton" value="Modificar Usuario"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="modmae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>