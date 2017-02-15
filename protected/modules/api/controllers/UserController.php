<?php

use nastradamus39\slate\annotations\ApiController;
use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\ApiContent;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\ApiObject;

/**
 * @ApiContent(
 *     title="Общие параметры",
 *     description="
<b>Общие параметры для всех методов</b>
Language – переключение языка приложения и его ответов в “ru” или “en”. По-умолчанию, значение устанавливается в 'ru'."
 * )
 * @ApiController(
 *     controller="User",
 *     title="Пользователи",
 *     description="Загрузка данных пользователя. Работа с пользователями."
 * )
 * @ApiObject(
 *     code="USER",
 *     title="Пользователь",
 *     json="{'RocId':454,'RunetId':454,'LastName':'Борзов','FirstName':'Максим','FatherName':'','CreationTime':'2007-05-25 19:29:22','Visible':true,'Verified':true,'Gender':'male','Photo':{'Small':'http://runet-id.dev/files/photo/0/454_50.jpg?t=1475191745','Medium':'http://runet-id.dev/files/photo/0/454_90.jpg?t=1475191306','Large':'http://runet-id.dev/files/photo/0/454_200.jpg?t=1475191317'},'Attributes':{},'Work':{'Position':'Генеральный директор','Company':{'Id':77529,'Name':'RUVENTS'},'StartYear':2014,'StartMonth':4,'EndYear':null,'EndMonth':null},'Status':{'RoleId':1,'RoleName':'Участник','RoleTitle':'Участник','UpdateTime':'2012-04-18 12:06:49','TicketUrl':'http://runet-id.dev/ticket/rif12/454/7448b8c03688bf317a7506f41/','Registered':false},'Email':'max.borzov@gmail.com','Phone':'79637654577','PhoneFormatted':'8 (963) 765-45-77','Phones':['89637654577','79637654577']}",
 *     description="Объект пользователя.",
 *     params={"Id":"Айди пользователя", "Name":"Имя пользователя"}
 * )
 */
class UserController extends \api\components\Controller
{

}