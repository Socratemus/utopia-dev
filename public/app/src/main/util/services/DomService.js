(function(define) {
    "use strict";

    /**
     * Register the Dom class with RequireJS
     */
    define([], function() {

        var DOM = function($rootScope, $log , $timeout , $location , $routeParams) {
            
            var _instance = {
                
                
                enablePanels : function(){
                    var self = this;
                    $(document).on('click' , '.toggle-panel' , (function(){
                        $('.content').toggleClass('disable-scroll');
                        $('panel').toggleClass('open');
                        
                    }));
                    $(document).on('click' , 'panel .overlay' , (function(){
                        $('.content').toggleClass('disable-scroll');
                        $('panel').toggleClass('open');
                    }));
                    
                    $(document).on('click' , 'panel .close-panel' , (function(){
                        $('.content').toggleClass('disable-scroll');
                        $('panel').toggleClass('open');
                    }));
                    
                    // $(document).mouseup(function (e)
                    // {
                    //     var container = $("panel"),
                    //         btn = $('.toggle-panel')
                    //     ;
                    
                    //     if (!container.is(e.target) // if the target of the click isn't the container...
                    //         && !btn.is(e.target) 
                    //         && container.has(e.target).length === 0
                    //         && btn.has(e.target).length === 0
                    //         ) 
                            
                    //     {
                    //         container.removeClass('open');
                    //         $('.content').toggleClass('disable-scroll');
                    //     }
                    // });
                    
                },
                disableBodyScroll : function(){
                   $(window).on('scroll' , '.content' , (function(e){
                       console.log(e);
                   }));
                },
                // enableBodyScroll : function(){
                   
                // },
                init : function(){
                    this.disableBodyScroll();
                    this.enablePanels();
                    $log.info('initialize DomService ');
                }
                
            };

            return _instance;

        };

        return ["$rootScope", "$log" , "$timeout", "$location" , "$routeParams", DOM];

    });


}(define));