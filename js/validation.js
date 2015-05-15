
(function( $ ){

    $(function() {

        $('.rf').each(function(){
            var form = $(this),
                btn = form.find('.btn_submit');

            form.find('.rfield').addClass('empty_field');


            //function check input fields
            function checkInput(){
                form.find('.rfield').each(function(){
                    if($(this).val() != ''){
                        $(this).removeClass('empty_field');
                    } else {
                        $(this).addClass('empty_field');
                    }
                });
            }


            //function glow didn't fill fields
            function lightEmpty(){
                form.find('.empty_field').css({'border-color':'#4cae4c'});
                setTimeout(function(){
                    form.find('.empty_field').removeAttr('style');
                },500);
            }

            setInterval(function(){
                checkInput();
                var sizeEmpty = form.find('.empty_field').size();
                if(sizeEmpty > 0){
                    if(btn.hasClass('disabled')){
                        return false
                    } else {
                        btn.addClass('disabled')
                    }
                } else {
                    btn.removeClass('disabled')
                }
            },500);

            btn.click(function(){
                if($(this).hasClass('disabled')){
                    lightEmpty();
                    return false
                } else {
                    form.submit();
                }
            });

        });

    });

})( jQuery );