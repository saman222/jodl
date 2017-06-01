<?php
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the Joomdle component
 */
class JoomdleViewStats extends JViewLegacy {
	function display($tpl = null) {

	$app        = JFactory::getApplication();
	$params = $app->getParams();
	$this->assignRef('params',              $params);

	$this->course_no = JoomdleHelperContent::getCoursesNo();
//	$this->e_course_no = JoomdleHelperContent::getEnrollableCoursesNo();
	$this->student_no = JoomdleHelperContent::getStudentsNo();
	$this->assignments = JoomdleHelperContent::getAssignmentsNo();
	$this->stats = JoomdleHelperContent::getLastWeekStats();
	$this->cursos = JoomdleHelperContent::getCourseList(0);


        parent::display($tpl);
    }
}
?>
