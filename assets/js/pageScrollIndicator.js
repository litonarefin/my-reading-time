// On scroll execute the scrollProgress function
window.onscroll = function () { scrollProgress() };

function scrollProgress() {
  var currentState = document.body.scrollTop || document.documentElement.scrollTop;
  var pageHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrollStatePercentage = (currentState / pageHeight) * 100;
  document.querySelector(".ma-el-page-scroll-indicator > .ma-el-scroll-indicator").style.width = scrollStatePercentage + "%";
}