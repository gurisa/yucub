<?php

namespace App\Http\Middleware;

use Closure;

class Cors {

    private static $allowedOriginsWhitelist = [
      'http://bot.confucius.id', 'https://bot.confucius.id',
      'http://www.confucius.id', 'https://www.confucius.id'
    ];

    private static $allowedOrigin = '*';
    private static $allowedMethods = 'OPTIONS, GET, POST, PUT, PATCH, DELETE';
    private static $allowCredentials = 'true';
    private static $allowedHeaders = '';

    public function handle($request, Closure $next)
    {
      if (! $this->isCorsRequest($request) && config('app.debug'))
      {
        return $next($request);
      }

      static::$allowedOrigin = $this->resolveAllowedOrigin($request);

      static::$allowedHeaders = $this->resolveAllowedHeaders($request);

      $headers = [
        'Access-Control-Allow-Origin'       => static::$allowedOrigin,
        'Access-Control-Allow-Methods'      => static::$allowedMethods,
        'Access-Control-Allow-Headers'      => static::$allowedHeaders,
        'Access-Control-Allow-Credentials'  => static::$allowCredentials,
      ];

      // For preflighted requests
      if ($request->getMethod() === 'OPTIONS')
      {
        return response('', 200)->withHeaders($headers);
      }

      $response = $next($request);
      // $response = $response instanceof RedirectResponse ? $response : response($response);
      // return response('', 200)->withHeaders($headers);
      return $response;
    }

    private function isCorsRequest($request)
    {
      $requestHasOrigin = $request->headers->has('Origin');

      if ($requestHasOrigin)
      {
        $origin = $request->headers->get('Origin');

        $host = $request->getSchemeAndHttpHost();

        if ($origin !== $host)
        {
          return true;
        }
      }

      return false;
    }

    private function resolveAllowedOrigin($request)
    {
      $allowedOrigin = static::$allowedOrigin;

      // If origin is in our $allowedOriginsWhitelist
      // then we send that in Access-Control-Allow-Origin

      $origin = $request->headers->get('Origin');

      if (in_array($origin, static::$allowedOriginsWhitelist))
      {
        $allowedOrigin = $origin;
      }

      return $allowedOrigin;
    }

    private function resolveAllowedHeaders($request)
    {
      $allowedHeaders = $request->headers->get('Access-Control-Request-Headers');

      return $allowedHeaders;
    }
}
