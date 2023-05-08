<?php include "template.php" ?>
<title>PHP Template</title>
<body>
<h1>Heading</h1>

<!--Arrays -->
<div class="container-fluid">
    <?php
    $starWarsMovies = array("A New Hope", "Empire Strikes Back", "Return Of the Jedi");
    echo "I like " . $starWarsMovies[0] . ", " . $starWarsMovies[1] . " and " . $starWarsMovies[2] . ".<br>";
    echo count($starWarsMovies);
    ?>
</div>
<br>

<!--Associative Arrays-->
<div class="container-fluid">
    <?php
    $subjectRooms = array("Website Development"=>"6118", "English"=>"3017", "Maths"=>"1120", "PE"=>"Gym", "Drama"=>"Theatre");
    echo "Room Numbers: <br>";
    echo "English: ".$subjectRooms["English"]."<br>";
    echo "Maths: ".$subjectRooms["Maths"]."<br>";
    echo "Website Development: ".$subjectRooms["Website Development"]."<br>";
    echo "Drama: ".$subjectRooms["Drama"]."<br>";
    echo "PE: ".$subjectRooms["PE"]."<br>";

    foreach ($subjectRooms as $subject => $roomNumber){
        echo "Subject - ".$subject.' - is in room '.$roomNumber."<br>";
    }
    ?>
</div>

<?php echo footer() ?>
</body>
<script src="js/bootstrap.bundle.min.js"></script>
</html>