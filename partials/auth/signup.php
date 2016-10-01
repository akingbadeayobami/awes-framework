__template:app
__templateVariable:title, Sign Up

__templateContent
<div class="container">
  <div class="content">
     <div class="container">
       <div class="row">
         <div class="span6 offset3">
           <h4 class="widget-header"><i class="icon-lock"></i> Sign Up</h4>
           <div class="widget-body text-center">
              <form class="form-horizontal form-signin-signup">
               <input type="text" name="email" placeholder="Email">
               <input type="password" name="password" placeholder="Password">
               <div class="clearfix"></div>
               <input type="submit" value="Signin" class="btn btn-primary btn-large">
             </form>
             <h4><i class="icon-question-sign"></i> Already have an account?</h4>
             <a href="{{ Route::to('auth.signin') }}" class="btn btn-large bottom-space">Signin</a>
           </div>
         </div>
       </div>
     </div>
   </div>
</div>
__end
