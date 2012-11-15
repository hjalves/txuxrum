/* global vars */
var ichecknewmsg;

/* onload */
window.onload = (function() {
    /* check for new messages */
    checknewmsg();
    ichecknewmsg = setInterval(checknewmsg, 2500);
});

/* check for new messages */
function checknewmsg() {
    var xmlhttp = new XMLHttpRequest();
    var count;

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            count = xmlhttp.responseText;
            if (count == "0") {
                msgicon.style.display = "none";
            }
            else {
                msgicon = document.getElementById("msgnewicon");
                msgicon.innerHTML = count;
                msgicon.style.display="inline";
            }
        }
    }
    xmlhttp.open("GET","ajax/getcountnewmsg.php",true);
    xmlhttp.send();
}

/* instant search */
function getusersearch(str, datalist) {
    if (str.length==0) {
        document.getElementById(datalist).innerHTML="";
        return;
    }
    xmlhttp=new XMLHttpRequest();

        xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById(datalist).innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","ajax/getusersearch.php?user="+str,true);
    xmlhttp.send();
}
