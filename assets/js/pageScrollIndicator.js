// On scroll execute the mrt_scrollProgress function
jQuery(document).ready(function() {
	window.onscroll = function () { mrt_scrollProgress() };

	function mrt_scrollProgress() {
	  var currentState = document.body.scrollTop || document.documentElement.scrollTop;
	  var pageHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
	  var scrollStatePercentage = (currentState / pageHeight) * 100;
	  document.querySelector(".ma-el-page-scroll-indicator > .ma-el-scroll-indicator").style.width = scrollStatePercentage + "%";
	}
	
});	