# 设计文档
姓名：李菲菲<br>
学号：18307110500
github地址：https://github.com/llffff/Web-Project2

### 项目完成情况
   #### 主要页面
   <hr>
   主页 
   
   `登录前显示登录按钮；登陆后显示个人中心+登出` `刷新显示随机图片`
   
   浏览
   
   `标题筛选：支持首字母匹配筛选`
   `多级筛选：国家-城市-内容筛选`
   `热门：上传数目最多，可根据国家、城市、内容点击选择`
   
   `分页的实现：上一页、下一页，首页、尾页，第1-5页`
    
   搜索
   
   `标题/描述的模糊筛选`
   `分页`
   
   <br>
   登录
   
   `哈希加盐`
   `用户名或密码有误提醒`
   
   注册
   
   `必须输入，否则进行提醒`
   `全是数字的弱密码不合法` 
   `验证码` 
   
   `若用户名已存在，注册失败`
   `若注册成功，弹出窗口确认用户名，密码和id，转到登录界面`
     
   
   #### 个人中心：
   <hr>
   我的图片
   
   `展示user的上传图片`
   `可以修改和删去`
   
   我的收藏
   
   `展示喜欢的图片`
   `可以删去`
   
   上传（和修改）
   
   `上传：无设置$_GET['iid']，所有信息为必填` 
   `修改：设置了$_GET['iid']，照片不可修改，其余可修改` 
   
   `上传/修改完成，提交后跳转到对应detail页面`
   
   #### 对数据库travels的修改
   
   1. 对表traveluser增加salt属性，用于储存注册时生成的盐值，并在每次登录时读取用于解码
    `Salt varchar(6) AUTO_INCREMENT` `使用attention-RUNONLYONCE-encode_db_pass.php将已有的明文密码加密，生成并写入salt`
    
   2. 对travelimage的imageID改为auto increment，自增
   
  
 ### bonus：
   
1. 密码加盐 

   `注册时密码哈希加盐`
   `登录时解码确认比对`
   
2. 部署服务器

   `（无域名）`
   `服务器系统：Ubuntu 18.04`
   `PHP版本：PHP7.0`
   
   `公网ip:120.78.151.169`
   
   
## pj2 意见和建议

1. 部署服务器太难了
