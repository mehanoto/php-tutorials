# MySQL SELECT Query
## Извличане на данни от SQL таблици
Време да извлечем данните, които вмъкнахме в предходния урок. Операторът SQL SELECT се използва за избиране на записите от таблиците в базата данни. Неговият основен синтаксис е както следва
```
SELECT column1_name, column2_name, columnN_name FROM table_name;
```
Нека направим SQL заявка с помощта на израза SELECT, след което ще изпълним тази SQL заявка, като я предадем на функцията PHP mysqli_query(), за да извлечем данните от таблицата.

PHP кодът в следващия пример избира всички данни, съхранени в таблицата с хора (използването на знака звездичка (*) на мястото на името на колоната избира всички колони в таблицата).
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Attempt select query execution
$sql = "SELECT * FROM persons";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table>";
            echo "<tr>";
                echo "<th>id</th>";
                echo "<th>first_name</th>";
                echo "<th>last_name</th>";
                echo "<th>email</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>
```
## Обяснение на кода
В примера по-горе данните, върнати от функцията mysqli_query(), се съхраняват в променливата $result. Всеки път, когато се извика mysqli_fetch_array(), тя връща следващия ред от набора с резултати като масив. Цикълът while се използва за преминаване през всички редове в резултатите. И накрая, стойността на отделното поле може да бъде достъпна от реда или чрез предаване на индекса на полето или името на полето към променливата $row като $row['id'] или $row[0], $row['first_name'] или $row[1], $row['last_name'] или $row[2] и $row['email'] или $row[3]. За повече информация относно функцията mysqli_fetch_array, кликнете [тук](https://www.php.net/manual/en/mysqli-result.fetch-array.php).

> **Забележка**: Винаги когато искате да разберете как работи дадена функция е достатъчно да я напишете в гугъл примерно "mysqli_fetch_array documentation" и първият линк най-вероятно ще бъде официалната документация в www.php.net. Може да потърсите директно и в php.net

Ако искате да използвате цикъла for, можете да получите стойността на брояча на цикъла или броя на редовете, върнати от заявката, като подадете променливата $result към функцията mysqli_num_rows(). Тази стойност на брояча на цикъла определя колко пъти трябва да се изпълнява цикълът.