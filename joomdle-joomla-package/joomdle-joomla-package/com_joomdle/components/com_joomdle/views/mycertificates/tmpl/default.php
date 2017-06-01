<?php 
/**
  * @package      Joomdle
  * @copyright    Qontori Pte Ltd
  * @license      http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
  */

defined('_JEXEC') or die('Restricted access'); ?>

<?php
$simple = '';
if ($this->cert_type == 'simple')
	$simple = 'simple';
?>
<div class="joomdle-mycertificates<?php echo $this->pageclass_sfx;?>">
    <?php if ($this->params->get('show_page_heading', 1)) : ?>
    <h1>
    <?php echo $this->escape($this->params->get('page_heading')); ?>
    </h1>
    <?php endif; ?>


    <div class="joomdle_mycertificates">
    <ul>
    <?php
    if (is_array ($this->my_certificates))
        foreach ($this->my_certificates as $cert) :  ?>
            <li>
                <?php
					$id = $cert['id'];
					if ($this->cert_type == 'custom')
						$redirect_url = $this->moodle_url."/mod/${simple}customcert/view.php?id=$id&action=download";
					else
						$redirect_url = $this->moodle_url."/mod/${simple}certificate/view.php?id=$id&certificate=1&action=review";
				?>
				<span>
					<a target='_blank' href="<?php echo $redirect_url; ?>"><?php echo $cert['name']; ?></a>
					<?php if ($this->show_send_certificate) : ?>
						<a href="index.php?option=com_joomdle&view=sendcert&tmpl=component&cert_type=<?php echo $this->cert_type; ?>&cert_id=<?php echo $id; ?>" onclick="window.open(this.href,'win2','width=400,height=350,menubar=yes,resizable=yes'); return false;" title="Email"><img alt="Email" src="media/system/images/emailButton.png"></a>
				<?php endif; ?>
				</span>
			</li>
        <?php endforeach; ?>
    </ul>
    </div>
</div>
