```
My finance
```

Module:
Установить layout
```php
$this->setLayout('new layout');
```

Вызвать метод из шаблонов
```php
<?php $this->widget->Finance('footer'); ?>
<?php $this->widget->show('Finance', 'footer'); ?>
```