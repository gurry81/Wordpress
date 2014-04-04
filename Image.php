<?php 
	class Image {
		public $url;
		public $link;

		 function __construct($url,$link){
		 	$this->$url = $url;
		 	$this->$link = $link;
		}
	}
function twcm_sub_string($text, $charlength=200) {
	$charlength++;
	$retext="";

	if ( mb_strlen( $text ) > $charlength ) {
		$subex = mb_substr( $text, 0, $charlength - 5 )	;
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

		if ( $excut < 0 ) {
			$retext .= mb_substr( $subex, 0, $excut );
		} else {
			$retext .= $subex;
		}

		$retext .= '[...]';
	} else {
		$retext .= $text;
	}	

	return $retext;
}
?>

