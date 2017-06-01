<?php 
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

defined('_JEXEC') or die('Restricted access'); ?>

<?php
$itemid = JoomdleHelperContent::getMenuItem();
?>

<table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<tr>
        <td width="90%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo JText::_('COM_JOOMDLE_PLATFORM_STATS'); ?>
        </td>
</tr>

<tr>
        <td width="60%" colspan="2">
        </td>
</tr>
<tr class="sectiontableentry">
	<td align="left">
		<b><?php echo JText::_('COM_JOOMDLE_COURSE_NUMBER'); ?>:&nbsp;</b><?php echo $this->course_no; ?>
        </td>
</tr>
<!--
<tr class="sectiontableentry">
	<td align="left">
		<b><?php //echo JText::_('COM_JOOMDLE_ENROLABLE COURSE NUMBER'); ?>:&nbsp;</b><?php //echo $this->e_course_no; ?>
        </td>
</tr>
--!>
<tr class="sectiontableentry">
	<td align="left">
		<b><?php echo JText::_('COM_JOOMDLE_STUDENTS'); ?>:&nbsp;</b><?php echo $this->student_no; ?>
        </td>
</tr>
<tr class="sectiontableentry">
	<td align="left">
		<b><?php echo JText::_('COM_JOOMDLE_SUBMISSIONS'); ?>:&nbsp;</b><?php echo $this->assignments; ?>
        </td>
</tr>
<tr class="sectiontableentry">
	<td align="left">
		<b><?php echo JText::_('COM_JOOMDLE_VISITS_LAST_WEEK'); ?>:&nbsp;</b><?php echo $this->stats[0]['stat1']; ?>
        </td>
</tr>
<tr class="sectiontableentry">
	<td align="left">
		<b><?php echo JText::_('COM_JOOMDLE_UNIQUE_VISITORS'); ?>:&nbsp;</b><?php echo $this->stats[0]['stat2']; ?>
        </td>
</tr>
<tr>
        <td width="90%" height="20" class="sectiontableheader<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo JText::_('COM_JOOMDLE_COURSE_STATS'); ?>
        </td>
</tr>

<?php
$index_url = JURI::base()."index.php";
$odd= 0;

if (is_array ($this->cursos))
foreach ($this->cursos as  $curso) :
$cat_id = $curso['cat_id'];
$course_id = $curso['remoteid'];
$cat_slug = JFilterOutput::stringURLSafe ($curso['cat_name']);
$course_slug = JFilterOutput::stringURLSafe ($curso['fullname']);
?>
<tr class="sectiontableentry<?php echo $odd + 1; ?>">
                <?php $odd++; $odd = $odd % 2; ?>
        <td height="20">
                <?php $url = JRoute::_("index.php?option=com_joomdle&view=coursestats&cat_id=$cat_id:$cat_slug&course_id=$course_id:$course_slug&Itemid=$itemid"); ?>
                <P><b><?php  echo "<a href=\"$url\">".$curso['fullname']."</a><br>"; ?></b>
        </td>
</tr>
<?php endforeach; ?>


</table>

