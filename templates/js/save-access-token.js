jQuery(document).ready(function($) {
                $.get(PT_Ajax_Access_Token.ajaxurl, 
                {   
                        action: 'save_access_token',
                        nextNonce: PT_Ajax_Access_Token.nextNonce,
                        access_token: $('#access-token').text()
                },  
                function(data,status){
                        //alert(data);
                }); 
});
