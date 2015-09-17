/**
 * ******************************************************************************************************
 *
 *   ApplicationModule
 *
 *   Defines controllers and services for the Trip Admin
 *
 *  @author     Corneliu Iancu
 *  @date       May 2015
 *
 * *****************************************************************************
 */

(function ( define, angular ) {
    "use strict";

    define([
            'utils/logger/ExternalLogger',
            'application/services/SessionService',
            'application/services/ApiService',
            'application/services/ControllService',
            'application/services/CategoryService',
            
            'application/directives/Ckeditor',
            'application/directives/File',
            'application/directives/MultipleFile',
            
            
            'application/controllers/MainController',
            'application/controllers/CategoryController', 'application/controllers/CategoriesController',
            'application/controllers/ProductsController', 'application/controllers/ProductController',
            'application/controllers/FilemanagerController', 'application/controllers/GoogleDriveController',
            'application/controllers/CliController',
            
            'application/controllers/ModalController',
            'application/controllers/ModalInstanceController'
        ],
        function ( 
            $log,
            SessionService, ApiService, ControllService, CategoryService,
    
            CkEditor, MxFile, MltFile,
        
            MainController, CategoryController, CategoriesController , ProductsController, ProductController,
            FilemanagerController, GoogleDriveController, CliController,
            ModalController , ModalInstanceCtrl)
        {
            var moduleName = "main.Application";
           
            angular.module( moduleName, [ ] )
                .service(       "session"              ,    SessionService        )
                .service(       "ApiService"           ,    ApiService            )
                .service(       "ControllService"      ,    ControllService       )
                .service(       "CategoryService"      ,    CategoryService       )
                
               
                .directive(     "ckeditor"             ,    CkEditor )
                .directive(     "mxfile"               ,    MxFile )
                .directive(     "multifile"            ,    MltFile )
            
                .controller(    "MainCtrl"             ,    MainController        )
                .controller(    "CategoryCtrl"         ,    CategoryController    )
                .controller(    "CategoriesCtrl"       ,    CategoriesController  )
                .controller(    "ProductsCtrl"         ,    ProductsController    )
                .controller(    "ProductCtrl"          ,    ProductController     )
                .controller(    "FilemanagerCtrl"      ,    FilemanagerController )
                .controller(    "GoogleDriveCtrl"      ,    GoogleDriveController )
                .controller(    "CliCtrl"              ,    CliController )
                
                
                .controller(    "ModalCtrl"            ,    ModalController       )
                .controller(    "ModalInstanceCtrl"    ,    ModalInstanceCtrl     )
           
            $log.info('APPLICATION MODULE LOADED');
            
            return moduleName;
        });

}( define, angular ));

