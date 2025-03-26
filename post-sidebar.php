<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div class="col-sm-12 col-md-4" id="secondary" role="complementary">
    <!-- 文章目录 -->
    <section class="widget" id="toc-widget" style="opacity: 0; transition: opacity 0.3s ease; display: none;">
        <h3 class="widget-title"><?php _e('文章目录'); ?></h3>
        <div id="toc-container" class="widget-list">
        </div>
    </section>

    <!-- 移动端侧边目录 -->
    <div id="mobile-toc-button" class="mobile-only" style="display: none;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="6" x2="20" y2="6"></line>
            <line x1="3" y1="12" x2="12" y2="12"></line>
            <line x1="3" y1="18" x2="16" y2="18"></line>
        </svg>
    </div>

    <!-- 返回顶部按钮 -->
    <div id="back-to-top" class="back-to-top-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </div>

    <div id="mobile-toc-overlay" class="mobile-only">
        <div id="mobile-toc-sidebar">
            <div id="mobile-toc-header">
                <h3>文章目录</h3>
                <button id="mobile-toc-close">×</button>
            </div>
            <div id="mobile-toc-container">
            </div>
        </div>
    </div>

    <style>
        /* 桌面端目录 */
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

        /* 滚动条 */
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

        /* 初始化 CSS 变量用于按钮定位 */
        :root {
            --button-bottom-position: 20px;
        }

        /* 按钮共享样式 */
        .back-to-top-button,
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
            transition: opacity 0.3s ease, transform 0.3s ease;
            /* 避免重绘 */
            transform: translateZ(0);
            will-change: transform;
            /* 减少闪烁和抖动 */
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        /* 返回顶部按钮 */
        .back-to-top-button {
            right: 15px;
            bottom: calc(var(--button-bottom-position) + 60px);
            /* 使用 CSS 变量保持相对位置关系 */
            opacity: 0;
            transform: translateY(20px) translateZ(0);
            pointer-events: none;
        }

        .back-to-top-button.show {
            opacity: 1;
            transform: translateY(0) translateZ(0);
            pointer-events: auto;
            /* 显示时可点击 */
        }

        /* 目录按钮特定样式 */
        #mobile-toc-button {
            /* 默认距离底部 20px */
            right: 15px;
            bottom: 20px;
            /* 添加 transform 属性确保按钮位置稳定 */
            transform: translateZ(0);
            /* 减少位移问题 */
            will-change: transform;
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

        /* 小屏幕 */
        @media (max-width: 375px) {

            #mobile-toc-button,
            .back-to-top-button {
                right: 12px;
                width: 40px;
                height: 40px;
            }

            #mobile-toc-button {
                bottom: 20px;
            }

            .back-to-top-button {
                bottom: 70px;
                /* 调整间距 */
            }
        }

        /* 中屏幕 */
        @media (min-width: 400px) and (max-width: 768px) {

            #mobile-toc-button,
            .back-to-top-button {
                right: 18px;
            }

            #mobile-toc-button {
                bottom: 20px;
            }

            .back-to-top-button {
                bottom: 80px;
            }
        }

        /* 大屏幕 */
        @media (min-width: 600px) and (max-width: 768px) {

            #mobile-toc-button,
            .back-to-top-button {
                right: 20px;
                width: 50px;
                height: 50px;
            }

            #mobile-toc-button {
                bottom: 20px;
            }

            .back-to-top-button {
                bottom: 85px;
            }
        }

        /* 底部操作条 */
        @media (max-width: 768px) and (min-height: 800px) {
            #mobile-toc-button {
                bottom: 25px;
            }

            .back-to-top-button {
                bottom: 85px;
            }
        }

        /* 桌面端 */
        @media (min-width: 769px) {
            .mobile-only {
                display: none !important;
            }

            /* 桌面端返回顶部按钮放在目录容器区域内 */
            .back-to-top-button {
                position: fixed;
                right: auto; /* 不固定在页面右侧 */
                left: auto; /* 不固定在页面左侧 */
                bottom: 3em; /* 与footer上内边距对齐 */
            }
            
            /* 确保桌面端的toc-widget有一致的左边距，便于对齐 */
            #toc-widget {
                margin-left: 0;
            }
        }
    </style>

    <script>
        // 初始化函数
        (function() {
            // 滚动标志
            let userScrollingToc = false;
            let userScrollTimeout;

            // ID 生成
            function generateIdFromText(text) {
                const processed = text.trim()
                    // 先替换点号和空格为连字符
                    .replace(/[\.\s]+/g, '-')
                    // 保留数字、字母、中文、连字符
                    .replace(/[^\w\u4e00-\u9fa5\-]/g, '')
                    // 将连续的连字符替换为单个连字符
                    .replace(/\-{2,}/g, '-')
                    // 去除开头和结尾的连字符
                    .replace(/^-+|-+$/g, '')
                    .toLowerCase();

                return processed || 'section'; // 确保返回有效 ID
            }

            // ID 唯一性
            const usedIds = {};

            function getUniqueId(baseId) {
                if (!usedIds[baseId]) {
                    usedIds[baseId] = 1;
                    return baseId;
                }
                const newId = baseId + '-' + usedIds[baseId];
                usedIds[baseId]++;
                return newId;
            }

            // 检查移动设备
            function isMobileDevice() {
                return window.innerWidth <= 768;
            }

            // 按钮位置调整
            function adjustButtonPosition() {
                const button = document.getElementById('mobile-toc-button');
                const backToTopButton = document.getElementById('back-to-top');
                if (!button) return;

                // 设备检测
                const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                const hasHomeIndicator = isIOS && window.innerHeight >= 800;

                // 底部距离
                let bottomPosition = 20; // 基础值设为 20px

                // 如果有底部操作条
                if (hasHomeIndicator) {
                    bottomPosition += 5;
                }

                // 应用计算后位置
                document.documentElement.style.setProperty('--button-bottom-position', bottomPosition + 'px');

                if (button.style.display !== 'none') {
                    button.style.bottom = 'var(--button-bottom-position)';
                }

                const isTocButtonVisible = button.style.display !== 'none' && button.style.display !== '';

                // 返回按钮位置
                if (backToTopButton && isMobileDevice()) { // 只在移动设备上调整
                    if (isTocButtonVisible) {
                        // 显示时
                        backToTopButton.style.bottom = 'calc(var(--button-bottom-position) + 60px)';
                    } else {
                        // 隐藏时
                        backToTopButton.style.bottom = 'var(--button-bottom-position)';
                    }
                }
            }

            // 存储目录是否已创建 de 标记
            let tocCreated = false;
            let mobileTocCreated = false;

            function initTOC() {
                // 内容区域
                const articleContent = document.querySelector('.post-content');
                const tocWidget = document.getElementById('toc-widget');
                const mobileTocContainer = document.getElementById('mobile-toc-container');
                const mobileTocButton = document.getElementById('mobile-toc-button');
                const mobileTocOverlay = document.getElementById('mobile-toc-overlay');
                const mobileTocClose = document.getElementById('mobile-toc-close');
                const backToTopButton = document.getElementById('back-to-top');

                const isMobile = isMobileDevice();

                if (!articleContent) return;

                // 位置调整
                if (isMobile) {
                    adjustButtonPosition();
                }

                // 初始位置
                if (backToTopButton) {
                    backToTopButton.style.bottom = 'var(--button-bottom-position)';
                }

                // 获取标题
                const headings = articleContent.querySelectorAll('h1, h2, h3, h4, h5, h6');

                if (headings.length <= 1) {
                    // 标题不足
                    if (tocWidget) tocWidget.style.display = 'none';
                    if (mobileTocButton) mobileTocButton.style.display = 'none';

                    // 按钮位置
                    const backToTopButton = document.getElementById('back-to-top');
                    if (backToTopButton) {
                        backToTopButton.style.bottom = 'var(--button-bottom-position)';
                    }
                    return;
                }

                // 标题级别检查
                let headingTypes = new Set();
                headings.forEach(h => headingTypes.add(h.tagName));
                if (headingTypes.size === 1 && headings.length < 3) {
                    // 隐藏目录
                    if (tocWidget) tocWidget.style.display = 'none';
                    if (mobileTocButton) mobileTocButton.style.display = 'none';

                    // 按钮位置
                    const backToTopButton = document.getElementById('back-to-top');
                    if (backToTopButton) {
                        backToTopButton.style.bottom = 'var(--button-bottom-position)';
                    }
                    return;
                }

                // 目录创建函数
                function createTocContent(container, forceRecreate = false) {
                    if (!container) return;

                    // 重建检查
                    if (container.querySelector('ul') && !forceRecreate) {
                        return {
                            tocList: container.querySelector('ul'),
                            headingToLinkMap: new Map() // 返回空映射防止错误
                        };
                    }

                    // 清空容器
                    container.innerHTML = '';

                    const tocList = document.createElement('ul');
                    container.appendChild(tocList);

                    // 标题映射
                    const headingToLinkMap = new Map();

                    // 标题 ID
                    headings.forEach(function(heading, index) {
                        // 使用 ID
                        if (!heading.id) {
                            // 生成 ID
                            const headingText = heading.textContent;
                            const baseId = generateIdFromText(headingText);
                            heading.id = getUniqueId(baseId);
                        }

                        const listItem = document.createElement('li');
                        const link = document.createElement('a');
                        link.href = '#' + heading.id;
                        link.textContent = heading.textContent;
                        link.className = 'toc-' + heading.tagName.toLowerCase();
                        link.setAttribute('data-target-id', heading.id);

                        // 存储映射
                        headingToLinkMap.set(heading, link);

                        listItem.appendChild(link);
                        tocList.appendChild(listItem);

                        // 点击处理
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            const targetId = this.getAttribute('data-target-id');
                            const targetElement = document.getElementById(targetId);

                            if (targetElement) {

                                if (isMobile && mobileTocOverlay) {
                                    // 关闭侧边栏
                                    closeMobileToc();

                                    // 滚动
                                    setTimeout(() => {
                                        targetElement.scrollIntoView({
                                            behavior: 'smooth'
                                        });
                                        history.pushState(null, null, '#' + targetId);
                                    }, 300);
                                } else {
                                    // 立即滚动
                                    targetElement.scrollIntoView({
                                        behavior: 'smooth'
                                    });
                                    history.pushState(null, null, '#' + targetId);
                                }
                            }
                        });
                    });

                    // 事件检测
                    if (container) {
                        // 滚轮事件
                        container.addEventListener('wheel', function() {
                            userScrollingToc = true;
                            clearTimeout(userScrollTimeout);
                            userScrollTimeout = setTimeout(() => {
                                userScrollingToc = false;
                            }, 1500); // 用户停止滚动 1.5 秒后恢复自动滚动
                        });

                        // 触摸事件
                        container.addEventListener('touchstart', function() {
                            userScrollingToc = true;
                        });

                        container.addEventListener('touchend', function() {
                            clearTimeout(userScrollTimeout);
                            userScrollTimeout = setTimeout(() => {
                                userScrollingToc = false;
                            }, 1500); // 用户停止触摸 1.5 秒后恢复自动滚动
                        });
                    }

                    return {
                        tocList,
                        headingToLinkMap
                    };
                }

                // 桌面端目录
                if (tocWidget && !isMobile && !tocCreated) {
                    const tocContainer = document.getElementById('toc-container');
                    const {
                        tocList,
                        headingToLinkMap
                    } = createTocContent(tocContainer);
                    tocCreated = true;

                    // 显示目录
                    tocWidget.style.display = 'block';
                    setTimeout(() => {
                        tocWidget.style.opacity = '1';
                    }, 10);

                    // 滚动监听
                    function updateActiveHeading() {
                        const scrollPosition = window.scrollY;

                        // 寻找标题
                        let closestHeading = null;
                        let closestDistance = Number.MAX_SAFE_INTEGER;

                        headings.forEach(heading => {
                            const distance = Math.abs(heading.getBoundingClientRect().top);
                            if (distance < closestDistance && heading.getBoundingClientRect().top <= 150) {
                                closestHeading = heading;
                                closestDistance = distance;
                            }
                        });

                        if (closestHeading) {
                            // 移除激活
                            tocContainer.querySelectorAll('a').forEach(link => link.classList.remove('toc-active'));

                            // 激活链接
                            const activeLink = headingToLinkMap.get(closestHeading);
                            if (activeLink) {
                                activeLink.classList.add('toc-active');

                                // 自动滚动
                                if (!userScrollingToc) {
                                    // 滚动目录项
                                    const activeLinkRect = activeLink.getBoundingClientRect();
                                    const tocWidgetRect = tocWidget.getBoundingClientRect();

                                    // 计算位置
                                    const activeLinkTop = activeLinkRect.top - tocWidgetRect.top + tocWidget.scrollTop;
                                    const middlePosition = activeLinkTop - (tocWidgetRect.height / 2) + (activeLinkRect.height / 2);

                                    // 检查可视
                                    if (activeLinkRect.bottom > tocWidgetRect.bottom || activeLinkRect.top < tocWidgetRect.top) {

                                        tocWidget.scrollTo({
                                            top: middlePosition,
                                            behavior: 'smooth'
                                        });
                                    }
                                }
                            }
                        }
                    }

                    // 初始更新
                    updateActiveHeading();
                    window.addEventListener('scroll', updateActiveHeading);
                }

                // 关闭函数
                function closeMobileToc() {
                    if (mobileTocOverlay) {
                        mobileTocOverlay.classList.remove('active');
                        document.body.classList.remove('toc-open');
                        setTimeout(() => {
                            mobileTocOverlay.style.display = 'none';
                        }, 300);
                    }
                }

                // 移动端目录
                if (mobileTocButton) {
                    if (isMobile) {
                        // 标题检查
                        if (headings.length > 1 && !(headingTypes.size === 1 && headings.length < 3)) {
                            mobileTocButton.style.display = 'flex';

                            // 按钮位置
                            if (backToTopButton) {
                                backToTopButton.style.bottom = 'calc(var(--button-bottom-position) + 60px)';
                            }

                            if (!mobileTocCreated && mobileTocContainer) {
                                createTocContent(mobileTocContainer, true);
                                mobileTocCreated = true;
                            }
                        } else {
                            // 位置调整
                            if (backToTopButton) {
                                backToTopButton.style.bottom = 'var(--button-bottom-position)';
                            }
                        }

                        // 按钮事件
                        if (mobileTocOverlay) {
                            mobileTocButton.addEventListener('click', function() {
                                mobileTocOverlay.style.display = 'block';
                                document.body.classList.add('toc-open');
                                // 触发动画
                                setTimeout(() => {
                                    mobileTocOverlay.classList.add('active');
                                }, 10);
                            });

                            // 关闭事件
                            if (mobileTocClose) {
                                mobileTocClose.addEventListener('click', closeMobileToc);
                            }

                            // 遮罩关闭
                            mobileTocOverlay.addEventListener('click', function(e) {
                                if (e.target === mobileTocOverlay) {
                                    closeMobileToc();
                                }
                            });
                        }
                    } else {
                        // 桌面隐藏
                        mobileTocButton.style.display = 'none';
                        if (mobileTocOverlay) {
                            mobileTocOverlay.style.display = 'none';
                        }
                    }
                }
            }

            // 初始化
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    initTOC();
                    initBackToTop();
                });
            } else {
                initTOC();
                initBackToTop();
            }

            // 返回顶部按钮
            function initBackToTop() {
                const backToTopButton = document.getElementById('back-to-top');
                const mobileTocButton = document.getElementById('mobile-toc-button');
                const tocWidget = document.getElementById('toc-widget');
                if (!backToTopButton) return;
                
                // 桌面端时，将返回顶部按钮与目录左边框垂直对齐并调整底部位置
                if (!isMobileDevice()) {
                    let leftPosition;
                    // 记录目录是否可见
                    const isTocVisible = tocWidget && window.getComputedStyle(tocWidget).display !== 'none';
                    
                    if (isTocVisible) {
                        // 有目录时，使用目录左边框位置
                        const tocRect = tocWidget.getBoundingClientRect();
                        leftPosition = tocRect.left;
                    } else {
                        // 没有目录时，计算目录的默认位置
                        // 使用侧边栏的位置来计算
                        const secondary = document.getElementById('secondary');
                        if (secondary) {
                            const secondaryRect = secondary.getBoundingClientRect();
                            leftPosition = secondaryRect.left;
                        } else {
                            // 如果无法获取侧边栏位置，使用一个合理的默认值
                            leftPosition = window.innerWidth * 0.15; // 默认值，大约是侧边栏起始位置
                        }
                    }
                    
                    // 应用位置设置
                    backToTopButton.style.left = leftPosition + 'px';
                    backToTopButton.style.right = 'auto';
                    
                    // 尝试找到footer元素并调整按钮位置与其对齐
                    const footer = document.getElementById('footer');
                    if (footer) {
                        // 从footer获取顶部padding值并应用到按钮
                        const footerStyle = window.getComputedStyle(footer);
                        const footerPaddingTop = footerStyle.getPropertyValue('padding-top');
                        if (footerPaddingTop) {
                            backToTopButton.style.bottom = footerPaddingTop;
                        }
                    }
                    
                    // 添加窗口大小变化监听，保证位置一致性
                    window.addEventListener('resize', function() {
                        if (!isMobileDevice()) {
                            // 重新检查目录是否可见
                            const isResizedTocVisible = tocWidget && window.getComputedStyle(tocWidget).display !== 'none';
                            let updatedLeftPosition;
                            
                            if (isResizedTocVisible) {
                                // 有目录时使用目录位置
                                const updatedTocRect = tocWidget.getBoundingClientRect();
                                updatedLeftPosition = updatedTocRect.left;
                            } else {
                                // 没有目录时使用侧边栏位置
                                const secondary = document.getElementById('secondary');
                                if (secondary) {
                                    const secondaryRect = secondary.getBoundingClientRect();
                                    updatedLeftPosition = secondaryRect.left;
                                } else {
                                    updatedLeftPosition = window.innerWidth * 0.15;
                                }
                            }
                            
                            backToTopButton.style.left = updatedLeftPosition + 'px';
                            
                            // 重新调整底部位置
                            if (footer) {
                                const updatedFooterStyle = window.getComputedStyle(footer);
                                const updatedPaddingTop = updatedFooterStyle.getPropertyValue('padding-top');
                                if (updatedPaddingTop) {
                                    backToTopButton.style.bottom = updatedPaddingTop;
                                }
                            }
                        }
                    });
                }

                // 滚动监听
                function toggleBackToTopButton() {
                    // 显示条件
                    if (window.scrollY > 300) {
                        backToTopButton.classList.add('show');
                    } else {
                        backToTopButton.classList.remove('show');
                    }

                    // 显示状态并调整返回顶部按钮位置
                    if (mobileTocButton && isMobileDevice()) { // 只在移动设备上调整
                        const isTocButtonVisible = mobileTocButton.style.display !== 'none' && mobileTocButton.style.display !== '';
                        if (isTocButtonVisible) {
                            // 显示时
                            backToTopButton.style.bottom = 'calc(var(--button-bottom-position) + 60px)';
                        } else {
                            // 隐藏时
                            backToTopButton.style.bottom = 'var(--button-bottom-position)';
                        }
                    }
                }

                // 初始检查
                toggleBackToTopButton();
                window.addEventListener('scroll', toggleBackToTopButton);

                // 点击事件
                backToTopButton.addEventListener('click', function() {
                    // 平滑滚动
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // 窗口大小监听
            window.addEventListener('resize', function() {
                // 节流处理
                clearTimeout(window.resizeTimer);
                window.resizeTimer = setTimeout(function() {
                    const wasMobile = window.innerWidth <= 768;
                    // 位置调整
                    adjustButtonPosition();

                    initTOC();
                    const isMobile = window.innerWidth <= 768;

                    // 模式切换
                    if (wasMobile !== isMobile) {
                        tocCreated = false;
                        mobileTocCreated = false;
                        initTOC();
                    }
                }, 250);
            });

            // 添加滚动监听，处理浏览器 UI 变化导致的位置问题
            let lastScrollY = window.scrollY;
            let scrollTimer;

            window.addEventListener('scroll', function() {
                // 滚动方向
                const currentScrollY = window.scrollY;
                const isScrollingDown = currentScrollY > lastScrollY;
                lastScrollY = currentScrollY;

                // 禁用过渡
                const mobileTocButton = document.getElementById('mobile-toc-button');
                if (mobileTocButton) {
                    mobileTocButton.style.transition = 'opacity 0.3s';
                }

                // 停止调整
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(function() {
                    // 恢复过渡
                    if (mobileTocButton) {
                        mobileTocButton.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    }

                    // 重调位置
                    adjustButtonPosition();
                }, 100);
            }, {
                passive: true
            });

            // 方向变化
            window.addEventListener('orientationchange', function() {
                // 即时调整
                adjustButtonPosition();

                // 多次调整
                const orientationTimer = [100, 300, 500, 1000];
                orientationTimer.forEach(time => {
                    setTimeout(function() {
                        adjustButtonPosition();
                        initBackToTop();
                    }, time);
                });
            });

            // 针对 iOS Safari 特别处理
            if (/iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream) {
                // 监听视窗尺寸变化（捕获 Safari 工具栏显示/隐藏）
                let lastHeight = window.innerHeight;

                // 检测函数
                function checkViewportHeight() {
                    if (Math.abs(lastHeight - window.innerHeight) > 20) {
                        // 高度变化
                        adjustButtonPosition();
                        lastHeight = window.innerHeight;
                    }
                    requestAnimationFrame(checkViewportHeight);
                }

                // 开始监测
                requestAnimationFrame(checkViewportHeight);
            }
        })();
    </script>

</div><!-- end #sidebar -->
