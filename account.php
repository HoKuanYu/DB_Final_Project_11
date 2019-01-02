<!DOCTYPE html>
<html>
<head>
  <link href="css/account.css" rel="stylesheet" type="text/css" />
  <link href="css/slick/slick-theme.css" rel="stylesheet" type="text/css" />
  <link href="css/slick/slick.css" rel="stylesheet" type="text/css" />
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script type="text/javascript" src="js/slick.min.js"></script>

  <meta charset = "utf-8">
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
  <title></title>
</head>
<script type="text/javascript">
  var another_items_count=10
  var books_items_count=10
  var img_src="src/Books.jpg";
  var book_slick_img="src/test.jpg";
  var name="邱吉";
  var address="你心中";
  var condition="販售中";
  var category_count=7;
  $(document).ready(function(){
  
  for(var i=0;i<another_items_count;i++){
    $( ".c_bottom" ).append( "<a href=''><img src="+img_src+"></a>");
     }
     $('.c_bottom').slick({
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 3
    });
   
   for(var i=0;i<category_count;i++){
      $(".category_items").append("<input class='category_button' id = '"+i+"' type = 'button' value = ''>");
     }
  
});
</script>
  <body>
    <?php
      require_once "dbconnect.php"; //更嚴謹，需要確實加入此PHP  
  ?>
    <div class="main">
      <div class="top">
        <div class="title"> 
              <div class="titlename">Book</div>
              <div class="titlesquare">hub</div>
        </div>
        <div class="none">
          
        </div>
        <div class="user">
          <div class="account">hi, willchiu</div>
          <div class="account_b">
            <input id = "signIn" type = "button" value = "signIn">
            <input id = "logIn" type = "button" value = "logIn">
          </div> 
        </div>
      </div>
      <div class="center">
        <div class="c_left">
          <div class="category_title">新增</div>
          <div class="category_items">
            
          </div>
        </div>
        <div class="c_center">
          <div class="c_form">
            <h2>Account Management</h2>
            <span class="subtitle">update your account</span>
            <form action = "" method = "post" id="inputForm"> 
                <input class="creat" type = "text" name = "account_ID" id = "account_ID" placeholder="帳號(長度介於6到12個字元)">
              
                <input class="creat" type = "password" name = "password" id = "password" placeholder="密碼(長度介於6到12個字元)">
               
                <input class="creat" type = "password" name = "password2" id = "password2" placeholder="再次輸入密碼">
              
                <input class="creat" type = "text" name = "user_name" id="user_name" placeholder="使用者名稱(長度為25字元以內)">
                 
                <input class="creat" type = "text" name = "phoneNum" id="phoneNum" placeholder="電話號碼(長度為10, e.g. 0912345678)">

                <select class="drop_down city" id='city' name="city"> 
                <?php
                  $query = ("SELECT DISTINCT city FROM school;");
                  $stmt = $db->prepare($query);
                  $error = $stmt->execute(); 
                  $result = $stmt->fetchAll();
                  $citycount=0;
                  foreach ($result as $rows) {
                    $name[$citycount] = $rows['city'];
                    echo "<option id='idx".$citycount."'>".$rows['city']."</option>";
                    $citycount++;
                  }
                ?>
              </select>
              
              <select class="drop_down" id='school_name' name="school_name"></select><br>

              <select class="drop_down" id='department' name="department"></select><br>

              <input class="submit" type="submit" name = "btnsubmit" value = "Save">

              <!-- <span class="or">&nbsp;&nbsp;&nbsp;&nbsp;Or&nbsp;&nbsp;</span>

              <a class="login" href="login.php">Log In</a> -->
            </form>
            <script type="text/javascript" src="js/changeSelect.js" charset="utf-8"></script>
            <?php
              function signUp($db) {//傳入$db即不用宣告
                $account_ID = $_POST['account_ID'];
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                $user_name = $_POST['user_name'];
                $phoneNum = $_POST['phoneNum'];
                $city = $_POST['city'];
                $school_name = $_POST['school_name'];
                $department = $_POST['department'];
                $account_IDLength = strlen($account_ID);
                $passwordLength = strlen($password);

                $isWrong = 0;
                $isAccountWrong = 0;
                $isPasswordWrong = 0;
                $isPassword2Wrong = 0;
                $isPhoneNumWrong = 0;
                $isUserNameWrong = 0;
                if($account_IDLength < 6 || $account_IDLength > 12){              
                  echo "<script>document.getElementById('account_ID').className += ' wrongMessage';</script>";
                  $isWrong = 1;
                  $isAccountWrong = 1;
                }
                else {//判斷是否已存在帳號       
                  $id = $account_ID;
                  $query = ("SELECT account_ID FROM users WHERE account_ID=?");
                  $stmt = $db->prepare($query);
                  $error = $stmt->execute(array($id));
                  $result = $stmt->fetchALl();
                  if(count($result) > 0){
                    echo "<script>document.getElementById('account_ID').placeholder = '帳號已存在(帳號介於6到12個字元)';</script>";
                    echo "<script>document.getElementById('account_ID').className += ' wrongMessage';</script>";
                    $isWrong = 1;
                    $isAccountWrong = 1;
                  }
                }
                //echo "<script>console.log(".strcmp($_POST['password'], $_POST['password2']).");</script>";
                if($passwordLength < 6 || $passwordLength > 12){
                  echo "<script>document.getElementById('password').className += ' wrongMessage';</script>";
                  echo "<script>document.getElementById('password2').className += ' wrongMessage';</script>";
                  $isWrong = 1;
                  $isPasswordWrong = 1;
                  $isPassword2Wrong = 1;
                }
                else if(strcmp($_POST['password'], $_POST['password2']) != 0) {
                  echo "<script>document.getElementById('password2').className += ' wrongMessage';</script>";
                  $isWrong = 1;
                  $isPassword2Wrong = 1;
                }
                if(!(is_numeric($phoneNum) && strlen($phoneNum) == 10)){
                  echo "<script>document.getElementById('phoneNum').className += ' wrongMessage';</script>";
                  $isWrong = 1;
                  $isPhoneNumWrong = 1;
                }
                if(strlen($user_name) == 0) {
                  echo "<script>document.getElementById('user_name').placeholder = '使用者名稱不得為空(長度為25字元以內)';</script>";
                  echo "<script>document.getElementById('user_name').className += ' wrongMessage';</script>";
                  $isWrong = 1;
                  $isUserNameWrong = 1;
                }
                else if (strlen($user_name) >= 25) {
                  echo "<script>document.getElementById('user_name').className += ' wrongMessage';</script>";
                  $isWrong = 1;
                  $isUserNameWrong = 1;
                }
                if($isWrong == 0){//新增使用者
                  $query = ("INSERT INTO users VALUES(?,?,?,?,?,?,?)");
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute(array($account_ID, $password, $user_name, $phoneNum, $school_name, $city, $department));
                  $db = null;
                  echo "<script>document.getElementsByTagName('body')[0].style.color = 'white';</script>";
                  //$str = "註冊成功!三秒後到登入頁面。<?php header('Refresh:3; url=index.php');
                  echo "<script>document.getElementsByTagName('body')[0].innerHTML = '註冊成功!三秒後到登入頁面。';setTimeout(function() {document.location.href='login.php';}, 3000);</script>";
                }
                else {//回填已輸入的值
                  if ($isUserNameWrong == 0) {
                    echo "<script>document.getElementsByName('user_name')[0].value='".$user_name."';</script>";
                  }
                  if ($isAccountWrong == 0) {
                    echo "<script>document.getElementsByName('account_ID')[0].value='".$account_ID."';</script>";
                  }
                  if ($isPasswordWrong == 0) {
                    echo "<script>document.getElementsByName('password')[0].value='".$password."';</script>";
                  }
                  if ($isPassword2Wrong == 0) {
                    echo "<script>document.getElementsByName('password2')[0].value='".$password2."';</script>";
                  }
                  if ($isPhoneNumWrong == 0) {
                    echo "<script>document.getElementsByName('phoneNum')[0].value='".$phoneNum."';</script>";
                  }
                  echo "<script>document.getElementsByName('city')[0].value='".$city."';</script>";
                  echo "<script>setSchoolName('".$city."','".$school_name."','".$department."');</script>";
                }
              }
              if(isset($_POST["btnsubmit"])) {      
                signUp($db);
              }
              else {
                echo "<script>$('#city').change();</script>";
              }
            ?>
          </div>
        </div>
        <div class="c_right">
          <button class="ad_b" type="button"><img src="大頭.jpg"></button>
          <button class="ad_b" type="button"><img src=""></button>
        </div>
      </div>
    </div>
    <div class="bottom"></div>
  </body>
</html>