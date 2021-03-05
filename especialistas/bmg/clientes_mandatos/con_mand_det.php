<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,BMG";
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
$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;
$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM cliente WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
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
?><title>Consulta Mandato - Detalle</title><style type="text/css">
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
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

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
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')"><table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td align="left" class="Estilo3">CONSULTA MANDATO - DETALLE</td>
    <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">NEGOCIO INTERNACIONAL</td>
  </tr>
</table>
<br>
<table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
  <tr>
    <td colspan="4" align="left" valign="middle" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="subtitulopaguina">Detalle Mandato</span></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nro Registro:</td>
    <td align="center" valign="middle" class="nroregistro"><?php echo $row_DetailRS1['id']; ?> </td>
    <td align="right" valign="middle">Fecha Ingreso Sistema:</td>
    <td align="center" valign="middle" class="respuestacolumna_rojo"><?php echo $row_DetailRS1['date_ingreso']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Rut Cliente:</td>
    <td align="center" valign="middle"><?php echo strtoupper($row_DetailRS1['rut_cliente']); ?> </td>
    <td align="right" valign="middle">Estado Mandato:</td>
    <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_DetailRS1['estado_mandato']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre Cliente:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nombre_cliente']; ?> </td>
  </tr>
  <tr>
    <td align="right" valign="middle">Especialista:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['especialista']; ?> </td>
    <td align="right" valign="middle">Tipo Mandato:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['tipo_mandato']; ?> <span class="rojopequeno">(N = Nuevo / A = Antiguo)</span></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Ingresado Por:</td>
    <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_DetailRS1['ing_operador']; ?> </td>
    <td align="right" valign="middle">Fecha Ingreso:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_ingreso']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Visado Por:</td>
    <td align="center" valign="middle" class="respuestacolumna_azul"><?php echo $row_DetailRS1['visador']; ?> </td>
    <td align="right" valign="middle">Fecha Visacion:</td>
    <td align="center" valign="middle"><?php echo $row_DetailRS1['fecha_visacion']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Arqueo Fisico:</td>
    <td colspan="3" align="left" valign="middle" class="respuestacolumna_rojo"><?php echo $row_DetailRS1['arqueo_fisico']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Contacto 1</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['contacto1']; ?> </td>
  </tr>
  <tr>
    <td align="right" valign="middle">Contacto 2</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['contacto2']; ?> </td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre 1:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nombre_e1']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">E-Mail 1:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['email1']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre 2</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nombre_e2']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">E-Mail 2:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['email2']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre 3:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nombre_e3']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">E-Mail 3:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['email3']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre 4:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nombre_e4']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">E-Mail 4:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['email4']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">Nombre 5:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['nombre_e5']; ?></td>
  </tr>
  <tr>
    <td align="right" valign="middle">E-Mail 5:</td>
    <td colspan="3" align="left" valign="middle"><?php echo $row_DetailRS1['email5']; ?></td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right" valign="middle"><a href="con_mand_mae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0"></a></td>
  </tr>
</table>
<?php
mysqli_free_result($DetailRS1);
?>