# Създаване на MySQL база данни
## Създаване на база през PHP
След като видяхме как може да се отвори връзка към MySQL, ще видим как може да използваме същата връзка, за да изпълняваме заявки.

Преди да запазим или осъществим достъп до данните, първо трябва да създадем нова база данни. Заявката "CREATE DATABASE" се използва за създаване на нова база данни в MySQL.

Нека направим SQL заявка с помощта на оператора CREATE DATABASE, след което ще изпълним тази SQL заявка, като я предадем на функцията PHP mysqli_query(), за да създадем най-накрая нашата база данни. Следващият пример създава база данни с име demo.
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt create database query execution
$sql = "CREATE DATABASE demo";
if(mysqli_query($link, $sql)){
    echo "Database created successfully";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>
```

PHP сорс кодът от този пример се намира във файла create-mysql-database.php, за да го изпълните може да навигирате до http://localhost/php-tutorials/create_db/create-mysql-database.php

> **Забележка**: Изложеният подход за създаване на нова база данни не е добра практика в реални проекти, но се вписва добре като част от този туториал