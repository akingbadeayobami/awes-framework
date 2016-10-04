Views controller
post method
file bags
re - routing
try anc catch fro eval
middleWare guest
add php fastcache
after middelware
chack if the include has a controller; to append it;
migration
// Mail::send('activation',"xxx");
test multi templating

activation testing
need an error broadcaster
unset($_GET['url'])
more validation
mailing
//
// Php learnt
magic method
__get

//comit

input filed to objlke
auth registering no mail part yet
added randomUniqueTo
redirect :: to only
added closire for actons
auth guest middleware,  auth id working and auth attempt
and added resetProperties to moel to clean the garbages propeties for new ones
added the consept of factories

Test


// new commit
finally remove dthe old autoload
chnaged middle ware to instance class
added ViewAutoLoad for views 


function features(){
  Factorrus
  Model ORM
  Securti
  Model
 Auth
 Api ready
 Auto loading
 convention / config
 mvc
}

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
  {{ (Error::has('email')) ? Error::get('email') : "" }}

  //title,
  //required
  //min:value
  //max:value
  //pattern:value
  //matches:value
  //unique:value
  //type
}

function FormCreator(){
  <input {{{ inputField('user','email') }}}>
}

 RewriteBase /
