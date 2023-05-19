<?php

use Xhgui\Profiler\Profiler;
use Xhgui\Profiler\ProfilingFlags;

/** @see https://github.com/perftools/php-profiler/blob/main/examples/autoload.php */
return [
    'save.handler' => Profiler::SAVER_UPLOAD,
    'save.handler.upload' => [
        'url' => 'http://xhgui/run/import',
        'timeout' => 3,
        'token' => 'token',
    ],
    'profiler.enable' => function () {
        return true;
    },
    'profiler.flags' => [
        ProfilingFlags::CPU,
        ProfilingFlags::MEMORY,
        ProfilingFlags::NO_BUILTINS,
        ProfilingFlags::NO_SPANS,
    ],
    'profiler.options' => [],
    'profiler.exclude-env' => [],
    'profiler.simple_url' => function ($url) {
        return preg_replace('/=\d+/', '', $url);
    },
    'profiler.replace_url' => null,
];
