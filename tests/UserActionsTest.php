<?php

namespace Domatskiy\Tests;

use Domatskiy\AjaxResponse;

class UserActionsTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
 
    }
    public function tearDown()
    {
        
    }

    public function test()
    {
        new AjaxResponse(function (){

            });


        new AjaxResponse(function (){
            return null;
            });

        new AjaxResponse('call');
        new AjaxResponse(__CLASS__.'@testMethod');

    }

    public static function testMethod(){}

}

function call(){}