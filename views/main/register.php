
<div class = "InputBox">
    <form action = 'index.php?c=main&a=register' method = 'POST'>

        <h3>Registrierung</h3>

        <?php
            if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
                $label = 'Weiter';
    //        $_SESSION['guest'] = true;
            } else {
                $label = 'Registrieren';
            }


            if (!isset($_SESSION['guest'])) {

	            $userName = isset($_POST['username']) ? $_POST['username'] : '';
	            $password = isset($_POST['password']) ? $_POST['password'] : '';

	            echo '
            
                    <div class = "InputLine">
                        <input id="username"
                               name="username"
                               type="username"
                               placeholder="Username"
                               required value="'.$userName.'">
                        <br>
        
                        <input id="password"
                               name="password"
                               type="password"
                               placeholder="Password"
                               required value="'.$password.'">
                    </div>
                    
                   ';
            } else {

	            $userName = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';
	            $password = isset($_SESSION['uid']) ? $_SESSION['uid'] : '';

	            echo '
            
                    <div class = "InputLine">
                        <input id="username"
                               name="username"
                               type="username"
                               placeholder="Username"
                               hidden
                               required value="'.$userName.'">
                        <br>
        
                        <input id="password"
                               name="password"
                               type="password"
                               placeholder="Password"
                               hidden
                               required value="'.$password.'">
                    </div>
            
                ';
            }
        ?>

            <br>

            <div class = "InputLine">
                <input id="firstName"
                       name="firstName"
                       type="firstName"
                       placeholder="First name"
                       required value=<?php echo (isset($_POST['firstName']) ? $_POST['firstName'] : ''); //default Values?> >
                <br>
                <input id="lastName"
                       name="lastName"
                       type="lastName"
                       placeholder="Last name"
                       required value=<?php echo (isset($_POST['lastName']) ? $_POST['lastName'] : NULL); //default Values?> >

                <br><br>

                <input id="emailAddress"
                       name="emailAddress"
                       type="email"
                       placeholder="e-Mail"
                       required value=<?php echo (isset($_POST['emailAddress']) ? $_POST['emailAddress'] : NULL); //default Values?> >
                <br>
                <input id="phoneNumber"
                       name="phoneNumber"
                       type="tel"
                       placeholder="Mobile number"
                       value=<?php echo (isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : ''); //default Values?> >
            </div>
        <br>

        <input type = "checkbox" required> AGB <br><br>
        <input name="submit" type="submit" value="<?=$label?>">
    </form>
</div>
