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
                    $(document).on('click' , '.toggle-panel' , (function(ev){
                        $('panel').removeClass('open');// close all panels
                        var $target = $(ev.target),
                            panel = $($target.data('target'));
                        ;
                        
                        panel.addClass('open');
                    }));
                    $(document).on('click' , 'panel .overlay' , (function(){
                        $('.content').toggleClass('disable-scroll');
                        $('panel').toggleClass('open');
                    }));
                    
                    $(document).on('click' , 'panel .close-panel' , (function(){
                        $('.content').removeClass('disable-scroll');
                        $('panel').removeClass('open');
                    }));
                    
                    
                },
                
                enableAside : function(){
                    $(document).on('click' , '[aside-toggle]' , function(e){
                        var el = $(e.target);
                        var target = el.attr('aside-target'); 
                        if(target){
                            var $target = $(target);
                            console.log($target)
                            $target.addClass('open');
                        } else {
                            $log.error('Aside not properly constructed.[Missing aside target]');
                        }
                        
                    });
                    
                    $(document).on('click', '[close-aside]' , function(e){
                        var el = $(e.target);
                        var aside = el.closest('aside');
                        aside.removeClass('open');
                    });
                },
                
               
                // enableBodyScroll : function(){
                   
                // },
                init : function(){
                    
                    this.enablePanels();
                    this.enableAside();
                    $log.info('initialize DomService ');
                }
                
            };

            return _instance;

        };

        return ["$rootScope", "$log" , "$timeout", "$location" , "$routeParams", DOM];

    });


}(define));