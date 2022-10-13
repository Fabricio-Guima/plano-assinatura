<section class="text-gray-600 body-font overflow-hidden mt-4 mb-0">
    <div class="container mx-auto">
        <div class="w-full">
            <div class="flex rounded-lg h-full bg-gray-800 text-white p-4 flex-col">
                <div class="flex items-center">
                    <div class="w-8 h-8 mr-3 inline-flex items-center justify-center rounded-full bg-red-500 text-white flex-shrink-0">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg title-font font-medium">{{ session("notification")["title"] }}</h2>
                </div>
                <div class="flex-grow mt-4">
                    <p class="leading-relaxed text-base">{{ session("notification")["message"] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
