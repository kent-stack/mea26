

<?php $__env->startSection('title', 'Latest Update'); ?>

<?php $__env->startSection('content'); ?>
<section x-data="{ open:false, filterType: 'all' }" class="reports bg-white" aria-label="Latest Update">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-20 py-16">
        <?php if(!isset($showAllMode) || !$showAllMode): ?>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Latest Update</h2>
        <?php else: ?>
            <div class="mb-8 flex items-center justify-between gap-4">
                <h2 class="text-3xl font-extrabold text-gray-900">All Reports</h2>
            </div>
            
            <!-- Filter Buttons -->
            <div class="flex justify-center mb-8">
                <div class="flex gap-3 bg-gray-100 rounded-lg p-3">
                    <button @click="filterType = 'all'" :class="filterType === 'all' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'" class="px-5 py-2 rounded-md text-sm font-semibold transition-colors duration-200">
                        All
                    </button>
                    <button @click="filterType = 'Daily Report'" :class="filterType === 'Daily Report' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'" class="px-5 py-2 rounded-md text-sm font-semibold transition-colors duration-200">
                        Daily
                    </button>
                    <button @click="filterType = 'Weekly Report'" :class="filterType === 'Weekly Report' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'" class="px-5 py-2 rounded-md text-sm font-semibold transition-colors duration-200">
                        Weekly
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 gap-8">
            <?php if(!isset($showAllMode) || !$showAllMode): ?>
                <?php if(isset($report) && $report): ?>
                    <?php
                        $thumbPath = null;
                        if ($report->photos && is_array($report->photos) && count($report->photos)) {
                            // use Storage::url to generate correct public URL
                            $thumbPath = \Illuminate\Support\Facades\Storage::url($report->photos[0]);
                        }
                        $isVideo = $report->photos && is_array($report->photos) && count($report->photos)
                            && in_array(strtolower(pathinfo($report->photos[0], PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi', 'webm', 'mkv']);

                        $submittedDate = $report->created_at ?? $report->updated_at;
                    ?>
                    <article class="report-card bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col lg:flex-row w-full">
                        <div class="report-image lg:w-2/5 w-full">
                            <?php if($isVideo && $thumbPath): ?>
                                <video src="<?php echo e($thumbPath); ?>" muted preload="metadata" class="object-cover w-full h-48 lg:h-64" aria-label="Report video"></video>
                            <?php else: ?>
                                <img src="<?php echo e($thumbPath ?? asset('images/report-thumb.jpg')); ?>" alt="Report image" class="object-cover w-full h-48 lg:h-64">
                            <?php endif; ?>
                        </div>
                        <div class="p-6 lg:p-8 lg:w-3/5 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-4">
                                    <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold"><?php echo e($report->report_type ?? 'REPORT'); ?></span>
                                    <span class="text-sm text-gray-500"><?php echo e($submittedDate ? $submittedDate->format('d M Y') : 'Unknown date'); ?></span>
                                </div>
                                <h3 class="report-title mt-4 text-2xl font-extrabold text-gray-900 lg:text-3xl"><?php echo e($report->title); ?></h3>
                                <p class="report-description mt-3 text-gray-600"><?php echo e($report->description); ?></p>
                            </div>
                            <div class="mt-6">
                                <a href="<?php echo e(route('report.detail', $report)); ?>" class="text-red-600 font-semibold">More →</a>
                            </div>
                        </div>
                    </article>
                <?php else: ?>
                    <p class="text-gray-500">No reports yet.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Previous Reports Section / All Reports Section -->
        <?php if($previousReports && count($previousReports) > 0): ?>
        <div class="mt-16">
            <?php if(!isset($showAllMode) || !$showAllMode): ?>
                <h3 class="text-2xl font-extrabold text-gray-900 mb-8">Previous Reports</h3>
            <?php endif; ?>
            <div class="<?php echo e((isset($showAllMode) && $showAllMode) ? 'previous-reports-grid previous-reports-grid--all' : 'previous-reports-grid'); ?> grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $previousReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prevReport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $thumbPath = null;
                        if ($prevReport->photos && is_array($prevReport->photos) && count($prevReport->photos)) {
                            $thumbPath = \Illuminate\Support\Facades\Storage::url($prevReport->photos[0]);
                        }
                        $isVideo = $prevReport->photos && is_array($prevReport->photos) && count($prevReport->photos)
                            && in_array(strtolower(pathinfo($prevReport->photos[0], PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi', 'webm', 'mkv']);
                        $submittedDate = $prevReport->created_at ?? $prevReport->updated_at;
                        $isDaily = $prevReport->report_type === 'Daily Report';
                        $isWeekly = $prevReport->report_type === 'Weekly Report';
                    ?>
                    <?php if(isset($showAllMode) && $showAllMode): ?>
                        <article x-show="filterType === 'all' || filterType === '<?php echo e($prevReport->report_type); ?>'" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow flex flex-col" x-transition>
                            <div class="h-40 overflow-hidden bg-gray-200">
                                <?php if($isVideo && $thumbPath): ?>
                                    <video src="<?php echo e($thumbPath); ?>" muted preload="metadata" class="object-cover w-full h-full" aria-label="Report video"></video>
                                <?php else: ?>
                                    <img src="<?php echo e($thumbPath ?? asset('images/report-thumb.jpg')); ?>" alt="Report image" class="object-cover w-full h-full">
                                <?php endif; ?>
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="mb-3">
                                    <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><?php echo e($prevReport->submitter->name ?? 'Unknown'); ?></span>
                                </div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold"><?php echo e($prevReport->report_type ?? 'REPORT'); ?></span>
                                    <span class="text-xs text-gray-500"><?php echo e($submittedDate ? $submittedDate->format('d M Y') : 'Unknown date'); ?></span>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 truncate overflow-hidden text-ellipsis whitespace-nowrap"><?php echo e($prevReport->title); ?></h4>
                                <div class="mt-auto">
                                    <a href="<?php echo e(route('report.detail', $prevReport)); ?>" class="text-red-600 font-semibold text-sm">More →</a>
                                </div>
                            </div>
                        </article>
                    <?php else: ?>
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow flex flex-col">
                            <div class="h-40 overflow-hidden bg-gray-200">
                                <?php if($isVideo && $thumbPath): ?>
                                    <video src="<?php echo e($thumbPath); ?>" muted preload="metadata" class="object-cover w-full h-full" aria-label="Report video"></video>
                                <?php else: ?>
                                    <img src="<?php echo e($thumbPath ?? asset('images/report-thumb.jpg')); ?>" alt="Report image" class="object-cover w-full h-full">
                                <?php endif; ?>
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="mb-3">
                                    <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold"><?php echo e($prevReport->submitter->name ?? 'Unknown'); ?></span>
                                </div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold"><?php echo e($prevReport->report_type ?? 'REPORT'); ?></span>
                                    <span class="text-xs text-gray-500"><?php echo e($submittedDate ? $submittedDate->format('d M Y') : 'Unknown date'); ?></span>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 truncate overflow-hidden text-ellipsis whitespace-nowrap"><?php echo e($prevReport->title); ?></h4>
                                <div class="mt-auto">
                                    <a href="<?php echo e(route('report.detail', $prevReport)); ?>" class="text-red-600 font-semibold text-sm">More →</a>
                                </div>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if($hasMoreReports ?? false): ?>
            <div class="mt-8 text-center">
                <a href="<?php echo e(route('lapor.all')); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
                    All Reports →
                </a>
            </div>
            <?php endif; ?>

            <?php if(isset($showAllMode) && $showAllMode && $previousReports->hasPages()): ?>
                <div class="mt-8">
                    <nav aria-label="Pagination navigation">
                        <ul class="pagination">
                            <?php if($previousReports->onFirstPage()): ?>
                                <li class="disabled"><span>«</span></li>
                            <?php else: ?>
                                <li><a href="<?php echo e($previousReports->previousPageUrl()); ?>" rel="prev">«</a></li>
                            <?php endif; ?>

                            <?php
                                $currentPage = $previousReports->currentPage();
                                $lastPage = $previousReports->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            ?>

                            <?php if($start > 1): ?>
                                <li><a href="<?php echo e($previousReports->url(1)); ?>">1</a></li>
                                <?php if($start > 2): ?>
                                    <li><span>…</span></li>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php for($page = $start; $page <= $end; $page++): ?>
                                <?php if($page == $currentPage): ?>
                                    <li class="active"><span><?php echo e($page); ?></span></li>
                                <?php else: ?>
                                    <li><a href="<?php echo e($previousReports->url($page)); ?>"><?php echo e($page); ?></a></li>
                                <?php endif; ?>
                            <?php endfor; ?>

                            <?php if($end < $lastPage): ?>
                                <?php if($end < $lastPage - 1): ?>
                                    <li><span>…</span></li>
                                <?php endif; ?>
                                <li><a href="<?php echo e($previousReports->url($lastPage)); ?>"><?php echo e($lastPage); ?></a></li>
                            <?php endif; ?>

                            <?php if($previousReports->hasMorePages()): ?>
                                <li><a href="<?php echo e($previousReports->nextPageUrl()); ?>" rel="next">»</a></li>
                            <?php else: ?>
                                <li class="disabled"><span>»</span></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
        <div id="reportModal" x-show="open" x-cloak x-transition class="js-modal fixed inset-0 z-50 flex items-start justify-center p-6">
            <div data-js-overlay class="js-modal-overlay fixed inset-0 bg-black/40 backdrop-blur-sm"></div>
            <div data-js-dialog @click.stop class="relative bg-white w-full max-w-4xl rounded-lg overflow-hidden shadow-2xl">
                <div class="bg-green-600 text-white p-8">
                    <div class="flex items-start justify-between">
                        <h3 class="text-3xl font-extrabold">Weekly Report 4 (Project 2 : Social Media Marketing Kit for Sundan Plaosan Village Tourism Mapping)</h3>
                        <button data-js-close @click="open=false" class="js-modal-close text-white opacity-90 hover:opacity-100 text-2xl leading-none">✕</button>
                    </div>
                </div>
                <div class="p-8 max-h-[70vh] overflow-y-auto">
                    <p class="text-gray-700 mb-6">Malang, June 8–15, 2026</p>
                    <p class="mb-4">Monday, June 8, 2026<br>
                    Our team continued the finalization of our project. During this discussion session, we focused on determining and printing various materials and outputs that would later be presented during the final presentation at the end of the program period.</p>
                    <p class="mb-4">Tuesday, June 9, 2026<br>
                    Today was a special day because Dusun Sundan was holding its annual Bersih Dusun event...</p>
                    <p class="text-sm text-gray-500">(More content can be loaded dynamically from the DB.)</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .report-title {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
    }

    .report-description {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 1.5rem 0 0;
    }

    .pagination li {
        display: inline-flex;
        margin: 0;
    }

    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.6rem;
        height: 2.6rem;
        padding: 0 0.8rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background: #ffffff;
        color: #374151;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        line-height: 1;
        box-shadow: 0 1px 0 rgba(17, 24, 39, 0.02);
    }

    .pagination a:hover {
        background: #f3f4f6;
        color: #111827;
    }

    .pagination [aria-current="page"] > span,
    .pagination .active > span,
    .pagination .active > a,
    .pagination li.active a,
    .pagination li.active span {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .pagination .disabled > span,
    .pagination .disabled > a,
    .pagination li.disabled a,
    .pagination li.disabled span {
        opacity: 0.45;
        pointer-events: none;
        cursor: default;
    }

    .pagination .page-item .page-link,
    .pagination li > a,
    .pagination li > span {
        min-width: 2.6rem;
        height: 2.6rem;
    }

    @media (max-width: 767px) {
        .reports .mb-8, .reports .mb-6 {
            margin-bottom: 1rem !important;
        }

        .reports h2 {
            padding-top: 1.35rem !important;
            margin-top: 0.5rem !important;
        }

        .previous-reports-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }

        .previous-reports-grid article {
            border-radius: 0.875rem !important;
            overflow: hidden;
        }

        .previous-reports-grid:not(.previous-reports-grid--all) article:nth-child(n + 2) {
            display: none !important;
        }

        .previous-reports-grid article .h-40 {
            height: 150px !important;
        }

        .previous-reports-grid article .p-4 {
            padding: 0.75rem !important;
        }

        .previous-reports-grid article h4 {
            font-size: 1rem !important;
            line-height: 1.4 !important;
            margin-bottom: 0.75rem !important;
            white-space: normal !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .previous-reports-grid article .mt-auto {
            margin-top: 0.5rem !important;
        }

        .previous-reports-grid article .text-xs {
            font-size: 0.68rem !important;
        }

        .pagination {
            gap: 0.35rem;
            margin-top: 1.25rem;
        }

        .pagination a,
        .pagination span {
            min-width: 2.2rem;
            height: 2.2rem;
            padding: 0 0.6rem;
            font-size: 0.75rem;
        }
    }

</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\Documents\meapro\mea\resources\views/reports.blade.php ENDPATH**/ ?>