<?php
/**
* @version		
* @package		Joomdle
* @copyright		Antonio Duran Terres
* @license		GNU/GPL, see LICENSE.php
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once(JPATH_SITE.'/components/com_joomdle/helpers/content.php');
jimport( 'joomla.plugin.plugin' );

class  plgSystemJoomdlesession extends JPlugin
{

    function __construct (& $subject, $config)
    {
        parent::__construct($subject, $config);

    }

    /* Updates Moodle Session */
    function onAfterRender()
    {
        $mainframe = JFactory::getApplication();

        if($mainframe->isAdmin()) {
            return;
        }

        $logged_user = JFactory::getUser();
        $user_id = $logged_user->id;

        /* Don't update guest sessions */
        if (!$user_id)
            return;

        $reply = JoomdleHelperContent::call_method ("update_session", $logged_user->username);
    }

}
