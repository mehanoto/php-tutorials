# Изготвени заявки. Prepared statements
## Какво представляват. Prepared statements
Подготвената заявка (още позната като заявка с параметри) е шаблон на SQL заявка. Параметрите на заявката се означават с '?', като при изпълнение на заявката се задават фактическите им стойности.
```
INSERT INTO persons (first_name, last_name, email) VALUES (?, ?, ?);
```
Изготвените заявки съдържат два етапа на изпъление: 
- **Подготовка** Подготовката се изразява в изпращане на шаблона на заявката към MySQL сървъра, където се проверява дали синтаксисът е коректен и се извършва анализ на заявката, след което се запазва за престоящо изпълнение/изпълнения.
- **Изпъление** При изпълението реалните параметри се изпращат към MySQL, оттук MySQL конструира пълната заявка замествайки вече реалните стойности на параметрите и я изпълнява.

Подготвените заявки са много полезни, особено в ситуациите, когато изпълнявате определена заявка многократно с различни стойности на параметрите, например поредица от оператори INSERT. Следващият раздел описва някои от основните предимства от използването му.
## Предимства при използване на изготвени заявки.
Изготвените заявки могат да се изпълняват многократно, тъй като заявката се анализира само още веднъж в началото при подготовката(виж горе). По този начин всяко следващо изпълнение изпраща единствено параметрите, а не цялата заявка което пести време.

Изготвените заявки също осигуряват защита срещу [SQL Injection](https://www.w3schools.com/sql/sql_injection.asp), тъй като стойностите на параметрите не са вградени директно в низа на SQL заявката. Стойностите на параметрите се изпращат до сървъра на базата данни отделно от заявката, като се използва различен протокол. По този начин е гарантирано, че ще изпълняваме една и съща заявка, но с различни параметри, докато при директно изпълнение да заявка, тя може да бъде качествено изменена, което представлява потенциален риск от [SQL Injection](https://www.w3schools.com/sql/sql_injection.asp).
Примерът по-долу онагледява работата на изготвените заявки(prepared statements).
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Prepare an insert statement
$sql = "INSERT INTO persons (first_name, last_name, email) VALUES (?, ?, ?)";
 
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sss", $first_name, $last_name, $email);
    
    /* Set the parameters values and execute
    the statement again to insert another row */
    $first_name = "Hermione";
    $last_name = "Granger";
    $email = "hermionegranger@mail.com";
    mysqli_stmt_execute($stmt);
    
    /* Set the parameters values and execute
    the statement to insert a row */
    $first_name = "Ron";
    $last_name = "Weasley";
    $email = "ronweasley@mail.com";
    mysqli_stmt_execute($stmt);
    
    echo "Records inserted successfully.";
} else{
    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
}
 
// Close statement
mysqli_stmt_close($stmt);
 
// Close connection
mysqli_close($link);
?>
```
Както можете да видите в примера по-горе, подготвихме заявката INSERT само веднъж, но я изпълнихме 2 пъти с различен набор от параметри. Може да изпълните горния код тук http://localhost/php-tutorials/prepared/prepared-statement.php
## Обяснение на кода
В prepared statement SQL INSERT от примера по-горе, въпросителните знаци се използват като параметри за стойностите на полетата first_name, last_name, email. Функцията mysqli_prepare() извършва подготвителния етап и като резултат, самата изготвена заявка се съхранява в променливата $stmt, която ще бъде необходима при евентуалното предстоящо изпъление.


Функцията mysqli_stmt_bind_param() свързва променливи с параметри (?). Параметрите (?) ще бъдат заменени от действителните стойности, съхранявани в променливите по време на изпълнение. Низът за дефиниране на типа, предоставен като втори аргумент, т.е. низът "sss" указва, че типът данни на всяка свързваща променлива е от низов тип.

Низът за дефиниране на типа указва типовете данни на съответните променливи за свързване и съдържа един или повече от следните четири знака:

- b — двоичен (като изображение, PDF файл и др.)
- d — двойно (число с плаваща запетая)
- i — цяло число (цяло число)
- s — низ (текст)
Броят на обвързващите променливи и броят на знаците в низа за дефиниране на тип трябва да съответства на броя на контейнерите в шаблона на SQL оператор.
## Ипзползване на полета от web форма
Ако си спомняте от [предишната секция](../insert/README.md), създадохме HTML формуляр за вмъкване на данни в база данни. Тук ще разширим този пример чрез прилагане на изготвена заявка. 

Ето актуализирания PHP код за вмъкване на данните. Ако разгледате примера внимателно, ще откриете, че не сме използвали mysqli_real_escape_string() за екраниране на въведените от потребителя данни, както направихме в примера в предишната глава. Тъй като в подготвените изрази въведените от потребителя данни никога не се заместват директно в низа на заявката, така че не е необходимо да бъдат екранирани.
```
<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "demo");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Prepare an insert statement
$sql = "INSERT INTO persons (first_name, last_name, email) VALUES (?, ?, ?)";
 
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sss", $first_name, $last_name, $email);
    
    // Set parameters
    $first_name = $_REQUEST['first_name'];
    $last_name = $_REQUEST['last_name'];
    $email = $_REQUEST['email'];
    
    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        echo "Records inserted successfully.";
    } else{
        echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
    }
} else{
    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
}
 
// Close statement
mysqli_stmt_close($stmt);
 
// Close connection
mysqli_close($link);
?>
```

> **Забележка**: Въпреки че при подготвените заявки не се налага екраниране(escaping), винаги трябва да проверявате типа на данните, получени от външни източници, и да налагате подходящи ограничения в защита срещу злоупотреби. Или иначе казано е препоръчително да се прави валидация на полетата преди да ги добавим в базата.