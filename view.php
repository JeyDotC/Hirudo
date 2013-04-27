<?php

/**
 * Prints a particular instance of hirudo
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod
 * @subpackage hirudo
 * @copyright  2011 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/lib.php');

global $USER;
global $CFG;

//Change "mod/hirudo" for whatever needed string ("mod/my_module_name", "block/my_block_name")
$CFG->hirudo_module_location = "mod/hirudo";

//Setup your context as needed...
$id = optional_param('id', 0, PARAM_INT);

if ($id) {
    $context = context_course::instance($id);
} else {
    $context = context_system::instance();
}

$PAGE->set_url("/{$CFG->hirudo_module_location}/view.php");
$PAGE->set_context($context);

$PAGE->set_pagelayout('standard');

//Call Hirudo to do the job.
require_once 'init.php';
$manager = new Hirudo\Core\ModulesManager("moodle");
$result = $manager->run();


// Output starts here
echo $OUTPUT->header();
echo $result;
echo $OUTPUT->footer();
