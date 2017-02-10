<?php

class Finance extends Display
{
    public function displayIndex()
    {
        $vars = array();


        echo $this->fetchMain('index.phtml', $vars);
    }

    public function doSaveCash()
    {

        $values = array(
            'cash'     => $_REQUEST['cash'],
            'category' => $_REQUEST['type_cash'],
            'cdate'    => $_REQUEST['cdate']
        );
        $this->object->add($values);
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

        echo $this->fetchMain('charts.phtml', $vars);
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
}