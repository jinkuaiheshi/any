<?php

/**
 * 
 * @title OneNET��������PHP Demo/OneNET Data Push PHP Demo
 * @author limao (limao777@126.com)
 * @date 2017
 */


require_once 'util.php';


/**
 * *************************************
 * һ���򵥵�ʾ����ʼ
 * A simple example begins
 * *************************************
 */

/**
 * ��һ����Ҫ��ȡHTTP body������
 * Step1, get the HTTP body's data
 */
$raw_input = file_get_contents('php://input');

/**
 * �ڶ���ֱ�ӽ���body������ǵ�һ����֤ǩ����raw_inputΪ�գ���resolveBody�����Զ��жϣ�����$_GET
 * Step2, directly to resolve the body, if it is the first time to verify the signature, the raw_input is empty, by the resolveBody method to automatically determine, it's relied on $ _GET
 */
$resolved_body = Util::resolveBody($raw_input);

/**
 * ���õ���$resolved_body�������͹��������
 * At last, var $resolved_body is the data that is pushed
 */
echo $resolved_body;
// Util::l($resolved_body);

/**
 * *************************************
 * һ���򵥵�ʾ������
 * A simple example ends
 ***************************************/