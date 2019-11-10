function passMatch() {
    var p1 = document.getElementById("p1").value;
    var p2 = document.getElementById("p2").value;
    
    if (p1 != p2)
    {
        document.getElementById("warning").style.color = "red";
        document.getElementById("warning").innerHTML = "Passwords do not match";
    }
    else
    {
        document.getElementById("warning").innerHTML = "";
        document.getElementById("d_button").disabled = false;
    }
}