@include('partials.head')

<body class="bg-gray-50 dark:bg-gray-900 dark:text-gray-100 font-sans antialiased">

    @include('partials.navbar')
    @include('partials.navbar-script')

    <main>
        @include('partials.hero')
        @include('partials.quick-actions')
        @include('partials.about')
        @include('partials.services')
        @include('partials.partnerships')
        @include('partials.news')
        @include('partials.faq')

        <div id="scroll-progress" class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
            <div id="progress-bar" class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 transition-all duration-150 ease-out" style="width: 0%"></div>
        </div>
    </main>
    @include('partials.footer')
    @include('partials.scripts.hero-carousel')
    @include('partials.scripts.news-tabs')
    @include('partials.scripts.faq')
    @include('partials.scripts.general')
    @include('components.chatbot')
    @include('partials.cookie-consent')

</body>
</html>