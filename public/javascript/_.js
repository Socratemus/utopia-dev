var _ = {
    test : function(){
        console.debug('this is a test');
    },
    
    menu : function(){
        $(document).on('click' , '#MainHandler' , function(e){
            $('content').toggleClass('col-md-offset-4');
            $('content').toggleClass('pushed');
           
            e.preventDefault();return false;
        });
        $(document).on('click' , 'content.pushed' , function(e){
            $('content').toggleClass('col-md-offset-4');
            $('content').toggleClass('pushed');
            e.preventDefault();return false;
        })
    },
    
    init : function(){
        this.test();
        this.menu();
    }
};