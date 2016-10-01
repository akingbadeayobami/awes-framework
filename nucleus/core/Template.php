<?php

	class Template{

		public static function sessionFlashing($class=''){

			 if(Session::exists('success')){

				echo ' <div class="alert alert-success '. $class .'" role="alert"><strong>Well done! </strong>' . Session::flash('success') . ' </div> ';

			 }

			 if(Session::exists('error')){

				echo '<div class="alert alert-warning '. $class .'" role="alert"><strong>Oops! </strong>' . Session::flash('error') .  ' </div> ';

			 }


			 if(Session::exists('info')){

				echo '<div class="alert alert-info '. $class .'" role="alert"><strong>Attention! </strong>' . Session::flash('info') .  ' </div> ';

			 }


		}

		public static function pagination($data,$number,$class){

			$allPages = ceil(count($data) / $number);

			if(isset($_GET['page']) && $_GET['page'] > 0){

				if ($_GET['page'] > 0){

					$previous = $_GET['page'] - 1;

				} else {

					$previous = 1;

				}


				echo '<a href="?page=' . $previous . '" class="'.$class.'">Previous</a>';

			}

			echo "&nbsp;&nbsp;";

			if (isset($_GET['page'])){

				$page = $_GET['page'];

				$next = $_GET['page'] + 1;

			} else {

				$next = 1;

				$page = 0;

			}

			if($page < $allPages - 1){

				echo '<a href="?page='.$next.'" class="'.$class.'">Next</a>';

			}

			echo '( Page of ' . ($page + 1) .  '/' . $allPages . ')';

			return $data = array_slice($data, $page * $number, $number);

		}

	}
?>
