<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        p {
            color: black;
            font-family: Normal;
        }

        h1 {
            color: #808000;
        }
    </style>
</head>

<body>

    <h1> Hola {{$name}} bienvenido a mi pagina web</h1>
    <p>Gracias por registrarte, has click en el link e ingresa el numero de confirmacion </p>
    <p>Numero de Confirmacion:{{$random}}</p>
    <a href="http://localhost:4200/activate?id={{$id}}" class="btn">Activar Cuenta</a>


    
</body>

</html>