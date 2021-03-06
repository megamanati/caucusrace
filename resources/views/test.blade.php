<link href="{{ url('/css/app.css') }}" rel="stylesheet">
<!DOCTYPE html>
<html>
    <body>
        <h1>Hello, {{ $name; }} </h1> <a href="{{ route('profile', ['id' => 1, 'photos' => 'yes']); }}">Ve mi profile</a>
        <a href="{{ route('midominio.lista'); }}">Otra liga</a>
    </body>



<?php


use Illuminate\Support\Facades\DB;

try{
    DB::beginTransaction();
    
    //Select values of start date
    //$query = DB::table("dominios")->pluck('fechaInicio');
    $query = DB::table("dominios")->get();
    #$query->fechaInicio;
    #$query->domainName
    #$query->URLredirect
    //Get the current date in UTC
    $datetime1 = date_create(gmdate("Y-m-d",time()));

    foreach ($query as $inicio) {
        
        //Get the date to compare
        $datetime2 = date_create($inicio->fechaInicio);
        //Return the difference
        $diferencia = date_diff($datetime1, $datetime2);
        //Diference grater than 21 days
        //echo "<div>".$inicio->fechaInicio."</div>";
        //echo "<div>".$diferencia->format('%a')."</div>";
        
        
        if( $diferencia->format('%a') > 21){
            DB::table("dominios")->where('domainName', $inicio->domainName)->delete();
            echo "mayor a 21";
            
        }
    }
    DB::commit();
    

    ///Throws a exception if the name exist or a Query exception is throwed
} catch (\Illuminate\Database\QueryException $ex)
    { 
        echo "<div>".$ex."</div>";
        $fp = fopen('log.txt', 'w');
        fwrite($fp, 'Cats chase mice');
        fclose($fp);
    //Insert an error in log
    //log.("Error: ".$ex);
                    
    DB::rollback();
    
}


?>


</html>