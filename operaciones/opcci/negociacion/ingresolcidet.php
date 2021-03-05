<?php require_once('../../../Connections/comercioexterior.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "SUP,OPE,ADM";
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
  //$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($comercioexterior, $theValue) : mysqli_escape_string($comercioexterior, $theValue);
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
  $insertSQL = sprintf("INSERT INTO opcci (rut_cliente, nombre_cliente, fecha_ingreso, date_ingreso, evento, estado, asignador, operador, producto, nro_operacion, nro_operacion_relacionada, especialista_curse, moneda_operacion, monto_operacion, sub_estado, date_asig, estado_visacion, visador) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['rut_cliente'], "text"),
                       GetSQLValueString($_POST['nombre_cliente'], "text"),
                       GetSQLValueString($_POST['fecha_ingreso'], "text"),
                       GetSQLValueString($_POST['date_ingreso'], "date"),
                       GetSQLValueString($_POST['evento'], "text"),
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['asignador'], "text"),
                       GetSQLValueString($_POST['operador'], "text"),
                       GetSQLValueString($_POST['producto'], "text"),
                       GetSQLValueString($_POST['nro_operacion'], "text"),
                       GetSQLValueString($_POST['nro_operacion_relacionada'], "text"),
                       GetSQLValueString($_POST['especialista_curse'], "text"),
                       GetSQLValueString($_POST['moneda_operacion'], "text"),
                       GetSQLValueString($_POST['monto_operacion'], "double"),
                       GetSQLValueString($_POST['sub_estado'], "text"),
                       GetSQLValueString($_POST['date_asig'], "date"),
                       GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['visador'], "text"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $insertSQL) or die(mysqli_error($comercioexterior));
  $insertGoTo = "ingresolcimae.php";
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
$query_DetailRS1 = sprintf("SELECT * FROM carteraopera WHERE id = %s", GetSQLValueString($colname_DetailRS1, "int"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);
//var_dump($row_DetailRS1); die();
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Documento sin título</title>
    <style type="text/css">
    <!--
    body,
    td,
    th {
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
    -->
    </style>
    <link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
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
    </script>
    <script>
    var segundos = 1200
    var direccion = 'http://pdpto38:8303/comex/index.php'
    milisegundos = segundos * 1000
    window.setTimeout("window.location.replace(direccion);", milisegundos);
    </script>
</head>

<body onload="MM_preloadImages('../../../imagenes/Botones/boton_volver_2.jpg')">
    <table width="95%" border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
        <tr>
            <td width="93%" align="left" valign="middle" class="Estilo3">INGRESO PAGO Y/O PRORROGA LCI - DETALLE</td>
            <td width="7%" rowspan="2" align="left" valign="middle" class="Estilo3"><img
                    src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="Estilo4">CARTAS DE CR&Eacute;DITO IMPORTACI&Oacute;N</td>
        </tr>
    </table>
    <br />
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
            <tr valign="baseline">
                <td colspan="4" align="left" valign="middle" bgcolor="#999999" class="titulodetalle"><img
                        src="../../../imagenes/GIF/notepad.gif" width="19" height="21" />Detalle Ingreso Pago y/o
                    Prorroga LCI</td>
            </tr>
            <tr valign="baseline">
                <td width="19%" align="right" valign="middle">Rut Cliente:</td>
                <td colspan="3" align="left" valign="middle" class="nroregistro"><input name="rut_cliente" type="text"
                        class="etiqueta12" value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17"
                        maxlength="15" />
                    <span class="rojopequeno">Sin puntos ni Guion</span>
                </td>
            </tr>
            <tr valign="baseline">
                <td align="right" valign="middle">Nombre Cliente:</td>
                <td colspan="3" align="left" valign="middle"><input name="nombre_cliente" type="text" class="etiqueta12"
                        value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="80" maxlength="80" /></td>
            </tr>
            <tr valign="baseline">
                <td align="right" valign="middle">Fecha Ingreso:</td>
                <td width="27%" align="center" valign="middle"><input name="fecha_ingreso" type="text"
                        class="etiqueta12" value="<?php echo date("d-m-Y"); ?>" size="12" maxlength="10" />
                    <span class="rojopequeno">(dd-mm-aaaa)</span>
                    </div>
                </td>
                <td width="24%" align="right" valign="middle">Evento:</td>
                <td width="30%" align="center" valign="middle"><select name="evento" class="etiqueta12" id="evento">
                        <option value="Pago.">Pago</option>
                        <option value="Prorroga.">Prorroga</option>
                        <option value="Prorroga y Pago.">Prorroga y Pago</option>
                        <option value="Cambio Tasa.">Cambio Tasa</option>
                        <option value="Visacion.">Visacion (DI)</option>
                        <option value="Cartera Vencida.">Cartera Vencida</option>
                        <option value="Requerimiento.">Requerimiento</option>
                        <option value="Carta Original.">Carta Original</option>
                        <option value="Restructuracion.">Restructuracion</option>
                        <option value="Redenominacion.">Redenominacion</option>
                    </select></td>
            </tr>
            <tr valign="baseline">
                <td align="right" valign="middle">Asignador:</td>
                <td align="center" valign="middle"><input name="asignador" type="text" class="etiqueta12"
                        value="<?php echo $_SESSION['login'];?>" size="20" maxlength="20" /></td>
                <td align="right" valign="middle">Operador:</td>
                <td align="center" valign="middle"><select name="operador" class="etiqueta12" id="operador">
                        <option value="AVENEGC"
                            <?php if (!(strcmp("AVENEGC", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Ana M. Venegas Casta&ntilde;eda</option>
                        <option value="HRAMIRZ"
                            <?php if (!(strcmp("HRAMIRZ", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Hernan Ramirez Ramirez</option>
                        <option value="JAVELLO"
                            <?php if (!(strcmp("JAVELLO", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Juan Avello Poblete</option>
                        <option value="EVALENZU"
                            <?php if (!(strcmp("EVALENZU", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Eliza Valenzuela</option>
                        <option value="CURRUTP"
                            <?php if (!(strcmp("CURRUTP", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Claudia Urrutia</option>
                        <option value="EROBLES"
                            <?php if (!(strcmp("EROBLES", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Elizabeth Robles</option>
                        <option value="HURIBEC"
                            <?php if (!(strcmp("HURIBEC", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Hernan Uribe</option>
                        <option value="JMALDON"
                            <?php if (!(strcmp("JMALDON", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Jaime Maldonado</option>
                        <option value="LCELISD"
                            <?php if (!(strcmp("LCELISD", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Luis Celis</option>
                        <option value="PGODOY"
                            <?php if (!(strcmp("PGODOY", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Patricia Godoy</option>
                        <option value="PMOSCOA"
                            <?php if (!(strcmp("PMOSCOA", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Pamela Moscoso</option>
                        <option value="MTOROB"
                            <?php if (!(strcmp("MTOROB", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Veronica Toro</option>
                        <option value="RTOBARC"
                            <?php if (!(strcmp("RTOBARC", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Romuald Tobar Caro</option>
                        <option value="FESPINOZ"
                            <?php if (!(strcmp("FESPINOZ", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Franco Espinoza</option>
                        <option value="MPALACIO"
                            <?php if (!(strcmp("MPALACIO", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Manuel Palacios Gutierrez</option>
                        <option value="JSANTIBA"
                            <?php if (!(strcmp("JSANTIBA", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Jose Santibanez Pena</option>
                        <option value="FMABELP"
                            <?php if (!(strcmp("FMABELP", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Francisca Mabel Perez</option>
                        <option value="XMAGANA"
                            <?php if (!(strcmp("XMAGANA", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Ximena Maga�a Gonzalez</option>
                        <option value="YPARRA"
                            <?php if (!(strcmp("YPARRA", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Yanadet Parra Trincado</option>
                        <option value="JROMAN"
                            <?php if (!(strcmp("JROMAN", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Juan Roman Diaz</option>
                        <option value="PCCI1"
                            <?php if (!(strcmp("PCCI1", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Practica CCI 1</option>
                        <option value="PCCI2"
                            <?php if (!(strcmp("PCCI2", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Practica CCI 2</option>
                        <option value="PCCI3"
                            <?php if (!(strcmp("PCCI3", $row_DetailRS1['ope']))) {echo "selected=\"selected\"";} ?>>
                            Practica CCI 3</option>
                    </select></td>
            </tr>
            <tr valign="baseline">
                <td align="right" valign="middle">No. Operacion:</td>
                <td align="center" valign="middle"><input name="nro_operacion" type="text" class="etiqueta12"
                        value="<?php echo $row_DetailRS1['nro_operacion_relacionada_car']; ?>" size="10"
                        maxlength="7" />
                    <span class="rojopequeno">K000000</span>
                </td>
                <td align="right" valign="middle">No. Operacion Relacionada:</td>
                <td align="center" valign="middle"><input name="nro_operacion_relacionada" type="text"
                        class="etiqueta12" value="<?php echo $row_DetailRS1['nro_operacion_car']; ?>" size="10"
                        maxlength="7" />
                    <span class="rojopequeno">L000000</span>
                </td>
            </tr>
            <tr valign="baseline">
                <td align="right" valign="middle">Moneda / Monto Operacion:</td>
                <td colspan="3" align="left" valign="middle"><select name="moneda_operacion" class="etiqueta12"
                        id="moneda_operacion">
                        <option value="CLP"
                            <?php if (!(strcmp("CLP", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            CLP</option>
                        <option value="DKK"
                            <?php if (!(strcmp("DKK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            DKK</option>
                        <option value="NOK"
                            <?php if (!(strcmp("NOK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            NOK</option>
                        <option value="SEK"
                            <?php if (!(strcmp("SEK", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            SEK</option>
                        <option value="USD" selected="selected"
                            <?php if (!(strcmp("USD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            USD</option>
                        <option value="CAD"
                            <?php if (!(strcmp("CAD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            CAD</option>
                        <option value="AUD"
                            <?php if (!(strcmp("AUD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            AUD</option>
                        <option value="HKD"
                            <?php if (!(strcmp("HKD", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            HKD</option>
                        <option value="EUR"
                            <?php if (!(strcmp("EUR", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            EUR</option>
                        <option value="CHF"
                            <?php if (!(strcmp("CHF", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            CHF</option>
                        <option value="GBP"
                            <?php if (!(strcmp("GBP", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            GBP</option>
                        <option value="ZAR"
                            <?php if (!(strcmp("ZAR", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            ZAR</option>
                        <option value="JPY"
                            <?php if (!(strcmp("JPY", $row_DetailRS1['moneda_operacion']))) {echo "selected=\"selected\"";} ?>>
                            JPY</option>
                    </select>
                    /
                    <input name="monto_operacion" type="text" class="etiqueta12"
                        value="<?php echo $row_DetailRS1['saldo_operacion']; ?>" size="20" maxlength="20" />
                </td>
            </tr>
            <tr valign="baseline">
                <td colspan="4" align="center" valign="middle"><input type="submit" class="boton"
                        value="Ingresar Operación" /></td>
            </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
        <input type="hidden" name="date_ingreso" value="<?php echo date("Y-m-d"); ?>" size="32" />
        <input type="hidden" name="estado" value="" size="32" />
        <input type="hidden" name="sub_estado" value="" size="32" />
        <input type="hidden" name="date_asig" value="" size="32" />
        <input type="hidden" name="estado_visacion" value="" size="32" />
        <input type="hidden" name="visador" value="" size="32" />
    </form>
    <br />
    <table width="95%" border="0" align="center">
        <tr>
            <td align="right" valign="middle"><a href="ingresolcimae.php" onmouseout="MM_swapImgRestore()"
                    onmouseover="MM_swapImage('Imagen3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img
                        src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Imagen3" width="80"
                        height="25" border="0" id="Imagen3" /></a></td>
        </tr>
    </table>
</body>

</html><?php
mysqli_free_result($DetailRS1);
?>