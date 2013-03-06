<body style="background: #442712">
    <table width="100%" align="center" height="100%" cellspacing="1px" cellpadding="0" style="font-family: sans-serif;font-size:14px;  background: #442712; margin:0; padding:0;">
        <tr>
            <td>&nbsp;</td>
            <td width="450">
                <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:15px; margin-bottom: 15px;">
                    <tr>
                        <td align="center"><a href="#"><img width="110px" height="100px" src="http://thecheesecake.ru/images/logo.png" alt=""></a></td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellspacing="0" cellpadding="15px" style="background: white; margin-top:20px; padding-top: 15px; -webkit-border-radius:10px; -moz-border-radius:10px; border-radius:10px;">
                                <tr>
                                    <td><h1 style="margin-bottom: 0px">Новый пароль</h1></td>
                                </tr>    
                                <tr>
                                    <td>
                                        <p>Привет, <?php echo $user_name; ?>!</p>
                                        <p>Вы (или кто-то еще) запросили изменение пароля доступа к личному кабинету интернет-магазина <a style="color:#bb1d1d; text-decoration:none;" href="http://thecheesecake.ru">The Moscow Cheesecake</a>.</p>
                                        <p>Для получения нового пароля перейдите по <a style="color:#bb1d1d; text-decoration:none;" href="http://thecheesecake.ru/profile/forgot/?hash=<?php echo $url_hash; ?>">этой ссылке</a>. Ссылка действительна в течение 24 часов.</p>
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
