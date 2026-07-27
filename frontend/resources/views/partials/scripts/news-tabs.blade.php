<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabBtns = document.querySelectorAll('.news-tab-btn');
        const tabContents = document.querySelectorAll('.news-tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                // Remove active classes from all buttons
                tabBtns.forEach(b => {
                    b.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
                    b.classList.add('text-gray-600', 'dark:text-gray-300');
                });

                // Add active classes to clicked button
                this.classList.add('bg-blue-600', 'text-white', 'shadow-md');
                this.classList.remove('text-gray-600', 'dark:text-gray-300');

                // Hide all contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show target content
                const targetId = this.getAttribute('data-target');
                document.getElementById(targetId).classList.remove('hidden');
            });
        });
    });
</script>

