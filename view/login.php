<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat</title>
</head>
<>
<style>
    *{
        background-color: #22193f;
    }
    .input{
        border: 0;
        outline-style: none;
        /*outline: none;*/
        color: black;
        font-weight: bold;
        background-color: white;
        border-radius: 10px;
        height: 24px;
        box-shadow: 7px 1px 45px rgba(21, 52, 255, 0.8);
    }
    .button{
        border: none;
        background-color: springgreen;
        border-radius: 10px;
        cursor: pointer;
    }

    .text{
        color: white;
    }
</style>

<h1 align="center" class="text" > İstifadəçi adını daxil edin </h1>
<br><br>
<form  align="center" method="get" >
    <input name="login" class="input" type="text" >
    <input  class="button" type="submit" value="Göndər">
</form>

</body>
</html>