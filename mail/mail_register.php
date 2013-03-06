<body style="background: #442712">
    <table width="100%" align="center" height="100%" cellspacing="1px" cellpadding="0" style="font-family: sans-serif;font-size:14px;  background: #442712; margin:0; padding:0;">
        <tr>
            <td>&nbsp;</td>
            <td width="450">
                <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:15px; margin-bottom: 15px;">
                    <tr>
                        <td align="center"><a href="#"><img width="110px" height="100px" src="https://dl.dropbox.com/u/37804451/logo.png" alt=""></a></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="15px" style="background: white; margin-top:20px; padding-top: 15px; -webkit-border-radius:10px; -moz-border-radius:10px; border-radius:10px;">
                                <tr>
                                    <td><h1 style="margin-bottom: 0px">Регистрация</h1></td>
                                </tr>    
                                <tr>
                                    <td>
                                        <p>Привет, <?php echo $user_name; ?>!</p>
                                        <p>Ваш адрес электронной почты был указан при регистрации в интернет-магазине <a style="color:#bb1d1d; text-decoration:none;" href="http://thecheesecake.ru">The Moscow Cheesecake</a>.</p>
                                        <p>Все зарегистрированные пользователи получают скидку в размере 5% сразу после оформения первого заказа.</p>
										<?php if (isset($_SESSION['new_user'])) { ?>
                                        <p>Для того, чтобы вам не пришлось вводить адрес доставки в следующий раз, мы сохранили его в вашем личном кабинете. Пароль от него — <span class="bold">5 последних цифр вашего телефонного номера</span>. Вы всегда можете его <a href="http://exarium.ru/profile/">изменить в личном кабинете.</a></p>
                                        <?php } ?>
                                        <p>Спасибо, что выбрали наши чизкейки.</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>
