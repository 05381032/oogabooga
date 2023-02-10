<!doctype html>
<?php include "template.php" ?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Us</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h1>Contact Us</h1>
<div class="container-fluid">
    <h1 class="text-primary">Please Send us a Message</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="mb-3">
            <label for="contactEmail" class="form-label">Email address</label>
            <input type="email" class="form-control" id="contactEmail" name="contactEmail"
                   placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="contactMessage" class="form-label">Message</label>
            <textarea class="form-control" id="contactMessage" name="contactMessage" rows="3"></textarea>
        </div>
        <button type="submit" name="formSubmit" class="btn btn-primary">Submit</button>
    </form>
</div>

<?php
if (isset($_POST['fromsubmit'])) {
    $userEmail = sanitiseData($_POST['contactEmail']);
    $userMessage = sanitiseData($_POST['contactEmail']);

    echo $userEmail;
    echo"<p>";
    echo $userMessage;
}

?>

<?php echo footer () ?>
</body>
<script src="js/bootstrap.bundle.min.js" ></script>
</html>