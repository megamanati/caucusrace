<link href="{{ url('/css/app.css') }}" rel="stylesheet">
<!DOCTYPE html>
<html>
    <body>
        <h1>Hello, {{ $name; }} </h1> <a href="{{ route('profile', ['id' => 1, 'photos' => 'yes']); }}">Ve mi profile</a>
        <a href="{{ route('midominio.lista'); }}">Otra liga</a>
    </body>
</html>


<?php

?>