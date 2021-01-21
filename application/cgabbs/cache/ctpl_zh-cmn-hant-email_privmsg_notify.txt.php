<?php if (!defined('IN_PHPBB')) exit; ?>Subject: 新的私人訊息已經送達

親愛的 <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?> 您好：

您在「<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>」的帳號收到了來自「<?php echo (isset($this->_rootref['AUTHOR_NAME'])) ? $this->_rootref['AUTHOR_NAME'] : ''; ?>」新的私人訊息，其標題如下：

<?php echo (isset($this->_rootref['SUBJECT'])) ? $this->_rootref['SUBJECT'] : ''; ?>


您可以點選下面的連結檢視您的新訊息：

<?php echo (isset($this->_rootref['U_VIEW_MESSAGE'])) ? $this->_rootref['U_VIEW_MESSAGE'] : ''; ?>


您已經申請討論區在這類事件中通知您，記得您可以在個人資料設定中關閉它而不再收到這類的通知。

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>