<?php

class Finance extends Display
{
    public function displayIndex()
    {
        $vars = array();
        //$this->request->post();
        $this->controller->includeJs('test.js');
        
        $content = $this->fetch('index.phtml', $vars);

        $this->display($content);
        
        return true;
    }

    public function doSaveCash()
    {
        
        //$post = $this->controller->getPost();
        //$this->getPrepareData($_POST);
        $values = array(
            'cash'     => $_POST['cash'],
            'category' => $_POST['type_cash'],
            'cdate'    => $_POST['cdate']
        );
        $this->object->add($values);
    }
    
    public function getPrepareData($data)
    {
        return $data;
    }

    public function onDisplayCharts()
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
        
        $content = $this->fetch('charts.phtml', $vars);

        $this->display($content);
    }

    public function onDisplayFinanceAjax()
    {
        $data = $this->object->get(array());
    }

    public function test($id)
    {
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