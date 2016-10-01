<div class="nav-agency">
  <div class="navbar navbar-static-top">
    <!-- navbar-fixed-top -->
    <div class="navbar-inner">
      <div class="container"> <a class="brand" href="index.html"> <img src="<?=url()?>assets/img/Logo.png" alt="Logo"></a>
        <div id="main-nav">
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index.html">Home</a> </li>
              <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:"> Work <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="work.html">One Column</a></li>
                  <li><a href="work-two-columns.html">Two Column</a></li>
                  <li><a href="work-three-columns.html">Three Column</a></li>
                  <li><a href="work-details.html">Work Details</a></li>
                </ul>
              </li>
              <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:"> Pricing <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="pricing.html">Four Column</a></li>
                  <li><a href="pricing-three-columns.html">Three Column</a></li>
                </ul>
              </li>
              <li class="dropdown"><a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                  Pages
                 <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="faq.html">FAQ</a></li>
                  <li><a href="contact.html">Contact Us</a></li>
                  <li><a href="components.html">Components</a></li>
                </ul>
              </li>
              <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:"> Blog<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="blog.html">Blog Page</a></li>
                  <li><a href="blog-single.html">Single Page</a></li>
                </ul>
              </li>
               <li><a href="{{ Route::to('auth.signin') }}">Sign In</a> </li>
               <li><a href="{{ Route::to('auth.signup') }}">Sign Up</a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
