<?php include "template.php";
/**  @var $conn */
?>
<title>User Registration</title>
<h1 class='text-primary'>User Registration</h1>

<!-- Front End -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <!--Customer Details-->

            <div class="col-md-6">
                <h2>Account Details</h2>
                <p>Please enter wanted username and password:</p>
                <p>Email Address<input type="text" name="username" class="form-control" required="required"></p>
                <p>Password<input type="password" name="password" class="form-control" required="required"></p>

            </div>
            <div class="col-md-6">
                <h2>More Details</h2>
                <!--Product List-->
                <p>Please enter More Personal Details:</p>
                <p>First Name<input type="text" name="firstName" class="form-control" required="required"></p>
                <p>Second Name<input type="text" name="secondName" class="form-control" required="required"></p>
                <p>Address<input type="text" name="address" class="form-control" required="required"></p>
                <p>Phone Number<input type="text" name="phoneNumber" class="form-control" required="required"></p>
            </div>
        </div>
    </div>
    <input type="submit" name="formSubmit" value="Submit">
</form>


<?php
// Back End
if ($_SERVER["REQUEST_METHOD"] == "POST") {   // Will return true when the user presses the submit button
    $username = sanitiseData($_POST['username']);
    $password = sanitiseData($_POST['password']);
    $firstName = sanitiseData($_POST['firstName']);
    $secondName = sanitiseData($_POST['secondName']);
    $address = sanitiseData($_POST['address']);
    $phoneNumber = sanitiseData($_POST['phoneNumber']);

    // Check if username/email address already exists in the database.
    $query = $conn->query("SELECT COUNT(*) FROM Customers WHERE EmailAddress='$username'");
    $data = $query->fetchArray();
    $numberOfUsers = (int)$data[0];

    if ($numberOfUsers > 0) {  // username already exists.
        echo "Sorry, that username already exists";
    } else {
        // the username entered is unique (doesn't already exist)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sqlStmt = $conn->prepare("INSERT INTO Customers (EmailAddress, HashedPassword, FirstName, SecondName, Address, PhoneNumber) VALUES (:EmailAddress, :HashedPassword, :FirstName, :SecondName, :Address, :PhoneNumber)");
        $sqlStmt->bindParam(':EmailAddress', $username);
        $sqlStmt->bindParam(':HashedPassword', $hashedPassword);
        $sqlStmt->bindParam(':FirstName', $firstName);
        $sqlStmt->bindParam(':SecondName', $secondName);
        $sqlStmt->bindParam(':Address', $address);
        $sqlStmt->bindParam(':PhoneNumber', $phoneNumber);
        $sqlStmt->execute();

    }
}
?>
