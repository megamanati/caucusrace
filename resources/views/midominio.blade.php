<!DOCTYPE html>
<html>
<head>
    <title>Mi dominio</title>
    <style>
        div {
            font-size: 22px;
        }
    </style>
</head>
<body>
    <div class="formaDominio">
        <form action="/dominio" method="POST">
        
        @csrf
        
            <div class="labelDominio">
                <label>Escribe tu dominio</label>
    </div>
    
            <input type="text" id="nombreDominio" value="">
            <!-- <input type="hidden" id="valor1" name="valor1" value=""> -->
            <!-- @method('PUT') -->
            
            <div class="botonDominio">
            <input type="submit" value="dominio">
    </div>
        </form>
        <div>
</body>
</html>