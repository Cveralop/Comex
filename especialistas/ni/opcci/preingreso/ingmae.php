<?php require_once('../../../../Connections/comercioexterior.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "ADM,ESP";
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

//AGREGADO 1 para total de registros
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_ingape = 10;
$pageNum_ingape = 0;
if (isset($_GET['pageNum_ingape'])) {
  $pageNum_ingape = $_GET['pageNum_ingape'];
}
$startRow_ingape = $pageNum_ingape * $maxRows_ingape;

$colname_ingape = "-1";
if (isset($_GET['rut_cliente'])) {
  $colname_ingape = $_GET['rut_cliente'];
}
mysqli_select_db($comercioexterior,$database_comercioexterior);
$query_ingape = sprintf("SELECT * FROM cliente nolock WHERE rut_cliente = %s", GetSQLValueString($colname_ingape, "text"));
$query_limit_ingape = sprintf("%s LIMIT %d, %d", $query_ingape, $startRow_ingape, $maxRows_ingape);
$ingape = mysqli_query($comercioexterior, $query_limit_ingape) or die(mysqli_error($comercioexterior));
$row_ingape = mysqli_fetch_assoc($ingape);
$totalRows_ingape = mysqli_num_rows($ingape);

//AGREGADO 1.2 para total de registros
if (isset($_GET['totalRows_ingape'])) {
  $totalRows_ingape = $_GET['totalRows_ingape'];
} else {
  $all_ingape = mysqli_query($comercioexterior, $query_ingape);
  $totalRows_ingape = mysqli_num_rows($all_ingape);
}
$totalPages_ingape = ceil($totalRows_ingape/$maxRows_ingape)-1;

$queryString_ingape = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ingape") == false && 
        stristr($param, "totalRows_ingape") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ingape = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ingape = sprintf("&totalRows_ingape=%d%s", $totalRows_ingape, $queryString_ingape);


//AGREGADO 2 para total de registros
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_ingvarios = 10;
$pageNum_ingvarios = 0;
if (isset($_GET['pageNum_ingvarios'])) {
  $pageNum_ingvarios = $_GET['pageNum_ingvarios'];
}
$startRow_ingvarios = $pageNum_ingvarios * $maxRows_ingvarios;

$colname_ingvarios = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_ingvarios = $_GET['nro_operacion'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_ingvarios = sprintf("SELECT * FROM opcci nolock WHERE nro_operacion = %s ORDER BY id DESC", GetSQLValueString($colname_ingvarios, "text"));
$query_limit_ingvarios = sprintf("%s LIMIT %d, %d", $query_ingvarios, $startRow_ingvarios, $maxRows_ingvarios);
$ingvarios = mysqli_query($comercioexterior, $query_limit_ingvarios) or die(mysqli_error($comercioexterior));
$row_ingvarios = mysqli_fetch_assoc($ingvarios);

//AGREGADO 2.2 para total de registros
if (isset($_GET['totalRows_ingvarios'])) {
  $totalRows_ingvarios = $_GET['totalRows_ingvarios'];
} else {
  $all_ingvarios = mysqli_query($comercioexterior, $query_ingvarios);
  $totalRows_ingvarios = mysqli_num_rows($all_ingvarios);
}
$totalPages_ingvarios = ceil($totalRows_ingvarios/$maxRows_ingvarios)-1;

$queryString_ingvarios = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ingvarios") == false && 
        stristr($param, "totalRows_ingvarios") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ingvarios = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ingvarios = sprintf("&totalRows_ingvarios=%d%s", $totalRows_ingvarios, $queryString_ingvarios);

//AGREGADO 3 para total de registros
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_opcci = 10;
$pageNum_opcci = 0;
if (isset($_GET['pageNum_opcci'])) {
  $pageNum_opcci = $_GET['pageNum_opcci'];
}
$startRow_opcci = $pageNum_opcci * $maxRows_opcci;

$colname_opcci = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_opcci = $_GET['nro_operacion'];
}

$colname_opcci = "K";
if (isset($_GET['nro_operacion_relacionada_car'])) {
  $colname_opcci = $_GET['nro_operacion_relacionada_car'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_opcci = sprintf("SELECT * FROM carteraopera nolock WHERE nro_operacion_relacionada_car = %s ORDER BY id DESC", GetSQLValueString($colname_opcci, "text"));
$query_limit_opcci = sprintf("%s LIMIT %d, %d", $query_opcci, $startRow_opcci, $maxRows_opcci);
$opcci = mysqli_query($comercioexterior, $query_limit_opcci) or die(mysqli_error($comercioexterior));
$row_opcci = mysqli_fetch_assoc($opcci);


//AGREGADO 3.2 para total de registros
if (isset($_GET['totalRows_opcci'])) {
  $totalRows_opcci = $_GET['totalRows_opcci'];
} else {
  $all_opcci = mysqli_query($comercioexterior, $query_opcci);
  $totalRows_opcci = mysqli_num_rows($all_opcci);
}
$totalPages_opcci = ceil($totalRows_opcci/$maxRows_opcci)-1;

$queryString_opcci = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_opcci") == false && 
        stristr($param, "totalRows_opcci") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_opcci = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_opcci = sprintf("&totalRows_opcci=%d%s", $totalRows_opcci, $queryString_opcci);

//AGREGADO 4 para total de registros
$currentPage = $_SERVER["PHP_SELF"];
$maxRows_inglci = 10;
$pageNum_inglci = 0;
if (isset($_GET['pageNum_inglci'])) {
  $pageNum_inglci = $_GET['pageNum_inglci'];
}
$startRow_inglci = $pageNum_inglci * $maxRows_inglci;

$colname_inglci = "-1";
if (isset($_GET['nro_operacion'])) {
  $colname_inglci = $_GET['nro_operacion'];
}

$colname_inglci = "L";
if (isset($_GET['nro_operacion_car'])) {
  $colname_inglci = $_GET['nro_operacion_car'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_inglci = sprintf("SELECT * FROM carteraopera nolock WHERE nro_operacion_car = %s ORDER BY id DESC", GetSQLValueString($colname_inglci, "text"));
$query_limit_inglci = sprintf("%s LIMIT %d, %d", $query_inglci, $startRow_inglci, $maxRows_inglci);
$inglci = mysqli_query($comercioexterior, $query_limit_inglci) or die(mysqli_error($comercioexterior));
$row_inglci = mysqli_fetch_assoc($inglci);


//AGREGADO 4.2 para total de registros
if (isset($_GET['totalRows_inglci'])) {
  $totalRows_inglci = $_GET['totalRows_inglci'];
} else {
  $all_inglci = mysqli_query($comercioexterior, $query_inglci);
  $totalRows_inglci = mysqli_num_rows($all_inglci);
}
$totalPages_inglci = ceil($totalRows_inglci/$maxRows_inglci)-1;

$queryString_inglci = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_inglci") == false && 
        stristr($param, "totalRows_inglci") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_inglci = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_inglci = sprintf("&totalRows_inglci=%d%s", $totalRows_inglci, $queryString_inglci);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Pre-Ingreso Intrucciones - Maestro</title>
    <style type="text/css">
    <!--
    @import url("../../../../estilos/estilo12.css");

    body,
    td,
    th {
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

    .Estilo7 {
        font-size: 12px;
        font-weight: bold;
        color: #FFFFFF;
    }

    .Estilo11 {
        color: #FFFFFF;
        font-weight: bold;
    }

    .Estilo12 {
        color: #FF0000;
        font-weight: bold;
    }
    -->
    </style>
    <script>
    var segundos = 1200
    var direccion = 'http://pdpto38:8303/comex/index.php'
    milisegundos = segundos * 1000
    window.setTimeout("window.location.replace(direccion);", milisegundos);
    </script>
    <link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
    <link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">
</head>

<body
    onLoad="MM_preloadImages('../../../../espcomex/imagenes/Botones/boton_volver_2.jpg','../../../../imagenes/Botones/boton_volver_2.jpg')">
    <table width="95%" border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
        <tr valign="middle">
            <td align="left" class="Estilo3">PRE-INGRESO INSTRUCCIONES - MAESTRO </td>
            <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif"
                    width="43" height="43" align="right"></td>
        </tr>
        <tr valign="middle">
            <td align="left" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
        </tr>
    </table>
    <br>
    <form name="form1" method="get" action="">
        <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
            <tr valign="middle" bgcolor="#999999">
                <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"
                        border="0"><span class="Estilo7">Pre-Ingreso Instrucci&oacute;n Apertura Carta de Cr&eacute;dito
                        de Importaci&oacute;n</span></td>
            </tr>
            <tr valign="middle">
                <td align="right">Rut Cliente:</td>
                <td width="79%" align="left"><input name="rut_cliente" type="text" class="etiqueta12" id="rut_cliente"
                        size="17" maxlength="12">
                    <span class="rojopequeno">Sin puntos ni Guion</span>
                </td>
            </tr>
            <tr valign="middle">
                <td colspan="2" align="center">
                    <input name="Submit" type="submit" class="boton" value="Buscar">
                    <input name="Submit" type="reset" class="boton" value="Limpiar">
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <br>
    <form name="form2" method="get" action="">
        <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
            <tr valign="middle" bgcolor="#999999">
                <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"
                        border="0"><span class="Estilo7">Pre-Ingreso Instrucciones Carta de Cr&eacute;dito de
                        Importaci&oacute;n</span></td>
            </tr>
            <tr valign="middle">
                <td align="right">Nro Operaci&oacute;n:</td>
                <td width="79%" align="left"><input name="nro_operacion" type="text" class="etiqueta12"
                        id="nro_operacion" size="17" maxlength="7">
                    <span class="rojopequeno">K000000</span>
                </td>
            </tr>
            <tr valign="middle">
                <td colspan="2" align="center">
                    <input name="Submit" type="submit" class="boton" value="Buscar">
                    <input name="Submit" type="reset" class="boton" value="Limpiar">
                    </div>
                </td>
            </tr>
        </table>
    </form>
    <br>
    <form name="form3" method="get" action="">
        <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
            <tr valign="middle" bgcolor="#999999">
                <td colspan="2" align="left"><img src="../../../../imagenes/GIF/notepad.gif" alt="" width="19"
                        height="21" border="0"><span class="Estilo7">Pre-Ingreso Instrucciones Pr&eacute;stamos
                        (CCI)</span></td>
            </tr>
            <tr valign="middle">
                <td width="21%" align="right">Nro Operaci&oacute;n:
                    </div>
                </td>
                <td width="79%" align="left"><input name="nro_operacion_relacionada_car" type="text" class="etiqueta12"
                        id="nro_operacion_relacionada_car" size="15" maxlength="7">
                    <span class="rojopequeno">K000000</span>
                </td>
            </tr>
            <tr valign="middle">
                <td colspan="2" align="center"><input name="Submit2" type="submit" class="boton" value="Buscar">
                    <input name="Submit2" type="reset" class="boton" value="Limpiar">
                </td>
            </tr>
        </table>
    </form>
    <br>
    <form name="form4" method="get" action="">
        <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
            <tr>
                <td colspan="2" align="left" valign="middle" bgcolor="#999999"><img
                        src="../../../../imagenes/GIF/notepad.gif" alt="" width="19" height="21" border="0"><span
                        class="titulo_menu">Pre-Ingreso Instrucciones Prestamos (CCI)</span></td>
            </tr>
            <tr>
                <td width="21%" align="right" valign="middle" bgcolor="#CCCCCC">Nro Operacion Relacionada:</td>
                <td width="79%" align="left" valign="middle" bgcolor="#CCCCCC"><input name="nro_operacion_car"
                        type="text" class="etiqueta12" id="nro_operacion_car" size="15" maxlength="7">
                    <span class="rojopequeno">L000000</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="middle" bgcolor="#CCCCCC"><input name="button" type="submit"
                        class="boton" id="button" value="Enviar">
                    <input name="button2" type="submit" class="boton" id="button2" value="Enviar">
                </td>
            </tr>
        </table>
    </form>
    <br>
    <?php if ($totalRows_ingape > 0) { // Show if recordset not empty ?>
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr valign="middle" bgcolor="#999999">
            <td align="center" class="titulocolumnas">Ingresar Apertura </div>
            </td>
            <td align="center" class="titulocolumnas">Rut Cliente
                </div>
            </td>
            <td align="center" class="titulocolumnas">Nombre Cliente</td>
            <td align="center" class="titulocolumnas">Impedido de Operar / Passport</td>
        </tr>
        <?php do { ?>
        <tr valign="middle">
            <td align="center"><a href="ingdet.php?recordID=<?php echo $row_ingape['id']; ?>"> <img
                        src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div>
            </td>
            <td align="center"><?php echo $row_ingape['rut_cliente']; ?> </div>
            </td>
            <td align="left"><?php echo strtoupper($row_ingape['nombre_cliente']); ?></td>
            <td align="center"><?php echo strtoupper($row_ingape['impedido_operar']); ?> / <span
                    class="respuestacolumna_rojo"><?php echo strtoupper($row_ingape['cliente_passport']); ?></span></td>
        </tr>
        <?php } while ($row_ingape = mysqli_fetch_assoc($ingape)); ?>
    </table>
    <br>

    <table border="0" width="50%" align="center">
        <tr>
            <td width="23%" align="center"><?php if ($pageNum_ingape > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, 0, $queryString_ingape); ?>">Primero</a>
                <?php } // Show if not first page ?>
            </td>
            <td width="31%" align="center"><?php if ($pageNum_ingape > 0) { // Show if not first page ?>
                <a
                    href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, max(0, $pageNum_ingape - 1), $queryString_ingape); ?>">Anterior</a>
                <?php } // Show if not first page ?>
            </td>
            <td width="23%" align="center"><?php if ($pageNum_ingape < $totalPages_ingape) { // Show if not last page ?>
                <a
                    href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, min($totalPages_ingape, $pageNum_ingape + 1), $queryString_ingape); ?>">Siguiente</a>
                <?php } // Show if not last page ?>
            </td>
            <td width="23%" align="center"><?php if ($pageNum_ingape < $totalPages_ingape) { // Show if not last page ?>
                <a
                    href="<?php printf("%s?pageNum_ingape=%d%s", $currentPage, $totalPages_ingape, $queryString_ingape); ?>">&Uacute;ltimo</a>
                <?php } // Show if not last page ?>
            </td>
        </tr>
    </table>


    Registros del <strong><?php echo ($startRow_ingape + 1) ?></strong> al
    <strong><?php echo min($startRow_ingape + $maxRows_ingape, $totalRows_ingape) ?></strong> de un total de
    <strong><?php echo $totalRows_ingape ?></strong>
    <?php } // Show if recordset not empty ?>
    <br>
    <?php if ($totalRows_ingvarios > 0) { // Show if recordset not empty ?>
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr valign="middle" bgcolor="#999999" class="respuestacolumna">
            <td align="center" class="titulocolumnas">Ingresar Instrucci&oacute;n</div>
            </td>
            <td align="center" class="titulocolumnas">Nro Operaci&oacute;n </div>
            </td>
            <td align="center" class="titulocolumnas">Rut Cliente
                </div>
            </td>
            <td align="center" class="titulocolumnas">Nombre Cliente
                </div>
            </td>
            <td align="center" class="titulocolumnas">Evento</td>
            <td align="center" class="titulocolumnas">Estado</td>
            <td align="center" class="titulocolumnas">Moneda / Monto Operaci&oacute;n</td>
        </tr>
        <?php do { ?>
        <tr valign="middle">
            <td align="center"><a href="ingdet2.php?recordID=<?php echo $row_ingvarios['id']; ?>"> <img
                        src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></div>
            </td>
            <td align="center"><span
                    class="respuestacolumna_rojo"><?php echo strtoupper($row_ingvarios['nro_operacion']); ?></span>
                </div>
            </td>
            <td align="center"><?php echo $row_ingvarios['rut_cliente']; ?> </div>
            </td>
            <td align="left"><?php echo $row_ingvarios['nombre_cliente']; ?> </td>
            <td align="center"><?php echo $row_ingvarios['evento']; ?></td>
            <td align="center"><?php echo $row_ingvarios['estado']; ?></td>
            <td align="right"><span
                    class="respuestacolumna_rojo"><?php echo $row_ingvarios['moneda_operacion']; ?></span> <span
                    class="respuestacolumna_azul"><?php echo number_format($row_ingvarios['monto_operacion'], 2, ',', '.'); ?></span>
            </td>
        </tr>
        <?php } while ($row_ingvarios = mysqli_fetch_assoc($ingvarios)); ?>
    </table>
    <br>

    <table border="0" width="50%" align="center">
        <tr>
            <td width="23%" align="center"><?php if ($pageNum_ingvarios > 0) { // Show if not first page ?>
                <a
                    href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, 0, $queryString_ingvarios); ?>">Primero</a>
                <?php } // Show if not first page ?>
            </td>
            <td width="31%" align="center"><?php if ($pageNum_ingvarios > 0) { // Show if not first page ?>
                <a
                    href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, max(0, $pageNum_ingvarios - 1), $queryString_ingvarios); ?>">Anterior</a>
                <?php } // Show if not first page ?>
            </td>
            <td width="23%" align="center">
                <?php if ($pageNum_ingvarios < $totalPages_ingvarios) { // Show if not last page ?>
                <a
                    href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, min($totalPages_ingvarios, $pageNum_ingvarios + 1), $queryString_ingvarios); ?>">Siguiente</a>
                <?php } // Show if not last page ?>
            </td>
            <td width="23%" align="center">
                <?php if ($pageNum_ingvarios < $totalPages_ingvarios) { // Show if not last page ?>
                <a
                    href="<?php printf("%s?pageNum_ingvarios=%d%s", $currentPage, $totalPages_ingvarios, $queryString_ingvarios); ?>">&Uacute;ltimo</a>
                <?php } // Show if not last page ?>
            </td>
        </tr>
    </table>

    Registros del <strong><?php echo ($startRow_ingvarios + 1) ?></strong> al
    <strong><?php echo min($startRow_ingvarios + $maxRows_ingvarios, $totalRows_ingvarios) ?></strong> de un total de
    <strong><?php echo $totalRows_ingvarios ?></strong>
    <?php } // Show if recordset not empty ?>
    <br>
    <?php if ($totalRows_opcci > 0) { // Show if recordset not empty ?>
    <br>
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr valign="middle" bgcolor="#999999">
            <td align="center" class="titulocolumnas">Ingresar Instrucci&oacute;n
                </div>
            </td>
            <td align="center" class="titulocolumnas">Nro Operaci&oacute;n
                </div>
            </td>
            <td align="center" class="titulocolumnas">Nro Operacion Relacionada</td>
            <td align="center" class="titulocolumnas">Rut Cliente
                </div>
            </td>
            <td align="center" class="titulocolumnas">Nombre Cliente
                </div>
            </td>
            <td align="center" class="titulocolumnas">Feha Vencimiento</td>
            <td align="center" class="titulocolumnas">Moneda Saldo Operaci&oacute;n
                </div>
            </td>
        </tr>
        <?php do { ?>
        <tr valign="middle">
            <td align="center"><a href="ingdet3.php?recordID=<?php echo $row_opcci['id']; ?>"> <img
                        src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a>
                </div>
            </td>
            <td align="center"><span
                    class="respuestacolumna_rojo"><?php echo strtoupper($row_opcci['nro_operacion_relacionada_car']); ?></span>
                </div>
            </td>
            <td align="center"><?php echo strtoupper($row_opcci['nro_operacion_car']); ?></td>
            <td align="center"><?php echo strtoupper($row_opcci['rut_cliente']); ?>
                </div>
            </td>
            <td align="left"><?php echo $row_opcci['nombre_cliente']; ?></td>
            <td align="center"><?php echo $row_opcci['fecha_vcto']; ?></td>
            <td align="right"><span
                    class="Estilo12"><?php echo strtoupper($row_opcci['moneda_operacion']); ?></span><span
                    class="respuestacolumna_azul">
                    <strong><?php echo number_format($row_opcci['saldo_operacion'], 2, ',', '.'); ?></strong>
                    </div>
            </td>
        </tr>
        <?php } while ($row_opcci = mysqli_fetch_assoc($opcci)); ?>
    </table>
    <br>
    Registros del <strong><?php echo ($startRow_opcci + 1) ?></strong> al
    <strong><?php echo min($startRow_opcci + $maxRows_opcci, $totalRows_opcci) ?></strong> de un total de
    <strong><?php echo $totalRows_opcci ?></strong>
    <?php } // Show if recordset not empty ?>
    <br>
    <?php if ($totalRows_inglci > 0) { // Show if recordset not empty ?>
    <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
        <tr>
            <td align="center" valign="middle" class="titulocolumnas">Ingresar Instrucci&oacute;n</td>
            <td align="center" valign="middle" class="titulocolumnas">Nro Operaci&oacute;n</td>
            <td align="center" valign="middle" class="titulocolumnas">Nro Operacion Relacionada</td>
            <td align="center" valign="middle" class="titulocolumnas">Rut Cliente</td>
            <td align="center" valign="middle" class="titulocolumnas">Nombre Cliente</td>
            <td align="center" valign="middle" class="titulocolumnas">Fecha Vcto</td>
            <td align="center" valign="middle" class="titulocolumnas">Moneda / Saldo Operacion</td>
        </tr>
        <?php do { ?>
        <tr>
            <td align="center" valign="middle" bgcolor="#CCCCCC"><a
                    href="ingdet4.php?recordID=<?php echo $row_inglci['id']; ?>"><img
                        src="../../../../imagenes/ICONOS/ingreso_dato.jpg" width="20" height="20" border="0"></a></td>
            <td align="center" valign="middle" bgcolor="#CCCCCC" class="respuestacolumna_rojo">
                <?php echo $row_inglci['nro_operacion_relacionada_car']; ?></td>
            <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_inglci['nro_operacion_car']; ?></td>
            <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_inglci['rut_cliente']; ?></td>
            <td align="left" valign="middle" bgcolor="#CCCCCC"><?php echo $row_inglci['nombre_cliente']; ?></td>
            <td align="center" valign="middle" bgcolor="#CCCCCC"><?php echo $row_inglci['fecha_vcto']; ?></td>
            <td align="right" valign="middle" bgcolor="#CCCCCC"><span
                    class="respuestacolumna_rojo"><?php echo $row_inglci['moneda_operacion']; ?></span><span
                    class="respuestacolumna_azul">
                    <strong><?php echo number_format($row_inglci['saldo_operacion'], 2, ',', '.'); ?></strong>
                    </div>
            </td>
        </tr>
        <?php } while ($row_inglci = mysqli_fetch_assoc($inglci)); ?>
    </table>
    <br>
    Registros del<span class="respuestacolumna_azul"><?php echo ($startRow_inglci + 1) ?></span> al <span
        class="respuestacolumna_azul"><?php echo min($startRow_inglci + $maxRows_inglci, $totalRows_inglci) ?></span> de
    un total de <span class="respuestacolumna_azul"><?php echo $totalRows_inglci ?></span>
    <?php } // Show if recordset not empty ?>
    <br>
    <table width="95%" border="0" align="center">
        <tr>
            <td align="right" valign="middle"><a href="../opcci.php" onMouseOut="MM_swapImgRestore()"
                    onMouseOver="MM_swapImage('Image6','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img
                        src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image6" width="80"
                        height="25" border="0"></a></div>
            </td>
        </tr>
    </table>
</body>

</html>
<?php
mysqli_free_result($ingape);
mysqli_free_result($ingvarios);
mysqli_free_result($opcci);
mysqli_free_result($inglci);
?>