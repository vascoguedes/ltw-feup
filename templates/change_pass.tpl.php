<?php function drawChangePass() { ?>

    <section id="recoverpass">
        <h1>THE MENU</h1>
        <form action='../actions/reset_password.php' method="get">
            <input name='password' type='password' placeholder='New password' />
            <input hidden name='token' value = <?php echo $_GET['token']; ?> />
            <error></error>
            <button type="submit">Reset password</button>
        </form>
    </section>
<?php } ?>