<?php

use Illuminate\Support\Str;

if (! function_exists('title_case')) {
  function title_case(string $string) {
    return Str::title($string);
  }
}

if (! function_exists('plural')) {
  function plural(string $string) {
    return Str::plural($string);
  }
}
