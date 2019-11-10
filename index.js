var constraints = { audio: false, video: { width: 1280, height: 720 } };
navigator.mediaDevices.getUserMedia(constraints)
.then(function(mediaStream)
{
    var video = document.querySelector('video');
    video.srcObject = mediaStream;
    video.onloadedmetadata = function() 
    {
        video.play();
    };
})

function camera()
{
    var canvas = document.getElementById("canvas");
    var context = canvas.getContext("2d");
    setInterval(() =>
    {
        context.drawImage(video, 0, 0, 1000, 600);
    }, 16);
}

function updatesnaps()
{
    xhr = new XMLHttpRequest();
    xhr.open("GET", "getThumbnails.php", false);
    xhr.send();
    if (xhr.responseText)
        document.getElementById("sidebar").insertAdjacentHTML('afterend', '<img id="thumbnail" class="thumb" src="'+xhr.responseText+'">');
    
}
    
function capture()
{
    if (document.getElementById("images/filters/blank.png") || document.getElementById("images/filters/deer.png") || document.getElementById("images/filters/king.png") || document.getElementById("images/filters/santa.png") || document.getElementById("images/filters/frame.png"))
    {
        var picData = "";
        var stickerData = "";
        var i = 0;
        var j = 0;
        if (!document.getElementById("upload1"))
        {
            picData = document.getElementById("canvas").toDataURL();
        }
        else
        {
            picData = document.getElementById("upload2").src;
            j++;
        }
        while (document.getElementById("camview").getElementsByTagName('div')[i + j].getElementsByTagName('img')[0])
        {
            stickerData = stickerData + "sticker" + i + "=" + document.getElementById("camview").getElementsByTagName('div')[i + j].getElementsByTagName('img')[0].id + "&";
            i++;
        }
        var fData = stickerData + "pic=" + picData + "&" + "s_no=" + i;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'imageCreate.php', true);
        //Send the proper header information along with the request
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(fData);
        xhr.addEventListener("load", updatesnaps);
    }
    else
    {
        if (!document.getElementById("warning"))
            document.getElementById("btngrp").insertAdjacentHTML('afterend', '<p id="warning">Please select one or more overlays first!</p>');
    }
}

function sticker(e)
{
    if (document.getElementById("warning"))
        document.getElementById("warning").parentNode.removeChild(document.getElementById("warning"));
    if (!document.getElementById(e))
    {
        if (document.getElementById("upload1"))
        {
            document.getElementById("upload1").insertAdjacentHTML('afterend', '<div id="' + e + '" class="overlay"><img id="' + e + '" style="width:1000px; height:600px;" class="sticker" src="' + e + '"></div>');
        }
        else
        {
            var temp = document.getElementById("camview").innerHTML;
            temp = '<div id="' + e + '" class="overlay"><img id="' + e + '" style="width:1000px; height:600px;" class="sticker" src="' + e + '""></div>' + temp;
            document.getElementById("camview").innerHTML = temp;
        }
    }
    else
        delete_sticker(e);
    camera();
}

function delete_sticker(e)
{
    document.getElementById(e).parentNode.removeChild(document.getElementById(e));
}

function clear1()
{
    if (document.getElementById("upload1"))
        document.getElementById("upload1").parentNode.removeChild(document.getElementById("upload1"));
    if (document.getElementById("images/filters/blank.png"))
        document.getElementById("images/filters/blank.png").parentNode.removeChild(document.getElementById("images/filters/blank.png"));
    if (document.getElementById("images/filters/deer.png"))
        document.getElementById("images/filters/deer.png").parentNode.removeChild(document.getElementById("images/filters/deer.png"));
    if (document.getElementById("images/filters/king.png"))
        document.getElementById("images/filters/king.png").parentNode.removeChild(document.getElementById("images/filters/king.png"));
    if (document.getElementById("images/filters/santa.png"))
        document.getElementById("images/filters/santa.png").parentNode.removeChild(document.getElementById("images/filters/santa.png"));
    if (document.getElementById("images/filters/frame.png"))
        document.getElementById("images/filters/frame.png").parentNode.removeChild(document.getElementById("images/filters/frame.png"));
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
        if (document.getElementById("upload1"))
        {
            document.getElementById("upload1").parentNode.removeChild(document.getElementById("upload1"));
            temp = document.getElementById("camview");
            temp.insertAdjacentHTML('afterbegin', '<div id="upload1" class="overlay"><img id="upload2" style="width:1000px; height:600px;" class="sticker" src="' + reader.result + '""></div>');
        }
        else
        {
            temp = document.getElementById("camview");
            temp.insertAdjacentHTML('afterbegin', '<div id="upload1" class="overlay"><img id="upload2" style="width:1000px; height:600px;" class="sticker" src="' + reader.result + '"></div>');
        }
    }, false);

    if (file) 
    {
        reader.readAsDataURL(file);
    }
}