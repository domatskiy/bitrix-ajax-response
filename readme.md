# bitrix-ajax-response

## install 

```
composer require domatskiy/bitrix-ajax-response
```
## use

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

or use function 

```php
new AjaxResponse('func');
```

or use class method 

```php
new AjaxResponse('myClass@func');
```

in func

```php
func(){
 
    $result = new AjaxResponse\Result();
    $data = array();
    
    # body
    
    $result->setData($data);
    return $result;
    
    }
```