<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

//Conexion base de datos en azure
$hostname_historico_goc = 'comexdbtest.mysql.database.azure.com';
$database_historico_goc = 'comex_historico'; 
$username_historico_goc = 'xmsadmin@comexdbtest';
$password_historico_goc = 'Microsoft01*';


$historico_goc = mysqli_init();
mysqli_ssl_set($historico_goc,NULL,NULL, "/home/site/wwwroot/Connections/BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);
mysqli_real_connect($historico_goc, $hostname_historico_goc, $username_historico_goc, $password_historico_goc, $database_historico_goc, 3306, MYSQLI_CLIENT_SSL);
if (mysqli_connect_errno($historico_goc)) {
die('Failed to connect to MySQL: '.mysqli_connect_error());
}

//Conexion base de datos Local
// $hostname_historico_goc = 'localhost';
// $database_historico_goc = "historico_goc";
// $username_historico_goc = 'root';
// $password_historico_goc = '';

//conexion nueva
// $historico_goc = new mysqli($hostname_historico_goc, $username_historico_goc, $password_historico_goc,
// $database_historico_goc);

//Check connection
// if ($historico_goc->connect_error) {
//     die("Connection failed: " . $historico_goc->connect_error);
//   }
?>
