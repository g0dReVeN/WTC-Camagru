var xhr;

function getData(n)
{
    /*document.getElementById("warn3").innerHTML = "";
    document.getElementById("warn1").innerHTML = "";
    document.getElementById("warn2").innerHTML = "";*/
    xhr = new XMLHttpRequest;
    xhr.open("GET", "getProfileData.php?username=" + n, true)
    xhr.send();
    xhr.addEventListener("load", function()
    {
        if (xhr.responseText)
        {
            var resp = (xhr.responseText.replace("\r\n", "")).split(";");
            document.getElementById("username").value = resp[0];
            document.getElementById("email").value = resp[1];
            if (resp[2] == 1)
                document.getElementById("yes").checked = true;
            else
                document.getElementById("no").checked = true;
            if (resp[3])
                document.getElementById("pic").src = "data:image/png;base64," + resp[3];
            else
                document.getElementById("pic").src = "img/profile_image.png";
        }
    });
}
/*
document.getElementById("table").addEventListener("submit", function(e) {
    alert("sad");
    e.preventDefault();
    //update();
});*/

function update()
{
    document.getElementById("warn3").innerHTML = "";
    document.getElementById("warn1").innerHTML = "";
    document.getElementById("warn2").innerHTML = "";
    if (document.getElementById("warn4").innerHTML == "")
    {
        if (document.getElementById("pic").src != "img/profile_image.png")
            document.getElementById("propic").value = document.getElementById("pic").src;
        var fd = new FormData(document.forms["table"]);
        xhr = new XMLHttpRequest;
        xhr.open('POST', 'setProfileData.php', true);
        xhr.send(fd);
        xhr.onload = function()
        {
            if (xhr.responseText)
            {
                var resp = (xhr.responseText.replace("\r\n", "")).split(";");
                if (resp[0] == 0 && resp[1] == 0 && resp[2] == 0)
                {
                    getData(resp[3]);
                    document.getElementById("uname").innerHTML = resp[3];
                    document.getElementById("p0").value = "";
                    document.getElementById("p1").value = "";
                    document.getElementById("p2").value = "";
                    alert("Account Details Successfully Changed!");
                }
                if (resp[0] == 1)
                    document.getElementById("warn3").innerHTML = "Incorrect Password!";
                if (resp[1] == 1)
                    document.getElementById("warn1").innerHTML = "Username already on record!";
                if (resp[2] == 1)
                    document.getElementById("warn2").innerHTML = "Email Address already on record!";
            }
        }
    }
}

function passMatch() 
{
    var p0 = document.getElementById("p0").value;
    var p1 = document.getElementById("p1").value;
    var p2 = document.getElementById("p2").value;
    
    if (p1 != p2 && p2 != "")
        document.getElementById("warn4").innerHTML = "Passwords do not match!";
    else
        document.getElementById("warn4").innerHTML = "";

    if (p0 != "" && p0.length < 6)
        document.getElementById("warn3").innerHTML = "Password too short!";
    else
        document.getElementById("warn3").innerHTML = "";
}

function filer()
{
    document.getElementById("fileElem").click();
}

function previewFile() 
{
    var file = document.querySelector('input[type=file]').files[0];
    var reader = new FileReader();
    var temp;

    reader.addEventListener("load", function() 
    {
        document.getElementById("pic").src = reader.result;
    }, false);

    if (file) 
    {
        reader.readAsDataURL(file);
    }
}