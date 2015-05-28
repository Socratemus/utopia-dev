/* 
    Created on : May 26, 2015, 11:42:49 PM
    Author     : Cornelius
*/

var application = application || {} ;

application.global = {
  
    menuDependency : function(){
      
    },
    searchDependency : function(){
        
        $(document).on('click' , '.search-form input' , function(){
            $(this).addClass('extended');      
        });
        
        $(document).on('blur' , '.search-form input' , function(){
            $(this).removeClass('extended');      
        });
    },
    initialize : function(){
        this.menuDependency();
        this.searchDependency();
        console.info('Application was initialized');
    }
};

$().ready(function(){
    application.global.initialize();
});