<?php if (!defined('IN_PHPBB')) exit; ?>Subject: 歡迎光臨「<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>」

<?php echo (isset($this->_rootref['WELCOME_MSG'])) ? $this->_rootref['WELCOME_MSG'] : ''; ?>


請妥善保留這封電子郵件。您的帳號資料如下：

----------------------------
帳號：<?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>


討論區網址：<?php echo (isset($this->_rootref['U_BOARD'])) ? $this->_rootref['U_BOARD'] : ''; ?>

----------------------------

您的密碼已被安全地存入我們的資料庫，且無法重新取得。如果您忘記了密碼，您可以使用 e-mail 與您的帳號，申請一組新的隨機密碼，再重新設定它。

感謝您的註冊。

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>