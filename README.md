# PHP_MySQL_application
<ul>
  <li>本會員管理系統使用XAMPP(包含Apache、MySQL等的整合式網頁伺服器安裝包)</li>
  <li>XAMPP可至網路免費下載，可自行建構簡易的個人資料庫在本機裡</li>
  <li>安裝完成後，須設定MySQL的root密碼，才能以phpMyAdmin進入資料庫管理畫面</li>
  <li>本系統為php表單結合資料庫的應用</li>
</ul>
如下操作安裝同名資料庫，以順利執行本系統:
<ol>
  <li>從phpMyAdmin登入至MySQL</li>
  <li>新增使用者108321015(密碼: pwd1015),並產生同名之資料庫108321015</li>
  <li><ul>
      <li>帳號: "使用文字方塊:" 108321015</li>
      <li>主機名稱： 選"本機" (localhost)</li>
      <li>勾選 "建立與使用者同名的資料庫並授予所有權限。"</li>
    </ul>
  </li> 
  <li>於108321015 database新增一資料表 member:(可直接以匯入member.sql取代)</li>
  <li>
    <ul>
      <li>ID : tinyint(3) primary AUTO_INCREMENT</li>
      <li>Username : varchar(20) utf8mb4_unicode_ci</li>
      <li>Password : varchar(255) utf8mb4_unicode_ci</li>
      <li>Sex : enum('男', '女') utf8mb4_unicode_ci 預設:男</li>
      <li>Birthday : date 空值勾選</li>
      <li>Phone : varchar(50) utf8mb4_unicode_ci 空值勾選</li>
      <li>Mail : varchar(100) utf8mb4_unicode_ci </li>
      <li>Interest : set('鉛筆畫', '色鉛筆畫', '油畫', '水彩畫') utf8mb4_unicode_ci 預設:鉛筆畫</li>
      <li>CourseType : enum('線上課程','實體互動') utf8mb4_unicode_ci 預設:線上課程</li>
    </ul>
  </li>
  <li>介面操作從 01login.html開始</li>
  <li>本系統缺失:帳號名稱為case insensitive</li>
</ol>
