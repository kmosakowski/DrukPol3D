<?php
/**
 * @package calculator
 * @version 0.0.2
 */
/*
Plugin Name: Custom printing calculator
Description: Calculator for printing
Author: S10707
Version: 0.0.1
Author URI: http://sample.pl
*/

function price_print_calculator() {
	if (true) { 
		?>
			<script type="text/javascript">
 
jQuery(document).ready(function($) {
  $('.custom-div-calculate').click(function(){
	var x = document.getElementsByClassName("wpcf7-file")[0];
	var isAbs = document.getElementsByClassName("wpcf7-list-item first")[0].getElementsByTagName("input")[0].checked
	var radiomaterial = document.getElementsByClassName("radio-material")[0];
	
	var printFile = x.files
	if(typeof printFile==='undefined'||typeof printFile[0]==='undefined'){
		alert('Missing file');
		return
	}
	 
	var basePrice = ((printFile[0].size/1024)/2)/80
	if(basePrice<25){
	basePrice=25
	}else{
		if(basePrice>250)
		{basePrice=270}
	}
	var additionalPriceAddition;
	if(isAbs) {
		additionalPriceAddition=1.23
	}
	else{
		additionalPriceAddition=1
	}
	var finalPrize= basePrice*additionalPriceAddition
var formattedPrize=	(Math.round(finalPrize * 100) / 100).toFixed(2);

 	alert('Suggested price for this product is: ' + formattedPrize+ 'PLN.');
 });
 
});

</script>
		<?php
	  }	
}


add_action('wp_footer', 'price_print_calculator');

 