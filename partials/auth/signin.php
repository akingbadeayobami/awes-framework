__template:app
__templateVariable:title, Sign In

__templateContent
<div class="container">
  <div class="content">
     <div class="container">
       <div class="row">
         <div class="span6 offset3">
           __include:flash
           <h4 class="widget-header"><i class="icon-lock"></i> Signin</h4>
           <div class="widget-body text-center">
              <form class="form-horizontal form-signin-signup" method="post">
               <input {{{ inputField('user','email') }}}>
               <input {{{ inputField('user','password') }}}>
               <div class="remember-me">
                 <div class="pull-left">
                   <label class="checkbox">
                     <input type="checkbox"> Remember me
                   </label>
                 </div>
                 <div class="pull-right">
                   <a href="{{ Route::to('auth.forgotpassword') }}">Forgot password?</a>
                 </div>
                 <div class="clearfix"></div>
               </div>
               {{{ csrfToken() }}}
               <button type="submit" name="signIn" value="1" class="btn btn-primary btn-large">Sign In</button>
             </form>
             <h4><i class="icon-question-sign"></i> Don't have an account?</h4>
             <a href="{{ Route::to('auth.signup') }}" class="btn btn-large bottom-space">Signup</a>
           </div>
         </div>
       </div>
     </div>
   </div>
</div>
__end
