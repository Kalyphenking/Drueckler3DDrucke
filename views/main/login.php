
<?php
    $guest = false;
    $error = '';

    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        $error = $_SESSION['error'];
    }

    if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder']) && ($_SESSION['makeOrder'] == true)) {
        $guest = true;
    }


?>

<div class="login-container">
    <div class="InputBox">
        <form class="loginForm" action = 'index.php?c=main&a=login' method = 'POST'>
            <label class="errorMessage"><?=$error?></label>
            <h3>Login</h3>
            <div class = "InputLine">
                <input id="username"
                       name="username"
                       type="username"
                       placeholder="Username"
                       required value=<?= (isset($_POST['username']) ? $_POST['username'] : ''); //default Values?> >
            </div>

            <br>

            <div class = "InputLine">
                <input id="password"
                       name="password"
                       type="password"
                       placeholder="Password"
                       required value=<?= (isset($_POST['passowrd']) ? $_POST['passowrd'] : ''); //default Values?> >
            </div>

            <br>

            <div class="input submit">
                <input name="submit"
                       type="submit"
                       value="Login">
            </div>
            <br>
            <div class="login-footer">
                <a href="index.php?c=main&a=register">Konto erstellen</a>


			    <?php if($guest) :?>
                    <a href="index.php?c=main&a=register/guest">Als Gast fortfahren</a>
			    <?php endif;?>
            </div>
        </form>
    </div>
</div>