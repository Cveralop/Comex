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

$colname_DetailRS1 = "-1";
if (isset($_GET['recordID'])) {
  $colname_DetailRS1 = $_GET['recordID'];
}
mysqli_select_db($comercioexterior, $database_comercioexterior);
$query_DetailRS1 = sprintf("SELECT * FROM opcci nolock WHERE id = %s", GetSQLValueString($colname_DetailRS1, "text"));
$DetailRS1 = mysqli_query($comercioexterior, $query_DetailRS1) or die(mysqli_error($comercioexterior));
$row_DetailRS1 = mysqli_fetch_assoc($DetailRS1);
$totalRows_DetailRS1 = mysqli_num_rows($DetailRS1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE opcci SET estado=%s, obs=%s, sub_estado=%s, estado_visacion=%s, date_espe=%s WHERE id=%s",
                       GetSQLValueString($_POST['estado'], "text"),
                       GetSQLValueString($_POST['obs'], "text"),
                       GetSQLValueString($_POST['sub_estado'], "text"),
					   GetSQLValueString($_POST['estado_visacion'], "text"),
                       GetSQLValueString($_POST['date_espe'], "date"),
                       GetSQLValueString($_POST['id'], "int"));
  mysqli_select_db($comercioexterior, $database_comercioexterior);
  $Result1 = mysqli_query($comercioexterior, $updateSQL) or die(mysqli_error($comercioexterior));

  $updateGoTo = "elimae.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Anular Instrucci&oacute;n - Detalle</title>
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

    .Estilo5 {
        color: #FFFFFF;
        font-size: 12px;
        font-weight: bold;
    }
    -->
    </style>
    <script src="../../../../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
    <script>
    var segundos = 1200
    var direccion = 'http://pdpto38:8303/comex/index.php'
    milisegundos = segundos * 1000
    window.setTimeout("window.location.replace(direccion);", milisegundos);
    </script>
    <link href="../../../../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
</head>
<link rel="shortcut icon" href="../../../../imagenes/barraweb/favicon.ico">
<link rel="icon" type="image/gif" href="../../../../imagenes/barraweb/animated_favicon1.gif">

<body onLoad="MM_preloadImages('../../../../imagenes/Botones/boton_volver_2.jpg')">
    <table width="95%" border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
        <tr valign="middle">
            <td align="left" class="Estilo3">ANULAR INSTRUCCION - DETALLE </td>
            <td width="7%" rowspan="2" align="left" class="Estilo3"><img src="../../../../imagenes/GIF/erde016.gif"
                    width="43" height="43" align="right"></td>
        </tr>
        <tr valign="middle">
            <td align="left" class="Estilo4">CARTAS DE CR&Eacute;DITO DE IMPORTACI&Oacute;N</td>
        </tr>
    </table>
    <br>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1">
        <table width="95%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
            <tr valign="middle" bgcolor="#999999">
                <td colspan="4" align="left"><img src="../../../../imagenes/GIF/notepad.gif" width="19" height="21"
                        border="0"> <span class="titulodetalle">Anular Instrucci&oacute;n</div>
                    </span></td>
            </tr>
            <tr valign="middle">
                <td align="right">Rut Cliente:</td>
                <td align="center">
                    <input name="rut_cliente" type="text" class="etiqueta12"
                        value="<?php echo $row_DetailRS1['rut_cliente']; ?>" size="17" maxlength="15"
                        readonly="readonly">
                    <span class="rojopequeno">Sin puntos ni Guion</span></div>
                </td>
                <td align="right">Fecha Ingreso:</div>
                </td>
                <td align="center">
                    <input name="fecha_ingreso" type="text" class="etiqueta12"
                        value="<?php echo $row_DetailRS1['fecha_ingreso']; ?>" size="12" maxlength="10"
                        readonly="readonly">
                    <span class="rojopequeno">(dd-mm-aaaa)</span> </div>
                </td>
            </tr>
            <tr valign="middle">
                <td align="right">Nombre Cliente:</td>
                <td colspan="3" align="left"><input name="nombre_cliente" type="text" class="etiqueta12"
                        value="<?php echo $row_DetailRS1['nombre_cliente']; ?>" size="122" maxlength="120"
                        readonly="readonly"></td>
            </tr>
            <tr valign="middle">
                <td align="right">Evento:</td>
                <td align="center"> <input name="evento" type="text" class="etiqueta12" id="evento"
                        value="<?php echo $row_DetailRS1['evento']; ?>" size="20" maxlength="20" readonly="readonly">
                    </div>
                </td>
                <td align="right">Especialista:</div>
                </td>
                <td align="center">
                    <input name="especialista" type="text" class="etiqueta12" value="<?php echo $_SESSION['login'];?>"
                        size="20" maxlength="20" readonly="readonly">
                    </div>
                </td>
            </tr>
            <tr valign="middle">
                <td align="right">Observaci&oacute;n:</td>
                <td colspan="3" align="left"><span id="sprytextarea1">
                        <textarea name="obs" cols="80" rows="4"
                            class="etiqueta12"><?php echo (isset($row_DetailRS1['obs'])?$row_DetailRS1['obs']:""); ?></textarea>
                        <span class="rojopequeno" id="countsprytextarea1">&nbsp;</span><span
                            class="textareaMaxCharsMsg">Se ha superado el n&uacute;mero m&aacute;ximo de caracteres.</span></span>
                </td>
            </tr>
            <tr valign="middle">
                <td align="right">Moneda<br>
                    Monto Operaci&oacute;n:</td>
                <td align="center">
                    <select name="moneda_operacion" disabled="disabled" class="etiqueta12" id="moneda_operacion">
                        <option value="CLP">CLP</option>
                        <option value="DKK">DKK</option>
                        <option value="NOK">NOK</option>
                        <option value="SEK">SEK</option>
                        <option value="USD">USD</option>
                        <option value="CAD">CAD</option>
                        <option value="AUD">AUD</option>
                        <option value="HKD">HKD</option>
                        <option value="EUR">EUR</option>
                        <option value="CHF">CHF</option>
                        <option value="GBP">GBP</option>
                        <option value="ZAR">ZAR</option>
                        <option value="JPY">JPY</option>
                    </select>
                    <span class="rojopequeno">/</span>
                    <input name="monto_operacion" type="text" class="etiqueta12"
                        value="<?php echo $row_DetailRS1['monto_operacion']; ?>" size="20" maxlength="20"
                        readonly="readonly">
                    </div>
                </td>
                <td align="right">Urgente:</div>
                </td>
                <td align="center">
                    <label>
                        <input <?php if (!(strcmp($row_DetailRS1['urgente'],"Si"))) {echo "CHECKED";} ?> name="urgente"
                            type="radio" class="etiqueta12" value="Si">
                        Si</label>
                    <label>
                        <input <?php if (!(strcmp($row_DetailRS1['urgente'],"No"))) {echo "CHECKED";} ?> name="urgente"
                            type="radio" class="etiqueta12" value="No" checked>
                        No</label>
                </td>
            </tr>
            <tr valign="middle">
                <td colspan="4" align="center">
                    <input type="submit" class="boton" value="Anular o Eliminar Instrucci&oacute;n">
                    </div>
                </td>
            </tr>
        </table>
        <input name="id" type="hidden" value="<?php echo $row_DetailRS1['id']; ?>">
        <input type="hidden" name="MM_update" value="form1">
        <input name="estado" type="hidden" id="estado" value="Eliminada.">
        <input name="sub_estado" type="hidden" id="sub_estado" value="Eliminada.">
        <input name="estado_visacion" type="hidden" id="estado_visacion" value="Eliminada.">
        <input name="date_espe" type="hidden" id="date_espe" value="<?php echo date("Y-m-d H:i:s"); ?>">
    </form>
    <br>
    <table width="95%" border="0" align="center">
        <tr>
            <td align="right" valign="middle"><a href="elimae.php" onMouseOut="MM_swapImgRestore()"
                    onMouseOver="MM_swapImage('Image3','','../../../../imagenes/Botones/boton_volver_2.jpg',1)"><img
                        src="../../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80"
                        height="25" border="0"></a></div>
            </td>
        </tr>
    </table>
    <script type="text/javascript">
    <!--
    var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {
        minChars: 0,
        maxChars: 255,
        validateOn: ["blur"],
        isRequired: false,
        counterType: "chars_remaining",
        counterId: "countsprytextarea1"
    });
    //
    -->
    </script>
</body>

</html>
<?php
mysqli_free_result($DetailRS1);
?>