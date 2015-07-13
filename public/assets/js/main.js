/* 
 Created on : May 26, 2015, 11:42:49 PM
 Author     : Cornelius
 */

var application = application || {};

application.global = {
    enableMenu: function() {

    },
    initialize: function() {
        this.enableMenu();
        console.info('Application was initialized');
    }
};

$().ready(function() {
    application.global.initialize();
});