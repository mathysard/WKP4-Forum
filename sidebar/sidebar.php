<?php
$topics = showTopicsOnHomePage();

?>



<div x-data="setup()" x-init="$refs.loading.classList.add('hidden');" @resize.window="watchScreen()">
    <div class="flex antialiased text-gray-900 bg-gray-100 ">
        <!-- Loading screen -->
        <div x-ref="loading" class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-gray-900">
            Chargement...</div>
        <!-- Sidebar -->
        <div class="mb-16 h-screen flex flex-shrink-0 transition-all">
            <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 z-10 bg-black bg-opacity-50 lg:hidden"></div>
            <div x-show="isSidebarOpen" class="fixed inset-y-0 z-10 w-16"></div>
            <!-- Mobile bottom bar -->
            <nav aria-label="Options" class="fixed inset-x-0 bottom-0 flex flex-row-reverse items-center justify-between px-4 py-2 bg-white border-t border-indigo-100 sm:hidden shadow-t rounded-t-3xl">
                <div class="text-lg">

                    <!-- Menu button -->
                    <button @click="(isSidebarOpen && currentSidebarTab == 'linksTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'linksTab'" class="p-2 transition-colors rounded-lg shadow-md hover:bg-black hover:text-white focus:outline-none focus:ring focus:ring-gray-600 focus:ring-offset-white focus:ring-offset-2" :class="(isSidebarOpen && currentSidebarTab == 'linksTab') ? 'text-white bg-gray-600' : 'text-gray-500 bg-white'">
                        <span class="sr-only">Button sidebar mobile</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                </div>
                <!-- Logo -->
                <a href="#">
                    <img class="w-10 h-auto" src="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png" alt="G-4" />
                </a>
            </nav>
            <!-- Left mini bar -->
            <nav aria-label="Options" class="z-20 flex-col items-center flex-shrink-0 hidden w-16 py-4 bg-white border-r-2 border-indigo-100 shadow-md sm:flex rounded-tr-3xl rounded-br-3xl">
                <!-- Logo -->
                <div class="flex-shrink-0 py-4">
                    <a href="#">
                        <img class="w-10 h-auto" src="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png" alt="G4" />
                    </a>
                </div>
                <div class="flex flex-col items-center flex-1 p-2 space-y-4">
                    <!-- Menu button -->
                    <button @click="(isSidebarOpen && currentSidebarTab == 'linksTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'linksTab'" class="p-2 transition-colors duration-300 rounded-lg shadow-md hover:bg-gray-900 hover:text-white focus:outline-none focus:ring focus:ring-gray-600 focus:ring-offset-white focus:ring-offset-2" :class="(isSidebarOpen && currentSidebarTab == 'linksTab') ? 'text-white bg-gray-900' : 'text-gray-500 bg-white'">
                        <span class="sr-only">button sidebar</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    <!-- Messages button -->
                    <button @click="(isSidebarOpen && currentSidebarTab == 'messagesTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'messagesTab'" class="p-2 transition-colors duration-300 rounded-lg shadow-md hover:bg-gray-900 hover:text-white focus:outline-none focus:ring focus:ring-gray-600 focus:ring-offset-white focus:ring-offset-2" :class="(isSidebarOpen && currentSidebarTab == 'messagesTab') ? 'text-white bg-gray-900' : 'text-gray-500 bg-white'">
                        <span class="sr-only">button catégorie</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                    </button>
                    <!-- Notifications button -->
                    <button @click="(isSidebarOpen && currentSidebarTab == 'notificationsTab') ? isSidebarOpen = false : isSidebarOpen = true; currentSidebarTab = 'notificationsTab'" class="p-2 transition-colors duration-300 rounded-lg shadow-md hover:bg-gray-900 hover:text-white focus:outline-none focus:ring focus:ring-gray-600 focus:ring-offset-white focus:ring-offset-2" :class="(isSidebarOpen && currentSidebarTab == 'notificationsTab') ? 'text-white bg-gray-900' : 'text-gray-500 bg-white'">
                        <span class="sr-only">button message</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>

                    </button>
                </div>
            </nav>
            <div x-transition:enter="transform transition-transform duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition-transform duration-300" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-show="isSidebarOpen" class="fixed inset-y-0 left-0 z-10 flex-shrink-0 w-64 bg-white border-r-2 border-indigo-100 shadow-lg sm:left-16 rounded-tr-3xl rounded-br-3xl sm:w-72 lg:static lg:w-64">
                <nav x-show="currentSidebarTab == 'linksTab'" aria-label="Main" class="flex flex-col h-full">
                    <!-- Logo -->
                    <div class="flex items-center justify-center flex-shrink-0 py-10">
                        <a href="#">
                            <img class="w-24 h-auto" src="https://static.wixstatic.com/media/b77c9c_3b112ce9986a41f0a6c092c5b3e17fe9~mv2_d_4876_3149_s_4_2.png">
                        </a>
                    </div>
                    <!-- Links -->
                    <div class="flex-1 px-4 space-y-2 overflow-hidden hover:overflow-auto">
                        <a href="./index.php" class="flex items-center space-x-2 text-white transition-colors rounded-lg group bg-gray-900 hover:text-white">
                            <span aria-hidden="true" class="p-2 bg-gray-800 rounded-lg">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </span>
                            <span>Accueil</span>
                        </a>
                        <a href="./pages.php" class="flex items-center w-full space-x-2 text-black hover:bg-gray-900 hover:text-white rounded-lg duration-300">
                            <span aria-hidden="true" class="p-2 transition-colors rounded-lg bg-gray-800 group-hover:bg-gray-800 group-hover:text-white">
                                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span>Pages</span>
                        </a>
                    </div>

                </nav>

                <section x-show="currentSidebarTab == 'messagesTab'" class="px-4 py-6">
                    <h2 class="text-xl">Catégories</h2>
                </section>

                <section x-show="currentSidebarTab == 'notificationsTab'" class="px-4 py-6">
                    <h2 class="text-xl">Notifications</h2>
                </section>
            </div>
        </div>
        <div class="flex flex-col flex-1">
            <header class="relative flex items-center justify-between flex-shrink-0 p-4">
                <!-- Mobile sub header button -->


                <!-- Mobile sub header -->
                <div x-transition:enter="transform transition-transform" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transform transition-transform" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-full opacity-0" x-show="isSubHeaderOpen" @click.away="isSubHeaderOpen = false" class="absolute flex items-center justify-between p-2 bg-white rounded-md shadow-lg sm:hidden top-16 left-5 right-5">

                    <!-- Messages button -->
                    <button @click="isSidebarOpen = true; currentSidebarTab = 'messagesTab'; isSubHeaderOpen = false" class="p-2 text-gray-400 bg-white rounded-lg shadow-md hover:bg-black hover:text-white focus:outline-none focus:ring focus:ring-gray-600 focus:ring-offset-gray-100 focus:ring-offset-4">
                        <span class="sr-only">Button catégorie mobile</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                    </button>
                    <!-- Notifications button -->
                    <button @click="isSidebarOpen = true; currentSidebarTab = 'notificationsTab'; isSubHeaderOpen = false" class="p-2 text-gray-400 bg-white rounded-lg shadow-md hover:bg-black hover:text-white focus:outline-none focus:ring focus:ring-gray-600 focus:ring-offset-gray-100 focus:ring-offset-4">
                        <span class="sr-only">Button notifications mobile</span>
                        <svg aria-hidden="true" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                    <!-- Github link -->
                    <a href="#" target="_blank" class="p-2 text-black bg-white rounded-lg shadow-md hover:text-white hover:bg-black focus:outline-none focus:ring focus:ring-gray-600 focus:ring-offset-gray-100 focus:ring-offset-2">
                        <span class="sr-only">Lien github</span>
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.026,2c-5.509,0-9.974,4.465-9.974,9.974c0,4.406,2.857,8.145,6.821,9.465 c0.499,0.09,0.679-0.217,0.679-0.481c0-0.237-0.008-0.865-0.011-1.696c-2.775,0.602-3.361-1.338-3.361-1.338 c-0.452-1.152-1.107-1.459-1.107-1.459c-0.905-0.619,0.069-0.605,0.069-0.605c1.002,0.07,1.527,1.028,1.527,1.028 c0.89,1.524,2.336,1.084,2.902,0.829c0.091-0.645,0.351-1.085,0.635-1.334c-2.214-0.251-4.542-1.107-4.542-4.93 c0-1.087,0.389-1.979,1.024-2.675c-0.101-0.253-0.446-1.268,0.099-2.64c0,0,0.837-0.269,2.742,1.021 c0.798-0.221,1.649-0.332,2.496-0.336c0.849,0.004,1.701,0.115,2.496,0.336c1.906-1.291,2.742-1.021,2.742-1.021 c0.545,1.372,0.203,2.387,0.099,2.64c0.64,0.696,1.024,1.587,1.024,2.675c0,3.833-2.33,4.675-4.552,4.922 c0.355,0.308,0.675,0.916,0.675,1.846c0,1.334-0.012,2.41-0.012,2.737c0,0.267,0.178,0.577,0.687,0.479 C19.146,20.115,22,16.379,22,11.974C22,6.465,17.535,2,12.026,2z">
                            </path>
                        </svg>
                    </a>
                </div>
            </header>
        </div>
    </div>
</div>