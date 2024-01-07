<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #photo{
            max-width: 100vw;
            width: auto;
            max-height: 100vh;
            height: auto;


            margin: 0 auto;
             display: block;
        }
        
        body{
            background-color: black;
        }
    </style>
</head>
<body>
    
    <img src="" alt="" id="photo">

<script>
    var xhttp = new XMLHttpRequest();
    var activeslides = [];
    var slidetimer = {{ config('app.slide_delay', 30000) }};
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       // Typical action to be performed when the document is ready:
        slides = xhttp.responseText;
        slides = JSON.parse(slides)
        if (slides.data.messages.length > 0){
            for (i=0; i < slides.data.messages.length; i++){
                activeslides[activeslides.length] =  slides.data.messages[i].assetpath;
            }
        }


        currslide = 0;
        document.getElementById("photo").src=slides.data.messages[currslide].assetpath;


        chkinterval = window.setInterval(function () {
            currslide++;
            if (currslide == slides.data.messages.length) 
                currslide=0;
            document.getElementById("photo").src=slides.data.messages[currslide].assetpath;
           
            
        }, slidetimer);






       
    }
};

xhttp.open("GET", "/messages/getActive", true);
xhttp.send();

reloadinterval = window.setInterval(function(){
    window.clearInterval(chkinterval);
    xhttp.open("GET", "/messages/getActive", true);
    xhttp.send();
}, 15*60*1000);


// reloadinterval = window.setInterval(document.location.href=document.location.href, 30*60*1000)
</script>
</body>
</html>