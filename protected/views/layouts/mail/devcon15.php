<? $this->beginContent('/layouts/mail'); ?>

    <table style="width: 100%;">
        <tr>
            <td>&nbsp;</td>
            <td width="700">

                <table cellpadding="0" cellspacing="0" border="0" width="700" align="left"
                       style="border: 1px solid #efefef; font-family:Segoe UI,Tahoma,Arial,Helvetica,Sans-Serif; font-size:14px;">
                    <tr>
                        <td height="140">
                            <a href="http://www.msdevcon.ru/"><img
                                    src="http://runet-id.com/img/mail/2015/devcon2015-700x140.jpg"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="10" cellspacing="10" border="0" width="100%">
                                <tr>
                                    <td style="font-size: 14px;">

                                        <?= $content; ?>

                                        <br/><br/>

                                        <p style="font-family: Segoe UI, Tahoma,Arial,Helvetica, sans-serif; font-size: 14px;">
                                            До встречи на DevCon 2015!<br/><br/>
                                            С уважением,<br/>
                                            организаторы конференции DevCon 2015<br/>
                                            _______________________________________<br/>
                                            +7 (929) 694-00-99<br/>
                                            <a href="mailto:ms@devcon2015.ru">ms@devcon2015.ru</a><br/>
                                            <a href="http://www.msdevcon.ru">www.msdevcon.ru</a><br/>
                                            <br/>
                                            #msdevcon
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="80">
                            <img src="http://runet-id.com/img/event/devcon14/email-footer.gif"/>
                        </td>
                    </tr>
                </table>

            </td>
            <td>&nbsp;</td>
        </tr>
    </table>

<?= $this->endContent(); ?>