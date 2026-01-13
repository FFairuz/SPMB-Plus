<?= $this->extend('layout/app'); ?>

<?= $this->section('title'); ?>Video Sekolah<?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<!-- Header -->
<div class="mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-2">Video Sekolah</h2>
            <p class="text-muted mb-0">Tonton profil dan kegiatan sekolah kami</p>
        </div>
        <a href="<?= base_url('sales/dashboard') ?>" class="btn btn-light">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<?php if (empty($videos)): ?>
    <!-- Empty State -->
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="bi bi-camera-video-off text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
        </div>
        <h4 class="fw-semibold mb-2">Belum Ada Video</h4>
        <p class="text-muted mb-4">Video belum tersedia. Silakan hubungi admin.</p>
        <a href="<?= base_url('sales/dashboard') ?>" class="btn btn-primary">
            <i class="bi bi-house-door me-2"></i>Kembali ke Dashboard
        </a>
    </div>
<?php else: ?>
    
    <!-- Video Grid -->
    <div class="row g-4">
        <?php foreach ($videos as $index => $video): 
            // Extract video ID from YouTube URL
            $videoID = '';
            if (!empty($video['video_url'])) {
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $video['video_url'], $match);
                $videoID = $match[1] ?? '';
            }
        ?>
        <div class="col-md-6 col-xl-4">
            <div class="video-card" onclick="playVideo('<?= esc($videoID) ?>', '<?= esc($video['title']) ?>')">
                <div class="video-thumbnail">
                    <?php if ($videoID): ?>
                        <img src="https://img.youtube.com/vi/<?= esc($videoID) ?>/maxresdefault.jpg" 
                             alt="<?= esc($video['title']) ?>" 
                             onerror="this.src='https://img.youtube.com/vi/<?= esc($videoID) ?>/hqdefault.jpg'">
                        <div class="play-button">
                            <div class="play-icon">
                                <i class="bi bi-play-fill"></i>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="video-placeholder">
                            <i class="bi bi-camera-video"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="video-info">
                    <h5 class="video-title"><?= esc($video['title']) ?></h5>
                    <?php if ($video['description']): ?>
                        <p class="video-description">
                            <?= esc(strlen($video['description']) > 80 ? substr($video['description'], 0, 80) . '...' : $video['description']) ?>
                        </p>
                    <?php endif; ?>
                    <div class="video-meta">
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-play-circle me-1"></i>Video #<?= $index + 1 ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-semibold" id="videoModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="videoFrame" 
                            src="" 
                            allowfullscreen 
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Video Card Styling */
.video-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.video-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(220, 53, 69, 0.15);
}

.video-thumbnail {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
    background: #f8f9fa;
    overflow: hidden;
}

.video-thumbnail img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.video-card:hover .video-thumbnail img {
    transform: scale(1.05);
}

.play-button {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.2);
    transition: background 0.3s ease;
}

.video-card:hover .play-button {
    background: rgba(0, 0, 0, 0.4);
}

.play-icon {
    width: 72px;
    height: 72px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.video-card:hover .play-icon {
    background: #dc3545;
    transform: scale(1.1);
}

.play-icon i {
    font-size: 32px;
    color: #dc3545;
    margin-left: 4px;
    transition: color 0.3s ease;
}

.video-card:hover .play-icon i {
    color: #fff;
}

.video-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.video-placeholder i {
    font-size: 4rem;
    color: #adb5bd;
}

.video-info {
    padding: 24px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.video-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 8px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.video-description {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 16px;
    line-height: 1.5;
    flex: 1;
}

.video-meta {
    display: flex;
    align-items: center;
    gap: 8px;
}

.video-meta .badge {
    font-weight: 500;
    padding: 6px 12px;
    border-radius: 8px;
}

/* Modal Styling */
.modal-content {
    border-radius: 16px;
    overflow: hidden;
}

.modal-header {
    padding: 20px 24px;
}

/* Responsive */
@media (max-width: 768px) {
    .video-card {
        border-radius: 12px;
    }
    
    .video-info {
        padding: 16px;
    }
    
    .play-icon {
        width: 56px;
        height: 56px;
    }
    
    .play-icon i {
        font-size: 24px;
    }
}
</style>

<script>
function playVideo(videoId, title) {
    if (!videoId) return;
    
    const modal = new bootstrap.Modal(document.getElementById('videoModal'));
    const videoFrame = document.getElementById('videoFrame');
    const modalTitle = document.getElementById('videoModalTitle');
    
    modalTitle.textContent = title;
    videoFrame.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
    
    modal.show();
    
    // Stop video when modal is closed
    document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
        videoFrame.src = '';
    }, { once: true });
}
</script>
