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
            $requestPath = request()->path();

            $includePatterns = explode(',', config('xhgui.enabler.include_routes')); 
            $excludePatterns = explode(',', config('xhgui.enabler.exclude_routes')); 
            $excludePatterns = $excludePatterns === [''] ? null : $excludePatterns;
            $includePatterns = $includePatterns === [''] ? null : $includePatterns;

            if ($probablility < 1) { $probablility = 1; }

            if (mt_rand(1, $probablility) !== 1) {
                return false;
            }

            // If current request path matches any of the include patterns, profile the request.
            // Include patterns take precedence over exclude patterns.
            if ($includePatterns !== null) {
                foreach ($includePatterns as $pattern) {
                    if (Str::is($pattern, $requestPath)) {
                        return true;
                    }
                }

                return false;
            }

            // If current request path matches any of the exclude patterns, do not profile the request.
            if ($excludePatterns !== null) {
                foreach ($excludePatterns as $pattern) {
                    if (Str::is($pattern, $requestPath)) {
                        return false;
                    }
                }
            }

            return true;
        };
    }
}
