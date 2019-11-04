jQuery(function ($) {
    $('ul.file_menuAchat').slideUp()
$('ul.file_menuVente').slideUp()
$('ul.file_menuStock').slideUp()

$(".hoverliAchat").hover(
  function () {
     $('ul.file_menuAchat').slideDown()
  }, 
  function () {
     $('ul.file_menuAchat').slideUp()
  }
)

$(".hoverliVente").hover(
  function () {
     $('ul.file_menuVente').slideDown()
  }, 
  function () {
     $('ul.file_menuVente').slideUp()
  }
)

$(".hoverliStock").hover(
  function () {
     $('ul.file_menuStock').slideDown()
  }, 
  function () {
     $('ul.file_menuStock').slideUp()
  }
)

})// End of use strict