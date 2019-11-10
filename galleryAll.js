var xhr;
var xhr2;
var n = 0;
var flag = 0;

function router(e)
{
    if (e)
        getPic(e);
    getPics();
}

function getPic(e)
{
    var id = e.split("!");
    var link = document.getElementById("download");

    xhr2 = new XMLHttpRequest();
    xhr2.open("GET", "getData.php?img_id=" + id[0] , true);
    xhr2.send();
    xhr2.addEventListener("load", putData);

    document.getElementById('myModal').style.display = "block";
    document.getElementById("img01").src = id[1];
    link.download = e + ".jpg";
    link.href = id[1];
}

function getPics()
{
    xhr = new XMLHttpRequest();
    xhr.open("GET", 'getImagesAll.php?n=' + n, true);
    xhr.send();
    xhr.addEventListener("load", putPics);
}

function putPics() 
{
    if(xhr.responseText)
    {
        var resp = xhr.responseText.replace("\r\n", "");
        var imgs = resp.split("!");

        for(i = 0; i < imgs.length; i += 2)
        {
            if(imgs[i] != "")
                document.getElementById("footer").insertAdjacentHTML('beforebegin', '<img src="' + imgs[i + 1] + '" id="' + imgs[i] + '" onclick="expand1(' + imgs[i] + ', 0)">');
        }
    flag = 1;
    n += 40;
    }
    else
        document.getElementById("footer").insertAdjacentHTML('beforebegin', '<p id="end" style="color: #00ccff; font-family: Impact, sans-serif; font-style: italic; font-size: 70px">End of Gallery</p>');
}

window.addEventListener('scroll', function() 
{
    var con = document.getElementById("container2");/*
    var gmain = document.getElementById("gmain");
    console.log("****************");
    console.log(document.body.scrollTop);
    console.log(window.pageYOffset);
    console.log(gmain.scrollTop);
    console.log(con.scrollTop);
    console.log(gmain.clientHeight);
    console.log(gmain.scrollHeight);
    console.log(con.clientHeight);
    console.log(con.scrollHeight);
    console.log("****************");*/
    if (((window.pageYOffset + con.clientHeight) >= con.scrollHeight) && flag) 
    {
        flag = 0;
        getPics();
    }
});

function putData()
{
    if (xhr2.responseText)
    {
        var resp = xhr2.responseText.replace("\r\n", "");
        var likes = resp.split(";");

        if (likes[0] > 0)
        {
            document.getElementById("s1").style.opacity = "0.5";
            document.getElementById("s1").style.cursor = "default";
            document.getElementById("s1").onclick = "";
            document.getElementById("s4").style.opacity = "0.5";
            document.getElementById("s4").style.cursor = "default";
            document.getElementById("s4").onclick = "";
        }
        if (likes[1] < 1000000)
            document.getElementById("likes").innerHTML = '<p>' + likes[1] + '</p>';
        else
            document.getElementById("likes").innerHTML = '<p>999999</p>';
        if (likes[0] < 1000000)
            document.getElementById("dislikes").innerHTML = '<p>' + likes[2] + '</p>';
        else
            document.getElementById("likes").innerHTML = '<p>999999</p>';

        if (!parseInt(likes[3], 10))
            document.getElementById("commentbox").insertAdjacentHTML('afterbegin', '<p style="line-height: 1;">No Comments Yet.</p>');
        else
        {
            var i = parseInt(likes[3], 10) + 3;
            var j = 4;
            while (j < i)
            {
                if (likes[j])
                {
                    document.getElementById("commentbox").insertAdjacentHTML('afterbegin', '<p align="right" line-height: 0;><i>~ by ' + likes[j + 1] + ' at ' + likes[j + 2] + '&nbsp;&nbsp;&nbsp;&nbsp;' + '<i></p>');
                    document.getElementById("commentbox").insertAdjacentHTML('afterbegin', '<p style="line-height: 1;">"' + likes[j] + '"</p>');
                    document.getElementById("commentbox").insertAdjacentHTML('afterbegin', '<div style="height: 1px;"></div>');
                }
                j += 3;
            }
        }
    }
}

function expand1(e)
{
    var img = document.getElementById(e);
    var link = document.getElementById("download");

    xhr2 = new XMLHttpRequest();
    xhr2.open("GET", "getData.php?img_id=" + e , true);
    xhr2.send();
    xhr2.addEventListener("load", putData);

    document.getElementById('myModal').style.display = "block";
    document.getElementById("img01").src = img.src;
    link.download = e + ".jpg";
    link.href = img.src;
}

function close1() 
{
    document.getElementById('myModal').style.display = "none";
    //document.getElementById("likes").innerHTML = "";
    //document.getElementById("dislikes").innerHTML = "";
    while (document.getElementById("commentbox").hasChildNodes()) 
    {
        document.getElementById("commentbox").removeChild(document.getElementById("commentbox").lastChild);
    }
    document.getElementById("likes").removeChild(document.getElementById("likes").lastChild);
    document.getElementById("dislikes").removeChild(document.getElementById("dislikes").lastChild);
    document.getElementById("s1").style.opacity = "1";
    document.getElementById("s1").style.cursor = "pointer";
    document.getElementById("s1").onclick = "submit(1)";
    document.getElementById("s4").style.opacity = "1";
    document.getElementById("s4").style.cursor = "pointer";
    document.getElementById("s4").onclick = "submit(-1)";
    clear1();
}

function clear1()
{
    /*var ta = document.getElementById('textbox');
    if (!ta.value || ta.value != ta.defaultValue && confirm('Are you sure?')) {
        ta.value = ta.defaultValue;
    }*/
    document.getElementById('textbox').value = "";
}

function submit(e)
{
    var id = document.getElementById("download").download.replace(".jpg", "")
    var comment = "img_id=" + id + "&comment=" + document.getElementById("textbox").value + "&like=" + e;
    xhr = new XMLHttpRequest();
    xhr.open('POST', 'setComments.php', true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(comment);
    xhr.addEventListener("load", function()
    {
        xhr = new XMLHttpRequest();
        xhr.open("GET", "getData.php?img_id=" + id , true);
        xhr.send();
        xhr.addEventListener("load", putData);
    });
    clear1();
}