<?php

namespace KitchenSink\Modules\CrudModule\ViewModels;

use UIExtensions\Annotations\HiddenField;
use UIExtensions\Html\ViewModel;
use UIExtensions\Annotations\DisplayName;

/**
 * Description of BarViewModel
 *
 * @author JeyDotC
 */
class BarViewModel extends ViewModel{

    /**
     *
     * @var string
     * 
     * @DisplayName("Bar Name")
     */
    public $name;

}

?>
