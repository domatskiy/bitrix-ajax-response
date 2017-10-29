# bitrix-ajax-response

## Установка

```
composer require domatskiy/bitrix-ajax-response
```
## использование Closure

```php
    new AjaxResponse(function(){
        
        ... 
        
        });
```

## использование метода класса
```php
    new AjaxResponse('class@method');
```

## Использование старого bitrix api
Важно: в запросе нужно передавать поле 'ajax' со значением 'Y'

```php
    new AjaxResponse('class@method', true);
```

## Пример
```php
define("STOP_STATISTICS", true);
define('NO_AGENT_CHECK', true);
define("STATISTIC_SKIP_ACTIVITY_CHECK", true);
 
use Domatskiy\AjaxResponse;
 
# подключаем bitrix
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
 
if(class_exists('\Domatskiy\AjaxResponse')){
 
    new AjaxResponse(function(){
     
        $result = new AjaxResponse\Result();
        $data = array();
         
        # body
         
        $result->setData($data);
        return $result;
         
        });
    
    }
```