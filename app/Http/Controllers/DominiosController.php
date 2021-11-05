<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class DominiosController extends Controller
{
     /**
     * Llamada cuando no se invoca algun metodo al controlador.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // ...
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('midominio.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($request->isMethod('post')) {
            $input = $request->all();
            $indice = '';
            
            if (!empty($input)){
                try {
                    DB::insert("insert into dominios (domainName, URLredirect, fechaInicio, usuario) VALUES (?,
                    ?, ?, ?)", [$request->nombreDominio, $Urlredir,gmdate("Y-m-d H:i:s",time()),"laravel"]);
                } catch (\Illuminate\Database\QueryException $ex){ return $ex->getMessage(); }
                //echo $request->nombreDominio.' '.$Urlredir.' '.gmdate("Y-m-d H:i:s",time()).' '."laravel";
            }else {
                $indice = 'nada';
            }
        
        }
        #return $Urlredir.' '.gmdate("Y-m-d H:i:s",time()).' '."laravel";
        return view('midominio.name', compact('midominio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getdominio(Request $request)
    {
        $method = $request->method();
        #$nombreDominio = $request->input('nombreDominio');
        DB::beginTransaction();

        
        if ($request->isMethod('post')) { //If the method is of the request is POST
            $input = $request->all();
            $indice = '';
            $fechaInicio = '';
            
            //Replace HTTP and HTTPS string to ""
            $dominio = preg_replace("(^https?://)", "", $request->nombreDominio.".".$request->terminacion);
            $dominio = str_replace(' ', '', $dominio); //Remove blank spaces
            $Urlredir = preg_replace("(^https?://)", "",  $request->redireccionDominio); //Replace HTTP and HTTPS string to ""

            if (!empty($input) && isset($request->nombreDominio)){
                try{
                    //Insert of data
                    DB::insert("insert into dominios (domainName, URLredirect, fechaInicio, usuario) VALUES (?,
                    ?, ?, ?)", [$dominio, $Urlredir,gmdate("Y-m-d H:i:s",time()),"laravel"]);
                    // echo $request->nombreDominio.' '.$Urlredir.' '.gmdate("Y-m-d H:i:s",time()).' '."laravel";
                ///Throws a exception if the name exist or a Query exception is throwed
                } catch (\Illuminate\Database\QueryException $ex)
                { 
                    #$fechaInicio = DB::select("select fechaInicio from dominios where domainName = ? limit 1", [$request->nombreDominio]);
                    //Get the query where domain name is passed getting the info
                    $query = DB::table("dominios")->where('domainName',[$dominio])->first();
                    #$query->fechaInicio;
                    #$query->domainName
                    #$query->URLredirect
                    
                    DB::rollback();
                    return back()->withError('Lamentablemente El dominio '.$dominio.' fue creado el dia, '.$query->fechaInicio.'. Tienes que esperar '.DominiosController::diasParaExpirar($query->fechaInicio).' dias desde su creacion para poder usarlo.')->withInput();
                }
            }else {
                DB::rollback();
                return back()->withError('Favor de llenar los Valores')->withInput();
            }
        }
        DB::commit();
        //Return View midominio with parameters, dominio, URL and fecha
        return view('midominio.midominio')
        ->with('dominio', $dominio)
        ->with('URL', $Urlredir)
        ->with('FechaInicio', gmdate("Y-m-d",time()));
    }

    private function diasParaExpirar($fechaInicio){

        //Get the current date in UTC
        $datetime1 = date_create(gmdate("Y-m-d",time()));
        //Get the date to compare
        $datetime2 = date_create($fechaInicio);
        //Return the difference
        $diferencia = date_diff($datetime1, $datetime2);
        //Diference of 21 days minus the result
        $faltante = 21 - $diferencia->format('%a');
        //Return
        return $faltante;

    }

    public function subdomain(Request $request){
        //Replace the http:// with whitespace
        $url = preg_replace("(^https?://)", "", URL::current());
        //Save the first domain name that matches in the table
        $domain = DB::table("dominios")->where('domainName',[$url])->first();
        //If the domain exists, returns a the url, if not, redirect to HOME
        if (!empty($domain) || isset($domain)){
            //return $domain->domainName.' '.$domain->fechaInicio.''.$domain->URLredirect;
            return ('http://'.$domain->URLredirect);
        }else {
            return redirect('/home');           
        }
    }
}
