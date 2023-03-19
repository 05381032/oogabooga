
<link<!doctype html>
<?php include "template.php" ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Template</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h1>Contact Us</h1>
<div class="container-fluid">
    <h1 class"text-primary">please send us a message </h1>
    <form action="contact2.php" method="post">
        <div class="mb-3">
            <label for="inputEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="inputMessage" class="form-label">Message</label>
            <textarea type="text" class="form-control" id="inputMessage" name="inputMessage"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formError = false;
    if (empty($_POST['inputEmail'])) {
        $formError = true;
        echo "Enter an email address.";
    }
    if (empty($_POST['inputMessage'])) {
        $formError = true;
        echo "Enter a message to submit.";
    }
    if ($formError == false) {

        $emailAddress = $_POST['inputEmail'];
        $messageSubmitted = $_POST['inputMessage'];
        $csvfile = fopen("contact.csv", "a");
        fwrite($csvfile, $emailAddress . "," . $messageSubmitted);
        fclosee($csvfile);
    }
}
?>
</body>
<script src="js/bootstrap.bundle.min.js" ></script>
</html>