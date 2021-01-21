<?php if (!defined('IN_PHPBB')) exit; ?>Subject: 帳號已經啟用

親愛的 <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?> 您好：

您在「<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>」 申請的會員帳號已經被管理員啟用了，您現在可以登入。

您的密碼已被安全地存入我們的資料庫，且無法重新取得。如果您忘記了密碼，您可以使用 e-mail 與您的帳號，申請一組新的隨機密碼，再重新設定它。

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>