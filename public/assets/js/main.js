/* 
    Created on : May 26, 2015, 11:42:49 PM
    Author     : Cornelius
*/

var application = application || {} ;

application.global = {
  
    enableMenu : function(){
        
        $('.root-categories > li > a').mouseenter(function(){
            $('.root-categories > li').removeClass('open');
            $(this).parent().addClass('open');
        });
          
        $('.open-cat').mouseleave(function(){
            $(this).parent().removeClass('open');
        });
    },
  
    initialize : function(){
        this.enableMenu();
    console.info('Application was initialized');
}
};

$().ready(function(){
    application.global.initialize();
});