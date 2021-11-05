@include('../header')

<?php

    //$users = DB::select('select * from dominios');
    $users = DB::table("dominios")->get();
    echo "<div style='overflow-x: auto;'>";
    echo "<table class='tabla'>";
    echo "<tr class='TablaHeader'>";
    echo "<th>Nombre del dominio</th>";
    echo "<th>URL de Redireccion</th>";
    echo "<th>Fecha de creacion</th>";
    echo "</tr>";
    foreach ($users as $user) {
        echo "<tr class='row'>";
        echo "<th>".$user->domainName."</th>";
        echo "<th>".$user->URLredirect."</th>";
        echo "<th>".$user->fechaInicio."</th>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";

?>

@include('../footer')