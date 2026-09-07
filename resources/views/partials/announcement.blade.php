@php
    // Show only announcements that still have an active submitted report.
    $announcementTitles = \App\Models\Report::where('report_type', 'Announcement')
        ->whereNull('deleted_at')
        ->pluck('title');
    $announcements = \App\Models\Announcement::where(function ($query) {
        $query->whereNotNull('image')->orWhereNotNull('file');
    })->whereIn('title', $announcementTitles)->latest()->get();
@endphp

<section id="pengumuman" class="announcement-section relative z-10 isolate py-8 sm:py-12 lg:py-16" style="background: #f8fafc !important;">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div style="margin-bottom: clamp(1.5rem, 4vw, 3rem);">
            <h2 style="font-size: clamp(1.75rem, 5vw, 3rem); font-weight: 900; color: #08203a; margin-bottom: 0.5rem;">Announcements.</h2>
        </div>

        @if($announcements->count() > 0)
        <!-- Carousel Container -->
        <div class="announcement-carousel" style="position: relative;">
            <div class="carousel-wrapper" style="overflow: hidden; border-radius: 24px;">
                <div class="carousel-inner" style="display: flex; transition: transform 0.4s ease-in-out; border-radius: 24px;">
                    @foreach($announcements as $announcement)
                        @php
                            $mediaPath = $announcement->image ?? $announcement->file;
                            $fileExt = $mediaPath ? pathinfo($mediaPath, PATHINFO_EXTENSION) : '';
                            $fileUrl = $mediaPath ? \Illuminate\Support\Facades\Storage::url($mediaPath) : null;
                            $fileSizeFormatted = 'Unknown size';

                            try {
                                if ($mediaPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($mediaPath)) {
                                    $fileSize = \Illuminate\Support\Facades\Storage::disk('public')->size($mediaPath);
                                    $fileSizeFormatted = $fileSize > 1048576 ? round($fileSize / 1048576, 2) . ' MB' : round($fileSize / 1024, 2) . ' KB';
                                }
                            } catch (\Exception $e) {
                                $fileSizeFormatted = 'Unknown size';
                            }
                        @endphp
                        <div class="carousel-item" style="min-width: 100%; display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 1.75rem; align-items: center; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08); padding: 1.5rem 1.5rem 1.5rem 1.25rem;">
                            <!-- File Preview Section -->
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f8fafc 0%, #edf3f9 100%); border-radius: 20px; border: 1px solid #dfe7f1; overflow: hidden; padding: 1rem;">
                                <div style="width: 100%; height: 100%; min-height: 360px; display: flex; align-items: center; justify-content: center; background: #fff; border-radius: 18px; overflow: hidden; border: 1px solid #edf2f7;">
                                    @if(in_array(strtolower($fileExt), ['jpg', 'jpeg', 'png', 'gif', 'webp']) && $fileUrl)
                                        <img src="{{ $fileUrl }}" alt="{{ $announcement->title }}" style="display: block; width: 100%; height: 100%; object-fit: cover;" />
                                    @elseif(in_array(strtolower($fileExt), ['pdf']))
                                        <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: linear-gradient(135deg, #fff7f7 0%, #fef2f2 100%);">
                                            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                            </svg>
                                        </div>
                                    @elseif(in_array(strtolower($fileExt), ['doc', 'docx']))
                                        <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                                            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="12" y1="13" x2="12" y2="17"></line>
                                                <line x1="9" y1="15" x2="15" y2="15"></line>
                                            </svg>
                                        </div>
                                    @elseif(in_array(strtolower($fileExt), ['xls', 'xlsx']))
                                        <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);">
                                            <svg width="120" height="120" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="9" y1="13" x2="15" y2="13"></line>
                                                <line x1="9" y1="17" x2="15" y2="17"></line>
                                            </svg>
                                        </div>
                                    @else
                                        <div style="display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: linear-gradient(135deg, #f8fafc 0%, #eef2f7 100%); border: 2px dashed #d1d5db;">
                                            <div style="text-align: center; color: #ef4444;">
                                                <svg width="110" height="110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="9" y1="15" x2="15" y2="15"></line>
                                                    <line x1="12" y1="12" x2="12" y2="18"></line>
                                                </svg>
                                                <div style="margin-top: 0.75rem; font-weight: 700; font-size: 0.8rem; letter-spacing: 0.04em; text-transform: uppercase;">{{ strtoupper($fileExt ?: 'FILE') }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div style="width: 100%; display: flex; flex-direction: column; justify-content: center; padding: 0.5rem 0.5rem 0.5rem 0;">
                                <div style="margin-bottom: 1rem;">
                                    <p style="color: #059669; font-weight: 700; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.05em; margin: 0;">Latest Announcement</p>
                                </div>
                                <h3 style="font-size: clamp(2rem, 3vw, 3.2rem); font-weight: 900; color: #08203a; margin: 0 0 1.4rem; line-height: 1.12; letter-spacing: -0.04em;">
                                    {{ $announcement->title }}
                                </h3>
                                <p style="color: #4b5563; margin: 0 0 1rem; line-height: 1.6; font-size: 1rem;">
                                    Date: {{ $announcement->created_at->format('d M Y') }}
                                </p>
                                <p style="color: #4b5563; margin: 0 0 2rem; line-height: 1.6; font-size: 1rem;">
                                    Click to view the announcement details.
                                </p>
                                <div>
                                    <a href="{{ route('announcement.download', $announcement->id) }}" target="_blank" rel="noopener noreferrer" class="announce-cta" style="display: inline-flex; align-items: center; gap: 0.75rem; color: #ef4444; font-weight: 700; text-decoration: none; font-size: 1.1rem;">
                                        <span>Read more</span>
                                        <span style="display: inline-flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%); border-radius: 50%; color: white; font-size: 1.2rem; box-shadow: 0 10px 20px rgba(249, 115, 22, 0.25);">→</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Carousel Navigation Arrows -->
            @if($announcements->count() > 1)
                <button class="carousel-nav prev-btn" onclick="moveCarousel(-1)" style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); z-index: 10; background: #1f9bf1; border: none; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 12px rgba(31, 155, 241, 0.35); font-size: 26px; color: white; transition: all 0.3s ease; margin-left: -24px;">
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;">
                        <path d="M12.5 5L7.5 10L12.5 15" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="carousel-nav next-btn" onclick="moveCarousel(1)" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); z-index: 10; background: #1f9bf1; border: none; width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 12px rgba(31, 155, 241, 0.35); font-size: 26px; color: white; transition: all 0.3s ease; margin-right: -24px;">
                    <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px;">
                        <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <style>
        @media (min-width: 769px) {
            .announcement-section .carousel-item > div:first-child {
                min-height: 260px !important;
            }

            .announcement-section .carousel-item > div:first-child > div {
                min-height: 260px !important;
            }
        }

        .announcement-carousel {
            position: relative;
            max-width: 100%;
        }

        .carousel-nav:hover {
            background: #f3f4f6 !important;
            transform: translateY(-50%) scale(1.1) !important;
        }

        @media (max-width: 768px) {
            .announcement-carousel {
                width: calc(100% - 1rem);
                margin-left: 15px;
                margin-right: 15px;
            }

            .carousel-item {
                grid-template-columns: 1fr !important;
                gap: 0.65rem !important;
                padding: 0.65rem !important;
                border-radius: 16px !important;
            }

            .carousel-item > div {
                width: 100% !important;
            }

            .carousel-item > div:first-child {
                height: 185px !important;
                min-height: 0 !important;
                padding: 0.5rem !important;
                border-radius: 12px !important;
            }

            .carousel-item > div:last-child {
                padding: 0.5rem !important;
            }

            .carousel-item > div:first-child > div {
                min-height: 0 !important;
                height: 100% !important;
                border-radius: 10px !important;
            }

            .carousel-item h3 {
                font-size: clamp(1.25rem, 4vw, 2rem) !important;
            }

            .carousel-item .carousel-nav {
                width: 40px !important;
                height: 40px !important;
                margin-left: -20px !important;
                margin-right: -20px !important;
            }

            .carousel-nav {
                width: 36px !important;
                height: 36px !important;
                font-size: 18px !important;
                background: #1f9bf1 !important;
                box-shadow: 0 2px 8px rgba(31, 155, 241, 0.3) !important;
            }

            .prev-btn {
                margin-left: -16px !important;
                left: 0 !important;
            }

            .next-btn {
                margin-right: -16px !important;
                right: 0 !important;
            }

            .carousel-wrapper {
                overflow-x: hidden !important;
            
            }
        }

        @media (max-width: 480px) {
            .carousel-nav {
                width: 32px !important;
                height: 32px !important;
                font-size: 14px !important;
            }

            .prev-btn {
                margin-left: -14px !important;
            }

            .next-btn {
                margin-right: -14px !important;
            }
            .carousel-item {
                padding: 0.5rem !important;
                gap: 0.5rem !important;
            }

            .carousel-item > div:first-child {
                height: 155px !important;
            }

            .carousel-item h3 {
                font-size: 1.1rem !important;
                margin-bottom: 0.65rem !important;
            }

            .carousel-item p {
                font-size: 0.78rem !important;
                margin-bottom: 0.65rem !important;
            }
        }
    </style>

    <script>
        let currentIndex = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;

        function moveCarousel(direction) {
            const carousel = document.querySelector('.carousel-inner');
            if (totalItems <= 1) return;

            currentIndex = (currentIndex + direction + totalItems) % totalItems;
            carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        // Auto-rotate carousel every 5 seconds
        setInterval(() => {
            if (totalItems > 1) {
                moveCarousel(1);
            }
        }, 5000);

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') moveCarousel(-1);
            if (e.key === 'ArrowRight') moveCarousel(1);
        });
    </script>
        @else
            <div style="display: flex; min-height: 180px; align-items: center; justify-content: center; border: 1px dashed #cbd5e1; border-radius: 1.5rem; background: #ffffff; color: #64748b; font-size: 1.05rem; font-weight: 600; text-align: center;">
                No announcement yet.
            </div>
        @endif
</section>
