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
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Convenio WEB </title>
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

    .Estilo41 {
        font-size: 12px;
        font-weight: bold;
        color: #FFFFFF;
    }
    </style>
    <script type="text/javascript">
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
    </script>
    <link href="../../../estilos/estilo12.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <table width="95%" border="1" align="center" bordercolor="#FF0000" bgcolor="#FF0000">
        <tr>
            <td width="95%" align="left" valign="middle" class="Estilo3">CONVENIO WEB</td>
            <td width="5%" rowspan="2" align="right" valign="middle" class="Estilo3"><img
                    src="../../../imagenes/GIF/erde016.gif" alt="" width="43" height="43" align="right" /></td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="Estilo4">COMERCIO EXTERIOR</td>
        </tr>
    </table>
    <br />
    <table width="95%" border="1" align="center" bordercolor="#000000">
        <tr>
            <td bordercolor="#000000"><br />
                <table width="90%" border="1" align="center" bordercolor="#666666" bgcolor="#CCCCCC">
                    <tr>
                        <td align="left" valign="middle" bgcolor="#999999" class="titulo_menu"><img
                                src="../../../imagenes/GIF/notepad.gif" width="19" height="21" />ConvenioWEB</td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle"><img src="../../../imagenes/GIF/check.gif" width="13"
                                height="12" /><a href="ingconweb_mae.php">Ingreso Convenio WEB</a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle"><img src="../../../imagenes/GIF/check.gif" alt="" width="13"
                                height="12" /><a href="consultacw_mae.php">Consulta de Convenio WEB</a></td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle"><img src="../../../imagenes/GIF/check.gif" alt="" width="13"
                                height="12" /><a href="solreparo_mae.php">Solución de Reparo</a></td>
                    </tr>
                </table>
                <br />
                </div>
            </td>
        </tr>
        <table width="95%" border="0" align="center">
            <tr>
                <td align="right" valign="middle"><a href="../../territorial/tr.php" onMouseOut="MM_swapImgRestore()"
                        onMouseOver="MM_swapImage('Image3','','../../../imagenes/Botones/boton_volver_2.jpg',1)"><img
                            src="../../../imagenes/Botones/boton_volver_1.jpg" alt="Volver" name="Image3" width="80"
                            height="25" border="0"></a></div>
                </td>
            </tr>
    </table>
    </table>
    <br />
    <table width="95%" border="0" align="center">
        <tr>
            <td align="right" valign="middle"><a href="consultacw_mae.php">Consultas WEB</a> // <a
                    href="../../ni/ni.php">Especialista NI</a> // <a href="../../territorial/tr.php">Especialista
                    Territoriales</a> // <a href="../../bmg/bmg.php">Especilaista BMG</a></td>
        </tr>
    </table>
</body>

</html>