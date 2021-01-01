# A STAR WARS FORUM !

[@Mitth'raw'nuruodo](https://user.qzone.qq.com/2791794651/main) 的 『**星球大战中文社区！**』 项目 (服务端)

# 项目概述

- 项目名称：**Star-Wars-Forum-Of-China**

- 项目代号：star-wars-forum-of-china

- 产品地址：[还没有。。。]() 



**Star-Wars-Forum-Of-China** 是一个由[@Mitth'raw'nuruodo](https://user.qzone.qq.com/2791794651/main)发起的星球大战论坛项目，旨在让中国星球大战爱好者有一个更好的，功能更完善的交流平台，本项目基于**Laravel 8.12**框架搭建。

<img src="https://i.loli.net/2020/12/05/qTUaW1E7Ld9ArBI.png" style="zoom: 25%;" />

# 本项目功能和概念如下

(**特色**：第三方登录，Markdown支持，标签，话题，专栏，实时通知)

## 用户 User

_**用户**是社区的主人、社区的核心_

- 用户认证——用户登录，登出，注册，授权
- 第三方登录——QQ、微信、Github、微博登录，简化注册、登录流程
- 个人中心——个人头像，昵称，介绍等资料设置
- 个人空间——展示个人发表的内容
- 用户关注——用户可互相关注，并收到通知

## 文章 Article

_**文章**是社区用户发表的内容之一，长度较长，一般在300字以上，内容多为对某件事的议论、科普、评价..._

- 发表文章——已经注册的用户可发表文章

- Markdown编辑——文章内容使用Markdown撰写
- 文章删除、修改——作者或管理员可删除、修改文章
- 文章点赞、收藏、评论、关注——用户可点赞、收藏、评论、关注文章

## 帖子 Post

_**帖子**是社区用户发表的内容之一，比**文章**短，内容多为即兴撰写的_

- 发表帖子——用户可发表帖子
- Markdown编辑——帖子可使用Markdown撰写
- 帖子删除、修改——作者或管理员可删除、修改帖子
- 帖子点赞、关注、回复——用户可点赞、关注、回复文章

## 专栏 Column

_**专栏**为用户发表的文章的集合_

- 创建专栏——已经注册的用户可创建专栏

- 专栏点赞、订阅、评论——用户可点赞、订阅、评论专栏

## 其他

- **评论 Comments**——用户可点赞评论
- **标签 Tags**——文章、专栏的标签
- **话题 Topic**——文章的话题
- **通知 Notification**
  - 邮件通知 Mail
  - 站内实时通知 Websocket
- 定时生成活跃用户、热门文章、帖子、话题排行榜



# 运行环境要求

- Apache 2 | Nginx 1.8+
- PHP 7.3+
- Mysql 5.7+
- Redis 3.0+



# 开发环境部署/安装

本项目使用**Laravel 8.12**框架，并使用**Laravel Homestead**作为开发环境

请先安装**Laravel Homestead**环境

## 安装

### 克隆源代码

克隆`Star-Wars-Forum-Of-China`到本地

```bash
git clone git@github.com:admiral-thrawn/Star-Wars-Forum-Of-China.git
```

### 安装扩展包

```bash
composer install
```

### 配置Homestead

修改项目根目录下的`Homestead.yaml`

示例：

```yaml
ip: 192.168.10.10
memory: 2048
cpus: 2
provider: virtualbox
authorize: ~/.ssh/id_rsa.pub
keys:
  - ~/.ssh/id_rsa
folders:
  - map: /home/sidious/Documents/Code/php/starwarsforum # 你的项目根目录路径
    to: /home/vagrant/code
sites:
  - map: starwarsforum.test
    to: /home/vagrant/code/public
databases:
  - homestead

backup: true

features:
  - mysql: false
  - mariadb: false
  - postgresql: false
  - ohmyzsh: false
  - webdriver: false
name: starwarsforum
hostname: starwarsforum
```

### 生成配置文件

```bash
cp .env.example .env
```

### 根据实际修改配置文件

略。。。

### 数据库迁移

```bash
php artisan migrate
```

### 生成秘钥

```bash
php artisan key:generate
```

### 配置本地 hosts 文件

```bash
sudo echo "192.168.10.10   larabbs.test" | sudo tee -a /etc/hosts
```

- [x] 本地开发环境配置完成！

**同志，你现在可以加入 『星球大战中文社区！』 的开发了！**

# 前端项目

暂无。。。

# 其他事项

我没怎么写过正经项目，所以写的很烂，你们随便吐槽。。。



