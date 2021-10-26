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
                <label> {{ 'messages.escribedominio' }} </label>
            </div>
            <input type="text" id="nombreDominio" name="nombreDominio" require>
            <select id="terminacion" name="terminacion">
              <option value="republican">and.recuplican</option>
             <option value="democrat">and.democrat</option>
             <option value="caucusrace">caucusrace.org</option>
</select>
            <div class="labelUrl">
            <label><?php echo('messages.URLredirect') ?> </label>        
            </div>
            <input type="text" id="redireccionDominio" name="redireccionDominio" require>


            <!-- <input type="hidden" id="valor1" name="valor1" value=""> -->
            <!-- @method('PUT') -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            
            <div class="botonDominio">
            <input type="submit" value="sumbit">
    </div>
        </form>
        <div>
</body>
@include('../footer')
</html>