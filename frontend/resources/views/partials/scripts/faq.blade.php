<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggles = document.querySelectorAll('.faq-toggle');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function () {
                const content = this.nextElementSibling;
                const icon = this.querySelector('.faq-icon');
                
                if (content.style.display === 'none') {
                    content.style.display = 'block';
                    icon.classList.add('rotate-180');
                } else {
                    content.style.display = 'none';
                    icon.classList.remove('rotate-180');
                }
            });
        });

        // View more functionality
        const btnToggleFaq = document.getElementById('btn-toggle-faq');
        if (btnToggleFaq) {
            btnToggleFaq.addEventListener('click', function() {
                const hiddenItems = document.querySelectorAll('.faq-hidden-item');
                const textSpan = document.getElementById('text-toggle-faq');
                const iconSvg = document.getElementById('icon-toggle-faq');
                
                let isExpanded = false;
                
                hiddenItems.forEach(item => {
                    if (item.classList.contains('hidden')) {
                        item.classList.remove('hidden');
                        isExpanded = true;
                    } else {
                        item.classList.add('hidden');
                    }
                });
                
                if (isExpanded) {
                    textSpan.textContent = 'Tampilkan Lebih Sedikit';
                    iconSvg.classList.add('rotate-180');
                } else {
                    textSpan.textContent = 'Lihat Selengkapnya';
                    iconSvg.classList.remove('rotate-180');
                }
            });
        }
    });
</script>

