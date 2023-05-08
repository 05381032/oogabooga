<title>PHP Template</title>
<body>
<h1>Heading</h1>


<?php
//$loopControlVariable = 1;
//
//while($loopControlVariable <= 3) {
//  echo "The number is: $loopControlVariable <br>";
//  $loopControlVariable++;
//}
?>


<?php
//$loopControlVariable = 1;
//
//do {
//  echo "The number is: $loopControlVariable <br>";
//  $loopControlVariable++;
//} while ($loopControlVariable <= 10);
?>

<?php
//for ($loopControlVariable = 0; $loopControlVariable <= 100; $loopControlVariable++) {
//  echo "The number is: $loopControlVariable <br>";
//}
?>

<?php
$characters = array("Luke", "Leia", "Rey", "Finn");

foreach ($characters as $name) {
    echo "$name <br>";
}
?>


</body>
</html>