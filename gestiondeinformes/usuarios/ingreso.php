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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO usuarios (id, nombre, usuario, password, perfil, segmento, grupo) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['perfil'], "text"),
                       GetSQLValueString($_POST['segmento'], "text"),
                       GetSQLValueString($_POST['grupo'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingreso.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Ingreso de Nuevo Usuario</title>
<style type="text/css">
<!--
@import url("../../gestionmedios/estilos/estilo12.css");
@import url("../../estilos/estilo12.css");
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
.Estilo4 {
	font-size: 12px;
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo5 {
	color: #FFFFFF;
	font-size: 16px;
	font-weight: bold;
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
    <td align="left" valign="middle" bgcolor="#FF0000" class="titulopaguina">INGRESO DE NUEVO USUARIO</td>
    <td width="43" align="left" valign="middle" bgcolor="#FF0000"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"> </div></td>
  </tr>
</table>
<br>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" onSubmit="MM_validateForm('nombre','','R','usuario','','R','password','','R');return document.MM_returnValue">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline" bgcolor="#999999">
      <td colspan="6" align="left" valign="middle"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"><span class="Estilo4">Ingresar Usuarios</span></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Usuario:</td>
      <td colspan="5" align="left" valign="middle"><input name="nombre" type="text" class="etiqueta12" value="" size="120" maxlength="120"></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Segmento:</td>
      <td align="center" valign="middle"><label>
        <select name="segmento" class="etiqueta12" id="segmento">
          <option selected>NO APLICA</option>
          <option value="BMG">BMG</option>
          <option value="BANCA EMPRESA">BANCA EMPRESA</option>
          <option value="BANCA GRANDES EMPRESAS">BANCA GRANDES EMPRESAS</option>
          <option value="OPE COMEX">OPE COMEX</option>
          <option value="RED DE SUCURSALES">RED DE SUCURSALES</option>
          <option value="TERRITORIAL">TERRITORIAL</option>
          <option value="BEI">BEI</option>
          </select>
      </label></td>
      <td colspan="2" align="right" valign="middle">Grupo:</td>
      <td colspan="2" align="center" valign="middle"><select name="grupo" class="etiqueta12" id="grupo">
<option value="N/A" selected>No Aplica Grupo</option>
        <option value="Banca Grandes Empresas GRP2">Banca Grandes Empresas GRP2</option>
        <option value="Banca Grandes Empresas GRP3 + Inmob">Banca Grandes Empresas GRP3 + Inmob</option>
        <option value="Banca Empresas GRP5">Banca Empresas GRP5</option>
        <option value="Banca Grandes Empresas GRP4">Banca Grandes Empresas GRP4</option>
        <option value="Banca Empresas GRP2">Banca Empresas GRP2</option>
        <option value="Banca Grandes Empresas GRP1">Banca Grandes Empresas GRP1</option>
        <option value="Banca Empresas GRP3">Banca Empresas GRP3</option>
        <option value="Banca Grandes Empresas GRP5 + Institucional">Banca Grandes Empresas GRP5 + Institucional</option>
        <option value="Banca Empresas GRP4">Banca Empresas GRP4</option>
      </select></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Usuario: <img src="../../imagenes/ICONOS/usuario.jpg" width="20" height="20"></td>
      <td align="center" valign="middle">
        <input name="usuario" type="text" class="etiqueta12" size="12" maxlength="10">
      </div></td>
      <td align="right" valign="middle">Password: <img src="../../imagenes/ICONOS/llave.jpg" width="20" height="20"></div></td>
      <td align="center" valign="middle">
        <input name="password" type="text" class="etiqueta12" value="12345678" size="13" maxlength="8">
      </div></td>
      <td align="right" valign="middle">Perfil:</div></td>
      <td align="center" valign="middle">
      <select name="perfil" class="etiqueta12" id="perfil">
            <option selected>Seleccione un Perfil</option>
            <option value="ADM">Administrador</option>
            <option value="ESP">Especialista NI</option>
            <option value="BMG">Especilaista BMG</option>
            <option value="OPE">Operador Operaciones</option>
            <option value="TATA">Operador TATA</option>
            <option value="REG">Regional</option>
            <option value="RED">Red Sucursales</option>
            <option value="SUP">Supervisor Operaciones</option>
            <option value="TER">Territorial</option>
            <option value="CUS">Custodia</option>
      </select>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="6" align="center" valign="middle">
        <input type="submit" class="boton" value="Ingresar Usuario"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
  <input type="hidden" name="id" value="" size="32">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="../gestiondeinformes.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image5" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>