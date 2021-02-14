//checks if JavaScript is enabled and hides phpBased content and displays jsBased content
function javaScriptEnabled() {
    var phpBasedContent = document.getElementsByClassName("phpBased")

    if (phpBasedContent) {
        for (i = 0; i < phpBasedContent.length; i++) {
            phpBasedContent[i].style.display = "none"
            // phpBasedContent[i].style.visibility = "hidden"
        }
    }

    var javaScriptBasedContent = document.getElementsByClassName("javaScriptBased")

    if (javaScriptBasedContent) {

        for (i = 0; i < javaScriptBasedContent.length; i++) {
            javaScriptBasedContent[i].style.display = "block"
        }

    }
}




