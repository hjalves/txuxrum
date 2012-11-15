/* onload */
checknewmsg();

/* check for new messages */
function checknewmsg() {
    var xmlhttp = new XMLHttpRequest();
    var count;

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            count = xmlhttp.responseText;
            if (count >= 0) {
                msgicon = document.getElementById("msgnewicon");
                msgicon.innerHTML = count;
                msgicon.style.display="inherit";
            }
            else {
                msgicon.style.display = "none";
            }
        }
        setTimeout("checknewmsg()", 2500);
    }
    xmlhttp.open("GET","ajax/getcountnewmsg.php",true);
    xmlhttp.send();
}

