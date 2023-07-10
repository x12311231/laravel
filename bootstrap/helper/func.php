<?php

if (!function_exists('layout')) {
    function layout($component) {
        return view('layout', [
            'component' => $component,
        ]);
    }
} else {
    throw new \Exception('func exists');
}
//if (function_exists('view')) {
//    throw new \Exception('view func exists');
//}
