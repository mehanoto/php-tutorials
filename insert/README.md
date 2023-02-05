# Вмъкване на записи в MySQL
Операторът INSERT INTO се използва за вмъкване на нови редове в MySQL базата.

Нека направим SQL заявка, използвайки оператора INSERT INTO с подходящи стойности, след което ще изпълним тази заявка за вмъкване, като я предадем на функцията PHP mysqli_query(), за да вмъкнем данни в таблицата. Ето един пример, който вмъква нов ред в таблицата с хора, като посочва стойности за полетата *first_name*, *last_name* и _email_.
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt insert query execution
$sql = "INSERT INTO persons (first_name, last_name, email) VALUES ('Peter', 'Parker', 'peterparker@mail.com')";
if(mysqli_query($link, $sql)){
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>
```
PHP сорс кодът от този пример се намира във файла insert-records-into-mysql-database-table.php, за да го изпълните може да навигирате до http://localhost/php-tutorials/insert/insert-records-into-mysql-database-table.php 


Ако си спомняте от [предходната глава.](../create_tbl/README.md), полето id беше маркирано с флага AUTO_INCREMENT. Този модификатор казва на MySQL автоматично да присвои стойност на това поле, ако е оставено неуточнено, като увеличи предишната стойност с 1.

## Добавяне на повече от един редове наведнъж
Можете също да вмъкнете няколко реда в таблица с една заявка за вмъкване наведнъж. За да направите това, следвайте синтаксиса даден в примера по-долу в израза INSERT INTO, където стойностите на колоните за всеки ред трябва да бъдат оградени в скоби и разделени със запетая. 
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt insert query execution
$sql = "INSERT INTO persons (first_name, last_name, email) VALUES
            ('John', 'Rambo', 'johnrambo@mail.com'),
            ('Clark', 'Kent', 'clarkkent@mail.com'),
            ('John', 'Carter', 'johncarter@mail.com'),
            ('Harry', 'Potter', 'harrypotter@mail.com')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>
```
PHP сорс кодът от този пример се намира във файла insert-multiple-rows-into-table-in-mysql.php, за да го изпълните може да навигирате до http://localhost/php-tutorials/insert/insert-multiple-rows-into-table-in-mysql.php.

Сега отидете на phpMyAdmin (http://localhost/phpmyadmin/) и проверете данните от таблицата с лица в базата demo. Ще откриете, че стойността за колоната id се присвоява автоматично чрез увеличаване на стойността на предишния id с 1.

## Добавяне на записи от HTML Form
В предишния раздел видяхме как може да се вмъкват данни от PHP скрипт. Сега ще видим как можем да вмъкнем данни, получени от HTML формуляр. Нека създадем HTML формуляр, който може да се използва за вмъкване на нови записи в таблицата с хора.

### **Стъпка 1.** Създаване на формата.
По-долу е дадена проста HTML форма, която има 3 текстови <input> полета и submit бутон
```
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Record Form</title>
</head>
<body>
<form action="insert.php" method="post">
    <p>
        <label for="firstName">First Name:</label>
        <input type="text" name="first_name" id="firstName">
    </p>
    <p>
        <label for="lastName">Last Name:</label>
        <input type="text" name="last_name" id="lastName">
    </p>
    <p>
        <label for="emailAddress">Email Address:</label>
        <input type="text" name="email" id="emailAddress">
    </p>
    <input type="submit" value="Submit">
</form>
</body>
</html>
```
### **Стъпка 2.** Предаване на данните и вмъкване в базата.
Когато потребител щракне върху бутона за изпращане на HTML формуляра за добавяне на запис, в примера по-горе, данните от формуляра се изпращат до файла „insert.php“. Скриптът 'insert.php' се свързва MySQL, извлича полета от HTTP заявката, използвайки $_REQUEST променливите и накрая изпълнява заявката за вмъкване, за да добави записите. Ето пълния код на нашия файл 'insert.php':
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$first_name = mysqli_real_escape_string($link, $_REQUEST['first_name']);
$last_name = mysqli_real_escape_string($link, $_REQUEST['last_name']);
$email = mysqli_real_escape_string($link, $_REQUEST['email']);
 
// Attempt insert query execution
$sql = "INSERT INTO persons (first_name, last_name, email) VALUES ('$first_name', '$last_name', '$email')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>
```
За да изпълните този пример може да навигирате тук http://localhost/php-tutorials/insert/add-record-form.php
В следващата секция ще разширим този пример за заявка за вмъкване и ще го направим една стъпка напред, като внедрим [изготвена заявка(prepared statement)](../prepared/README.md) за по-добра сигурност и производителност.
> **Забележка**: Функцията mysqli_real_escape_string() екранира специални знаци в низ и създава легален SQL низ, за ​​да осигури защита срещу SQL инжектиране.
