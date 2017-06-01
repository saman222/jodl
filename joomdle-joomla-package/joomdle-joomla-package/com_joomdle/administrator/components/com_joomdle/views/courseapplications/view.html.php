<?php
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

// no direct access
defined('_JEXEC') or die('Restricted access');
// Import Joomla! libraries
jimport( 'joomla.application.component.view');
require_once( JPATH_COMPONENT.'/helpers/content.php' );
require_once( JPATH_COMPONENT.'/helpers/mappings.php' );
require_once( JPATH_COMPONENT.'/helpers/applications.php' );

class JoomdleViewCourseapplications extends JViewLegacy {
    function display($tpl = null) {

		$cursos = JoomdleHelperContent::getCourseList ();
		$i = 0;
		$c = array ();
		foreach ($cursos as $curso)
		{
				$c[$i] = new JObject ();
				$c[$i]->id = $curso['remoteid'];
				$c[$i]->fullname = $curso['fullname'];
				$i++;
		}

		$this->courses = $c;

        $this->addToolbar();
        $this->sidebar = JHtmlSidebar::render();

		$this->course_id = JFactory::getApplication()->input->get('course_id');

        parent::display($tpl);
    }

    protected function addToolbar()
    {
        JToolbarHelper::title(JText::_('COM_JOOMDLE_VIEW_COURSE_APPLICATIONS_TITLE'), 'courseapplications');

        JHtmlSidebar::setAction('index.php?option=com_joomdle&view=courseapplications');
    }


}
?>
