# Връзка с MySQL през PHP
Тук ще видим как може да се осъществи връзка към MySQL през PHP.

## Различни начини за връзка с MySQL
За съхрaнение или осъществяване на достъп до данните в MySQL базата от данни, първо трябва да се свържете със сървъра на MySQL. PHP предлага два начина за свързване към MySQL сървър: разширения MySQLi (Подобрен MySQL) и PDO (PHP Data Objects).

Докато разширението PDO е по-универсално и поддържа повече от дванадесет различни бази данни, разширението MySQLi, поддържа само MySQL база данни. Разширението MySQLi е по-лесно за използване и затова ще се спрем основно на него. И двата метода имат обектно-ориентирана и процедурна разновидности, тъй като няма да изучаваме обектно-ориентирано php, ще се спрем на процедурния вариант. 

## Връзка с MySQL
В PHP можете лесно да направите това с помощта на функцията mysqli_connect(). Цялата комуникация между PHP и MySQL сървъра на бази данни се осъществява чрез тази връзка.
```
$link = mysqli_connect("hostname", "username", "password", "database");
```
Така върната "връзка" е запазена под формата на променливата $link, тази променлива ще служи за по-нататъшната работа с базата. Параметърът "hostname" в горния синтаксис указва името на хоста (напр. localhost) или IP адреса на MySQL сървъра, докато параметрите "username" и "password" указват идентификационните данни за достъп до MySQL сървъра, а параметърът на базата данни(ако е предоставено), ще посочи името на база данни в MySQL, която ще бъде достъпвана.

Пример:
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Print host information
echo "Connect Successfully. Host info: " . mysqli_get_host_info($link);
?>
```

**Забележка**: _Потребителското име по подразбиране за MySQL сървъра е root и няма парола. Въпреки това, за да предотвратите неоторизиран достъп е препоръчително да зададете парола на MySQL акаунтите._

## Затваряне на връзката с базата
Връзката към MySQL сървъра на база данни ще бъде затворена автоматично веднага щом изпълнението на скрипта приключи. Въпреки това, ако искате да го затворите по-рано, можете да направите това, като просто извикате функцията PHP mysqli_close().

Пример:
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Print host information
echo "Connect Successfully. Host info: " . mysqli_get_host_info($link);
 
// Close connection
mysqli_close($link);
?>
```
PHP сорс кодът от този пример се намира във файла connect-to-mysql-database-server.php, за да го изпълните може да навигирате до http://localhost/php-tutorials/connection/connect-to-mysql-database-server.php
