<?php require_once('../../../Connections/basecomercial.php'); ?>
<?php
  session_start();
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
//-->
</script>
</head>
<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr valign="middle">
    <td width="95%" align="left" class="Estilo3">INGRESO CLIENTES GOC SEGUN BASE COMERCIAL NI</td>
    <td width="5%" rowspan="2" align="right" class="Estilo3"><img src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" /></td>
  </tr>
  <tr valign="middle">
    <td align="left" class="Estilo4">RED DE SUCURSALES</td>
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
      </tr>
      <?php } while ($row_ingreso_cliente = mysqli_fetch_assoc($ingreso_cliente)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<br>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right"><a href="../../gerenciaregional.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80" height="25" border="0"></a></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($ingreso_cliente);
?>