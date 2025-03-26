# ToC for Memoo

一个博客文章目录插件，自动为文章生成 ToC 目录，添加返回顶部按钮，只在 [Memoo](https://memoo.online/) 主题上测试了。

## 功能特点

### 文章目录

- 自动检测并解析文章中的标题（h2-h6）
- 动态生成文章目录，支持多层级结构
- 滚动时自动高亮当前位置
- 平滑滚动
- 移动端显示优化

### 返回顶部

- 滚动页面时自动显示/隐藏（仅当页面向下滚动超过一定距离时显示）
- 点击后平滑滚动回到页面顶部

## 安装使用

1. 将 `post-sidebar.php` 文件上传到 `Memoo` 主题目录中
2. 更改 `post.php` 文件中第 34 行：

   ```php
   <!-- 将 34 行 -->
   <?php $this->need('sidebar.php'); ?>

   <!-- 改为以下 -->
   <?php $this->need('post-sidebar.php'); ?>
   ```

4. 保存并刷新

## 兼容性

- 兼容现代浏览器
- 响应式设计
- iOS 底部操作条优化适配

## 更新日志

### v1.1.0

- 添加返回顶部按钮
  - 按钮显示/隐藏的平滑过渡效果
  - 优化按钮位置
- 改进移动端适配
  - 调整按钮间距和位置
  - 适配 iOS 底部操作条
- 优化代码结构

### v1.0.0

- 发布

## 开源协议

本项目使用 MIT 协议开源，详情请参阅 [LICENSE](LICENSE) 文件。
