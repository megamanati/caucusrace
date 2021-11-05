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
        //Diference of 21 days minus the result
        //echo "<div>".$inicio->fechaInicio."</div>";
        //echo "<div>".$diferencia->format('%a')."</div>";
        if( $diferencia->format('%a') > 21){
            DB::table("dominios")->where('domainName', $inicio->domainName)->delete();
            Log::info("Registro: ".$inicio->domainName." borrado" );
            //log.("Registry: ".$inicio." Deleted");
        }
    }
    DB::commit();
    

    ///Throws a exception if the name exist or a Query exception is throwed
} catch (\Illuminate\Database\QueryException $ex)
    { 
        //echo "<div>".$ex."</div>";
    //Insert an error in log
    //log.("Error: ".$ex);
                    
    DB::rollback();
    
}


?>


    

