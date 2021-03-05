<?php require_once('../../../Connections/basecomercial.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,TER";
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
$colname_ingreso_cliente = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_ingreso_cliente = $_GET['rut_cliente'];
}
mysqli_select_db($basecomercial, $database_basecomercial);
$query_ingreso_cliente = sprintf("SELECT * FROM base_comercial WHERE rut_cliente = %s", GetSQLValueString($colname_ingreso_cliente, "text"));
$ingreso_cliente = mysqli_query($basecomercial, $query_ingreso_cliente) or die(mysqli_error());
$row_ingreso_cliente = mysqli_fetch_assoc($ingreso_cliente);
$totalRows_ingreso_cliente = mysqli_num_rows($ingreso_cliente);
?><style type="text/css">
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
-->
</style>
<link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css">
<title>Ingreso Cliente Segun Base Comercial - Maestro</title>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script> 
//Script original de KarlanKas para forosdelweb.com 
var segundos=1200
var direccion='http://pdpto38:8303/comex/index.php' 
milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script>
</head>
<body>
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="95%" align="left" class="Estilo3">INGRESO CLIENTES GOC SEGUN BASE COMERCIAL NI</td>
    <td width="5%" rowspan="2" align="right" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">NEGOCIO INTERNACIONAL</td>
  </tr>
</table>
<br />
<form name="form1" method="get" action="">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td colspan="2" align="left" bgcolor="#999999"><img src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulo_menu">Ingreso cliente en GOC Segun Base Comercial NI</span></td>
    </tr>
    <tr>
      <td width="20%" align="right">Rut Cliente:</td>
      <td width="80%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente" size="17" maxlength="20">
      <span class="respuestacolumna_rojo">(Sin puntos ni Gui&oacute;n)</span></td>
    </tr>
    <tr>
      <td colspan="2"><input name="button" type="submit" class="boton" id="button" value="Buscar"></td>
    </tr>
  </table>
</form>
<?php if ($totalRows_ingreso_cliente > 0) { // Show if recordset not empty ?>
  <span class="respuestacolumna_azul"><?php echo $totalRows_ingreso_cliente ?></span> Registros Total <br>
  <br />
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
    <tr>
      <td class="titulocolumnas">Rut Cliente</td>
      <td class="titulocolumnas">Nombre Cliente</td>
      <td class="titulocolumnas">Nombre Ejecutivo</td>
      <td class="titulocolumnas">Ejecutivo NI</td>
      <td class="titulocolumnas">Especialista NI</td>
      <td class="titulocolumnas">Subgerente</td>
      <td class="titulocolumnas">Distribucion GOC</td>
      <td class="titulocolumnas">Impedido de Operar &gt;= 500</td>
    </tr>
    <?php do { ?>
      <tr>
        <td align="center"><a href="ingresobcdet.php?recordID=<?php echo $row_ingreso_cliente['rut_cliente']; ?>"> <?php echo $row_ingreso_cliente['rut_cliente']; ?></a></td>
        <td align="left"><?php echo $row_ingreso_cliente['nombre_cliente']; ?></td>
        <td align="left"><?php echo $row_ingreso_cliente['nombre_ejecutivo']; ?></td>
        <td align="left"><?php echo $row_ingreso_cliente['ejecutivo_ni']; ?></td>
        <td align="left"><?php echo $row_ingreso_cliente['especialista_ni']; ?></td>
        <td align="left"><?php echo $row_ingreso_cliente['subgerente']; ?></td>
        <td align="left"><?php echo $row_ingreso_cliente['distribucion_goc']; ?></td>
        <td align="center" class="destadado"><?php echo $row_ingreso_cliente['negative_file']; ?></td>
      </tr>
      <?php } while ($row_ingreso_cliente = mysqli_fetch_assoc($ingreso_cliente)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="clientes_mandatos.php"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0"></a></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($ingreso_cliente);
?>