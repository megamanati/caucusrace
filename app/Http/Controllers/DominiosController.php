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

    public function cpanel(){
        include ('../resources/cpanel.live.php');

       $cp = new cpanelC();
       $cpvar = $cp->cpanel;


    }

    public function getdominio(Request $request)
    {
        // dd($request->all());  //to check all the datas dumped from the form
        // //if your want to get single element,someName in this case
        // $someName = $request->someName; \
        $name = Route::currentRouteName(); // string
        $method = $request->method();
        #$nombreDominio = $request->input('nombreDominio');
        DB::beginTransaction();

        if ($request->isMethod('post')) {
            $input = $request->all();
            $indice = '';
            $fechaInicio = '';
            
            $htmlRequestStr = 'https://caucusrace.org:2083/cpsessCULKHIG2HZNWBWL9JCHT13VYQKTAXV59/execute/SubDomain/addsubdomain?domain='.$request->nombreDominio.'&rootdomain='.$request->terminacion;
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);

            $header[0] = "Authorization: WHM $whmusername:";
            curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
            curl_setopt($curl, CURLOPT_URL, $htmlRequestStr);
            $result = curl_exec($curl);

            if ($result == false) {
                // your error log
            }
            if($result){
                $decoded_response = json_decode( $result, true );
                if(isset($decoded_response['data']) && !empty($decoded_response['data'])){
                    $url = $decoded_response['data']['url'];
                    echo $url;
                }

            }     
            
            $dominio = preg_replace("(^https?://)", "", $request->nombreDominio.".".$request->terminacion);
            $dominio = str_replace(' ', '', $dominio);
            $Urlredir = preg_replace("(^https?://)", "",  $request->redireccionDominio);

            if (!empty($input) && isset($request->nombreDominio)){
                try{
                DB::insert("insert into dominios (domainName, URLredirect, fechaInicio, usuario) VALUES (?,
                ?, ?, ?)", [$dominio, $Urlredir,gmdate("Y-m-d H:i:s",time()),"laravel"]);
               // echo $request->nombreDominio.' '.$Urlredir.' '.gmdate("Y-m-d H:i:s",time()).' '."laravel";
                } catch (\Illuminate\Database\QueryException $ex)
                { 
                    #$fechaInicio = DB::select("select fechaInicio from dominios where domainName = ? limit 1", [$request->nombreDominio]);
                
                    $fechaInicio = DB::table("dominios")->where('domainName',[$dominio])->first();
                    #return $fechaInicio->fechaInicio;
                    #return gmdate("Y-m-d",time());
                    DB::rollback();
                    return back()->withError('Lamentablemente El dominio '.$dominio.' fue creado el dia, '.$fechaInicio->fechaInicio.'. Tienes que esperar '.DominiosController::diasParaExpirar($fechaInicio->fechaInicio).' dias desde su creacion para poder usarlo.')->withInput();
                }
            }else {
                DB::rollback();
                return back()->withError('Favor de llenar los Valores')->withInput();
            }
        }
        DB::commit();
        return view('midominio.midominio')
        ->with('dominio', $dominio)
        ->with('URL', $Urlredir)
        ->with('FechaInicio', gmdate("Y-m-d",time()));
    }

    private function diasParaExpirar($fechaInicio){

        $datetime1 = date_create(gmdate("Y-m-d",time()));
        $datetime2 = date_create($fechaInicio);

        $diferencia = date_diff($datetime1, $datetime2);
        $faltante = 21 - $diferencia->format('%a');

        return $faltante;

    }

    public function subdomain(Request $request){
        $name = Route::currentRouteName(); 
        $url = preg_replace("(^https?://)", "", URL::current());

        $domain = DB::table("dominios")->where('domainName',[$name])->first();
        
        if (!empty($domain) || isset($domain)){
                return $domain->domainName.' '.$domain->fechaInicio.''.$domain->URLredirect;
        }else {
            redirect('/home');           
        }
    }
}
