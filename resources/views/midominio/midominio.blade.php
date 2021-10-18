<html>
@include('../header')

<body>

<h3 class="page-title text-center">Dominio ingresado: <?php echo $dominio; ?> </h3>
<b>URL redireccionada</b>: <?php echo $URL; ?>
<br>
<b>Creado</b>: <?php echo $FechaInicio; ?>
<?php $urlRedireccion = '//'.$URL; ?>
<p>Prueba tu nueva liga!!! Da Click aqui: 
<a href="{{ $urlRedireccion }}"><?php echo $dominio; ?></a>
<p>
<!-- <a href="{{ route('midominio.index') }}">Regresar</a> -->

</body>

@include('../footer')
</html>
