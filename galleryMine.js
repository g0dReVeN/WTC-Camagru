var xhr;
var n = 0;
var flag = 0;
 
function getPics()
{
    xhr = new XMLHttpRequest();
    xhr.open("GET", 'getImagesMine.php?n=' + n, true);
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
                document.getElementById("footer").insertAdjacentHTML('beforebegin', '<img src="' + imgs[i + 1] + '" id="' + imgs[i] + '" onclick="expand1(' + imgs[i] + ')">');
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
    console.log("****************");
    console.log(document.body.scrollTop);
    console.log(window.pageYOffset);
    console.log(listElm.scrollTop);
    console.log(listElm2.scrollTop);
    console.log(listElm.clientHeight);
    console.log(listElm.scrollHeight);
    console.log(listElm2.clientHeight);
    console.log(listElm2.scrollHeight);
    console.log("****************");*/
    if (((window.pageYOffset + con.clientHeight) >= con.scrollHeight) && flag) 
    {
        flag = 0;
        getPics();
    }
});

function putData()
{
    if (xhr.responseText)
    {
        var resp = xhr.responseText.replace("\r\n", "");
        var likes = resp.split(";");

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

    xhr = new XMLHttpRequest();
    xhr.open("GET", "getData.php?img_id=" + e , true);
    xhr.send();
    xhr.addEventListener("load", putData);

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
}

function delete1()
{
    window.location.href = "imageDelete.php?img_id=" + document.getElementById("download").download.replace(".jpg", "");
}