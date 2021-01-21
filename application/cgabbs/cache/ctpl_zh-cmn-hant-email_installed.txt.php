<?php if (!defined('IN_PHPBB')) exit; ?>Subject: phpBB 安裝成功

恭喜您！

您已經成功的在主機上安裝了 phpBB。

這封電子郵件包含有關您安裝的重要資訊，請妥善保管以供參考。您的密碼已被安全地存入我們的資料庫，且無法重新取得。如果您忘記了密碼，您可以使用 e-mail 與您的帳號，申請一組新的隨機密碼，再重新設定它。

----------------------------
帳號：<?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>


討論區網址：<?php echo (isset($this->_rootref['U_BOARD'])) ? $this->_rootref['U_BOARD'] : ''; ?>

----------------------------

您可以在 /docs/ 資料夾和 phpBB.com 的支援網頁 (https://www.phpbb.com/support/) 中找到與 phpBB 軟體相關的有用資訊。

為了確保討論區的安全可靠，我們高度建議您保持目前的軟體釋出版本。為了您的方便，加入在此網頁上面之郵寄名單是有用的。

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>