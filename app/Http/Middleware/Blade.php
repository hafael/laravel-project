<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Blade
{
    public $view = 'app';
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $view)
    {
        if ($view) {
            $this->view = $view;
        }

        Inertia::setRootView($this->view);

        return $next($request);
    }
}
