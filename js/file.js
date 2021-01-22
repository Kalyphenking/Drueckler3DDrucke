function upload(postUrl, fieldName, file, filePath)
{
    var formData = new FormData();
    var file = new File(file, filePath)
    formData.append(fieldName, file);

    var req = new XMLHttpRequest();
    req.open("POST", postUrl);
    req.onload = function (event) {
        alert(event.target.responseText);
    };
    req.send(formData);
    alert(req.readyState)
}

function test() {
    // alert('test')
}