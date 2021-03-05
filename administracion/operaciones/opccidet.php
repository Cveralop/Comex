<?php require_once('../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,MOX";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE opcci SET rut_cliente=%s, nombre_cliente=%s, fecha_ingreso=%s, date_ingreso=%s, evento=%s, estado=%s, fecha_curse=%s, date_curse=%s, asignador=%s, operador=%s, producto=%s, nro_operacion=%s, obs=%s, especialista=%s, especialista_curse=%s, ejecutivo=%s, moneda_operacion=%s, monto_operacion=%s, pais=%s, banco_destino=%s, folio=%s, currier=%s, moneda_documentos=%s, monto_documentos=%s, convenio=%s, tipo_negociacion=%s, fecha_valija=%s, nro_sobre=%s, despacho_doctos=%s, sucursal=%s, encargado_sucursal=%s, receptor=%s, acuse_recibo=%s, segmento=%s, sub_estado=%s, vi=%s, iteraciones=%s, date_preingreso=%s, date_espe=%s, date_visa=%s, date_asig=%s, date_oper=%s, date_supe=%s, forward=%s, autorizador=%s, estado_reparo=%s, reparo_espe=%s, reparo_obs=%s, moneda_reparo=%s, monto_reparo=%s, estado_visacion=%s, visador=%s, excepcion=%s, autorizacion_operaciones=%s, autorizacion_especialista=%s, tipo_excepcion=%s, solucion_excepcion=%s, estado_excepcion=%s, solucionado=%s, urgente=%s, fuera_horario=%s, numero_neg=%s, fecha_neg=%s, fecha_endoso=%s, estado_doc=%s, garantia=%s, can1=%s, can2=%s, can3=%s, can4=%s, can5=%s, can6=%s, can7=%s, can8=%s, can9=%s, can10=%s, can11=%s, can12=%s, can13=%s, can14=%s, can15=%s, can16=%s, can17=%s, can18=%s, can19=%s, can20=%s, doc1=%s, doc2=%s, doc3=%s, doc4=%s, doc5=%s, doc6=%s, doc7=%s, doc8=%s, doc9=%s, doc10=%s, entregado_por=%s WHERE id=%s",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['fecha_curse'], "text"),
                       GetSQLValueString($_POST['date_curse'], "date"),
                       GetSQLValueString($_POST['asignador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['especialista'], "text"),
                       GetSQLValueString($_POST['especialista_curse'], "text"),
                       GetSQLValueString($_POST['ejecutivo'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['pais'], "text"),
                       GetSQLValueString($_POST['banco_destino'], "text"),
                       GetSQLValueString($_POST['folio'], "text"),
                       GetSQLValueString($_POST['currier'], "text"),
                       GetSQLValueString($_POST['moneda_documentos'], "text"),
                       GetSQLValueString($_POST['monto_documentos'], "double"),
                       GetSQLValueString($_POST['convenio'], "text"),
                       GetSQLValueString($_POST['tipo_negociacion'], "text"),
                       GetSQLValueString($_POST['fecha_valija'], "text"),
                       GetSQLValueString($_POST['nro_sobre'], "int"),
                       GetSQLValueString($_POST['despacho_doctos'], "text"),
                       GetSQLValueString($_POST['sucursal'], "int"),
                       GetSQLValueString($_POST['encargado_sucursal'], "text"),
                       GetSQLValueString($_POST['receptor'], "text"),
                       GetSQLValueString($_POST['acuse_recibo'], "text"),
                       GetSQLValueString($_POST['segmento'], "text"),
                       GetSQLValueString($_POST['sub_estado'], "text"),
                       GetSQLValueString($_POST['vi'], "text"),
                       GetSQLValueString($_POST['iteraciones'], "int"),
                       GetSQLValueString($_POST['date_preingreso'], "date"),
                       GetSQLValueString($_POST['date_espe'], "date"),
                       GetSQLValueString($_POST['date_visa'], "date"),
                       GetSQLValueString($_POST['date_asig'], "date"),
                       GetSQLValueString($_POST['date_oper'], "date"),
                       GetSQLValueString($_POST['date_supe'], "date"),
                       GetSQLValueString($_POST['forward'], "text"),
                       GetSQLValueString($_POST['autorizador'], "text"),
                       GetSQLValueString($_POST['estado_reparo'], "text"),
                       GetSQLValueString($_POST['reparo_espe'], "text"),
                       GetSQLValueString($_POST['reparo_obs'], "text"),
                       GetSQLValueString($_POST['moneda_reparo'], "text"),
                       GetSQLValueString($_POST['monto_reparo'], "double"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['visador'], "text"),
                       GetSQLValueString($_POST['excepcion'], "text"),
                       GetSQLValueString($_POST['autorizacion_operaciones'], "text"),
                       GetSQLValueString($_POST['autorizacion_especialista'], "text"),
                       GetSQLValueString($_POST['tipo_excepcion'], "text"),
                       GetSQLValueString($_POST['solucion_excepcion'], "date"),
                       GetSQLValueString($_POST['estado_excepcion'], "text"),
                       GetSQLValueString($_POST['solucionado'], "date"),
                       GetSQLValueString($_POST['urgente'], "text"),
                       GetSQLValueString($_POST['fuera_horario'], "text"),
                       GetSQLValueString($_POST['numero_neg'], "int"),
                       GetSQLValueString($_POST['fecha_neg'], "text"),
                       GetSQLValueString($_POST['fecha_endoso'], "text"),
                       GetSQLValueString($_POST['estado_doc'], "text"),
                       GetSQLValueString($_POST['garantia'], "text"),
                       GetSQLValueString($_POST['can1'], "int"),
                       GetSQLValueString($_POST['can2'], "int"),
                       GetSQLValueString($_POST['can3'], "int"),
                       GetSQLValueString($_POST['can4'], "int"),
                       GetSQLValueString($_POST['can5'], "int"),
                       GetSQLValueString($_POST['can6'], "int"),
                       GetSQLValueString($_POST['can7'], "int"),
                       GetSQLValueString($_POST['can8'], "int"),
                       GetSQLValueString($_POST['can9'], "int"),
                       GetSQLValueString($_POST['can10'], "int"),
                       GetSQLValueString($_POST['can11'], "int"),
                       GetSQLValueString($_POST['can12'], "int"),
                       GetSQLValueString($_POST['can13'], "int"),
                       GetSQLValueString($_POST['can14'], "int"),
                       GetSQLValueString($_POST['can15'], "int"),
                       GetSQLValueString($_POST['can16'], "int"),
                       GetSQLValueString($_POST['can17'], "int"),
                       GetSQLValueString($_POST['can18'], "int"),
                       GetSQLValueString($_POST['can19'], "int"),
                       GetSQLValueString($_POST['can20'], "int"),
                       GetSQLValueString($_POST['doc1'], "text"),
                       GetSQLValueString($_POST['doc2'], "text"),
                       GetSQLValueString($_POST['doc3'], "text"),
                       GetSQLValueString($_POST['doc4'], "text"),
                       GetSQLValueString($_POST['doc5'], "text"),
                       GetSQLValueString($_POST['doc6'], "text"),
                       GetSQLValueString($_POST['doc7'], "text"),
                       GetSQLValueString($_POST['doc8'], "text"),
                       GetSQLValueString($_POST['doc9'], "text"),
                       GetSQLValueString($_POST['doc10'], "text"),
                       GetSQLValueString($_POST['fecha_doc_ent'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));

  $updateGoTo = "opccimae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_DetailRS1 = "1";
if (isset($_GET['id'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcci WHERE id = %s", $colname_DetailRS1);
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$maxRows_DetailRS1 = 10;
$pageNum_DetailRS1 = 0;
if (isset($_GET['pageNum_DetailRS1'])) {
  $pageNum_DetailRS1 = $_GET['pageNum_DetailRS1'];
}
$startRow_DetailRS1 = $pageNum_DetailRS1 * $maxRows_DetailRS1;

$colname_DetailRS1 = "1";
if (isset($_GET['nro_operacion'])) {
  $colname_DetailRS1 = (get_magic_quotes_gpc()) ? $_GET['nro_operacion'] : addslashes($_GET['nro_operacion']);
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$recordID = $_GET['recordID'];
$query_DetailRS1 = sprintf("SELECT * FROM opcci  WHERE id = $recordID", $colname_opcci);
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
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>OPCCI -  Detalle</title>
<style type="text/css">
<!--
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
.Estilo3 {font-size: 18px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo4 {font-size: 14px;
	font-weight: bold;
	color: #FFFFFF;
}
.Estilo7 {
	color: #FFFFFF;
	font-size: 12px;
	font-weight: bold;
}
.Estilo8 {
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
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
<script> 
//Script original de KarlanKas para forosdelweb.com 


var segundos=1800
var direccion='http://pdpto38:8303/comex/' 


milisegundos=segundos*1000 
window.setTimeout("window.location.replace(direccion);",milisegundos); 
</script> 
</head>
<link rel="shortcut icon" href="../../../comex/imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../comex/imagenes/barraweb/animated_favicon1.gif">
</head>

<body onLoad="MM_preloadImages('../../imagenes/Botones/boton_volver_2.jpg')">
<table width="95%"  border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
  <tr>
    <td width="93%" class="Estilo3">OPCCI - DETALLE</td>
    <td width="7%" rowspan="2" class="Estilo3"><img src="../../imagenes/GIF/erde016.gif" width="43" height="43"></td>
  </tr>
  <tr>
    <td height="21" class="Estilo4">COMERCIO EXTERIOR CARTAS DE CR&Eacute;DITO DE IMPORTACIONES</td>
  </tr>
</table>
<br>
<form method="post" name="form2" action="<?php echo $editFormAction; ?>">
  <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr valign="middle">
          <td colspan="4" align="right" nowrap><div align="left"><img src="../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="Estilo7">Modificaci&oacute;n Registro OPCCI </span></div></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Nro Registro:</td>
          <td><div align="center" class="Estilo8"><?php echo $row_DetailRS1['id']; ?></div></td>
          <td><div align="right">Rut Cliente: </div></td>
          <td><div align="center">
            <input name="rut_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15">
            <span class="rojopequeno">xxx.xxx.xxx-x</span></div></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Nombre Cliente:</td>
          <td colspan="3"><input name="nombre_cliente" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Fecha Ingreso:</td>
          <td align="center"><input name="fecha_ingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10"> 
            <span class="rojopequeno">(dd-mm-aaaa)</span> </td>
          <td align="right">Date Ingreso: </td>
          <td><div align="center">
            <input name="date_ingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_ingreso']; ?>" size="12" maxlength="10"> 
          <span class="rojopequeno">(aaaa-mm-dd)</span></div></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Evento:</td>
          <td><div align="center">
            <select name="evento" class="etiqueta12" id="evento">
              <option value="Apertura." <?php if (!(strcmp("Apertura.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Apertura</option>
              <option value="Modificacion." <?php if (!(strcmp("Modificacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Modificacion</option>
              <option value="Anulacion." <?php if (!(strcmp("Anulacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Anulacion</option>
              <option value="MSG-Swift." <?php if (!(strcmp("MSG-Swift.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>MSG-Swift</option>
              <option value="VTA-Gtos." <?php if (!(strcmp("VTA-Gtos.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>VTA-Gtos</option>
              <option value="Requerimiento." <?php if (!(strcmp("Requerimiento.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Requerimiento</option>
              <option value="Negociacion." <?php if (!(strcmp("Negociacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Negociacion</option>
              <option value="Vcto Pzo Proveedor." <?php if (!(strcmp("Vcto Pzo Proveedor.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Vcto Pzo Proveedor</option>
              <option value="Alzamiento." <?php if (!(strcmp("Alzamiento.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Alzamiento</option>
              <option value="Alzamiento Anticipado." <?php if (!(strcmp("Alzamiento Anticipado.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Alzamiento Anticipado</option>
              <option value="Contabilizacion." <?php if (!(strcmp("Contabilizacion.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Contabilizacion</option>
              <option value="Endoso Anticipado." <?php if (!(strcmp("Endoso Anticipado.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Endoso Anticipado</option>
              <option value="Valuta." <?php if (!(strcmp("Valuta.", $row_DetailRS1['evento']))) {echo "SELECTED";} ?>>Valuta</option>
            </select>
          </div></td>
          <td align="right">Estado:</td>
          <td><div align="center">
            <select name="estado" class="etiqueta12" id="estado">
              <option value="Pendiente." <?php if (!(strcmp("Pendiente.", $row_DetailRS1['estado']))) {echo "SELECTED";} ?>>Pendiente</option>
              <option value="Cursada." <?php if (!(strcmp("Cursada.", $row_DetailRS1['estado']))) {echo "SELECTED";} ?>>Cursada</option>
              <option value="Reparada." <?php if (!(strcmp("Reparada.", $row_DetailRS1['estado']))) {echo "SELECTED";} ?>>Reparada</option>
            </select>
          </div></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Fecha Curse:</td>
          <td align="center"><input name="fecha_curse" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_curse']; ?>" size="12" maxlength="10">
            <span class="rojopequeno">(dd-mm-aaaa)</span> </td>
          <td align="right">Date Curse: </td>
          <td align="center"><input name="date_curse" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_curse']; ?>" size="12" maxlength="10">
            <span class="rojopequeno">(aaaa-mm-dd)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Asignador:</td>
          <td><div align="center">
            <input name="asignador" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['asignador']; ?>" size="20" maxlength="20">
          </div></td>
          <td align="right">Operador:</td>
          <td><div align="center">
            <select name="operador" class="etiqueta12" id="operador">
              <option value="ABURGOS" <?php if (!(strcmp("ABURGOS", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Alejandro Marcel Burgos</option>
              <option value="CURRUTP" <?php if (!(strcmp("CURRUTP", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Claudia Urritia Padilla</option>
              <option value="DDELCAM" <?php if (!(strcmp("DDELCAM", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Daniela del Campo Vergara</option>
              <option value="EROBLES" <?php if (!(strcmp("EROBLES", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Elizabeth Robles Novoa</option>
              <option value="FOLEAOR" <?php if (!(strcmp("FOLEAOR", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Fabiola Olea Ortega</option>
              <option value="FLOPEC" <?php if (!(strcmp("FLOPEC", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Fernando Lopez</option>
              <option value="HRAMIRZ" <?php if (!(strcmp("HRAMIRZ", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Hernan Ramirez Ramirez</option>
              <option value="HURIBEC" <?php if (!(strcmp("HURIBEC", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Hernan Uribe Campos</option>
              <option value="JMALDON" <?php if (!(strcmp("JMALDON", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Jaime Maldonado Cerda</option>
              <option value="JCONCHF" <?php if (!(strcmp("JCONCHF", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Jorge Concha Farina</option>
              <option value="JMARTOS" <?php if (!(strcmp("JMARTOS", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Jorge Martinez</option>
              <option value="LCELISD" <?php if (!(strcmp("LCELISD", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Luis Celis de MArini</option>
              <option value="MBERRIT" <?php if (!(strcmp("MBERRIT", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Manuel Berrios Tudela</option>
              <option value="MALCANTA" <?php if (!(strcmp("MALCANTA", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Maria Jose Alcantara Dominguez</option>
              <option value="MSALAMA" <?php if (!(strcmp("MSALAMA", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Marco Salamanca Sanchez</option>
              <option value="MNAVECH" <?php if (!(strcmp("MNAVECH", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Mauricio Nevech</option>
              <option value="PMOSCOA" <?php if (!(strcmp("PMOSCOA", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Pamela Moscoso</option>
              <option value="PESPINH" <?php if (!(strcmp("PESPINH", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Pascuala Espinoza Huerta</option>
              <option value="PGODOY" <?php if (!(strcmp("PGODOY", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Patricia Godoy Chavez</option>
              <option value="MTOROB" <?php if (!(strcmp("MTOROB", $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Veronica Toro</option>
              <option value="0" <?php if (!(strcmp(0, $row_DetailRS1['operador']))) {echo "SELECTED";} ?>>Operador Cero</option>
            </select>
          </div></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Producto:</td>
          <td><div align="center">
            <input name="producto" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['producto']; ?>" size="5" maxlength="1">
            <span class="rojopequeno">K</span></div></td>
          <td align="right">Nro Operaci&oacute;n: </td>
          <td><div align="center">
            <input name="nro_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion']; ?>" size="15" maxlength="7">
            <span class="rojopequeno">K000000</span></div></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Observaciones:</td>
          <td colspan="3"><textarea name="obs" cols="80" rows="3" class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
          <span class="rojopequeno">(255 caracteres max. 3 l&iacute;neas)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Especialista:</td>
          <td align="center"><input name="especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista']; ?>" size="50" maxlength="50"></td>
          <td align="right">Especilaista Curse: </td>
          <td align="center"><input name="especialista_curse" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['especialista_curse']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Ejecutivo:</td>
          <td align="center"><input name="ejecutivo" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['ejecutivo']; ?>" size="50" maxlength="50"></td>
          <td align="right">Moneda / Monto Operaci&oacute;n: </td>
          <td align="center"><input name="moneda_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_operacion']; ?>" size="5" maxlength="3"> 
          <span class="rojopequeno">/</span>          <input name="monto_operacion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="17" maxlength="15"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Pais:</td>
          <td align="center"><input name="pais" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['pais']; ?>" size="20" maxlength="20"></td>
          <td align="right">Banco Destino: </td>
          <td align="center"><input name="banco_destino" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['banco_destino']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Folio:</td>
          <td align="center"><input name="folio" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['folio']; ?>" size="20" maxlength="20"></td>
          <td align="right">Currier:</td>
          <td align="center"><input name="currier" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['currier']; ?>" size="20" maxlength="20"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Moneda / Monto Documentos:</td>
          <td align="center"><input name="moneda_documentos" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_documentos']; ?>" size="5" maxlength="3"> 
          <span class="rojopequeno">/</span>          <input name="monto_documentos" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_documentos']; ?>" size="17" maxlength="15"></td>
          <td align="right">Convenio:</td>
          <td align="center"><input name="convenio" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['convenio']; ?>" size="10" maxlength="5"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Tipo Negociaci&oacute;n:</td>
          <td align="center">            <select name="tipo_negociacion" class="etiqueta12" id="tipo_negociacion">
            <option value="" <?php if (!(strcmp("", $row_DetailRS1['tipo_negociacion']))) {echo "SELECTED";} ?>>Seleccione Una Opci&oacute;n</option>
            <option value="Limpia." <?php if (!(strcmp("Limpia.", $row_DetailRS1['tipo_negociacion']))) {echo "SELECTED";} ?>>Limpia</option>
            <option value="Discrepancia." <?php if (!(strcmp("Discrepancia.", $row_DetailRS1['tipo_negociacion']))) {echo "SELECTED";} ?>>Discrepancia</option>
                </select></td>
          <td align="right">Fecha Valija: </td>
          <td align="center"><input name="fecha_valija" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_valija']; ?>" size="18" maxlength="12"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Nro Sobre:</td>
          <td align="center"><input name="nro_sobre" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['nro_sobre']; ?>" size="20" maxlength="20"></td>
          <td align="right">Despacho Documentos:</td>
          <td align="center"><input name="despacho_doctos" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['despacho_doctos']; ?>" size="60" maxlength="120"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Sucursal:</td>
          <td align="center"><input name="sucursal" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['sucursal']; ?>" size="10" maxlength="5">
            <span class="rojopequeno">00000</span></td>
          <td align="right">Encargado Sucursal: </td>
          <td align="center"><input name="encargado_sucursal" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['encargado_sucursal']; ?>" size="60" maxlength="120"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Receptor:</td>
          <td align="center"><input name="receptor" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['receptor']; ?>" size="50" maxlength="50"></td>
          <td align="right">Acuse Recibo: </td>
          <td align="center"><input name="acuse_recibo" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['acuse_recibo']; ?>" size="20" maxlength="20"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Segmento:</td>
          <td align="center"><input name="segmento" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['segmento']; ?>" size="32"></td>
          <td align="right">Sub Estado: </td>
          <td align="center">            <select name="sub_estado" class="etiqueta12" id="sub_estado">
            <option value="Pendiente." <?php if (!(strcmp("Pendiente.", $row_DetailRS1['sub_estado']))) {echo "SELECTED";} ?>>Pendiente</option>
            <option value="Cursada." <?php if (!(strcmp("Cursada.", $row_DetailRS1['sub_estado']))) {echo "SELECTED";} ?>>Cursada</option>
            <option value="Reparada." <?php if (!(strcmp("Reparada.", $row_DetailRS1['sub_estado']))) {echo "SELECTED";} ?>>Reparada</option>
            <option value="Eliminada." <?php if (!(strcmp("Eliminada.", $row_DetailRS1['sub_estado']))) {echo "SELECTED";} ?>>Eliminada</option>
            </select></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Valor Iteraci&oacute;n:</td>
          <td align="center">            <select name="vi" class="etiqueta12" id="vi">
            <option value="1" <?php if (!(strcmp(1, $row_DetailRS1['vi']))) {echo "SELECTED";} ?>>Uno</option>
            </select>
            </td>
          <td align="right">Iteraciones:</td>
          <td align="center"><input name="iteraciones" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['iteraciones']; ?>" size="5" maxlength="3">
            <span class="rojopequeno">000</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Fecha Preingreso Especialista:</td>
          <td align="center"><input name="date_preingreso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_preingreso']; ?>" size="25">
            <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span> </td>
          <td align="right">Fecha Ingreso Especialista:</td>
          <td align="center"><input name="date_espe" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_espe']; ?>" size="25">
          <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Fecha Visaci&oacute;n :</td>
          <td align="center"><input name="date_visa" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_visa']; ?>" size="25">
          <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span></td>
          <td align="right">Fecha Asignaci&oacute;n: </td>
          <td align="center"><input name="date_asig" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_asig']; ?>" size="25">
          <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Fecha Curse Operador: </td>
          <td align="center"><input name="date_oper" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_oper']; ?>" size="25">
          <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span></td>
          <td align="right">Fecha Curse Supervisor:</td>
          <td align="center"><input name="date_supe" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['date_supe']; ?>" size="25">
          <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Forward:</td>
          <td align="center"><input name="forward" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['forward']; ?>" size="20" maxlength="20"></td>
          <td align="right">Autorizador:</td>
          <td align="center"><input name="autorizador" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['autorizador']; ?>" size="20" maxlength="20"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Estado Reparo:</td>
          <td align="center"><input name="estado_reparo" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['estado_reparo']; ?>" size="20" maxlength="20"></td>
          <td align="right">Reparo Espcialista:</td>
          <td align="center"><select name="reparo_espe" class="etiqueta12" id="reparo_espe">
            <option value="Sin Reparo." selected>Sin Reparo</option>
          </select>          </td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Reparo Observaciones:</td>
          <td colspan="3"><textarea name="reparo_obs" cols="80" rows="3" class="etiqueta12"><?php echo $row_DetailRS1['reparo_obs']; ?></textarea>
          <span class="rojopequeno">(255 caracteres max. 3 l&iacute;neas)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Moneda / Monto Reparo: </td>
          <td align="center"><input name="moneda_reparo" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['moneda_reparo']; ?>" size="5" maxlength="3">
            <span class="rojopequeno">/</span>  <input name="monto_reparo" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['monto_reparo']; ?>" size="17" maxlength="15"></td>
          <td align="right">Estado Visaci&oacute;n: </td>
          <td align="center">            <select name="estado_visacion" class="etiqueta12" id="estado_visacion">
            <option value="Pendiente." <?php if (!(strcmp("Pendiente.", $row_DetailRS1['estado_visacion']))) {echo "SELECTED";} ?>>Pendiente</option>
            <option value="Cursada." <?php if (!(strcmp("Cursada.", $row_DetailRS1['estado_visacion']))) {echo "SELECTED";} ?>>Cursada</option>
              </select></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Visador:</td>
          <td align="center"><input name="visador" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['visador']; ?>" size="20" maxlength="20"></td>
          <td align="right">Excepci&oacute;n:</td>
          <td align="center">            <select name="excepcion" class="etiqueta12" id="excepcion">
            <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['excepcion']))) {echo "SELECTED";} ?>>Si</option>
            <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['excepcion']))) {echo "SELECTED";} ?>>No</option>
              </select></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Autorizaci&oacute;n Operaciones:</td>
          <td align="center"><input name="autorizacion_operaciones" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['autorizacion_operaciones']; ?>" size="50" maxlength="50"></td>
          <td align="right">Autorizaci&oacute;n Especialista:</td>
          <td align="center"><input name="autorizacion_especialista" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['autorizacion_especialista']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Tipo Excepci&oacute;n:</td>
          <td align="center"><input name="tipo_excepcion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['tipo_excepcion']; ?>" size="50" maxlength="50"></td>
          <td align="right">Fecha Soluci&oacute;n Excepci&oacute;n:</td>
          <td align="center"><input name="solucion_excepcion" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['solucion_excepcion']; ?>" size="12" maxlength="10">
            <span class="rojopequeno">(aaaa-mm-dd)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Estado Excepci&oacute;n:</td>
          <td align="center">            <select name="estado_excepcion" class="etiqueta12" id="estado_excepcion">
              <option value="Pendiente.">Pendiente</option>
              <option value="Solucionado.">Solucionado</option>
              </select></td>
          <td align="right">Solucionado:</td>
          <td align="center"><input name="solucionado" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['solucionado']; ?>" size="12" maxlength="10">
          <span class="rojopequeno">(aaaa-mm-dd)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Urgente:</td>
          <td align="center">            <select name="urgente" class="etiqueta12" id="urgente">
            <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['urgente']))) {echo "SELECTED";} ?>>Si</option>
            <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['urgente']))) {echo "SELECTED";} ?>>No</option>
              </select></td>
          <td align="right">Fuera Horario: </td>
          <td align="center"><select name="fuera_horario" class="etiqueta12" id="fuera_horario">
            <option value="Si" <?php if (!(strcmp("Si", $row_DetailRS1['fuera_horario']))) {echo "SELECTED";} ?>>Si</option>
            <option value="No" <?php if (!(strcmp("No", $row_DetailRS1['fuera_horario']))) {echo "SELECTED";} ?>>No</option>
          </select>          </td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Numero Negociaci&oacute;n:</td>
          <td align="center"><input name="numero_neg" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['numero_neg']; ?>" size="7" maxlength="5">
            <span class="rojopequeno">00000</span></td>
          <td align="right">Fecha Negociaci&oacute;n:</td>
          <td align="center"><input name="fecha_neg" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_neg']; ?>" size="12" maxlength="10">
            <span class="rojopequeno">(dd-mm-aaaa)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Fecha Endoso:</td>
          <td align="center"><input name="fecha_endoso" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['fecha_endoso']; ?>" size="12" maxlength="10">
            <span class="rojopequeno">(dd-mm-aaaa)</span></td>
          <td align="right">Estado Documentos:</td>
          <td align="center">            <select name="estado_doc" class="etiqueta12" id="estado_doc">
            <option value="Pendiente." <?php if (!(strcmp("Pendiente.", $row_DetailRS1['estado_doc']))) {echo "SELECTED";} ?>>Pendiente</option>
            <option value="Recibido." <?php if (!(strcmp("Recibido.", $row_DetailRS1['estado_doc']))) {echo "SELECTED";} ?>>Recibido</option>
            <option value="Entregado." <?php if (!(strcmp("Entregado.", $row_DetailRS1['estado_doc']))) {echo "SELECTED";} ?>>Entregado</option>
            <option value="Rechazado." <?php if (!(strcmp("Rechazado.", $row_DetailRS1['estado_doc']))) {echo "SELECTED";} ?>>Rechazado</option>
            <option value="" <?php if (!(strcmp("", $row_DetailRS1['estado_doc']))) {echo "SELECTED";} ?>>Seleccione Una Opci&oacute;n</option>
              </select></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Garantia:</td>
          <td colspan="3"><textarea name="garantia" cols="80" rows="3" class="etiqueta12"><?php echo $row_DetailRS1['garantia']; ?></textarea>
          <span class="rojopequeno">(255 caracteres max. 3 l&iacute;neas)</span></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap><div align="center" class="Estilo7">Original / Copia</div></td>
          <td colspan="3"><span class="Estilo7">Documentos de Embarque </span></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can1" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can1']; ?>" size="5" maxlength="3"> 
          / 
          <input name="can11" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can11']; ?>" size="5"></td>
          <td colspan="3">          <input name="doc1" type="text" class="etiqueta12" id="doc1" value="<?php echo $row_DetailRS1['doc1']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can2" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can2']; ?>" size="5" maxlength="3"> 
          / 
          <input name="can12" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can12']; ?>" size="5" maxlength="3"></td>
          <td colspan="3">          <input name="doc2" type="text" class="etiqueta12" id="doc2" value="<?php echo $row_DetailRS1['doc2']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can3" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can3']; ?>" size="5" maxlength="3"> 
            / 
            <input name="can13" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can13']; ?>" size="5" maxlength="3"></td>
          <td colspan="3">          <input name="doc3" type="text" class="etiqueta12" id="doc3" value="<?php echo $row_DetailRS1['doc3']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can4" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can4']; ?>" size="5" maxlength="3"> 
            / 
            <input name="can14" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can14']; ?>" size="5" maxlength="3"></td>
          <td colspan="3">          <input name="doc4" type="text" class="etiqueta12" id="doc4" value="<?php echo $row_DetailRS1['doc4']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can5" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can5']; ?>" size="5" maxlength="3"> 
            / 
            <input name="can15" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can15']; ?>" size="5" maxlength="3"></td>
          <td colspan="3">          <input name="doc5" type="text" class="etiqueta12" id="doc5" value="<?php echo $row_DetailRS1['doc5']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can6" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can6']; ?>" size="5" maxlength="3"> 
            / 
            <input name="can16" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can16']; ?>" size="5" maxlength="3"></td>
          <td colspan="3">          <input name="doc6" type="text" class="etiqueta12" id="doc6" value="<?php echo $row_DetailRS1['doc6']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can7" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can7']; ?>" size="5" maxlength="3"> 
            / 
            <input name="can17" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can17']; ?>" size="5" maxlength="3"></td>
          <td colspan="3">          <input name="doc7" type="text" class="etiqueta12" id="doc7" value="<?php echo $row_DetailRS1['doc7']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can8" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can8']; ?>" size="5" maxlength="3"> 
            / 
            <input name="can18" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can18']; ?>" size="5" maxlength="3"></td>
          <td colspan="3">          <input name="doc8" type="text" class="etiqueta12" id="doc8" value="<?php echo $row_DetailRS1['doc8']; ?>" size="50" maxlength="50"></td>
        </tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can9" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can9']; ?>" size="5" maxlength="3"> 
            / 
            <input name="can19" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can19']; ?>" size="5" maxlength="3"></td>
        <td colspan="3">          <input name="doc9" type="text" class="etiqueta12" id="doc10" value="<?php echo $row_DetailRS1['doc9']; ?>" size="50" maxlength="50"></td></tr>
        <tr valign="middle">
          <td align="center" nowrap class="rojopequeno"><input name="can10" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can10']; ?>" size="5" maxlength="3"> 
            / 
            <input name="can20" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['can20']; ?>" size="5" maxlength="3"></td>
          <td colspan="3"><input name="doc10" type="text" class="etiqueta12" id="doc10" value="<?php echo $row_DetailRS1['doc10']; ?>" size="80" maxlength="100"></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Fecha Recibo Documento Valorado:</td>
          <td><div align="center">
            <input name="date_rec_doc_val" type="text" class="etiqueta12" id="date_rec_doc_val" value="<?php echo $row_DetailRS1['date_rec_doc_val']; ?>" size="25">
            <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span></div></td>
          <td><div align="right">Fecha Entrega / Rechazo Documento Valorado: </div></td>
          <td><div align="center">
            <input name="date_ent_doc_val" type="text" class="etiqueta12" id="date_ent_doc_val" value="<?php echo $row_DetailRS1['date_ent_doc_val']; ?>" size="25">
            <span class="rojopequeno">(aaaa-mm-dd hh:mm:ss)</span></div></td>
        </tr>
        <tr valign="middle">
          <td align="right" nowrap>Entregado Por:</td>
          <td align="right" nowrap><div align="center">
            <input name="recibido_por" type="text" class="etiqueta12" id="recibido_por" size="20" maxlength="20">
          </div></td>
          <td align="right" nowrap>Recibido Por: </td>
          <td align="right" nowrap><div align="center">
            <input name="entregado_por" type="text" class="etiqueta12" value="<?php echo $row_DetailRS1['entregado_por']; ?>" size="20" maxlength="20">
          </div></td>
        </tr>
        <tr valign="middle">
          <td colspan="4" align="right" nowrap><div align="center">
            <input type="submit" class="etiqueta12" value="Actualizar Registro">
          </div></td>
        </tr>
  </table>
      <input type="hidden" name="MM_update" value="form2">
      <input type="hidden" name="id" value="<?php echo $row_DetailRS1['id']; ?>">
</form>
    <p>&nbsp;</p>
    <br>
<br>
<br>
<br>
<br>
<table width="95%"  border="0" align="center">
  <tr>
    <td><div align="right"><a href="opccimae.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image2','','../../imagenes/Botones/boton_volver_2.jpg',1)"><img src="../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image2" width="80" height="25" border="0"></a></div></td>
  </tr>
</table>
</body>
</html><?php
mysqli_free_result($DetailRS1);
?>