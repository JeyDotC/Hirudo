<?php

namespace KitchenSink\Modules\CrudModule\ViewModels;

use UIExtensions\Annotations\HiddenField;
use UIExtensions\Annotations\LongText;
use UIExtensions\Html\ViewModel;

/**
 * Description of FooViewModel
 *
 * @author JeyDotC
 */
class FooViewModel extends ViewModel {

    /**
     *
     * @var int
     * @HiddenField
     */
    public $id;

    /**
     *
     * @var string
     * @LongText
     */
    public $description;

    /**
     *
     * @var KitchenSink\Modules\CrudModule\ViewModels\BarViewModel
     */
    public $bar;
    
    function __construct() {
        $this->bar = new BarViewModel();
    }

}

?>
