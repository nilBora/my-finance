<?php 

class FinanceApi extends RestAPI
{
    public function testAPI(Response &$response)
    {
        $response->content = 'TestAPI';
    }
    
}
