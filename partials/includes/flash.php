
   _if(Session::exists('success'))

     <div class="alert alert-success" role="alert"><strong>Well done! </strong>{{ Session::flash('success') }}</div>

   _endif

   _if(Session::exists('error'))

      <div class="alert alert-warning" role="alert"><strong>Oops! </strong>{{ Session::flash('error') }}</div>

   _endif


   _if(Session::exists('info'))

      <div class="alert alert-info" role="alert"><strong>Attention! </strong>{{ Session::flash('info') }} </div>

   _endif
