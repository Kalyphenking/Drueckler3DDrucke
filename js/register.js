

document.addEventListener('DOMContentLoaded', function() {

    var btnRegister = document.getElementById('submitRegister');
    var username = document.getElementById('username');
    var password = document.getElementById('password');
    var firstName = document.getElementById('firstName');
    var lastName = document.getElementById('lastName');
    var emailAddress = document.getElementById('emailAddress');
    var phoneNumber = document.getElementById('phoneNumber');



    var passwordStrengthLabel = document.getElementById('passwordStrength')
    var validUsername = document.getElementById('validUsername')
    var validFirstName = document.getElementById('validFirstName')
    var validLastName = document.getElementById('validLastName')
    var validEmailLabel = document.getElementById('validEmail')

    if(btnRegister) {
        btnRegister.addEventListener('click', function (event){
            var valid = true;
            if(!username || username.value.length < 2 || username.value.length > 50)
            {
                if (validEmailLabel) {
                    validUsername.innerHTML = 'ungültiger Username'
                }
                valid = false;
            }
            if(!firstName || firstName.value.length < 2 || firstName.value.length > 50)
            {
                if (validEmailLabel) {
                    validFirstName.innerHTML = 'ungültiger Vorname'
                }
                valid = false;
            }
            if(!lastName || lastName.value.length < 2 || lastName.value.length > 50)
            {
                if (validEmailLabel) {
                    validLastName.innerHTML = 'ungültiger Nachname'
                }
                valid = false;
            }

            if(!emailAddress || emailAddress.value.length < 2 || emailAddress.value.length > 50)
            {
                if (validEmailLabel) {
                    validEmailLabel.innerHTML = 'ungültige Emailadresse'
                }
                valid = false;
            }

            if(!password || password.value.length < 8)
            {
                if (passwordStrengthLabel) {
                    passwordStrengthLabel.innerHTML = 'Passwort mindestens 8 Zeichen'
                }
                valid = false;
            }


            if(valid === false)
            {
                event.preventDefault(); // disable default event
                event.stopPropagation(); // disable event handling in hir
            }

            return valid;
        })
    }

    if(password)
    {
        password.addEventListener('keyup', function(){

            var regex1 = /^(?=.*?[A-Z].*?)(?=.*?[a-z].*?)(?=.*?[0-9].*?).{6,}$/m;
            var regex2 = /^(?=.*?[A-Z].*?)(?=.*?[a-z].*?[a-z])(?=.*?[0-9].*?[0-9])(?=.*?[^\w\s].*?).{8,}$/m;
            var regex3 = /^(?=.*?[A-Z].*?[A-Z])(?=.*?[a-z].*?[a-z])(?=.*?[0-9].*?[0-9])(?=.*?[^\w\s].*?[^\w\s]).{12,}$/m;
            var str = this.value;

            if(str.match(regex3))
            {
                passwordStrengthLabel.innerHTML = "stark";
            }
            else if(str.match(regex2))
            {
                passwordStrengthLabel.innerHTML = "medium";
            }
            else if(str.match(regex1))
            {
                passwordStrengthLabel.innerHTML = "ausreichend";
            }
            else
            {
                passwordStrengthLabel.innerHTML = "schwach";
            }
        });
    }

})