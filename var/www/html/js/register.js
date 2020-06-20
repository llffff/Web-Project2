const REG_LOW_STRENGTH_PASS = /^[0-9]*$/;
const REG_USER = /^.{2,20}$/;
const REG_PASS = /^.{6,20}$/;
const REG_EMAIL = /^([a-z]|[A-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+((\.[a-zA-Z]{2,4}){1,2})$/;
const OK_TAG = "<span class='glyphicon glyphicon-ok-sign' ></span>";
const FALSE_TAG = " <span class='glyphicon glyphicon-remove-sign'> </span>";

function checkuser() {
  var user = document.getElementsByTagName("input")[0];
  var span = document.getElementById("usernameSpan");

  if (user.value === "") span.innerHTML = FALSE_TAG + " 请填写";
  else if (!REG_USER.test(user.value))
    span.innerHTML = " 6-20位字母、数字或下划线";
  else span.innerHTML = " " + OK_TAG;

  return REG_USER.test(user.value);
}

function checkmail() {
  var user = document.getElementsByTagName("input")[1];
  var span = document.getElementById("mailSpan");

  if (user.value === "") span.innerHTML = FALSE_TAG + " 请填写";
  else if (!REG_EMAIL.test(user.value))
    span.innerHTML = FALSE_TAG + " 6-20位字母、数字或下划线";
  else span.innerHTML = " " + OK_TAG;

  return REG_EMAIL.test(user.value);
}

function checkpassword1() {
  var user = document.getElementsByTagName("input")[2];
  var span = document.getElementById("password1Span");

  //空
  if (user.value === "") span.innerHTML = FALSE_TAG + " 请填写";
  //不合格
  else if (!REG_PASS.test(user.value))
    span.innerHTML = FALSE_TAG + " 6-20位字母、数字或下划线";
  //合格但不好
  else if (REG_LOW_STRENGTH_PASS.test(user.value))
  span.innerHTML = FALSE_TAG + " 弱密码：不能全为数字";
  //ok
  else if (REG_PASS.test(user.value)) span.innerHTML = " " + OK_TAG;

  checkpassword2();
  return !REG_LOW_STRENGTH_PASS.test(user.value) && REG_PASS.test(user.value);
}

function checkpassword2() {
  var user1 = document.getElementsByTagName("input")[2];
  var user2 = document.getElementsByTagName("input")[3];
  var span = document.getElementById("password2Span");

  if (user2.value === "") span.innerHTML = FALSE_TAG + " 请填写";
  else if (user1.value !== user2.value) span.innerHTML = FALSE_TAG + " 不一致";
  else span.innerHTML = " " + OK_TAG;

  return user1.value === user2.value;
}

var int1 = 0;
var int2 = 0;
function createCode() {
  var codeSpan = document.getElementById("codeSpan");

  int1 = Math.floor(Math.random() * 100);
  int2 = Math.floor(Math.random() * 100);

  var str = " " + int1 + " + " + int2 + " = ? 点击重新生成验证码";
  codeSpan.innerText = str;
}

function checkCode() {
  var code = document.getElementById("code");
  var result = int1 + int2;
  return code.value == result;
}

function checkSubmit() {
  checkuser();
  checkmail();
  checkpassword1();
  checkpassword2();
  checkCode();

  return (
    checkuser() &&
    checkmail() &&
    checkpassword1() &&
    checkpassword2() &&
    checkCode()
  );
}

var form1 = document.getElementById("register-form");

form1.onsubmit = function () {
  console.log("checkuser is "+checkuser());
  console.log("checkmail is "+checkmail());
  console.log("checkpassword1 is "+checkpassword1());
  console.log("checkpassword2 is "+checkpassword2());
  console.log("checkCode is "+checkCode());

  return checkSubmit();
};
