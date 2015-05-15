<!doctype html>
<html lang="en">
<head>
    <script type="text/javascript" src="/../js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="/../js/validation.js"></script>





    <meta charset="UTF-8">

    <title>Гостевая книга</title>
    <link rel="stylesheet" href="/css/bootstrap.css"/>
    <link rel="stylesheet" href="/css/style.css"/>
</head>
<body>

<script>

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
                    form.find('.empty_field').css({'border-color':'#d8512d'});
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
</script>



            <div class="form_box">
                <form action="" method="post" name="form-message" enctype='multipart/form-data' class="rf">




                    <label for="subject">Тема сообщения</label>
                    <input name="subject" type="text" class="rfield" id="subject"
                           value="<? echo $input['subject'];?>">


                    <label for="name">Ваше имя</label>
                    <input name="name" type="text" class="rfield" id="name"
                           value="<? echo $input['name'];?>">
                    <label for="message">Ваше сообщение</label>
                    <input name="message" type="text" class="rfield" id="message"
                           value="<? echo $input['message'];?>">
                    <br/>


                    <p>Введите результат: <br>
                        <img src="/captcha.php">
                        <br>
                        <input type="text" size="35" name="captcha">
                        <?
                        //check fill in captcha
                        if(!empty($_POST['captcha']))
                        {
                            //check correct fill in captcha
                            if($_SESSION['captcha'] != $_POST['captcha']) {
                                echo '<p style="font-weight: bold; color: red; font-size:13pt;  ">К сожалению,
                            вы ошились при вводе капчи.</p>' ;
                            }
                        }
                        //check successfull fill in captcha
                        if($_SESSION['captcha'] == $_POST['captcha'])
                        {
                            if(!empty($_POST['captcha']))
                            {
                                echo '<p style="font-weight: bold; color: green; font-size:13pt;  ">Капча введена верно.</p>' ;
                            }

                        }

                        ?>
                    </p>
                    Выберите файл;: <input type='file' name='filename' size='10' /><br /><br />

                    <input class="btn_submit disabled" type="submit" value="Отправить" name="button">

                </form>
            </div>






</body>
</html>