$("body").on('click','.nav-dropdown',function(){
	$(this).closest('li').children('ul').toggle(600);
	$(this).closest('li').toggleClass('active');
});




