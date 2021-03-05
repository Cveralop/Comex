<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "ADM,ESP,BMG,TER";
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

$MM_restrictGoTo = "../../../erroracceso.php";
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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_modificar = 10;
$pageNum_modificar = 0;
if (isset($_GET['pageNum_modificar'])) {
  $pageNum_modificar = $_GET['pageNum_modificar'];
}
$startRow_modificar = $pageNum_modificar * $maxRows_modificar;

$colname_modificar = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_modificar = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_modificar = sprintf("SELECT * FROM pagareparagua WHERE rut_cliente = %s ORDER BY id DESC", GetSQLValueString($colname_modificar, "text"));
$query_limit_modificar = sprintf("%s LIMIT %d, %d", $query_modificar, $startRow_modificar, $maxRows_modificar);
$modificar = mysqli_query($comercioexterior, $query_limit_modificar) or die(mysqli_error());
$row_modificar = mysqli_fetch_assoc($modificar);

if (isset($_GET['totalRows_modificar'])) {
  $totalRows_modificar = $_GET['totalRows_modificar'];
} else {
  $all_modificar = mysqli_query($comercioexterior, $query_modificar);
  $totalRows_modificar = mysqli_num_rows($all_modificar);
}
$totalPages_modificar = ceil($totalRows_modificar/$maxRows_modificar)-1;

$colname_convenioweb = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_convenioweb = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_convenioweb = sprintf("SELECT * FROM convenioweb WHERE rut_cliente = %s", GetSQLValueString($colname_convenioweb, "text"));
$convenioweb = mysqli_query($comercioexterior, $query_convenioweb) or die(mysqli_error());
$row_convenioweb = mysqli_fetch_assoc($convenioweb);
$totalRows_convenioweb = mysqli_num_rows($convenioweb);

$queryString_modificar = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_modificar") == false && 
        stristr($param, "totalRows_modificar") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_modificar = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_modificar = sprintf("&totalRows_modificar=%d%s", $totalRows_modificar, $queryString_modificar);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Consulta Pagar&eacute; Paragua - Maestro</title>
    <style type="text/css">
    <!--
    @import url("../../../estilos/estilo12.css");

    .Estilo3 {
        font-size: 18px;
        font-weight: bold;
        color: #FFFFFF;
    }

    .Estilo4 {
        font-size: 14px;
        font-weight: bold;
        color: #FFFFFF;
    }

    body,
    td,
    th {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 10px;
        color: #0000FF;
    }

    body {
        background-image: url(../../../imagenes/JPEG/edificio_corporativo.jpg);
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
        font-weight: bold;
        font-size: 12px;
    }

    .Estilo8 {
        color: #FFFFFF;
        font-weight: bold;
    }
    -->
    </style>
    <script type="text/javascript">
    <!--
    function MM_swapImgRestore() { //v3.0
        var i, x, a = document.MM_sr;
        for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
    }

    function MM_preloadImages() { //v3.0
        var d = document;
        if (d.images) {
            if (!d.MM_p) d.MM_p = new Array();
            var i, j = d.MM_p.length,
                a = MM_preloadImages.arguments;
            for (i = 0; i < a.length; i++)
                if (a[i].indexOf("#") != 0) {
                    d.MM_p[j] = new Image;
                    d.MM_p[j++].src = a[i];
                }
        }
    }

    function MM_findObj(n, d) { //v4.01
        var p, i, x;
        if (!d) d = document;
        if ((p = n.indexOf("?")) > 0 && parent.frames.length) {
            d = parent.frames[n.substring(p + 1)].document;
            n = n.substring(0, p);
        }
        if (!(x = d[n]) && d.all) x = d.all[n];
        for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
        for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
        if (!x && d.getElementById) x = d.getElementById(n);
        return x;
    }

    function MM_swapImage() { //v3.0
        var i, j = 0,
            x, a = MM_swapImage.arguments;
        document.MM_sr = new Array;
        for (i = 0; i < (a.length - 2); i += 3)
            if ((x = MM_findObj(a[i])) != null) {
                document.MM_sr[j++] = x;
                if (!x.oSrc) x.oSrc = x.src;
                x.src = a[i + 2];
            }
    }
    //
    -->
    </script>
</head>

<body onLoad="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
    <table width="95%" border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
        <tr>
            <td width="95%" align="left" valign="middle" class="Estilo3">CONSULTA CONVENIO WEB Y PAGAR&Eacute; PARAGUA
            </td>
            <td width="5%" rowspan="2" align="right" valign="middle" class="Estilo3"><img
                    src="../../../imagenes/GIF/erde016.gif" width="43" height="43" align="right"></td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
        </tr>
    </table>
    <br>
    <form name="form1" method="get" action="">
        <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
            <tr bgcolor="#999999">
                <td colspan="2" align="left" valign="middle"><img src="../../../imagenes/GIF/notepad.gif" width="19"
                        height="21"><span class="Estilo5">Consulta Pagar&eacute; por Rut Cliente</span></td>
            </tr>
            <tr>
                <td width="21%" align="right" valign="middle">Rut Cliente:</td>
                <td width="79%" align="left" valign="middle"><input name="rut_cliente" type="text" class="etiqueta12"
                        id="rut_cliente" size="17" maxlength="15">
                    <span class="rojopequeno">Sin puntos ni Guion</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="middle">
                    <input name="Submit" type="submit" class="boton" value="Buscar">
                    <input name="Submit" type="reset" class="boton" value="Limpiar">
                </td>
            </tr>
        </table>
    </form>
    <br>
    <table width="95%" border="0" align="center">
        <tr>
            <td align="right" valign="middle"><a href="../../ni/ni.php" onMouseOut="MM_swapImgRestore()"
                    onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)">&lt;&lt;Volver
                    a NI&gt;&gt; </a>//<a href="../../bmg/bmg.php" onMouseOut="MM_swapImgRestore()"
                    onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)">
                    &lt;&lt;Volver a BMG&gt;&gt; </a>//<a href="../../territorial/tr.php"
                    onMouseOut="MM_swapImgRestore()"
                    onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)">
                    &lt;&lt;Volver a Territorial&gt;&gt;</a>
                <br><br>
                <a href="convenioweb.php" onMouseOut="MM_swapImgRestore()"
                    onMouseOver="MM_swapImage('Imagen5','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img
                        src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen5" width="80"
                        height="25" border="0"></a>
                </div>
            </td>
        </tr>
    </table>
    <br>
    <?php if ($totalRows_convenioweb > 0) { // Show if recordset not empty ?>
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr>
            <td colspan="11" align="left" bgcolor="#999999"><span class="titulocolumnas"><img
                        src="../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21"><span
                        class="titulo_menu">Convenio WEB</span></span></td>
        </tr>
        <tr>
            <td class="titulocolumnas">Ver Detalle</td>
            <td class="titulocolumnas">Fecha Ingreso</td>
            <td class="titulocolumnas">Rut Cliente</td>
            <td class="titulocolumnas">Nombe Cliente</td>
            <td class="titulocolumnas">Moneda / Monto Pagare</td>
            <td class="titulocolumnas">Moneda / Monto Convenio</td>
            <td class="titulocolumnas">Fecha Suscripci&oacute;n Pagare</td>
            <td class="titulocolumnas">Fecha Sucripci&oacute;n Convenio</td>
            <td class="titulocolumnas">Estado</td>
            <td class="titulocolumnas">Reparo OBS</td>
            <td class="titulocolumnas">Fecha de Vcto.</td>
        </tr>
        <?php do { ?>
        <tr>
            <td align="center" class="respuestacolumna_rojo"><a
                    href="consultacw_det.php?recordID=<?php echo $row_convenioweb['id']; ?>"><img
                        src="../../../imagenes/ICONOS/update_2.jpg" alt="" width="18" height="18" border="0"></a></td>
            <td align="center" class="respuestacolumna_rojo"><?php echo $row_convenioweb['date_ingreso']; ?></td>
            <td align="center"><?php echo $row_convenioweb['rut_cliente']; ?></td>
            <td align="left"><?php echo $row_convenioweb['nombre_cliente']; ?></td>
            <td align="right"><span
                    class="respuestacolumna_rojo"><?php echo $row_convenioweb['moneda_pagare']; ?></span><span
                    class="respuestacolumna_azul"><?php echo $row_convenioweb['monto_pagare']; ?></span></td>
            <td align="right"><span
                    class="respuestacolumna_rojo"><?php echo $row_convenioweb['moneda_convenio']; ?></span><span
                    class="respuestacolumna_azul"><?php echo $row_convenioweb['monto_convenio']; ?></span></td>
            <td align="center"><?php echo $row_convenioweb['fecha_suscripcion_pagare']; ?></td>
            <td align="center"><?php echo $row_convenioweb['fecha_suscripcion_convenio']; ?></td>
            <td align="center"><?php echo $row_convenioweb['estado']; ?></td>
            <td align="center"><?php echo $row_convenioweb['obs_reparo']; ?></td>
            <td align="center"><?php echo $row_convenioweb['fecha_vcto']; ?></td>
        </tr>
        <?php } while ($row_convenioweb = mysqli_fetch_assoc($convenioweb)); ?>
    </table>
    <?php } // Show if recordset not empty ?>
    <br>
    <?php if ($totalRows_modificar > 0) { // Show if recordset not empty ?>
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr align="center" bgcolor="#999999">
            <td colspan="9" align="left" valign="middle" class="titulocolumnas"><img
                    src="../../../imagenes/GIF/notepad.gif" width="19" height="21"><span class="titulo_menu">Pagare
                    Paragua</span></td>
        </tr>
        <tr align="center" bgcolor="#999999">
            <td valign="middle" class="titulocolumnas">Ver Detalle</td>
            <td valign="middle" class="titulocolumnas">Fecha Ingreso</td>
            <td valign="middle" class="titulocolumnas">Rut Cliente</td>
            <td valign="middle" class="titulocolumnas">Nombre Cliente </td>
            <td valign="middle" class="titulocolumnas">Moneda / Monto Pagare</td>
            <td valign="middle" class="titulocolumnas">Moneda / Monto Convenio</td>
            <td valign="middle" class="titulocolumnas">Fecha Suscripci&oacute;n Pagar&eacute;</td>
            <td valign="middle" class="titulocolumnas">Fecha Suscripci&oacute;n Convenio</td>
            <td valign="middle" class="titulocolumnas">Estado</td>
        </tr>
        <?php do { ?>
        <tr valign="middle">
            <td align="center" valign="middle" class="rojopequeno"><a
                    href="modpagdet.php?recordID=<?php echo $row_modificar['id']; ?>"><img
                        src="../../../imagenes/ICONOS/update_2.jpg" alt="" width="18" height="18" border="0"></a></td>
            <td align="center" valign="middle" class="rojopequeno"><?php echo $row_modificar['fecha_ingreso']; ?></td>
            <td align="center" valign="middle"><?php echo strtoupper($row_modificar['rut_cliente']); ?></td>
            <td align="center" valign="middle"><?php echo strtoupper($row_modificar['nombre_cliente']); ?></td>
            <td align="center" valign="middle"><span
                    class="respuestacolumna_rojo"><?php echo $row_modificar['moneda_pagare']; ?></span> <span
                    class="respuestacolumna_azul"><?php echo number_format($row_modificar['monto_pagare'], 2, ',', '.'); ?></span>
            </td>
            <td align="center" valign="middle"><span
                    class="respuestacolumna_rojo"><?php echo $row_modificar['moneda_convenio']; ?></span> <span
                    class="respuestacolumna_azul"><?php echo number_format($row_modificar['monto_convenio'], 2, ',', '.'); ?></span>
            </td>
            <td align="center" valign="middle"><?php echo $row_modificar['fecha_suscripcion_pagare']; ?></td>
            <td align="left" valign="middle"><?php echo $row_modificar['fecha_suscripcion_convenio']; ?></td>
            <td align="right" valign="middle"><?php echo $row_modificar['estado']; ?></td>
        </tr>
        <?php } while ($row_modificar = mysqli_fetch_assoc($modificar)); ?>
    </table>
    <br>
    <table border="0" width="50%" align="center">
        <tr>
            <td width="23%" align="center"><?php if ($pageNum_modificar > 0) { // Show if not first page ?>
                <a
                    href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, 0, $queryString_modificar); ?>">Primero</a>
                <?php } // Show if not first page ?>
            </td>
            <td width="31%" align="center"><?php if ($pageNum_modificar > 0) { // Show if not first page ?>
                <a
                    href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, max(0, $pageNum_modificar - 1), $queryString_modificar); ?>">Anterior</a>
                <?php } // Show if not first page ?>
            </td>
            <td width="23%" align="center">
                <?php if ($pageNum_modificar < $totalPages_modificar) { // Show if not last page ?>
                <a
                    href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, min($totalPages_modificar, $pageNum_modificar + 1), $queryString_modificar); ?>">Siguiente</a>
                <?php } // Show if not last page ?>
            </td>
            <td width="23%" align="center">
                <?php if ($pageNum_modificar < $totalPages_modificar) { // Show if not last page ?>
                <a
                    href="<?php printf("%s?pageNum_modificar=%d%s", $currentPage, $totalPages_modificar, $queryString_modificar); ?>">&Uacute;ltimo</a>
                <?php } // Show if not last page ?>
            </td>
        </tr>
    </table>
    <br>
    Registros del <strong><?php echo ($startRow_modificar + 1) ?></strong> al
    <strong><?php echo min($startRow_modificar + $maxRows_modificar, $totalRows_modificar) ?></strong> de un total de
    <strong><?php echo $totalRows_modificar ?></strong>
    <?php } // Show if recordset not empty ?>
    <br>
</body>

</html>
<?php
mysqli_free_result($modificar);
mysqli_free_result($convenioweb);
?>