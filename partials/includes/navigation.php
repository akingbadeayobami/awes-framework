<div class="nav-agency">
  <div class="navbar navbar-static-top">
    <!-- navbar-fixed-top -->
    <div class="navbar-inner">
      <div class="container"> <a class="brand" href="index.html"> <img src="{{ url('') }}assets/img/Logo.png" alt="Logo"></a>
        <div id="main-nav">
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="{{ url('') }}">Home</a> </li>
              <li class="active"><a href="{{ url('') }}">About Us</a> </li>
              <li class="active"><a href="{{ url('') }}">Books</a> </li>
              <li class="active"><a href="{{ url('') }}">Blog</a> </li>
              <li class="active"><a href="{{ url('') }}">Book Promotion</a> </li>
              <li class="active"><a href="{{ url('') }}">Event Map</a> </li>
              <li class="active"><a href="{{ url('') }}">Publishing</a> </li>
              <li class="active"><a href="{{ url('') }}">Consulting</a> </li>
              <li class="active"><a href="{{ url('') }}">Adverts</a> </li>
              <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"> Work <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="work.html">One Column</a></li>
                  <li><a href="work-two-columns.html">Two Column</a></li>
                  <li><a href="work-three-columns.html">Three Column</a></li>
                  <li><a href="work-details.html">Work Details</a></li>
                </ul>
              </li>
              _if(Auth::check())
                <li><a href="{{ url('auth.signin') }}">{{ Auth::user()->fname }} </a> </li>
                <li><a href="{{ url('auth.signout') }}">Log Out </a> </li>
              _else
               <li><a href="{{ url('auth.signin') }}">Sign In</a> </li>
               <li><a href="{{ url('auth.signup') }}">Sign Up</a> </li>
               _endif
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
