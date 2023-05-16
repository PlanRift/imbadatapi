<?php

namespace App\Http\Middleware;

use App\Models\comments;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikComment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id_komentator = comments::findOrFail($request->id);
        $user = Auth::user();

        if($id_komentator->user_id != $user->id){
            return response()->json(['kamu bukan pemilik komen']);
        }

        return $next($request);
    }
}
