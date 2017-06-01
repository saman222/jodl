<?php
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */
 
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
require_once(JPATH_SITE.'/components/com_joomdle/helpers/content.php');

JFormHelper::loadFieldClass('list');

 
class JFormFieldCourseList extends JFormFieldList
{
        /**
        * Element name
        *
        * @access       protected
        * @var          string
        */
        public    $type = 'CourseList';

        function getOptions()
        {
			$courses = JoomdleHelperContent::getCourseList (0);

			$options = array ();
			$c = array ();
			foreach ($courses as $course)
			{
				$val = $course['remoteid'];
				$text = $course['fullname'];
				$options[] = JHtml::_('select.option', $val, $text);
			}

			return $options;
        }
}

?>
