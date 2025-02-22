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
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opbga SET folio_boleta=%s, estado_boleta=%s WHERE id=%s",
                       GetSQLValueString($_POST['folio_boleta'], "text"),
                       GetSQLValueString($_POST['estado_boleta'], "text"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));
  $updateGoTo = "bgafoliomae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<?php
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = "SELECT * FROM opbga WHERE id = $recordID";
$query_limit_DetailRS1 = sprintf("%s LIMIT %d, %d", $query_DetailRS1, $startRow_DetailRS1, $maxRows_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_limit_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
if (isset($_GET['totalRows_DetailRS1'])) {
  $totalRows_DetailRS1 = $_GET['totalRows_DetailRS1'];
} else {
  $all_DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1);
  $totalRows_DetailRS1 = mysqli_num_rows($all_DetailRS1);
}
$totalPages_DetailRS1 = ceil($totalRows_DetailRS1/$maxRows_DetailRS1)-1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Consulta Operaciones por Numero Stand BY Recibidas - Detalle</title>
<style type="text/css">
<!--
@import url(../../../../estilos/estilo12.css);
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
.Estilo5 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo6 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo7 {
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
}

</style>
<script language="JavaScript" type="text/JavaScript">
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
</script>
</style>
<script> 
var segundos=1200
var direccion='../cierre.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" align="left" valign="middle" class="Estilo3">CONSULTA FOLIO BOLETA DE GARANT&Iacute;A - DETALLE </td>
    <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" class="Estilo4">OPERACIONES DE CAMBIO</td>
  </tr>
</table>
<br>
<form method="POST" name="form1" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr bgcolor="#999999">
      <td colspan="4" align="left" valign="middle"><p><span class="Estilo5"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21" border="0"></span><span class="Estilo5">Operaciones por Numero Boleta de Garant&iacute;a</span></p></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nro Registro: </div></td>
      <td align="center" valign="middle"><span class="nroregistro"><?php echo $row_DetailRS1['id']; ?></span>        </div></td>
      <td align="right" valign="middle">Rut Banco:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['rut_cliente']; ?><span class="rojopequeno"> Sin puntos ni Guion</span></div></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nombre Banco: </div></td>
      <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nombre_cliente']; ?> </td>
    </tr>
    <tr>
      <td align="right" valign="middle">Fecha Ingreso: </div></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_ingreso']; ?> <span class="rojopequeno">(dd-mm-aaaa)</span></div></td>
      <td align="right" valign="middle">Fecha Curse:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_curse']; ?><span class="rojopequeno"> (dd-mm-aaaa)</span></div></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Evento:</div></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['evento']; ?> </div></td>
      <td align="right" valign="middle">Estado:</div></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['estado']; ?></div></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Asignador:</div></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['asignador']; ?> </div></td>
      <td align="right" valign="middle">Operador:</div></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['operador']; ?></div></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nro Operaci&oacute;n:</div></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['nro_operacion']; ?> </div></td>
      <td align="right" valign="middle">Especialista:</div></td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['especialista']; ?></div></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Observaciones:</div></td>
      <td colspan="3" align="left" valign="middle"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?> </td>
    </tr>
    <tr>
      <td align="right" valign="middle">Monto Apertura: </div></td>
      <td align="center" valign="middle"><span class="Estilo6"><?php echo strtoupper($row_DetailRS1['moneda_operacion']); ?></span> <strong><?php echo number_format($row_DetailRS1['monto_operacion'], 2, ',', '.'); ?></strong> </div></td>
      <td align="right" valign="middle">Rut Cliente:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['rut_banco']; ?></div></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Nombre Cliente: </div></td>
      <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['banco']; ?> </div></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Pais:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['pais']; ?></td>
      <td align="right" valign="middle">Referencia:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['referencia']; ?></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Tipo Operaci&oacute;n: </td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['tipo_operacion']; ?></td>
      <td align="right" valign="middle">Vcto Operaci&oacute;n: </td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['vcto_operacion']; ?><span class="rojopequeno">(aaaa-mm-dd)</span></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Otros Beneficiarios: </td>
      <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['otros_ben']; ?></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Plazo:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['plazo']; ?></td>
      <td align="right" valign="middle">Gastos:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['gastos']; ?></td>
    </tr>
    <tr>
      <td align="right" valign="middle">Vcto Boleta: </td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['vcto_boleta']; ?> <span class="rojopequeno">(aaaa-mm-dd) </span></td>
      <td align="right" valign="middle">Responsabilidad:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['responsabilidad']; ?></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Moneda / Monto Contravalor:</td>
      <td align="center" valign="middle"><span class="respuestacolumna_rojo"><?php echo $row_DetailRS1['moneda_contra']; ?></span> <span class="respuestacolumna_azul"><?php echo $row_DetailRS1['monto_contra']; ?></span></td>
      <td align="right" valign="middle">Periodisidad:</td>
      <td align="center" valign="middle"><?php echo $row_DetailRS1['periodisidad']; ?></td>
    </tr>
    <tr valign="middle">
      <td align="right" valign="middle">Estado Boleta: </td>
      <td align="center" valign="middle">        
        <select name="estado_boleta" class="etiqueta12" id="estado_boleta">
            <option value="Vigente." <?php if (!(strcmp("Vigente.", $row_DetailRS1['estado_boleta']))) {echo "SELECTED";} ?>>Vigente</option>
            <option value="Nula." <?php if (!(strcmp("Nula.", $row_DetailRS1['estado_boleta']))) {echo "SELECTED";} ?>>Nula</option>
            <option value="Cancelada." <?php if (!(strcmp("Cancelada.", $row_DetailRS1['estado_boleta']))) {echo "SELECTED";} ?>>Cancelada</option>
        </select>
      </div></td>
      <td align="right" valign="middle">Folio Boleta:</div></td>
      <td align="center" valign="middle"><input name="folio_boleta" type="text" class="destadado" id="folio_boleta" value="<?php echo $row_DetailRS1['folio_boleta']; ?>" size="15" maxlength="15"></td>
    </tr>
    <tr>
      <td colspan="4" align="center" valign="middle">
        <input type="submit" class="etiqueta12" value="Actualizar Estado Boleta">
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
</form>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="bgaconromae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html>
<?php
mysqli_free_result($DetailRS1);
?>