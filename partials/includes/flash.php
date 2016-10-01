<?php
   if(Session::exists('success')){

    echo ' <div class="alert alert-success '. $class .'" role="alert"><strong>Well done! </strong>' . Session::flash('success') . ' </div> ';

   }

   if(Session::exists('error')){

    echo '<div class="alert alert-warning '. $class .'" role="alert"><strong>Oops! </strong>' . Session::flash('error') .  ' </div> ';

   }


   if(Session::exists('info')){

    echo '<div class="alert alert-info '. $class .'" role="alert"><strong>Attention! </strong>' . Session::flash('info') .  ' </div> ';

   }

?>
