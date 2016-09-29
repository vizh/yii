<?$this->beginContent('/layouts/mail')?>

    <table style="width: 100%;">
        <tr>
            <td>&nbsp;</td>
            <td width="700">

                <table cellpadding="0" cellspacing="0" border="0" width="700" align="left"
                       style="border: 1px solid #efefef; font-family:Segoe UI,Tahoma,Arial,Helvetica,Sans-Serif; font-size:14px;">
                    <tr>
                        <td height="140">
                            <a href="http://events.techdays.ru/msdevtour/"><img width="700"
                                                                                src="http://runet-id.com/img/mail/2015/msdevtour.png"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="10" cellspacing="10" border="0" width="100%">
                                <tr>
                                    <td style="font-size: 14px;">

                                        <?=$content?>

                                        <br/><br/>

                                        <p style="font-family: Segoe UI, Tahoma,Arial, Helvetica, sans-serif; font-size: 14px;">
                                            <br/>
                                            С уважением,<br/>
                                            Команда организаторов конференции Microsoft Developer Tour<br/>
                                            ----------------------<br/>
                                            <a href="http://events.techdays.ru/msdevtour/">msdevtour.ru</a>
                                            <br/>
                                            <a href="https://twitter.com/search?f=realtime&q=%23msdevtour%20&src=typd">#msdevtour</a>
                                            <br/>

                                        </p>
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

<?=$this->endContent()?>