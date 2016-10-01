<?php

	class Watermark{
	
		public static function watermarkText($imageURL){
	
			$WaterMarkText =  chr(169) . 'Kademiks';
			
			list($width,$height) = getimagesize($imageURL);
				
			$imageProperties = imagecreatetruecolor($width, $height);
				
			$size = getimagesize($imageURL);
		
			$imagetyper = $size[2];
	
			switch($imagetyper) {
			  
				case(1): $targetLayer = imagecreatefromgif($imageURL); break;

				case(2): $targetLayer = imagecreatefromjpeg($imageURL); break;

				case(3): $targetLayer = imagecreatefrompng($imageURL); break;

				case(6): $targetLayer = imagecreatefrombmp($imageURL); break;

			}
			
			imagecopyresampled($imageProperties, $targetLayer, 0, 0, 0, 0, $width, $height, $width, $height);
			
			$watermarkColor = imagecolorallocatealpha($imageProperties, 0,0,0,99); //black
			
			$font_size = $size[1] * 0.03;
			
			$dest_x = $size[0] - ($font_size * strlen($WaterMarkText) * 0.8);
			
			$dest_y = $size[1] - 5;

			$font = dirname( __FILE__ ) . '../../../assets/fonts/arial.ttf';
			
			$rotationAngle = 0;
			
			Imagettftext($imageProperties,$font_size,$rotationAngle,$dest_x,$dest_y,$watermarkColor,$font,$WaterMarkText);

		
			
			switch($imagetyper) {
		  case(1):
			imagegif($imageProperties, $imageURL,90);  
			break;

		  case(2):
			imagejpeg($imageProperties, $imageURL,90);  
			break;

		  case(3):
			imagepng($imageProperties, $imageURL,9);
			break;

		  case(6):
			imagewbmp($imageProperties, $imageURL,90);  
			break;

			}
			
		} 
	
	}
?>