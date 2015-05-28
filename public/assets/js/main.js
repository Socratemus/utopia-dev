/* 
    Created on : May 26, 2015, 11:42:49 PM
    Author     : Cornelius
*/

var application = application || {} ;

application.global = {
  
    menuDependency : function(){
      
    },
   
    initialize : function(){
        this.menuDependency()
        console.info('Application was initialized');
    }
};

$().ready(function(){
    application.global.initialize();
});