document.addEventListener('DOMContentLoaded', function() {


    var btnChangeAddress = document.getElementById('submitAddress');
    var street = document.getElementById('street');
    var number = document.getElementById('number');
    var postalCode = document.getElementById('postalCode');
    var city = document.getElementById('city');
    var country = document.getElementById('country');
    var addressId = document.getElementById('addressId');
    var customerId = document.getElementById('customerId');

    btnChangeAddress.addEventListener('click', function (event){
        // alert('called')
        event.preventDefault(); // disable default event
        event.stopPropagation(); // disable event handling in hir

        var xhttp = new XMLHttpRequest();

        // xhttp.setRequestHeader('X-Requested-Width', 'XMLHttpRequest')
        // xhttp.setRequestHeader("Content-type", "application/json");
        // xhttp.setRequestHeader("Accept", "application/json");

        let formData = new FormData();

        // alert(addressId.textContent)

        if (street) {
            formData.append("street", street.value);
        }
        if (number) {
            formData.append("number", number.value);
        }
        if (postalCode) {
            formData.append("postalCode", postalCode.value);
        }
        if (city) {
            formData.append("city", city.value);
        }
        if (country) {
            formData.append("country", country.value);
        }
        if (addressId) {
            formData.append("aid", addressId.textContent);
        }
        if (customerId) {
            formData.append("cid", customerId.textContent);
        }

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // document.getElementById("demo").innerHTML = this.responseText;
                // alert('Success')
            }
        };
        xhttp.open('POST', 'services/changeAddress.php', true);
        xhttp.send(formData);
    })




})