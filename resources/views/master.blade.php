<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="author" content="Erdem Özveren">
  <meta name="description" content="https://github.com/erdemozveren/laravelmacros">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <style type="text/css">
  body{
    margin:45px 45px;
    background-color:#6665ee;
    
}
form{
    /* width:330px; */
    border-top:1px dotted #D9D9D9;
    margin:10px auto
}
input[type="button"]{
    width: 35px;
}
button{
    width:246px;
    height:40px;
    color:#4C4C4C;
    margin-bottom:20px;
    margin-left:20px
}
/*
input{
    width:250px;
    padding:5px;
    margin:10px 0 10px;
    border-radius:5px;
    border:4px solid #acbfa5
}*/
input[type = submit] , .btn {
    width:100px!important;
    background-color:#6665ee;
    border-radius:5px;
    border:2px solid #4443ea;
    color:#fff
}
h4{
    color:#4C4C4C;
    text-align:center
}
.container{
    text-align:center;
    width:50%;
    border-left:1px solid #D0D0D0;
    background-color:#fff;
    padding-top:40px;
    padding-bottom:40px;
    border-radius:5px;
    margin: 0 auto;
}
.row {
    background-color:#fff;
}
</style>
  @yield('css')
</head>

<body>
  @yield('content')
  @yield('js')
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript">


// Add new element to the form
function addEl(parentId, elementTag, elementId, html) {
    var p = document.getElementById(parentId);
    var newElement = document.createElement(elementTag);
    newElement.setAttribute('id', elementId);
    newElement.innerHTML = html;
    p.appendChild(newElement);
}

// Remove exist element from form
function removeEl(elementId) {
    var element = document.getElementById(elementId);
    delete formJson[elementId.split("-")[1]];
    element.parentNode.removeChild(element);

}

</script>
</body>

</html>