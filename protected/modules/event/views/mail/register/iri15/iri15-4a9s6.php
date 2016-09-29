Здравствуйте&nbsp;<span style="color: rgb(153, 153, 153); font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 20px;"><?=$user->getFullName()?>&nbsp;</span>, это тестовое письмо
<?
 $salt = '71064386e1731ff1ceb2b4667ce67b8c';
    $hash = md5($user->RunetId . $salt);
?>
Ваша <a href="http://iri.runet-id.com/becomeexpert/?runetid=<?=$user->RunetId?>&hash=<?=$hash?>">ссылка</a>
