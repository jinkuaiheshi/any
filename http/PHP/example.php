<?php

/**
 * 
 * @title OneNETÊý¾ÝÍÆËÍPHP Demo/OneNET Data Push PHP Demo
 * @author limao (limao777@126.com)
 * @date 2017
 */


require_once 'util.php';


/**
 * *************************************
 * Ò»¸ö¼òµ¥µÄÊ¾Àý¿ªÊ¼
 * A simple example begins
 * *************************************
 */

/**
 * µÚÒ»²½ÐèÒª»ñÈ¡HTTP bodyµÄÊý¾Ý
 * Step1, get the HTTP body's data
 */
$raw_input = file_get_contents('php://input');

/**
 * µÚ¶þ²½Ö±½Ó½âÎöbody£¬Èç¹ûÊÇµÚÒ»´ÎÑéÖ¤Ç©ÃûÔòraw_inputÎª¿Õ£¬ÓÉresolveBody·½·¨×Ô¶¯ÅÐ¶Ï£¬ÒÀÀµ$_GET
 * Step2, directly to resolve the body, if it is the first time to verify the signature, the raw_input is empty, by the resolveBody method to automatically determine, it's relied on $ _GET
 */
$resolved_body = Util::resolveBody($raw_input);

/**
 * ×îºóµÃµ½µÄ$resolved_body¾ÍÊÇÍÆËÍ¹ýºóµÄÊý¾Ý
 * At last, var $resolved_body is the data that is pushed
 */

 //Util::l($resolved_body);

 echo $resolved_body;

/**
 * *************************************
 * Ò»¸ö¼òµ¥µÄÊ¾Àý½áÊø
 * A simple example ends
 ***************************************/