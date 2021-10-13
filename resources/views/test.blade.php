<?php

namespace App\Http\Middleware;

use Closure;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('token') !== 'my-secret-token') {
            return redirect('home');
        }

        return $next($request);
    }
}
?>

<html>
    <body>
        <h1>Hello, {{ $name }} </h1> <a href="{{ route('profile', ['id' => 1, 'photos' => 'yes']); }}">Ve mi profile</a>

        <form action="/dominio" method="POST">
            <input type="hidden" id="valor1" name="valor1" value="{{ $valor = 1 }}">
            <!-- @method('PUT') -->
            @csrf
            <input type="submit" value="dominio">
        </form>
        <a href="{{ route('domain', ['id' => 1]); }}">Otra liga</a>
    </body>
</html>


