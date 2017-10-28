<?php

namespace Domatskiy;

use Domatskiy\AjaxResponse\Result;

class AjaxResponse
{
    protected $action = null;
    protected $data = null;


    /**
     * @var \Domatskiy\AjaxResponse
     */

    function __construct($callback, $use_old_api)
    {
        
        try{

            $request = null;

            if($use_old_api)
            {

                if($_REQUEST['ajax']!=='Y')
                {
                    \CHTTP::SetStatus('500');
                    echo 'Not correct request';
                    die();
                }
                else
                {
                    /**
                     * @var \Bitrix\Main\Context\HttpRequest
                     */
                    $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

                    if(!$request->isAjaxRequest())
                    {
                        \CHTTP::SetStatus('500');
                        echo 'Not correct request';
                        die();
                    }
                }
            }


            if($callback instanceof \Closure)
            {
                $result = $callback($request);
            }
            elseif(is_string($callback))
            {
                if(strpos($callback, '@'))
                    $callback = explode('@', $callback);

                $result = call_user_func($callback, $request);
            }
            else
                throw new \Exception('not correct callback');

            if($result === null)
                $result = new Result();

            if(!($result instanceof Result))
                throw new \Exception('need return null or \Domatskiy\AjaxResponse\Result');

        }catch (\Exception $e){

            $result = new Result();
            $result->setError($e->getMessage(), $e->getCode());
            #$result->setResponseCode(500);
        }

        global $APPLICATION;
        $APPLICATION->RestartBuffer();

        if($result->isSuccess())
        {
            if($use_old_api)
                json_encode($result->getData());
            else
                echo \Bitrix\Main\Web\Json::encode($result->getData());
        }
        else
        {
            //header('version: 1.2', false);
            \CHTTP::SetStatus($result->getResponseCode());

            if($use_old_api)
                json_encode($result->getErrors());
            else
                echo \Bitrix\Main\Web\Json::encode($result->getErrors());
        }

        die();
    }

    function __destruct()
    {

    }

}