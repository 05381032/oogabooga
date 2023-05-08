<?php include "template.php" ?>
<?php include 'login.php'; ?>
<title>PHP Template</title>
<body>
<h1>Star Wars Shopfront</h1>
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <p>username: ryan.cather@ed.act.edu.au</p>
            <p>Password: password</p>
            <p>username: admin@admin.com</p>
            <p>Password: admin</p>
        </div>
        <div class="col-6">
            <?php if (!isset($_SESSION["EmailAddress"])) : ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required="required"/>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required="required"/>
                    </div>

                    <div class="text-center">
                        <button name="login" class="btn btn-primary">Login</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>


<?php echo footer(); ?>
</body>
<script src="js/bootstrap.bundle.min.js"></script>
</html>


<!--
 <div class="col-md-6">

        </div>
        <div class="col-md-6">
            <?php if (!isset($_SESSION["FirstName"])) : ?>

            <?php endif; ?>

-->