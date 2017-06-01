<?php 

/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

defined('_JEXEC') or die('Restricted access'); 
require_once(JPATH_SITE.'/components/com_joomdle/helpers/content.php');
$itemid = JoomdleHelperContent::getMenuItem();

$user = JFactory::getUser();
$id = $user->get('id');
$username = $user->get('username');

$cursos = JoomdleHelperContent::call_method ("get_my_courses_grades", $username);


?>
<div class="joomdle-gradelist<?php echo $this->pageclass_sfx;?>">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
    <h1>
    <?php echo $this->escape($this->params->get('page_heading')); ?>
    </h1>
    <?php endif; ?>



<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<tr>
        <td width="80%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo JText::_('COM_JOOMDLE_COURSE'); ?>
	</td>
        <td height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>"  align="center">
		<?php echo JText::_('COM_JOOMDLE_AVERAGE_GRADE'); ?>
	</td>
</tr>
<?php
/* Para cada curso, mostramos la nota media de sus tareas */
$odd = 0;
foreach ($cursos as  $curso) :

$course_id = $curso['id'];
$cat_id = $curso['cat_id'];
$cat_slug = JFilterOutput::stringURLSafe ($curso['cat_name']);
$course_slug = JFilterOutput::stringURLSafe ($curso['fullname']);
?>
<tr class="sectiontableentry<?php echo $odd + 1; ?>">
        <td width="80%" height="20">
		<?php $url = JRoute::_("index.php?option=com_joomdle&view=coursegrades&cat_id=$cat_id:$cat_slug&course_id=$course_id:$course_slug&Itemid=$itemid"); ?>
		<P><b><?php  echo "<a href=\"$url\">".$curso['fullname']."</a><br>"; ?></b>
        </td>
        <td width="30" height="20" align="center">
                <?php 
				printf ("%.2f", $curso['avg']); 
		?>
        </td>
</tr>
<?php 
$odd++; $odd = $odd % 2; 
endforeach; //Cursos ?>

</table>
</div>
