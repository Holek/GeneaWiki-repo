var fnames = new Array();var ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';
$j(document).ready( function() {
  var options = { errorClass: 'mce_inline_error', errorElement: 'div', onkeyup: function(){}, onfocusout:function(){}, onblur:function(){}  };
  var mce_validator = $j("#mc-embedded-subscribe-form").validate(options);
  options = { url: 'http://geneabase.us1.list-manage.com/subscribe/post-json?u=30f13c78ab863e816fd5cf7f8&id=564ae5a12a&c=?', type: 'GET', dataType: 'json', contentType: "application/json; charset=utf-8",
                beforeSubmit: function(){
                    $j('#mce_tmp_error_msg').remove();
                    $j('.datefield','#mc_embed_signup').each(
                        function(){
                            var txt = 'filled';
                            var fields = new Array();
                            var i = 0;
                            $j(':text', this).each(
                                function(){
                                    fields[i] = this;
                                    i++;
                                });
                            $j(':hidden', this).each(
                                function(){
                                 if ( fields[0].value=='MM' && fields[1].value=='DD' && fields[2].value=='YYYY' ){
                                  this.value = '';
         } else if ( fields[0].value=='' && fields[1].value=='' && fields[2].value=='' ){
                                  this.value = '';
         } else {
                                     this.value = fields[0].value+'/'+fields[1].value+'/'+fields[2].value;
                                 }
                                });
                        });
                    return mce_validator.form();
                }, 
                success: mce_success_cb
            };
  $j('#mc-embedded-subscribe-form').ajaxForm(options);

});
function mce_success_cb(resp){
    $j('#mce-success-response').hide();
    $j('#mce-error-response').hide();
    if (resp.result=="success"){
        $j('#mce-'+resp.result+'-response').show();
        $j('#mce-'+resp.result+'-response').html(resp.msg);
        $j('#mc-embedded-subscribe-form').each(function(){
            this.reset();
     });
    } else {
        var index = -1;
        var msg;
        try {
            var parts = resp.msg.split(' - ',2);
            if (parts[1]==undefined){
                msg = resp.msg;
            } else {
                i = parseInt(parts[0]);
                if (i.toString() == parts[0]){
                    index = parts[0];
                    msg = parts[1];
                } else {
                    index = -1;
                    msg = resp.msg;
                }
            }
        } catch(e){
            index = -1;
            msg = resp.msg;
        }
        try{
            if (index== -1){
                $j('#mce-'+resp.result+'-response').show();
                $j('#mce-'+resp.result+'-response').html(msg);            
            } else {
                err_id = 'mce_tmp_error_msg';
                html = '<div id="'+err_id+'"> '+msg+'</div>';
                
                var input_id = '#mc_embed_signup';
                var f = $j(input_id);
                if (ftypes[index]=='address'){
                    input_id = '#mce-'+fnames[index]+'-addr1';
                    f = $j(input_id).parent().parent().get(0);
                } else if (ftypes[index]=='date'){
                    input_id = '#mce-'+fnames[index]+'-month';
                    f = $j(input_id).parent().parent().get(0);
                } else {
                    input_id = '#mce-'+fnames[index];
                    f = $j().parent(input_id).get(0);
                }
                if (f){
                    $j(f).append(html);
                    $j(input_id).focus();
                } else {
                    $j('#mce-'+resp.result+'-response').show();
                    $j('#mce-'+resp.result+'-response').html(msg);
                }
            }
        } catch(e){
            $j('#mce-'+resp.result+'-response').show();
            $j('#mce-'+resp.result+'-response').html(msg);
        }
    }
}

