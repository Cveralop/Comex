<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

//Conexion base de datos en azure
//include ("BaltimoreCyberTrustRoot.crt.pem");
$hostname_comercioexterior = 'comexdbtest.mysql.database.azure.com';
$database_comercioexterior = 'comercioexterior';
$username_comercioexterior = 'xmsadmin@comexdbtest';
$password_comercioexterior = 'Microsoft01*';

$comercioexterior = mysqli_init();
mysqli_ssl_set($comercioexterior,NULL,NULL, "/home/site/wwwroot/Connections/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);
mysqli_real_connect($comercioexterior, $hostname_comercioexterior, $username_comercioexterior, $password_comercioexterior, $database_comercioexterior, 3306, MYSQLI_CLIENT_SSL);
if (mysqli_connect_errno($comercioexterior)) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}


//Conexion base de datos Local
// $hostname_comercioexterior = 'localhost';
// $database_comercioexterior = "comercioexterior";
// $username_comercioexterior = 'root';
// $password_comercioexterior = '';

//conexion nueva
// $comercioexterior = new mysqli($hostname_comercioexterior, $username_comercioexterior, $password_comercioexterior,
// $database_comercioexterior);

//Check connection
// if ($comercioexterior->connect_error) {
//     die("Connection failed: " . $comercioexterior->connect_error);
//   }
?>
