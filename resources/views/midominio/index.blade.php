<html>
@include('../header')
    
<body>
    <div class="formaDominio">
        @if (session('error'))
            <div class="alert alert-danger"> 
            <div> {{ session('error') }}  </div>
            <p>
            <div class="alert alert-danger"> 
        @endif

        <form action="{{ url('/midominio') }}" method="POST">
        
        @csrf
        
            <div class="labelDominio">
                <label>Escribe tu dominio</label>
            </div>
            <input type="text" id="nombreDominio" name="nombreDominio" require>
            <div class="labelUrl">
            <label>Escribe tu URL de redirección</label>        
            </div>
            <input type="text" id="redireccionDominio" name="redireccionDominio" require>


            <!-- <input type="hidden" id="valor1" name="valor1" value=""> -->
            <!-- @method('PUT') -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            
            <div class="botonDominio">
            <input type="submit" value="dominio">
    </div>
        </form>
        <div>
</body>
@include('../footer')
</html>