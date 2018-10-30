<?php 
/**
  @author: Raj Trivedi (India), 2009-10-14 
  @modify: Taylor Lopes (Brazil), 2012-04-06
*/
class BarCodeGenrator {
private $file;
private $into;
private $digitArray = array(0=>"00110",1=>"10001",2=>"01001",3=>"11000",4=>"00101",5=>"10100",6=>"01100",7=>"00011",8=>"10010",9=>"01010");
	//function __construct($value,$into=1, $filename = 'barcode.gif', $width_bar=300, $height_bar=65, $show_codebar=false) { 	 
      function __construct($params) {
        extract($params);
	  $lower = 1 ; $hight = 50;     
    $this->into = $into;
          $this->file = $filename;
	  for($count1=9;$count1>=0;$count1--){ 
		for($count2=9;$count2>=0;$count2--){   
		  $count = ($count1 * 10) + $count2 ; 
		  $text = "" ; 
		  for($i=1;$i<6;$i++){ 
			$text .=  substr($this->digitArray[$count1],($i-1),1) . substr($this->digitArray[$count2],($i-1),1); 
		  } 
		  $this->digitArray[$count] = $text; 
	   } 
	  } 
    
 
      $height_bar_max = $height_bar;
      $width_bar_max  = $width_bar;
      
		  $img 		= imagecreate($width_bar_max,$height_bar_max);  
      if ($show_codebar) {
        $height_bar -= 25;
      } 
            
		  $cl_black = imagecolorallocate($img, 0, 0, 0); 
		  $cl_white = imagecolorallocate($img, 255, 255, 255); 
	
		  #imagefilledrectangle($img, 0, 0, $lower*95+1000, $hight+300, $cl_white); 
      imagefilledrectangle($img, 0, 0, $width_bar_max, $height_bar_max, $cl_white);
		  imagefilledrectangle($img, 5,5,5,$height_bar,$cl_black); 
		  imagefilledrectangle($img, 6,5,6,$height_bar,$cl_white); 
		  imagefilledrectangle($img, 7,5,7,$height_bar,$cl_black); 
		  imagefilledrectangle($img, 8,5,8,$height_bar,$cl_white); 
	$thin = 1 ; 
	if(substr_count(strtoupper($_SERVER['SERVER_SOFTWARE']),"WIN32")){
 		$wide = 3;
	} else {
			$wide = 2.72;
	   }
	$pos   = 9 ; 
	$text = $value ; 
	if((strlen($text) % 2) <> 0){ 
		$text = "0" . $text; 
	} 
  
 
	while (strlen($text) > 0) { 
	  $i = round($this->JSK_left($text,2)); 
	  $text = $this->JSK_right($text,strlen($text)-2); 
	   
	  $f = $this->digitArray[$i]; 
	   
	  for($i=1;$i<11;$i+=2){ 
		if (substr($f,($i-1),1) == "0") { 
		  $f1 = $thin ; 
		}else{ 
		  $f1 = $wide ; 
		} 
	  imagefilledrectangle($img, $pos,5,$pos-1+$f1,$height_bar,$cl_black)  ; 
	  $pos = $pos + $f1 ;   
	   
	  if (substr($f,$i,1) == "0") { 
		  $f2 = $thin ; 
		}else{ 
		  $f2 = $wide ; 
		} 
	  imagefilledrectangle($img, $pos,5,$pos-1+$f2,$height_bar,$cl_white)  ; 
	  $pos = $pos + $f2 ;   
	  } 
	} 
	imagefilledrectangle($img, $pos,5,$pos-1+$wide,$height_bar,$cl_black); 
	$pos=$pos+$wide; 
	
	imagefilledrectangle($img, $pos,5,$pos-1+$thin,$height_bar,$cl_white); 
	$pos=$pos+$thin; 
	
	
	imagefilledrectangle($img, $pos,5,$pos-1+$thin,$height_bar,$cl_black); 
	$pos=$pos+$thin; 
  
  if ($show_codebar) {
    imagestring($img, 5, 0, $height_bar+5, " ".$value, imagecolorallocate($img, 0, 0, 0));
  } 
 	
	$this->put_img($img);
	} 
	
	function JSK_left($input,$comp){ 
		return substr($input,0,$comp); 
	} 
	
	function JSK_right($input,$comp){ 
		return substr($input,strlen($input)-$comp,$comp); 
	} 
	function put_img($image,$file='img/test.gif'){
		if($this->into){
			imagegif($image,$this->file);
		} else {
                   
					//header("Content-type: image/gif");
					//imagegif($image);
                    return imagegif($image);
			   }
		imagedestroy($image);
	}
        
}

?>