<?php

use \Carbon\Carbon as Carbon;

Validator::extend('antes_de', function($attribute, $value, $params) {
  $dt1 = Carbon::createFromFormat('d/m/Y', $value);
  $dt2 = new Carbon($params[0])
  
  return $dt2 < $dt1;
});

Validator::extend('despues_de', function($attribute, $value, $params) {
  $dt1 = Carbon::createFromFormat('d/m/Y', $value);
  $dt2 = new Carbon($params[0])
  
  return $dt2 > $dt1;
});