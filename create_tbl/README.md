# Създаване на таблица в MySQL база данни
## Създаване на таблица през PHP
В предишната секция научихме как да създадем база данни в MySQL сървър. Сега е време да създадете някои таблици в базата данни, които всъщност ще съдържат данните. Таблиците организират информацията в редове и колони.

Заявката "CREATE TABLE" се използва за създаване на таблица в база данни.

Нека направим SQL заявка, използвайки оператора CREATE TABLE, след което ще изпълним тази SQL заявка, като я предадем на функцията PHP mysqli_query(), за да създадем най-накрая нашата таблица.
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt create table query execution
$sql = "CREATE TABLE persons(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL UNIQUE
)";
if(mysqli_query($link, $sql)){
    echo "Table created successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>
```

> **Забележка**: Изложеният подход за създаване на таблици в базата данни не е добра практика в реални проекти, но се вписва добре като част от този туториал