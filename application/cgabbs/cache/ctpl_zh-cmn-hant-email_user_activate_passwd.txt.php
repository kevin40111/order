<?php if (!defined('IN_PHPBB')) exit; ?>Subject: 新密碼啟用

親愛的 <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?> 您好：

您會收到這個通知是因為您 (或者有人假裝是您) 在「<?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?>」為您的帳號申請一個新的密碼。如果您沒有提出申請，那麼請忽略這個通知；如果您一直收到類似的通知，那麼請聯絡討論區管理員。

要使用新的密碼必須啟用它。要啟用它，請點選以下連結。

<?php echo (isset($this->_rootref['U_ACTIVATE'])) ? $this->_rootref['U_ACTIVATE'] : ''; ?>


如果啟用成功，那麼您得使用以下的密碼登入討論區：

密碼： <?php echo (isset($this->_rootref['PASSWORD'])) ? $this->_rootref['PASSWORD'] : ''; ?>


當然，您可以經由個人資料頁面去更改這個密碼。如果您有任何的困難，那麼請聯絡討論區管理員。

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>