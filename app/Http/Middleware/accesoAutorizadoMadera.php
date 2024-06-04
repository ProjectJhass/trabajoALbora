<?php

namespace App\Http\Middleware;

use App\Models\apps\control_madera\api\auth\ModelClaveApi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class accesoAutorizadoMadera
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hash proporcionado en el encabezado de autorización
        $providedHash = $request->header('Authorization');

        // Hash esperado
        $data =  ModelClaveApi::where("clave", $providedHash)->first();
        if ($data) {
            $expectedHash = $data->clave;

            if ($providedHash !== $expectedHash) {
                return response()->json(['error' => 'No tiene autorización para realizar esta solicitud'], 401);
            }

            return $next($request);
        }
        return response()->json(['error' => 'No tiene autorización para realizar esta solicitud'], 401);
    }
}
