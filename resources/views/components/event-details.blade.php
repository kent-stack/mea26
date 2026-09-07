<div class="bootcamp-timeline relative z-10 isolate bg-gradient-to-br from-blue-50 to-green-50 py-16 sm:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-3">Timeline Bootcamp</h2>
            
        </div>

        <!-- Tabs Container -->
        <div x-data="{ activeTab: 'offline' }" class="w-full">
            <!-- Tabs Navigation -->
            <div class="flex justify-center mb-6 sm:mb-8">
                <div class="bootcamp-tabs flex flex-col sm:flex-row gap-2 sm:gap-4 bg-white rounded-lg shadow-sm p-2 w-full sm:w-auto">
                    <button @click="activeTab = 'offline'" :class="activeTab === 'offline' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:text-gray-900'" class="px-3 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-md font-semibold text-sm sm:text-base transition-colors duration-200">
                        🏢 Bootcamp Offline
                    </button>
                    <button @click="activeTab = 'online'" :class="activeTab === 'online' ? 'bg-green-600 text-white' : 'text-gray-600 hover:text-gray-900'" class="px-3 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-md font-semibold text-sm sm:text-base transition-colors duration-200">
                        💻 Mentoring Online
                    </button>
                </div>
            </div>

            <!-- Bootcamp Offline Image -->
            <div x-show="activeTab === 'offline'" class="rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow" x-transition>
                <img src="{{ asset('images/tm1.png') }}" alt="Bootcamp Offline - 2 Days" class="w-full h-auto">
            </div>

            <!-- Mentoring Online Image -->
            <div x-show="activeTab === 'online'" class="rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow" x-transition>
                <img src="{{ asset('images/tm2.png') }}" alt="Online Mentoring - 1 Month" class="w-full h-auto">
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 640px) {
        .bootcamp-tabs {
            flex-direction: row !important;
            gap: 0.35rem !important;
            padding: 0.35rem !important;
        }

        .bootcamp-tabs button {
            flex: 1 1 0;
            min-width: 0;
            padding: 0.55rem 0.35rem !important;
            font-size: 0.68rem !important;
            line-height: 1.2;
            white-space: nowrap;
        }
    }
</style>
