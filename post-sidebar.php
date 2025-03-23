<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="col-sm-12 col-md-4" id="secondary" role="complementary">
  <!-- 文章目录 - 初始隐藏状态 -->
  <section
    class="widget"
    id="toc-widget"
    style="opacity: 0; transition: opacity 0.3s ease; display: none"
  >
    <h3 class="widget-title"><?php _e('文章目录'); ?></h3>
    <div id="toc-container" class="widget-list">
      <!-- 目录通过JS动态生成 -->
    </div>
  </section>

  <!-- 移动端侧边目录 -->
  <div id="mobile-toc-button" class="mobile-only">
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="24"
      height="24"
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
    >
      <line x1="3" y1="6" x2="20" y2="6"></line>
      <line x1="3" y1="12" x2="12" y2="12"></line>
      <line x1="3" y1="18" x2="16" y2="18"></line>
    </svg>
  </div>

  <div id="mobile-toc-overlay" class="mobile-only">
    <div id="mobile-toc-sidebar">
      <div id="mobile-toc-header">
        <h3>文章目录</h3>
        <button id="mobile-toc-close">×</button>
      </div>
      <div id="mobile-toc-container">
        <!-- 内容通过JS动态填充 -->
      </div>
    </div>
  </div>

  <style>
    /* 桌面端目录样式 */
    #toc-widget {
      position: sticky;
      top: 20px;
      max-height: 80vh;
      overflow-y: auto;
      margin-bottom: 20px;
      scrollbar-width: thin;
      z-index: 100;
      background: #fff;
      border: 1px solid #f0f0f0;
      border-radius: 3px;
      padding: 5px 10px;
      scroll-behavior: smooth;
    }

    #toc-widget .widget-title {
      border-bottom: 1px solid #f0f0f0;
      padding-bottom: 8px;
      margin-bottom: 10px;
      padding-left: 5px;
    }

    /* 美化滚动条 */
    #toc-widget::-webkit-scrollbar,
    #mobile-toc-container::-webkit-scrollbar {
      width: 4px;
    }

    #toc-widget::-webkit-scrollbar-track,
    #mobile-toc-container::-webkit-scrollbar-track {
      background: #f9f9f9;
    }

    #toc-widget::-webkit-scrollbar-thumb,
    #mobile-toc-container::-webkit-scrollbar-thumb {
      background: #e0e0e0;
      border-radius: 3px;
    }

    #toc-widget::-webkit-scrollbar-thumb:hover,
    #mobile-toc-container::-webkit-scrollbar-thumb:hover {
      background: #d0d0d0;
    }

    #toc-container ul,
    #mobile-toc-container ul {
      padding-left: 0;
      list-style-type: none;
      margin: 0;
    }

    #toc-container li,
    #mobile-toc-container li {
      margin-bottom: 6px;
      line-height: 1.4;
    }

    #toc-container a,
    #mobile-toc-container a {
      text-decoration: none;
      color: #555;
      display: block;
      border-left: 2px solid transparent;
      padding: 2px 0 2px 10px;
      transition: all 0.2s ease;
      word-wrap: break-word;
      overflow-wrap: break-word;
      border-bottom: none !important;
    }

    #toc-container a:hover,
    #mobile-toc-container a:hover {
      color: #000;
      background-color: #f9f9f9;
      border-bottom: none !important;
    }

    #toc-container .toc-h2,
    #mobile-toc-container .toc-h2 {
      padding-left: 5px;
      font-weight: 500;
    }

    #toc-container .toc-h3,
    #mobile-toc-container .toc-h3 {
      padding-left: 20px;
      font-size: 0.95em;
    }

    #toc-container .toc-h4,
    #mobile-toc-container .toc-h4 {
      padding-left: 35px;
      font-size: 0.9em;
    }

    #toc-container .toc-h5,
    #mobile-toc-container .toc-h5 {
      padding-left: 50px;
      font-size: 0.85em;
    }

    #toc-container .toc-h6,
    #mobile-toc-container .toc-h6 {
      padding-left: 65px;
      font-size: 0.8em;
    }

    #toc-container .toc-active,
    #mobile-toc-container .toc-active {
      font-weight: bold;
      color: #3273dc;
      border-left-color: #3273dc;
      background-color: #f9f9f9;
      border-bottom: none !important;
    }

    /* 移动端特有样式 */
    .mobile-only {
      display: none;
    }

    /* 移动端按钮优化 - 针对不同屏幕大小调整位置 */
    #mobile-toc-button {
      position: fixed;
      width: 45px;
      height: 45px;
      background-color: rgba(50, 115, 220, 0.85);
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 900;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      /* 默认距离底部 20px */
      right: 15px;
      bottom: 20px;
    }

    #mobile-toc-overlay {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1000;
      display: none;
      -webkit-overflow-scrolling: touch;
      /* 添加 iOS 平滑滚动支持 */
    }

    #mobile-toc-sidebar {
      position: absolute;
      top: 0;
      right: 0;
      width: 60%;
      /* 调整宽度为 60% */
      height: 100%;
      background: white;
      box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
      transform: translateX(100%);
      transition: transform 0.3s ease;
      display: flex;
      flex-direction: column;
      /* 使用弹性布局确保内容区可滚动 */
    }

    #mobile-toc-overlay.active #mobile-toc-sidebar {
      transform: translateX(0);
    }

    #mobile-toc-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 15px;
      border-bottom: 1px solid #f0f0f0;
      flex-shrink: 0;
      /* 防止头部被压缩 */
    }

    #mobile-toc-header h3 {
      margin: 0;
      font-size: 18px;
    }

    #mobile-toc-close {
      border: none;
      background: none;
      font-size: 24px;
      cursor: pointer;
      color: #555;
      padding: 0 5px;
    }

    #mobile-toc-container {
      flex-grow: 1;
      /* 填充剩余空间 */
      overflow-y: auto;
      /* 启用滚动 */
      padding: 15px;
      padding-bottom: 15px;
      /* 底部空间减小 */
      scroll-behavior: smooth;
      -webkit-overflow-scrolling: touch;
      /* iOS 滚动优化 */
    }

    /* 添加底部占位元素 */
    /* #mobile-toc-container::after {
            content: "";
            display: block;
            height: 20px;
        } */

    /* 移动端适配 - 针对不同屏幕尺寸调整按钮位置 */
    @media (max-width: 768px) {
      #secondary {
        /* 在移动端隐藏侧边栏的目录组件 */
        display: block;
      }

      #toc-widget {
        /* 在移动端隐藏原有目录 */
        display: none !important;
      }

      .mobile-only {
        display: block;
      }

      /* 确保移动端可滚动 */
      body.toc-open {
        overflow: hidden;
        /* 防止背景滚动 */
      }

      /* 按钮位置统一为距底部 20px */
      #mobile-toc-button {
        right: 15px;
        bottom: 20px;
      }
    }

    /* 针对 < 375 */
    @media (max-width: 375px) {
      #mobile-toc-button {
        right: 12px;
        bottom: 20px;
        width: 40px;
        height: 40px;
      }
    }

    /* 针对 400-768 */
    @media (min-width: 400px) and (max-width: 768px) {
      #mobile-toc-button {
        right: 18px;
        bottom: 20px;
      }
    }

    /* 针对 600-768 */
    @media (min-width: 600px) and (max-width: 768px) {
      #mobile-toc-button {
        right: 20px;
        bottom: 20px;
        width: 50px;
        height: 50px;
      }
    }

    /* 适配带底部操作条 */
    @media (max-width: 768px) and (min-height: 800px) {
      #mobile-toc-button {
        bottom: 25px;
        /* 带有底部操作条的设备稍微调高一点 */
      }
    }

    /* 确保桌面端不显示移动端元素 */
    @media (min-width: 769px) {
      .mobile-only {
        display: none !important;
      }
    }
  </style>

  <script>
    // 提前注入执行，减少闪烁
    (function () {
      // 添加用户滚动标志变量
      let userScrollingToc = false;
      let userScrollTimeout;

      // 优化 ID 生成逻辑，处理连续连字符问题
      function generateIdFromText(text) {
        // 更完善的 ID 生成方式
        const processed = text
          .trim()
          // 先替换点号和空格为连字符
          .replace(/[\.\s]+/g, "-")
          // 保留数字、字母、中文、连字符
          .replace(/[^\w\u4e00-\u9fa5\-]/g, "")
          // 将连续的连字符替换为单个连字符
          .replace(/\-{2,}/g, "-")
          // 去除开头和结尾的连字符
          .replace(/^-+|-+$/g, "")
          .toLowerCase();

        return processed || "section"; // 确保返回有效 ID
      }

      // 确保 ID 唯一性
      const usedIds = {};

      function getUniqueId(baseId) {
        if (!usedIds[baseId]) {
          usedIds[baseId] = 1;
          return baseId;
        }
        const newId = baseId + "-" + usedIds[baseId];
        usedIds[baseId]++;
        return newId;
      }

      // 检查是否为移动设备
      function isMobileDevice() {
        return window.innerWidth <= 768;
      }

      // 动态调整按钮位置
      function adjustButtonPosition() {
        const button = document.getElementById("mobile-toc-button");
        if (!button) return;

        // 获取设备信息
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const hasHomeIndicator = isIOS && window.innerHeight >= 800;

        // 计算基础底部距离
        let bottomPosition = 20; // 基础值设为 20px

        // 如果有底部操作条，稍微调高
        if (hasHomeIndicator) {
          bottomPosition += 5;
        }

        // 应用计算后的位置
        button.style.bottom = bottomPosition + "px";
      }

      // 存储目录是否已创建的标记
      let tocCreated = false;
      let mobileTocCreated = false;

      function initTOC() {
        // 获取文章内容区域
        const articleContent = document.querySelector(".post-content");
        const tocWidget = document.getElementById("toc-widget");
        const mobileTocContainer = document.getElementById("mobile-toc-container");
        const mobileTocButton = document.getElementById("mobile-toc-button");
        const mobileTocOverlay = document.getElementById("mobile-toc-overlay");
        const mobileTocClose = document.getElementById("mobile-toc-close");

        const isMobile = isMobileDevice();

        if (!articleContent) return;

        // 调整按钮位置
        if (isMobile) {
          adjustButtonPosition();
        }

        // 获取所有标题
        const headings = articleContent.querySelectorAll("h1, h2, h3, h4, h5, h6");

        if (headings.length <= 1) {
          // 没有足够的标题，隐藏所有目录元素
          if (tocWidget) tocWidget.style.display = "none";
          if (mobileTocButton) mobileTocButton.style.display = "none";
          return;
        }

        // 检查是否都是同一级别标题
        let headingTypes = new Set();
        headings.forEach((h) => headingTypes.add(h.tagName));
        if (headingTypes.size === 1 && headings.length < 3) {
          // 不满足目录显示条件，隐藏所有目录元素
          if (tocWidget) tocWidget.style.display = "none";
          if (mobileTocButton) mobileTocButton.style.display = "none";
          return;
        }

        // 创建目录内容函数
        function createTocContent(container, forceRecreate = false) {
          if (!container) return;

          // 检查是否需要重新创建
          if (container.querySelector("ul") && !forceRecreate) {
            return {
              tocList: container.querySelector("ul"),
              headingToLinkMap: new Map(), // 返回空映射防止错误
            };
          }

          // 清空容器，防止重复创建
          container.innerHTML = "";

          const tocList = document.createElement("ul");
          container.appendChild(tocList);

          // 创建标题到目录项的映射
          const headingToLinkMap = new Map();

          // 为每个标题设置 ID
          headings.forEach(function (heading, index) {
            // 优先使用现有 ID
            if (!heading.id) {
              // 从标题文本直接生成 ID
              const headingText = heading.textContent;
              const baseId = generateIdFromText(headingText);
              heading.id = getUniqueId(baseId);
            }

            const listItem = document.createElement("li");
            const link = document.createElement("a");
            link.href = "#" + heading.id;
            link.textContent = heading.textContent;
            link.className = "toc-" + heading.tagName.toLowerCase();
            link.setAttribute("data-target-id", heading.id);

            // 存储标题与目录项的映射关系
            headingToLinkMap.set(heading, link);

            listItem.appendChild(link);
            tocList.appendChild(listItem);

            // 点击目录项的处理 - 优化响应速度
            link.addEventListener("click", function (e) {
              e.preventDefault();
              const targetId = this.getAttribute("data-target-id");
              const targetElement = document.getElementById(targetId);

              if (targetElement) {
                // 区分移动端和桌面端处理
                if (isMobile && mobileTocOverlay) {
                  // 移动端：先关闭侧边栏，再滚动
                  closeMobileToc();

                  // 等待侧边栏关闭动画完成后再滚动
                  setTimeout(() => {
                    targetElement.scrollIntoView({
                      behavior: "smooth",
                    });
                    history.pushState(null, null, "#" + targetId);
                  }, 300);
                } else {
                  // 桌面端：立即滚动，不需要延迟
                  targetElement.scrollIntoView({
                    behavior: "smooth",
                  });
                  history.pushState(null, null, "#" + targetId);
                }
              }
            });
          });

          // 添加鼠标滚轮和触摸事件检测
          if (container) {
            // 监听鼠标滚轮事件
            container.addEventListener("wheel", function () {
              userScrollingToc = true;
              clearTimeout(userScrollTimeout);
              userScrollTimeout = setTimeout(() => {
                userScrollingToc = false;
              }, 1500); // 用户停止滚动 1.5 秒后恢复自动滚动
            });

            // 监听触摸事件（移动设备）
            container.addEventListener("touchstart", function () {
              userScrollingToc = true;
            });

            container.addEventListener("touchend", function () {
              clearTimeout(userScrollTimeout);
              userScrollTimeout = setTimeout(() => {
                userScrollingToc = false;
              }, 1500); // 用户停止触摸 1.5 秒后恢复自动滚动
            });
          }

          return {
            tocList,
            headingToLinkMap,
          };
        }

        // 初始化桌面端目录
        if (tocWidget && !isMobile && !tocCreated) {
          const tocContainer = document.getElementById("toc-container");
          const { tocList, headingToLinkMap } = createTocContent(tocContainer);
          tocCreated = true;

          // 显示桌面端目录
          tocWidget.style.display = "block";
          setTimeout(() => {
            tocWidget.style.opacity = "1";
          }, 10);

          // 滚动监听，高亮当前阅读位置
          function updateActiveHeading() {
            const scrollPosition = window.scrollY;

            // 寻找视窗范围内的标题，优先选择最接近顶部的那个
            let closestHeading = null;
            let closestDistance = Number.MAX_SAFE_INTEGER;

            headings.forEach((heading) => {
              const distance = Math.abs(heading.getBoundingClientRect().top);
              if (distance < closestDistance && heading.getBoundingClientRect().top <= 150) {
                closestHeading = heading;
                closestDistance = distance;
              }
            });

            if (closestHeading) {
              // 移除所有当前激活状态
              tocContainer
                .querySelectorAll("a")
                .forEach((link) => link.classList.remove("toc-active"));

              // 获取对应的链接并激活
              const activeLink = headingToLinkMap.get(closestHeading);
              if (activeLink) {
                activeLink.classList.add("toc-active");

                // 仅在用户没有手动滚动时自动滚动目录
                if (!userScrollingToc) {
                  // 平滑滚动到当前激活的目录项
                  const activeLinkRect = activeLink.getBoundingClientRect();
                  const tocWidgetRect = tocWidget.getBoundingClientRect();

                  // 计算目标位置 - 将激活项放在容器中间
                  const activeLinkTop =
                    activeLinkRect.top - tocWidgetRect.top + tocWidget.scrollTop;
                  const middlePosition =
                    activeLinkTop - tocWidgetRect.height / 2 + activeLinkRect.height / 2;

                  // 如果目标不在可视区域内，则平滑滚动
                  if (
                    activeLinkRect.bottom > tocWidgetRect.bottom ||
                    activeLinkRect.top < tocWidgetRect.top
                  ) {
                    // 使用平滑滚动 API
                    tocWidget.scrollTo({
                      top: middlePosition,
                      behavior: "smooth",
                    });
                  }
                }
              }
            }
          }

          // 初始更新和滚动时更新
          updateActiveHeading();
          window.addEventListener("scroll", updateActiveHeading);
        }

        // 定义移动端目录关闭函数
        function closeMobileToc() {
          if (mobileTocOverlay) {
            mobileTocOverlay.classList.remove("active");
            document.body.classList.remove("toc-open");
            setTimeout(() => {
              mobileTocOverlay.style.display = "none";
            }, 300);
          }
        }

        // 初始化移动端目录
        if (mobileTocButton) {
          if (isMobile) {
            // 确保移动端按钮可见
            mobileTocButton.style.display = "flex";

            if (!mobileTocCreated && mobileTocContainer) {
              createTocContent(mobileTocContainer, true);
              mobileTocCreated = true;
            }

            // 设置移动端目录按钮事件
            if (mobileTocOverlay) {
              mobileTocButton.addEventListener("click", function () {
                mobileTocOverlay.style.display = "block";
                document.body.classList.add("toc-open");
                // 使用延迟添加类来触发过渡动画
                setTimeout(() => {
                  mobileTocOverlay.classList.add("active");
                }, 10);
              });

              // 关闭按钮事件
              if (mobileTocClose) {
                mobileTocClose.addEventListener("click", closeMobileToc);
              }

              // 点击遮罩区域也可以关闭
              mobileTocOverlay.addEventListener("click", function (e) {
                if (e.target === mobileTocOverlay) {
                  closeMobileToc();
                }
              });
            }
          } else {
            // 在桌面端确保按钮隐藏
            mobileTocButton.style.display = "none";
            if (mobileTocOverlay) {
              mobileTocOverlay.style.display = "none";
            }
          }
        }
      }

      // 尽早初始化 TOC
      if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initTOC);
      } else {
        initTOC();
      }

      // 监听窗口大小和方向变化
      window.addEventListener("resize", function () {
        // 使用节流函数来限制调用频率
        clearTimeout(window.resizeTimer);
        window.resizeTimer = setTimeout(function () {
          const wasMobile = window.innerWidth <= 768;
          // 调整按钮位置
          adjustButtonPosition();

          initTOC();
          const isMobile = window.innerWidth <= 768;

          // 如果从移动端切换到桌面端，或从桌面端切换到移动端，重置标记
          if (wasMobile !== isMobile) {
            tocCreated = false;
            mobileTocCreated = false;
            initTOC();
          }
        }, 250);
      });

      // 监听设备方向变化事件
      window.addEventListener("orientationchange", function () {
        // 方向改变后稍等一下，让系统完成布局调整
        setTimeout(adjustButtonPosition, 300);
      });
    })();
  </script>
</div>
<!-- end #sidebar -->
