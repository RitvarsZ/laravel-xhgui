<?php

namespace Ritvarsz\LaravelXhgui\Support\ProfileEnabler;

use Ritvarsz\LaravelXhgui\Support\SerializableClosure;
use Illuminate\Support\Str;

class DefaultProfileEnabler implements SerializableClosure
{
    public function getClosure(): \Closure
    {
        return function () {
            $probablility = config('xhgui.enabler.probablility');
            $includePatterns = explode(',', config('xhgui.enabler.include')); 
            $excludePatterns = explode(',', config('xhgui.enabler.exclude')); 
            $requestPath = request()->path();


            if ($probablility < 1) { $probablility = 1; }

            if (mt_rand(1, $probablility) !== 1) {
                return false;
            }

            // If current request path matches any of the include patterns, profile the request.
            // Include patterns take precedence over exclude patterns.
            if ($includePatterns) {
                foreach ($includePatterns as $pattern) {
                    if (Str::is($pattern, $requestPath)) {
                        return true;
                    }
                }

                return false;
            }

            // If current request path matches any of the exclude patterns, do not profile the request.
            foreach ($excludePatterns as $pattern) {
                if (Str::is($pattern, $requestPath)) {
                    return false;
                }
            }

            return true;
        };
    }
}
