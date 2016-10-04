__include:header
<body data-spy="scroll" data-target=".bs-docs-sidebar">
<!-- Navbar
    ================================================== -->
<div class="jumbotron masthead">
  <div class="splash"> <img src="<?=url()?>assets/img/home-banner-bg.jpg" alt="Banner" /> </div>
  <div class="splash"> <img src="<?=url()?>assets/img/home-banner-bg2.jpg" alt="Banner" /> </div>
  <div class="splash"> <img src="<?=url()?>assets/img/home-banner-bg3.jpg" alt="Banner" /> </div>
  __include:navigation
  <div class="container show-case-item">
    <h1> ENGAGE & INNOVATE, OR DIE<br />
      (555) 111-0000 </h1>
    <p> Quality Books At Affordable Prices</p>
    <a href="work.html" class="bigbtn">View Our Work</a>
    <div class="clearfix"> </div>
  </div>
  <div class="container show-case-item">
    <h1> SIMPLICITY IS A GOOD THING<br />
      ADOPT! </h1>
    <p> Gone are the days of building simple websites. Clients are demanding more functionality
      and better results from their websites and we create unforgettable brand experiences.
      Our passion is helping design and build solutions that strike the perfect balance
      between users, business, and technology.</p>
    <a href="work.html" class="bigbtn">View Our Work</a>
    <div class="clearfix"> </div>
  </div>
  <div class="container show-case-item">
    <h1> PLAN, BUILD, LAUNCH<br />
      & GROW! </h1>
    <p> Gone are the days of building simple websites. Clients are demanding more functionality
      and better results from their websites and we create unforgettable brand experiences.
      Our passion is helping design and build solutions that strike the perfect balance
      between users, business, and technology.</p>
    <a href="work.html" class="bigbtn">View Our Work</a>
    <div class="clearfix"> </div>
  </div>
  <div id="banner-pagination">
    <ul>
      <li><a href="#" class="active" rel="0"> <img src="<?=url()?>assets/img/slidedot-active.png" alt="" /></a></li>
      <li><a href="#" rel="1"> <img src="<?=url()?>assets/img/slidedot.png" alt="" /></a></li>
      <li><a href="#" rel="2"> <img src="<?=url()?>assets/img/slidedot.png" alt="" /></a></li>
    </ul>
  </div>
</div>
__templateBody
__include:footer
__include:scripts
<script type="text/javascript">
        $(document).ready(function () {

            var showCaseItems = $('.show-case-item').hide();

            var splashes = $('.splash').hide();
            //get each image for each slide and set it as a background of the slide
            //            splashes.each(function () {
            //                var img = $(this).find('img');
            //                var imgSrc = img.attr('src');
            //                img.css('visibility', 'hidden');
            //                $(this).css({ 'background-image': 'url(' + imgSrc + ')', 'background-repeat': 'no-repeat' });
            //            });

            splashes.eq(0).show();
            showCaseItems.eq(0).show();

            var prevIndex = -1;
            var nextIndex = 0;
            var currentIndex = 0;

            $('#banner-pagination li a').click(function () {

                nextIndex = parseInt($(this).attr('rel'));

                if (nextIndex != currentIndex) {
                    $('#banner-pagination li a').html('<img src="<?=url()?>assets/img/slidedot.png" alt="slide"/>');
                    $(this).html('<img src="<?=url()?>assets/img/slidedot-active.png" alt="slide"/>');
                    currentIndex = nextIndex;
                    if (prevIndex < 0) prevIndex = 0;

                    splashes.eq(prevIndex).css({ opacity: 1 }).animate({ opacity: 0 }, 500, function () {
                        $(this).hide();
                    });
                    splashes.eq(nextIndex).show().css({ opacity: 0 }).animate({ opacity: 1 }, 500, function () { });

                    showCaseItems.eq(prevIndex).css({ opacity: 1 }).animate({ opacity: 0 }, 500, function () {
                        $(this).hide();
                        showCaseItems.eq(nextIndex).show().css({ opacity: 0 }).animate({ opacity: 1 }, 200, function () { });
                    });

                    prevIndex = nextIndex;
                }

                return false;
            });

        });
    </script>
</body>
</html>
