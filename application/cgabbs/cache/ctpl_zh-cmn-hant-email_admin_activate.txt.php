<?php if (!defined('IN_PHPBB')) exit; ?>Subject: 啟用會員帳號

您好：

目前這個會員帳號「<?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>」已經被移除或是剛被建立，您必須要檢查這個會員的相關資料並做出適當的決定。

您可以點選下列連結檢視會員的個人資料：
<?php echo (isset($this->_rootref['U_USER_DETAILS'])) ? $this->_rootref['U_USER_DETAILS'] : ''; ?>


您可以點選下列連結直接啟用會員的帳號：
<?php echo (isset($this->_rootref['U_ACTIVATE'])) ? $this->_rootref['U_ACTIVATE'] : ''; ?>



<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>