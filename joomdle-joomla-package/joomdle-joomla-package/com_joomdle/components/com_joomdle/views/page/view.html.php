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
class JoomdleViewPage extends JViewLegacy {
	function display($tpl = null) {
	global $mainframe;

	$app                = JFactory::getApplication();
	$pathway =$app->getPathWay();
	$menus      = $app->getMenu();
	$menu  = $menus->getActive();

	$params = $app->getParams();
	$this->assignRef('params',              $params);

	$course_id = $app->input->get('course_id');
	if (!$course_id)
    {
        echo JText::_('COM_JOOMDLE_NO_COURSE_SELECTED');
        return;
    }

	$id = $app->input->get('page_id');
	$id = (int) $id;

	if (!$id)
    {
        echo JText::_('COM_JOOMDLE_NO_PAGE_SELECTED');
        return;
    }


    $user = JFactory::getUser();
    $username = $user->username;
    $this->course_info = JoomdleHelperContent::getCourseInfo($course_id, $username);

    if ((!$this->course_info['enroled']) && (!$this->course_info['guest']))
        return;

	$this->page = JoomdleHelperContent::call_method ( 'get_page', (int) $id);

	/* pathway */
        $cat_slug = $this->course_info['cat_id'].":".$this->course_info['cat_name'];
        $course_slug = $this->course_info['remoteid'].":".$this->course_info['fullname'];

        if(is_object($menu) && $menu->query['view'] != 'topics') {
                        $pathway->addItem($this->course_info['cat_name'], 'index.php?view=coursecategory&cat_id='.$cat_slug);
                        $pathway->addItem($this->course_info['fullname'], 'index.php?view=detail&cat_id='.$cat_slug.'&course_id='.$course_slug);
                        $pathway->addItem(JText::_('COM_JOOMDLE_COURSE_CONTENTS'), 'index.php?view=course&cat_id='.$cat_slug.'&course_id='.$course_slug);
                        $pathway->addItem($this->page['name'], '');
                }


		$document = JFactory::getDocument();
        $document->setTitle($this->course_info['fullname'] . ': ' . $this->page['name']);

        parent::display($tpl);
    }
}
?>
