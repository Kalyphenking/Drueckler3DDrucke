document.addEventListener('DOMContentLoaded', function() {


    var btnChangeContactData = document.getElementById('submitContactData');
    var firstName = document.getElementById('firstName');
    var lastName = document.getElementById('lastName');
    var phoneNumber = document.getElementById('phoneNumber');
    var emailAddress = document.getElementById('emailAddress');
    var contactDataId = document.getElementById('contactDataId');

    if (btnChangeContactData) {
        btnChangeContactData.addEventListener('click', function (event){
            // alert('called')
            event.preventDefault(); // disable default event
            event.stopPropagation(); // disable event handling in hir

            var xhttp = new XMLHttpRequest();
            let formData = new FormData();

            if (firstName) {
                formData.append("firstName", firstName.value);
            }
            if (lastName) {
                formData.append("lastName", lastName.value);
            }
            if (phoneNumber) {
                formData.append("phoneNumber", phoneNumber.value);
            }
            if (emailAddress) {
                formData.append("emailAddress", emailAddress.value);
            }
            if (contactDataId) {
                formData.append("cdid", contactDataId.textContent);
            }

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // document.getElementById("demo").innerHTML = this.responseText;
                    // alert('Success')
                }
            };
            xhttp.open('POST', 'services/changeContactData.php', true);
            xhttp.send(formData);
        })
    }






})