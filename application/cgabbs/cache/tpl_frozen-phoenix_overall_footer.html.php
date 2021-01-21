<?php if (!defined('IN_PHPBB')) exit; ?></div>

<div id="page-footer">

	<?php $this->_tpl_include('breadcrumbs_footer.html'); ?>


	<div class="footer-box">
	<div class="copyright">Design by <a href="http://www.icyphoenix.com/">Mighty Gorgon</a>
		<br /><?php echo (isset($this->_rootref['CREDIT_LINE'])) ? $this->_rootref['CREDIT_LINE'] : ''; ?>

		<?php if ($this->_rootref['TRANSLATION_INFO']) {  ?><br /><?php echo (isset($this->_rootref['TRANSLATION_INFO'])) ? $this->_rootref['TRANSLATION_INFO'] : ''; } if ($this->_rootref['DEBUG_OUTPUT']) {  ?><br /><?php echo (isset($this->_rootref['DEBUG_OUTPUT'])) ? $this->_rootref['DEBUG_OUTPUT'] : ''; } if ($this->_rootref['U_ACP']) {  ?><br /><strong><a href="<?php echo (isset($this->_rootref['U_ACP'])) ? $this->_rootref['U_ACP'] : ''; ?>"><?php echo ((isset($this->_rootref['L_ACP'])) ? $this->_rootref['L_ACP'] : ((isset($user->lang['ACP'])) ? $user->lang['ACP'] : '{ ACP }')); ?></a></strong><?php } ?>

	</div>
	</div>
</div>

</div>

<?php echo (isset($this->_tpldata['DEFINE']['.']['MG_WRAP_END'])) ? $this->_tpldata['DEFINE']['.']['MG_WRAP_END'] : ''; ?>

</div>

<div>
	<a id="bottom" name="bottom" accesskey="z"></a>
	<?php if (! $this->_rootref['S_IS_BOT']) {  echo (isset($this->_rootref['RUN_CRON_TASK'])) ? $this->_rootref['RUN_CRON_TASK'] : ''; } ?>

</div>

</body>
</html>