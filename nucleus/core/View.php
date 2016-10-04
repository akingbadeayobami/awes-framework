<?php
namespace Nucleus\Core;

use Nucleus\Core\Auth;

class View{

  private $view;

  private $data;

  public function __construct($view, $data){

    $view = str_replace(".","/",$view);

		$view = file_get_contents( BASE_DIR . cg('views/directory') . $view . '.php');

    $this->data = $data;

    $this->view = $view;

    $this->view = $this->parse($this->view);

    $this->view = $this->replaceShortHands($this->view);

    // $this->extractData();

    $this->view = $this->evalLogicBlocks($this->view);

    $this->outputView();

	}

  private function extractData(){

    if( is_array($this->data) && count($this->data) ){

        foreach($this->data as $var_name => $var_value){

            $$var_name = $var_value;

        }

    }

  }

  public  function runPHPString($view){

    $view = $this->replaceShortHands($view);

    // return preg_replace_callback('/(\<\?=|\<\?php=|\<\?php)(.*?)\?\>/', array(&$this, 'eval_block'), $view);

  }

  private function evalLogicBlocks($view){

    if( is_array($this->data) && count($this->data) ){

        foreach($this->data as $var_name => $var_value){

            $$var_name = $var_value;

        }

    }

    $view = self::replaceLogicBlocks($view);

    $view = file_get_contents( NUCLEUS . '/services/ViewAutoLoad.php') . $view;

    ob_start();

    eval(' ?> ' . $view . '<?php ');

    $view = ob_get_clean();

    return $view;

  }

  protected function eval_block($matches){

      $keywords = ['if','else','endif'];

      if(preg_match('/(\b' . implode('\b|\b', $keywords ) . '\b)/i', $matches[2] ) ){

        return $matches[0];

      }

      if( is_array($this->data) && count($this->data) ){

          foreach($this->data as $var_name => $var_value){

              $$var_name = $var_value;

          }

      }

      $eval_end = '';

      if( $matches[1] == '<?=' || $matches[1] == '<?php=' ){

          if( $matches[2][count($matches[2]-1)] !== ';' && $matches[2][count($matches[2]-1)] !== ':' ){

              $eval_end = ';';

          }

      }

      $return_block = '';

      eval('$return_block = ' . $matches[2] . $eval_end);

      return $return_block;
  }

  public  function replaceShortHands($view){

    // Replace the unescape
    $view = str_replace('{{{','<?=', $view);

    $view = str_replace('}}}','?>', $view);

    // replace the htmlentities
    $view = str_replace('{{','<?=ns(', $view);

    $view = str_replace('}}',')?>', $view);

    return $view;

  }

  public function replaceLogicBlocks($view){

    preg_match_all('%_if(.+)%',$view, $match);

    foreach($match[0] as $index => $temp){

      $view = str_replace($temp,'<?php if' . $match[1][$index] . ':?>',$view);

    }

    preg_match_all('%_elseif(.+)%',$view, $match);

    foreach($match[0] as $index => $temp){

      $view = str_replace($temp,'<?php elseif' . $match[1][$index] . ':?>',$view);

    }

    preg_match_all('%_foreach(.+)%',$view, $match);

    foreach($match[0] as $index => $temp){

      $view = str_replace($temp,'<?php foreach' . $match[1][$index] . ':?>',$view);

    }

    preg_match_all('%_while(.+)%',$view, $match);

    foreach($match[0] as $index => $temp){

      $view = str_replace($temp,'<?php while' . $match[1][$index] . ':?>',$view);

    }

    $view = str_replace('_else','<?php else: ?>', $view);
    $view = str_replace('_endif','<?php endif; ?>', $view);
    $view = str_replace('_endforeach','<?php endforeach; ?>', $view);
    $view = str_replace('_endwhile','<?php endwhile; ?>', $view);
    $view = str_replace('_switch','<?php ', $view); //
    $view = str_replace('_endswitch','<?php endswitch; ?>', $view);
    $view = str_replace('_case','<?php case', $view); //
    return $view;

  }
  // method_exists($this->model, $url[1];

  public  function parse($view){

    if(strpos($view,'__templateVariable:') !== false){

      $view = $this->templateVariable($view);

    }

    if(strpos($view,'__template:') !== false){

      // check if the view has any php error  and then try to report it
       $view = $this->loadTemplate($view);

    }

    if(strpos($view,'__include:') !== false){

      // check if the view has any php error  and then try to report it
       $view = $this->loadInclude($view);

    }

    return $view;

  }

  private function loadInclude($view){

    preg_match_all('%__include:(\w+)%',$view, $matches);

    foreach($matches[0] as $each){

      $includeName = str_replace('__include:','',$each);

      // chack if the include has a controller; to append it;

      $include = file_get_contents( BASE_DIR . cg('views/directory') . 'includes/' . $includeName . '.php');

      $include = self::parse($include);

      $view = str_replace('__include:' . $includeName ,$include, $view);

    }

    return $view;

  }

  private function templateVariable($view){

      preg_match_all('%__templateVariable:(.+)%',$view, $match);

      $data = [];

      foreach($match[1] as $each){

        $each = explode(",",$each);

        $data[$each[0]] = $each[1];

      }
      // TODO warn if the key exists
      $this->data = array_merge($this->data, $data);

      return $view;

  }

  /**
  * Since We Have Already Ascertained that this view has a template
  * We Will Like to import the template
  * @param $view: The View that has a template that we want to process
  * @return $templatedView: The view coated with the tekplate
  */

  public  function loadTemplate($view){

    // We get the name of the template
    preg_match('%__template:(\w+)%',$view, $templateNameMatch);

    // Extract the name of the template
    $templateName = str_replace('__template:','',$templateNameMatch[0]);

    //Load the template
    $template = file_get_contents( BASE_DIR . cg('views/directory') . 'templates/' . $templateName . '.php');

    $template = self::parse($template);

    // TODO Look for a way to hook the templateController Here
    // look for the template variables

    // TODO What if the tempate doesnt exist

    // Get the view template content
    preg_match('#__templateContent(?:.*?)__end#s',$view, $templateContentMatch);

    $templateContent = str_replace('__templateContent','',$templateContentMatch[0] );

    $templateContent = str_replace('__end','',$templateContent);

    // TODO What if there is not sectionName

    // Embed the template
    return str_replace('__templateBody' ,$templateContent,$template);

  }


  public  function outputView(){

    echo $this->view;

  }

}



    		//   Template::sessionFlashing('mw700 mauto pastel alert-border-left alert-dismissable');

    			// $errors = (object) $this->errors;
