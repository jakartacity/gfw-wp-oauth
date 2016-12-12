jQuery(document).ready(function($) {
 $('#test-access-token-button').click( function() {
                $.get(PT_Ajax_Test_Access_Token.ajaxurl, 
                {   
                        action: 'test_access_token',
                        nextNonce: PT_Ajax_Test_Access_Token.nextNonce,
                },  
                function(data,status){
                        alert(data);
                }); 
  });
});
