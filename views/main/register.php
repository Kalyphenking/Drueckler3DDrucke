
<div class = "InputBox">
    <form action = 'index.php?c=main&a=register' method = 'POST'>

        <h3>Registrierung</h3>

            <div class = "InputLine">
                <input id="username"
                       name="username"
                       type="username"
                       placeholder="Username"
                       required value=<?php echo (isset($_POST['username']) ? $_POST['username'] : ''); //default Values?> >
                <br>

                <input id="password"
                       name="password"
                       type="password"
                       placeholder="Password"
                       required value=<?php echo (isset($_POST['password']) ? $_POST['password'] : ''); //default Values?> >
            </div>


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

                <br>

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

        <input type = "checkbox" required> AGB

        <input name="submit" type="submit" value="registrieren">
    </form>
</div>
