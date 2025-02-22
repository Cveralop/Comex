<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "SUP,ADM";
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
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO opmec (id, rut_cliente, nombre_cliente, post_venta, operador_mesa, fecha_ingreso, date_ingreso, evento, asignador, operador, obs, moneda_operacion, monto_operacion, monto_ml, tipocambio, paridad, cta_cte_origen, cta_cte_destino, otro_destino, date_visa, date_asig, estado_visacion, visador, mandato, nro_foliomesadinero) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['post_venta'], "text"),
                       GetSQLValueString($_POST['operador_mesa'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['asignador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['monto_ml'], "double"),
                       GetSQLValueString($_POST['tipocambio'], "double"),
                       GetSQLValueString($_POST['paridad'], "double"),
                       GetSQLValueString($_POST['cta_cte_origen'], "text"),
                       GetSQLValueString($_POST['cta_cte_destino'], "text"),
                       GetSQLValueString($_POST['otro_destino'], "text"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_asig'], "date"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['mandato'], "text"),
                       GetSQLValueString($_POST['nro_foliomesadinero'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "mesadinero_imp.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM mesadinero WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
#Marca Operaciones Fast Track Ingresadas
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_loginicio = "UPDATE mesadinero INNER JOIN opmec ON mesadinero.id = opmec.nro_foliomesadinero SET impresion = 'Si';";
$loginicio = mysqli_query($comercioexterior, $query_loginicio) or die(mysqli_error());
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Compra Venta Mesa Dinero - Detalle</title>
<style type="text/css">
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

</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<script>
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos);
</script>
</head>
<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO Y ASIGNACION OPERACIONES MESA DINERO - DETALLE</td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">MERCADO DE CORREDORES </td>
  </tr>
</table>
<br />
<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr valign="baseline">
      <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21" /><span class="titulo_menu">Ingreso Operacion de la Mesa Dinero</span></td>
    </tr>
    <tr valign="baseline">
      <td width="17%" align="right" valign="middle">Rut Cliente:</td>
      <td width="32%" align="center" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15" readonly="readonly" />
        <span class="rojopequeno">Sin Puntos Ni Guión</span></td>
      <td width="16%" align="right" valign="middle">Fecha Ingreso:</td>
      <td width="35%" align="center" valign="middle"><input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" readonly="readonly" />
        <span class="rojopequeno">(dd-mm-aaaa)</span></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Nombre Cliente:</td>
      <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="80" maxlength="80" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Evento:</td>
      <td align="center" valign="middle"><select name="evento" class="destadado" id="evento">
        <option value="Ventas." <?php if (!(strcmp("Ventas.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Ventas</option>
        <option value="Compras." <?php if (!(strcmp("Compras.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Compras</option>
        <option value="Sin Definir." <?php if (!(strcmp("Sin Definir.", $row_DetailRS1['evento']))) {echo "selected=\"selected\"";} ?>>Sin Definir</option>
      </select></td>
      <td align="right" valign="middle">Asignador:</td>
      <td align="center" valign="middle"><input name="asignador" type="text" class="etiqueta12" value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Operador:</td>
      <td colspan="3" align="left" valign="middle"><select name="operador" class="etiqueta12" id="operador">
        <option value="CLEYTON" <?php if (!(strcmp("CLEYTON", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Carlos Leyton Gatica</option>
        <option value="MNICOLAS" <?php if (!(strcmp("MNICOLAS", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Matias Nicolas</option>
        <option value="RMISSEN" <?php if (!(strcmp("RMISSEN", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Romina Missen Hernandez</option>
        <option value="CZAMBRAN" <?php if (!(strcmp("CZAMBRAN", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>Cynthia Zambrano Leiva</option>
        <option value="PMECO1" <?php if (!(strcmp("PMECO1", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>PMECO1</option>
        <option value="PMECO2" <?php if (!(strcmp("PMECO2", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>PMECO2</option>
        <option value="PMECO3" <?php if (!(strcmp("PMECO3", $row_DetailRS1['operador']))) {echo "selected=\"selected\"";} ?>>PMECO3</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Obs:</td>
      <td colspan="3" align="left" valign="middle"><textarea name="obs" cols="85" rows="4" class="etiqueta12"></textarea></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Importes:</td>
      <td colspan="3" align="left" valign="middle">Moneda: 
        <input name="moneda_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda']; ?>" size="5" maxlength="5" readonly="readonly" /> 
        // Monto MX: 
          <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_mx']; ?>" size="25" maxlength="25" readonly="readonly" /> 
        // Monto ML:
        <label>
          <input name="monto_ml" type="text" class="etiqueta12" id="monto_ml" value="<?php echo $row_DetailRS1['monto_ml']; ?>" size="25" maxlength="25" readonly="readonly" />
        </label>
// Tipo Cambio: 
        <label>
<input name="tipocambio" type="text" class="etiqueta12" id="tipocambio" value="<?php echo $row_DetailRS1['tipo_cambio']; ?>" size="20" maxlength="20" readonly="readonly" />
        // Paridad: 
        <input name="paridad" type="text" class="etiqueta12" id="paridad" value="<?php echo $row_DetailRS1['paridad']; ?>" size="20" maxlength="20" readonly="readonly" />
        </label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Origen y Destino de Fondos:</td>
      <td colspan="3" align="left" valign="middle">Cta Cte Origen: 
        <label>
          <input name="cta_cte_origen" type="text" class="etiqueta12" id="cta_cte_origen" value="<?php echo $row_DetailRS1['cta_cte_origen']; ?>" size="30" maxlength="30" readonly="readonly" />
// Cta Cte Destino:
<input name="cta_cte_destino" type="text" class="etiqueta12" id="cta_cte_destino" value="<?php echo $row_DetailRS1['cta_cte_destino']; ?>" size="30" maxlength="30" readonly="readonly" />
      // Otro Destino: 
      <input name="otro_destino" type="text" class="etiqueta12" id="otro_destino" value="<?php echo $row_DetailRS1['otro_destino']; ?>" size="50" maxlength="50" readonly="readonly" />
      </label></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="middle">Post Venta:</td>
      <td align="center" valign="middle"><label>
        <input name="post_venta" type="text" class="etiqueta12" id="post_venta" value="<?php echo $row_DetailRS1['post_venta']; ?>" size="50" maxlength="50" readonly="readonly" />
      </label></td>
      <td align="right" valign="middle">Operador Mesa:</td>
      <td align="center" valign="middle"><input name="operador_mesa" type="text" class="etiqueta12" id="operador_mesa" value="<?php echo $row_DetailRS1['operador']; ?>" size="50" maxlength="50" readonly="readonly" /></td>
    </tr>
    <tr valign="baseline">
      <td colspan="4" align="center" valign="middle"><input type="submit" class="boton" value="Ingresar Operacion de la Mesa" /></td>
    </tr>
  </table>
  <br />
  <input type="hidden" name="MM_insert" value="form2" />
  <input name="id" type="hidden" id="id" size="32" />
  <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32" />
  <input type="hidden" name="date_visa" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32" />
  <input type="hidden" name="date_asig" value="<?php echo date("Y-m-d H:i:s"); ?>" size="32" />
  <input type="hidden" name="estado_visacion" value="Cursada." size="32" />
  <input type="hidden" name="visador" value="<?php echo $_SESSION['login'];?>" size="32" />
  <input type="hidden" name="mandato" value="<?php echo $row_DetailRS1['mandato']; ?>" size="32" />
  <input name="nro_foliomesadinero" type="hidden" id="nro_foliomesadinero" value="<?php echo $row_DetailRS1['id']; ?>" size="32" />
</form>
<br />
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="mesadinero_mae.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0" id="Imagen3" /></a></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>