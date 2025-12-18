<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Pass PHP data to JavaScript -->
<script>
    const publicationsData = <?php echo json_encode($publications ?? []); ?>;


    const facilitiesCount = <?php echo !empty($facilities) ? count($facilities) : 0; ?>;
    const equipmentCount = <?php echo !empty($equipmentForLanding) ? count($equipmentForLanding) : 0; ?>;
</script>

<!-- Initialize Swiper & Filter -->
<script>
let publicationSwiper = null;

let fasilitasSwiper = null;
let equipmentSwiper = null;


document.addEventListener('DOMContentLoaded', function() {
  initSwiper();

  initFasilitasSwiper();
  initEquipmentSwiper();

  
  // Filter buttons functionality
  const filterButtons = document.querySelectorAll('.filter-btn');
  filterButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      // Remove active class from all buttons
      filterButtons.forEach(b => {
        b.classList.remove('bg-blue-900', 'text-white', 'shadow-md');
        b.classList.add('bg-white', 'border-gray-200', 'text-gray-700');
      });
      
      // Add active class to clicked button
      this.classList.remove('bg-white', 'border-gray-200', 'text-gray-700');
      this.classList.add('bg-blue-900', 'text-white', 'shadow-md');
      
      // Filter publications
      const filterType = this.getAttribute('data-filter');
      filterPublications(filterType);
    });
  });
});

    function initSwiper() {
        // Only loop if we have enough slides (more than max slidesPerView which is 3)
        const enableLoop = publicationsData.length > 3;
        publicationSwiper = new Swiper('.publicationSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: enableLoop,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.publicationSwiper .swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    }





function initFasilitasSwiper() {
    const enableLoop = facilitiesCount > 3;
    fasilitasSwiper = new Swiper('.fasilitasSwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: enableLoop,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.fasilitasSwiper .swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },
        breakpoints: {
            640: { slidesPerView: 1, spaceBetween: 20 },
            768: { slidesPerView: 2, spaceBetween: 30 },
            1024:{ slidesPerView: 3, spaceBetween: 30 },
        },
    });
}

function initEquipmentSwiper() {
  const enableLoop = equipmentCount > 3;
  equipmentSwiper = new Swiper('.equipmentSwiper', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: enableLoop,
    autoplay: { delay: 5000, disableOnInteraction: false },
    pagination: {
      el: '.equipmentSwiper .swiper-pagination',
      clickable: true,
      dynamicBullets: true,
    },
    breakpoints: {
      640:  { slidesPerView: 1, spaceBetween: 20 },
      768:  { slidesPerView: 2, spaceBetween: 30 },
      1024: { slidesPerView: 3, spaceBetween: 30 },
    },
  });
}

    function filterPublications(filterType) {
        let sortedData = [...publicationsData];

        // Sort based on filter type
        switch (filterType) {
            case 'cited':
                sortedData.sort((a, b) => (b.citations || 0) - (a.citations || 0));
                break;
            case 'latest':
                sortedData.sort((a, b) => (b.year || 0) - (a.year || 0));
                break;
            case 'oldest':
                sortedData.sort((a, b) => (a.year || 0) - (b.year || 0));
                break;
        }

        // Update swiper slides
        updateSwiperSlides(sortedData);
    }

function updateSwiperSlides(data) {
    if (!publicationSwiper) return;
    
    // Remove all slides
    publicationSwiper.removeAllSlides();
    
    // Add new slides
    data.forEach(pub => {
        const excerpt = pub.abstract.length > 150 ? pub.abstract.substring(0, 150) + '...' : pub.abstract;
        const venue = pub.journal || pub.conference || 'Conference';
        
        const slideHTML = `
            <div class="swiper-slide">
                <div class="group relative bg-blue-50 rounded-2xl p-6 hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
                    ${pub.citations > 20 ? `
                    <div class="absolute top-4 right-4 w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    ` : ''}
                    
                    <div class="mb-4">
                        <span class="inline-block px-3 py-1 bg-blue-900 text-white text-xs font-semibold rounded-full">${pub.year}</span>
                        <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 text-xs font-medium rounded-full ml-2">${pub.type.charAt(0).toUpperCase() + pub.type.slice(1)}</span> 
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 ${pub.citations > 20 ? 'pr-12' : ''}">${pub.title}</h3>
                    
                    <p class="text-sm text-gray-600 mb-3 font-medium">${pub.authors}</p>
                    
                    <p class="text-sm text-blue-900 mb-3 font-semibold">${venue}</p>
                    
                    <p class="text-sm text-gray-600 mb-4 line-clamp-3 flex-grow">${excerpt}</p>
                    
                                       
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 mt-auto">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">${pub.citations} Citations</span>
                        </div>
                        ${pub.doi ? `
                        <a href="https://doi.org/${pub.doi}" target="_blank" class="inline-flex items-center gap-1 text-xs font-semibold text-blue-900 hover:text-blue-700 transition-colors">
                            DOI
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
        
        publicationSwiper.appendSlide(slideHTML);
    });
    
    
    // Update swiper
    publicationSwiper.update();
}
</script>

<style>
    /* Custom Swiper Styling */
    .publicationSwiper {
        padding: 0 0 50px;
    }

    .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #1e3a8a;
        opacity: 0.3;
    }

    .swiper-pagination-bullet-active {
        opacity: 1;
        background: #1e3a8a;
    }
</style>
