<?php

class Finance extends Display
{
    /**
     * @Response type Response::TYPE_NORMAL
     * @Response action Response::ACTION_REDIRECT
     */
    public function displayIndex(Response &$response)
    {
        $vars = array();
      
        $this->controller->includeStatic('test.js');
        
        //$content = $this->fetch('index.phtml', $vars);
        $response->content = $this->fetch('index.phtml', $vars);
        //$this->display($content);
        
        return true;
    }

    public function doSaveCash()
    {
        $fields = array(
            'cash' => array(
                'type'     => 'text',
                'required' => true
            ),
            'type_cash' => array(
                'type'     => 'text',
                'required' => true
            ),
            'cdate' => array(
                'type'     => 'text',
                'required' => true
            ),
        );
        
        $data = $this->getPreparedData($_POST, $fields, $errors);
        
        if ($errors) {
            throw new Exception('Error in POST params');
        }
        
        $values = array(
            'cash'     => $data['cash'],
            'category' => $data['type_cash'],
            'cdate'    => $data['cdate']
        );
        
        $this->object->add($values);
        
        $this->controller->redirect('/');
        
        return true;
    }

    public function onDisplayCharts(Response &$response)
    {
        $finance = $this->object->getByDate(array());

        $finance = json_encode($finance);

        $financeBar = $this->object->get(array());
        $financeBarNew = array();
        foreach ($financeBar as $item) {
            $financeBarNew[$item['cdate']][] = $item;    
        }
        
        $financeDonut = $this->object->getByCategory(array());
        
        $vars = array(
            'finance'    => $finance,
            'financeBar' => json_encode($financeBarNew),
            'financeDonut' => json_encode($financeDonut)
        );
        
        $response->content = $this->fetch('charts.phtml', $vars);

        //$this->display($content);
    }

    public function onDisplayFinanceAjax()
    {
        $data = $this->object->get(array());
    }

    public function test(Response &$response, $id)
    {
        $this->fragment = true;
        echo $id;
        echo 1;
    }
    
    public function testAdmin()
    {
        echo 'Admin';
    }
    
    public function footer()
    {
        echo 'footer';
    }
}