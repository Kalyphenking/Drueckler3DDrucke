




function javaScriptEnabled() {
    var phpBasedContent = document.getElementsByClassName("phpBased")

    if (phpBasedContent) {
        for (i = 0; i < phpBasedContent.length; i++) {
            phpBasedContent[i].style.display = "none"
        }
    }

    var javaScriptBasedContent = document.getElementsByClassName("javaScriptBased")

    if (javaScriptBasedContent) {

        for (i = 0; i < javaScriptBasedContent.length; i++) {
            javaScriptBasedContent[i].style.display = "block"
        }

    }
}


// document.addEventListener('DOMContentLoaded', function() {
//     javaScriptEnabled()
// }, false);