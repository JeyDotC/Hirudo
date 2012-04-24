<?php

/**
 * «Copyright 2012 Jeysson José Guevara Mendivil(JeyDotC)» 
 * 
 * This file is part of Hirudo.
 * 
 * Hirudo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 *  Hirudo is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with Hirudo.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Hirudo\Core\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of BeforeTaskEventListener
 *
 * @author JeyDotC
 */
abstract class BeforeTaskEventListener implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(BeforeTaskEvent::NAME => "onBeforeTask");
    }

    //A wrapper function for future cool stuff.
    public function onBeforeTask(BeforeTaskEvent $e) {
        $this->beforeTask($e);
    }

    protected abstract function beforeTask(BeforeTaskEvent $e);
}

?>
