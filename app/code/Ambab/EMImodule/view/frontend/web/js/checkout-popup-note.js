;define( 
    [ 
        'ko', 
        'jquery', 
        'uiComponent' 
    ], 
    function (ko, $, Component) { 
        'use strict'; 
        return Component.extend({ 
            defaults: { 
                template: 'Ambab_EMImodule/payment/customtemplate' 
            } 
        }); 
    } 
);