Views controller
post method
file bags
re - routing
middleWare guest
after middelware
test multi templating
validation extends to views
composer autoloading
unset($_GET['url'])
//
// Php learnt
magic method
__get

function Templating(){}
  // How to include
      __include:twocolumns

  // How to echo variables and sanitize
  {{$name1}}

  // how to echo html unSanitized
  {{{ $html }}}


  // How to load template content
  __templateContent
  Content goes here
  __end


  // How to load template
  __template:default

  // how to load template varialbles
  __templateVariable:title, Awesome


  // Foreach loop
  _foreach ([1,2,3,4] as $each)
    {{ $each }}
  _endforeach


  // if blockquote
  _if('iam rock' == 'awesoeme')
   <li><a href="index.html">False</a> </li>
   _else
       <li><a href="index.html">True</a> </li>
   _endif

   // how to placeholde template body
     __templateBody

  // Tenary operator
   {{ (1 == 1) ? 'one' : 'false' }}

}

function Validation(){

  //title,
  //required
  //min:value
  //max:value
  //pattern:value
  //matches:value
  //unique:value
  //type
}

 RewriteBase /
