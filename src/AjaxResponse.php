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
        $request = null;

        try{

            if($use_old_api)
            {
                if(!array_key_exists('ajax', $_REQUEST) || $_REQUEST['ajax'] !== 'Y')
                    throw new \Exception('Not correct request');
            }
            else
            {
                /**
                 * @var \Bitrix\Main\Context\HttpRequest
                 */
                $request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();

                if(!$request->isAjaxRequest())
                    throw new \Exception('Not correct request [D7]');
            }

            # callback
            if($callback instanceof \Closure)
            {
                $result = $callback($request);
            }
            elseif(is_string($callback))
            {
                if(strpos($callback, '@') !== false)
                {
                    $callback = explode('@', $callback);

                    if(count($callback) !== 2)
                        throw new \Exception('not correct callback with @: '.$callback);
                }

                $result = call_user_func($callback, $request);
            }
            else
                throw new \Exception('not correct callback');

            if($result === null)
                $result = new Result();

            if(!($result instanceof Result))
                throw new \Exception('need return null or \Domatskiy\AjaxResponse\Result');

        } catch (\Exception $e){

            #\CHTTP::SetStatus('500');

            $result = new Result();
            $result->setError($e->getMessage(), $e->getCode());
            #$result->setResponseCode(500);
        }

        global $APPLICATION;
        $APPLICATION->RestartBuffer();

        if($result->isSuccess())
        {
            if($use_old_api)
                echo json_encode($result->getData(), JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT);
            else
                echo \Bitrix\Main\Web\Json::encode($result->getData());
        }
        else
        {
            //header('version: 1.2', false);
            \CHTTP::SetStatus($result->getResponseCode());

            if($use_old_api)
                echo json_encode($result->getErrors(), JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT);
            else
                echo \Bitrix\Main\Web\Json::encode($result->getErrors());
        }

        die();
    }

    function __destruct()
    {

    }

}