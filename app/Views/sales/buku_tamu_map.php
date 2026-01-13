<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid mt-4">
    <div class="row mb-3">
        <div class="col-12">
            <h2 class="mb-0"><i class="fas fa-map me-2"></i><?= esc($title) ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marked-alt me-2"></i>
                        Peta Distribusi Asal Sekolah
                        <small class="ms-2 text-muted">(Total: <?= count($guestBooks) ?> data)</small>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 500px; width: 100%;"></div>
                </div>
            </div>

            <!-- Statistics Table -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Daftar Sekolah Asal
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php 
                    // Group by school
                    $schoolGroups = [];
                    foreach ($guestBooks as $guest) {
                        $school = $guest['asal_sekolah'];
                        if (!isset($schoolGroups[$school])) {
                            $schoolGroups[$school] = 0;
                        }
                        $schoolGroups[$school]++;
                    }
                    arsort($schoolGroups);
                    ?>

                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Sekolah Asal</th>
                                    <th style="width: 15%">Jumlah Pengunjung</th>
                                    <th style="width: 15%">Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($schoolGroups as $school => $count): ?>
                                    <tr>
                                        <td><?= array_search($school, array_keys($schoolGroups)) + 1 ?></td>
                                        <td><strong><?= esc($school) ?></strong></td>
                                        <td>
                                            <span class="badge bg-primary"><?= $count ?></span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <?php $percentage = ($count / count($guestBooks)) * 100; ?>
                                                <div class="progress-bar bg-success" role="progressbar" 
                                                     style="width: <?= $percentage ?>%" 
                                                     aria-valuenow="<?= $percentage ?>" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    <?= number_format($percentage, 1) ?>%
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Individual entries -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-friends me-2"></i>
                        Daftar Pengunjung
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama</th>
                                    <th>Sekolah Asal</th>
                                    <th>No HP</th>
                                    <th style="width: 15%">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($guestBooks as $i => $guest): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= esc($guest['nama']) ?></td>
                                        <td><strong><?= esc($guest['asal_sekolah']) ?></strong></td>
                                        <td><?= esc($guest['no_hp']) ?></td>
                                        <td>
                                            <small class="text-muted">
                                                <?= date('d M Y H:i', strtotime($guest['created_at'])) ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Leaflet MarkerCluster -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

<!-- Nominatim Geocoder for address lookup -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map centered on Indonesia
    const map = L.map('map').setView([-6.1753, 106.8650], 5);
    
    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Get guest book data
    const guestBooks = <?= json_encode($guestBooks) ?>;

    // School coordinates (latitude, longitude)
    // In a real application, you would geocode these addresses
    const schoolCoordinates = {
        // Major cities in Indonesia - default coordinates
        'Jakarta': [-6.1753, 106.8650],
        'Surabaya': [-7.2504, 112.7488],
        'Bandung': [-6.9175, 107.6062],
        'Medan': [3.1957, 98.6722],
        'Semarang': [-6.9667, 110.4167],
        'Yogyakarta': [-7.7956, 110.3695],
        'Makassar': [-5.3520, 119.4320],
        'Palembang': [-3.0952, 104.7618],
        'Tangerang': [-6.1788, 106.6304],
        'Depok': [-6.3926, 106.7942],
    };

    // Group by school and add markers
    const schoolMarkers = {};
    const markerClusterGroup = L.markerClusterGroup({
        maxClusterRadius: 50,
        disableClusteringAtZoom: 15
    });

    guestBooks.forEach(guest => {
        const school = guest.asal_sekolah;
        const city = guest.kota || '';
        let coords;

        // Try to find coordinates for the school by city
        for (let cityName in schoolCoordinates) {
            if (city.toLowerCase().includes(cityName.toLowerCase()) || school.toLowerCase().includes(cityName.toLowerCase())) {
                coords = schoolCoordinates[cityName];
                break;
            }
        }

        // If not found, use a default location with slight randomization
        if (!coords) {
            const defaultLat = -6.1753 + (Math.random() - 0.5) * 5;
            const defaultLng = 106.8650 + (Math.random() - 0.5) * 5;
            coords = [defaultLat, defaultLng];
        }

        const marker = L.marker(coords, {
            title: school,
            icon: L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            })
        }).bindPopup(`
            <div style="width: 250px;">
                <h6 style="margin: 0 0 10px 0;"><strong>${guest.nama}</strong></h6>
                <p style="margin: 5px 0;"><i class="fas fa-school"></i> ${guest.asal_sekolah}</p>
                <p style="margin: 5px 0;"><i class="fas fa-map-marker-alt"></i> ${guest.kota}, ${guest.provinsi}</p>
                <p style="margin: 5px 0;"><i class="fas fa-phone"></i> ${guest.no_hp}</p>
                <p style="margin: 5px 0;"><i class="fas fa-info-circle"></i> ${guest.sumber_info}</p>
                <small class="text-muted">${new Date(guest.created_at).toLocaleString('id-ID')}</small>
            </div>
        `);

        markerClusterGroup.addLayer(marker);
    });

    map.addLayer(markerClusterGroup);

    // Fit map to all markers
    if (markerClusterGroup.getLayers().length > 0) {
        map.fitBounds(markerClusterGroup.getBounds().pad(0.1));
    }
});
</script>

<style>
    #map {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card {
        border-radius: 8px;
        border: none;
    }

    .card-header {
        border-radius: 8px 8px 0 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }

    .progress {
        border-radius: 4px;
    }

    .progress-bar {
        border-radius: 4px;
        font-size: 11px;
        line-height: 20px;
    }
</style>
<?= $this->endSection() ?>
