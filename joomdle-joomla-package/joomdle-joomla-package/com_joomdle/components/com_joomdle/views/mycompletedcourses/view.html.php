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
class JoomdleViewMycompletedcourses extends JViewLegacy {
	function display($tpl = null) {
	global $mainframe;

	$app        = JFactory::getApplication();
    $params = $app->getParams();
    $this->assignRef('params',              $params);


	$group_by_category = $params->get( 'group_by_category' );

	$user = JFactory::getUser();
	$username = $user->username;
	$this->my_courses = JoomdleHelperContent::call_method('my_completed_courses', $username);

	$this->jump_url =  JoomdleHelperContent::getJumpURL ();

	$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

	$this->_prepareDocument();

	if ($this->my_courses)
		parent::display($tpl);
    }

	protected function _prepareDocument()
    {
        $app    = JFactory::getApplication();
        $menus  = $app->getMenu();
        $title  = null;

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if ($menu)
        {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_JOOMDLE_MY_COMPLETED_COURSES'));
        }
    }

}
?>
