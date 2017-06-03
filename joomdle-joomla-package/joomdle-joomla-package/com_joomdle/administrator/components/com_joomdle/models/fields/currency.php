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

 
class JFormFieldCurrency extends JFormFieldList
{
        /**
        * Element name
        *
        * @access       protected
        * @var          string
        */
        public    $type = 'Currency';

        function getOptions()
        {
			$currencies = array('USD' => 'US Dollars',
				  'EUR' => 'Euros',
				  'IRR'=>'Toman',
				  'JPY' => 'Japanese Yen',
				  'GBP' => 'British Pounds',
				  'CAD' => 'Canadian Dollars',
				  'AUD' => 'Australian Dollars'
				 );

			$options = array ();
			$c = array ();
			foreach ($currencies as $val => $text)
			{
				$options[] = JHtml::_('select.option', $val, $text);
			}

			return $options;
        }
}

?>
