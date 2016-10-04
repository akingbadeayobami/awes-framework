__template:app
__templateVariable:title, Sign Up

__templateContent
<div class="container">
  <div class="content">
     <div class="container">
       <div class="row">
         <div class="span6 offset3">
           __include:flash
           <h4 class="widget-header"><i class="icon-lock"></i> Sign Up</h4>
           <div class="widget-body text-center">
              <form class="form-horizontal form-signin-signup" method="POST">
               <input {{{ inputField('user.email') }}}>
               <input {{{ inputField('user.fname') }}}>
               <input {{{ inputField('user.lname') }}}>
               <input {{{ inputField('user.password') }}}>
               <input {{{ inputField('user.repassword') }}}>
               {{{ csrfToken() }}}
               <p> By creating an account, you agree to {{ cg('site.name') }} <a href="#">Terms Of Use</a> </p>
               <div class="clearfix"></div>
               <button type="submit" name="signUp" value="1" class="btn btn-primary btn-large"> Sign Up</button>
             </form>
             <h4><i class="icon-question-sign"></i> Already have an account?</h4>
             <a href="{{ url('auth.signin') }}" class="btn btn-large bottom-space">Signin</a>
           </div>
         </div>
       </div>
     </div>
   </div>
</div>
__end
