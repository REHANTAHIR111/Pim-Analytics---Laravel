<div :class="{ 'dark text-white-dark': $store.app.semidark }">
    <nav x-data="sidebar"
        class="sidebar fixed min-h-screen h-full top-0 bottom-0 w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300">
        <div class="dark:bg-[#0e1726] h-full" style='background:linear-gradient(-109deg, #16222a, #3a6073)'>
            <div class="flex justify-between items-center px-4 py-3">
                <a aria-current="page" class="main-logo flex items-center shrink-0 active" href="/">
                    <img class="h-14 ml-[5px] flex-none" src="/assets/images/logo.webp" alt="logo" style="filter: brightness(1) invert(1) hue-rotate(161deg);">
                </a>
                <a href="javascript:;"
                    class="collapse-icon w-8 h-8 rounded-full flex items-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180"
                    @click="$store.app.toggleSidebar()">
                    <svg class="w-5 h-5 m-auto" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 19L7 12L13 5" stroke="white" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="white"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <ul class="perfect-scrollbar relative font-semibold space-y-0.5 h-[calc(100vh-80px)] overflow-y-auto overflow-x-hidden  p-4 py-0"
                x-data="{ activeDropdown: {{ request()->routeIs('index') ? "'dashboard'" : 'null' }} }">
                <li class="menu nav-item">
                    <button type="button" class="nav-link group" :class="{ 'active': activeDropdown === 'dashboard' }"
                        @click="activeDropdown === 'dashboard' ? activeDropdown = null : activeDropdown = 'dashboard'">
                        <div class="flex items-center">
                            @php
                                $isActive = request()->is('/');
                                $iconColor = $isActive ? '!text-blue-600' : '!text-white';
                            @endphp
                            <svg class="group-hover:!text-blue-600 shrink-0 {{ $iconColor }}" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5"
                                    d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                    stroke="currentColor"
                                    stroke-width='2' />
                                <path
                                    d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                    stroke="currentColor"
                                    stroke-width='2' />
                            </svg>

                            <span
                                class="ltr:pl-3 rtl:pr-3 group-hover:!text-gray-900
                                group-[.active]:!text-gray-900
                                !text-gray-200
                                dark:!text-gray-200
                                dark:group-hover:!text-white-dark
                                dark:group-[.active]:!text-white-dark"
                                >
                            Dashboard</span>
                        </div>
                        <div class="rtl:rotate-180" :class="{ '!rotate-90': activeDropdown === 'dashboard' }">
                        @php
                                $isActive = request()->is('');
                                $iconColor = $isActive ? '!text-blue-600' : '!text-white';
                            @endphp
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 5L15 12L9 19" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </button>
                    <ul x-cloak x-show="activeDropdown === 'dashboard'" x-collapse class="nav-item group text-gray-500">
                        <li class="nav-item">
                            <a href="/" class="ltr:pl-3 rtl:pr-3 capitalize
                                group-hover:!text-gray-900
                                group-[.active]:!text-gray-900
                                !text-gray-200
                                dark:!text-gray-200
                                dark:group-hover:!text-white-dark
                                dark:group-[.active]:!text-white-dark
                            ">—	&nbsp; Sales</a>
                        </li>
                    </ul>
                </li>
                <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1" style='background:rgb(198 215 225);'>

                    <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>PIM</span>
                </h2>

                <li class="nav-item">
                    <ul>
                        @foreach ($modules as $module)
                            @php
                                $isActive = request()->is('pim/'.$module->name);
                                $iconColor = $isActive ? '!text-blue-600' : '!text-white';
                            @endphp
                            <li class="nav-item">
                                <a href={{ '/pim/'.$module->name }} class="group">
                                    <div class="flex items-center">
                                        <?php
                                            echo
                                                $module->name == 'productFaqs' ?
                                                '
                                                    <svg class="group-hover:!text-blue-600 shrink-0 ' . $iconColor . '" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.5" d="M16 4.00195C18.175 4.01406 19.3529 4.11051 20.1213 4.87889C21 5.75757 21 7.17179 21 10.0002V16.0002C21 18.8286 21 20.2429 20.1213 21.1215C19.2426 22.0002 17.8284 22.0002 15 22.0002H9C6.17157 22.0002 4.75736 22.0002 3.87868 21.1215C3 20.2429 3 18.8286 3 16.0002V10.0002C3 7.17179 3 5.75757 3.87868 4.87889C4.64706 4.11051 5.82497 4.01406 8 4.00195" stroke="currentColor" stroke-width="2"></path>
                                                        <path d="M8 14H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path><path d="M7 10.5H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path><path d="M9 17.5H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                                        <path d="M8 3.5C8 2.67157 8.67157 2 9.5 2H14.5C15.3284 2 16 2.67157 16 3.5V4.5C16 5.32843 15.3284 6 14.5 6H9.5C8.67157 6 8 5.32843 8 4.5V3.5Z" stroke="currentColor" stroke-width="2"></path>
                                                    </svg>
                                                '
                                                : null ;
                                        ?>
                                        <?php
                                            echo
                                                $module->name == 'tags' ?
                                                '
                                                    <svg class="group-hover:!text-blue-600 shrink-0 ' . $iconColor . '" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4.72848 16.1369C3.18295 14.5914 2.41018 13.8186 2.12264 12.816C1.83509 11.8134 2.08083 10.7485 2.57231 8.61875L2.85574 7.39057C3.26922 5.59881 3.47597 4.70292 4.08944 4.08944C4.70292 3.47597 5.59881 3.26922 7.39057 2.85574L8.61875 2.57231C10.7485 2.08083 11.8134 1.83509 12.816 2.12264C13.8186 2.41018 14.5914 3.18295 16.1369 4.72848L17.9665 6.55812C20.6555 9.24711 22 10.5916 22 12.2623C22 13.933 20.6555 15.2775 17.9665 17.9665C15.2775 20.6555 13.933 22 12.2623 22C10.5916 22 9.24711 20.6555 6.55812 17.9665L4.72848 16.1369Z" stroke="currentColor" stroke-width="2"/>
                                                        <circle cx="8.60699" cy="8.87891" r="2" transform="rotate(-45 8.60699 8.87891)" stroke="currentColor" stroke-width="2" />
                                                        <path d="M11.5417 18.5L18.5208 11.5208" stroke="currentColor" stroke-width="2" strokeLinecap="round" />
                                                    </svg>
                                                '
                                                : null ;
                                        ?>
                                        <?php
                                            echo
                                                $module->name == 'brand' ?
                                                '
                                                    <svg class="group-hover:!text-blue-600 shrink-0 ' . $iconColor . '" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.5" d="M11.1459 7.02251C11.5259 6.34084 11.7159 6 12 6C12.2841 6 12.4741 6.34084 12.8541 7.02251L12.9524 7.19887C13.0603 7.39258 13.1143 7.48944 13.1985 7.55334C13.2827 7.61725 13.3875 7.64097 13.5972 7.68841L13.7881 7.73161C14.526 7.89857 14.895 7.98205 14.9828 8.26432C15.0706 8.54659 14.819 8.84072 14.316 9.42898L14.1858 9.58117C14.0429 9.74833 13.9714 9.83191 13.9392 9.93531C13.9071 10.0387 13.9179 10.1502 13.9395 10.3733L13.9592 10.5763C14.0352 11.3612 14.0733 11.7536 13.8435 11.9281C13.6136 12.1025 13.2682 11.9435 12.5773 11.6254L12.3986 11.5431C12.2022 11.4527 12.1041 11.4075 12 11.4075C11.8959 11.4075 11.7978 11.4527 11.6014 11.5431L11.4227 11.6254C10.7318 11.9435 10.3864 12.1025 10.1565 11.9281C9.92674 11.7536 9.96476 11.3612 10.0408 10.5763L10.0605 10.3733C10.0821 10.1502 10.0929 10.0387 10.0608 9.93531C10.0286 9.83191 9.95713 9.74833 9.81418 9.58117L9.68403 9.42898C9.18097 8.84072 8.92945 8.54659 9.01723 8.26432C9.10501 7.98205 9.47396 7.89857 10.2119 7.73161L10.4028 7.68841C10.6125 7.64097 10.7173 7.61725 10.8015 7.55334C10.8857 7.48944 10.9397 7.39258 11.0476 7.19887L11.1459 7.02251Z" stroke="currentColor" stroke-width="2"></path><path d="M19 9C19 12.866 15.866 16 12 16C8.13401 16 5 12.866 5 9C5 5.13401 8.13401 2 12 2C15.866 2 19 5.13401 19 9Z" stroke="currentColor" stroke-width="2"></path>
                                                        <path opacity="0.5" d="M7.35111 15L6.71424 17.323C6.0859 19.6148 5.77173 20.7607 6.19097 21.3881C6.3379 21.6079 6.535 21.7844 6.76372 21.9008C7.41635 22.2331 8.42401 21.7081 10.4393 20.658C11.1099 20.3086 11.4452 20.1339 11.8014 20.0959C11.9335 20.0818 12.0665 20.0818 12.1986 20.0959C12.5548 20.1339 12.8901 20.3086 13.5607 20.658C15.576 21.7081 16.5837 22.2331 17.2363 21.9008C17.465 21.7844 17.6621 21.6079 17.809 21.3881C18.2283 20.7607 17.9141 19.6148 17.2858 17.323L16.6489 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                                    </svg>
                                                '
                                                : null;
                                        ?>
                                        <?php
                                            echo
                                                $module->name == 'categories' ?
                                                '
                                                    <svg class="group-hover:!text-blue-600 shrink-0 ' . $iconColor . '" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2 6.5C2 4.37868 2 3.31802 2.65901 2.65901C3.31802 2 4.37868 2 6.5 2C8.62132 2 9.68198 2 10.341 2.65901C11 3.31802 11 4.37868 11 6.5C11 8.62132 11 9.68198 10.341 10.341C9.68198 11 8.62132 11 6.5 11C4.37868 11 3.31802 11 2.65901 10.341C2 9.68198 2 8.62132 2 6.5Z" stroke="currentColor" stroke-width="1.5"/>
                                                        <path d="M13 17.5C13 15.3787 13 14.318 13.659 13.659C14.318 13 15.3787 13 17.5 13C19.6213 13 20.682 13 21.341 13.659C22 14.318 22 15.3787 22 17.5C22 19.6213 22 20.682 21.341 21.341C20.682 22 19.6213 22 17.5 22C15.3787 22 14.318 22 13.659 21.341C13 20.682 13 19.6213 13 17.5Z" stroke="currentColor" stroke-width="1.5"/>
                                                        <path d="M2 17.5C2 15.3787 2 14.318 2.65901 13.659C3.31802 13 4.37868 13 6.5 13C8.62132 13 9.68198 13 10.341 13.659C11 14.318 11 15.3787 11 17.5C11 19.6213 11 20.682 10.341 21.341C9.68198 22 8.62132 22 6.5 22C4.37868 22 3.31802 22 2.65901 21.341C2 20.682 2 19.6213 2 17.5Z" stroke="currentColor" stroke-width="2"/>
                                                        <path d="M13 6.5C13 4.37868 13 3.31802 13.659 2.65901C14.318 2 15.3787 2 17.5 2C19.6213 2 20.682 2 21.341 2.65901C22 3.31802 22 4.37868 22 6.5C22 8.62132 22 9.68198 21.341 10.341C20.682 11 19.6213 11 17.5 11C15.3787 11 14.318 11 13.659 10.341C13 9.68198 13 8.62132 13 6.5Z" stroke="currentColor" stroke-width="2"/>
                                                    </svg>
                                                '
                                                : null;
                                        ?>
                                        <?php
                                            echo
                                                $module->name == 'product' ?
                                                '
                                                    <svg class="group-hover:!text-blue-600 shrink-0 ' . $iconColor . '" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15.5777 3.38197L17.5777 4.43152C19.7294 5.56066 20.8052 6.12523 21.4026 7.13974C22 8.15425 22 9.41667 22 11.9415V12.0585C22 14.5833 22 15.8458 21.4026 16.8603C20.8052 17.8748 19.7294 18.4393 17.5777 19.5685L15.5777 20.618C13.8221 21.5393 12.9443 22 12 22C11.0557 22 10.1779 21.5393 8.42229 20.618L6.42229 19.5685C4.27063 18.4393 3.19479 17.8748 2.5974 16.8603C2 15.8458 2 14.5833 2 12.0585V11.9415C2 9.41667 2 8.15425 2.5974 7.13974C3.19479 6.12523 4.27063 5.56066 6.42229 4.43152L8.42229 3.38197C10.1779 2.46066 11.0557 2 12 2C12.9443 2 13.8221 2.46066 15.5777 3.38197Z" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                                        <path opacity="0.5" d="M21 7.5L12 12M12 12L3 7.5M12 12V21.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path>
                                                    </svg>
                                                '
                                                : null;
                                        ?>
                                        <?php
                                            echo
                                                $module->name == 'users' ?
                                                '
                                                    <svg class="group-hover:!text-blue-600 shrink-0 ' . $iconColor . '" width="20" height="20" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <circle cx="9" cy="6" r="4" stroke="currentColor" stroke-width="2" />
                                                        <path
                                                            d="M12.5 4.3411C13.0375 3.53275 13.9565 3 15 3C16.6569 3 18 4.34315 18 6C18 7.65685 16.6569 9 15 9C13.9565 9 13.0375 8.46725 12.5 7.6589"
                                                            stroke="currentColor"
                                                            stroke-width="2"
                                                        />
                                                        <ellipse cx="9" cy="17" rx="7" ry="4" stroke="currentColor" stroke-width="2" />
                                                        <path d="M18 14C19.7542 14.3847 21 15.3589 21 16.5C21 17.5293 19.9863 18.4229 18.5 18.8704" stroke="currentColor" stroke-width="2" strokeLinecap="round" />
                                                    </svg>
                                                '
                                            : null;
                                        ?>
                                        <?php
                                            echo
                                                $module->name == 'role' ?
                                                '
                                                    <svg class="shrink-0 group-hover:!text-blue-600 ' . $iconColor . '" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.5" d="M20 15.5524C18.8263 19.2893 15.3351 22 11.2108 22C6.12383 22 2 17.8762 2 12.7892C2 8.66488 4.71065 5.1737 8.44759 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                        <path d="M21.9131 9.94727C20.8515 6.14438 17.8556 3.14845 14.0527 2.0869C12.4091 1.6281 11 3.05419 11 4.76062V11.4551C11 12.3083 11.6917 13 12.5449 13H19.2394C20.9458 13 22.3719 11.5909 21.9131 9.94727Z" stroke="currentColor" stroke-width="2" />
                                                    </svg>
                                                '
                                                : null;
                                        ?>
                                        <span class="ltr:pl-3 rtl:pr-3 capitalize
                                            group-hover:!text-gray-900
                                            group-[.active]:!text-gray-900
                                            !text-gray-200
                                            dark:!text-gray-200
                                            dark:group-hover:!text-white-dark
                                            dark:group-[.active]:!text-white-dark
                                        ">
                                            {{ Str::headline($module->name) }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>
<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("sidebar", () => ({
            init() {
                const selector = document.querySelector('.sidebar ul a[href="' + window.location
                    .pathname + '"]');
                if (selector) {
                    selector.classList.add('active');
                    const ul = selector.closest('ul.sub-menu');
                    if (ul) {
                        let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                        if (ele) {
                            ele = ele[0];
                            setTimeout(() => {
                                ele.click();
                            });
                        }
                    }
                }
            },
        }));
    });
</script>
