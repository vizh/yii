<?php $this->beginContent('/layouts/mail') ?>

    <table style="width: 100%;">
        <tr>
            <td>&nbsp;</td>
            <td width="700">

                <table cellpadding="0" cellspacing="0" border="0" width="700" align="left"
                       style="border: 1px solid #efefef; font-family:Segoe UI,Tahoma,Arial,Helvetica,Sans-Serif; font-size:14px;">
                    <tr>
                        <td height="140">
                            <a href="http://www.msdevcon.ru/" mc:disable-tracking><img
                                    src="http://runet-id.com/img/mail/2016/devcon2016-700x140.jpg"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="10" cellspacing="10" border="0" width="100%">
                                <tr>
                                    <td style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">
                                        <p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;"><strong>Здравствуйте, <?=$this->mail->getUser()->getShortName();?>!</strong></p>
                                        <?=$content;?>

                                        <p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">С уважением,<br/>
                                        Организаторы конференции DevCon 2016<br/>
                                        <a href="http://www.msdevcon.ru" mc:disable-tracking>www.msdevcon.ru</a><br/>
                                        <a href="https://twitter.com/search/?q=%23msdevcon&amp;src=typd">#msdevcon</a><br/>
                                        <a href="mailto:v-devcon@microsoft.com" mc:disable-tracking>v-devcon@microsoft.com</a><br/>
                                        +7 (926) 37-37-320<br/>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="80">
                            <img src="http://runet-id.com/img/event/devcon16/email-footer.gif"/>
                        </td>
                    </tr>
                </table>

            </td>
            <td>&nbsp;</td>
        </tr>
    </table>

<?= $this->endContent(); ?>