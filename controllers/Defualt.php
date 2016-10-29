<?php
class Defualt {
  function main() {
   $blade = new Philo\Blade\Blade(BLADE_VIEWS, BLADE_CACHE);
   $bladeTemplate = 'layout';
   $bladeData = [];

   return $blade->view()->make($bladeTemplate, $bladeData)->render();
 }
}
?>
