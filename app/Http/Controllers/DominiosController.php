<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
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
                    ?, ?, ?)", [$request->nombreDominio, $request->redireccionDominio,gmdate("Y-m-d H:i:s",time()),"laravel"]);
                } catch (\Illuminate\Database\QueryException $ex){ return $ex->getMessage(); }
                //echo $request->nombreDominio.' '.$request->redireccionDominio.' '.gmdate("Y-m-d H:i:s",time()).' '."laravel";
            }else {
                $indice = 'nada';
            }
        
        }
        #return $request->redireccionDominio.' '.gmdate("Y-m-d H:i:s",time()).' '."laravel";
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

            if (!empty($input) && isset($request->nombreDominio)){
                try{
                DB::insert("insert into dominios (domainName, URLredirect, fechaInicio, usuario) VALUES (?,
                ?, ?, ?)", [$request->nombreDominio, $request->redireccionDominio,gmdate("Y-m-d H:i:s",time()),"laravel"]);
                //echo $request->nombreDominio.' '.$request->redireccionDominio.' '.gmdate("Y-m-d H:i:s",time()).' '."laravel";
                } catch (\Illuminate\Database\QueryException $ex)
                { 
                    #$fechaInicio = DB::select("select fechaInicio from dominios where domainName = ? limit 1", [$request->nombreDominio]);
                    $fechaInicio = DB::table("dominios")->where('domainName',[$request->nombreDominio])->first();
                    #return $fechaInicio->fechaInicio;
                    #return gmdate("Y-m-d",time());
                    DB::rollback();
                    return back()->withError('Lamentablemente El dominio '.$request->nombreDominio.' fue creado el dia, '.$fechaInicio->fechaInicio.'. Tienes que esperar '.DominiosController::diasParaExpirar($fechaInicio->fechaInicio).' dias desde su creacion para poder usarlo.')->withInput();
                }
            }else {
                DB::rollback();
                return back()->withError('Favor de llenar los Valores')->withInput();
            }
        }
        DB::commit();
        return view('midominio.midominio')
        ->with('dominio', $request->nombreDominio)
        ->with('URL', $request->redireccionDominio)
        ->with('FechaInicio', gmdate("Y-m-d",time()));
    }

    private function diasParaExpirar($fechaInicio){

        $datetime1 = date_create(gmdate("Y-m-d",time()));
        $datetime2 = date_create($fechaInicio);

        $diferencia = date_diff($datetime1, $datetime2);
        $faltante = 21 - $diferencia->format('%a');

        return $faltante;

    }
}
