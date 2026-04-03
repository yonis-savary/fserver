<?php

set_error_handler(function($severity, $message, $file, $line) {
    $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
    $formatted = array_map(fn($t) => ($t['file'] ?? '?') . ':' . ($t['line'] ?? '?') . ' ' . ($t['function'] ?? '?'), $trace);
    error_log("PHP Warning: $message in $file:$line\nStack:\n" . implode("\n", $formatted));
});