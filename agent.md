# Product Requirements Document (PRD)
## Website Direktori Cafe Ramah Anak - MVP

---

## 1. EXECUTIVE SUMMARY

### 1.1 Product Vision
Platform direktori online yang membantu orang tua dan pengasuh menemukan cafe ramah anak dengan fasilitas khusus (playground, highchair, mainan, mini zoo) secara cepat dan mudah, terutama saat traveling atau berada di area baru.

### 1.2 Problem Statement
Google Maps tidak memiliki filter spesifik untuk mencari cafe dengan fasilitas ramah anak. Orang tua kesulitan menemukan tempat yang aman dan nyaman untuk anak-anak mereka, terutama saat berada di area yang tidak familiar.

### 1.3 Success Criteria (MVP)
- Minimal 10 cafe terdaftar di database (fokus Yogyakarta & Solo)
- Jumlah user aktif mencapai target yang ditentukan
- Timeline: Launch dalam 1 minggu

---

## 2. TARGET USERS

### 2.1 Primary Users
**Persona: "Ibu Traveling"**
- **Demografi**: Orang tua atau pengasuh dengan anak usia 3-10 tahun
- **Geografis**: Nasional, pilot project di Yogyakarta & Solo
- **Perilaku**: 
  - Menggunakan platform secara dadakan saat traveling
  - Mencari cafe di area baru yang tidak familiar
  - Prioritas: tempat aman dengan fasilitas lengkap untuk anak

### 2.2 Secondary Users
**Persona: "Kontributor Komunitas"**
- Orang tua yang ingin berbagi informasi cafe ramah anak
- Berkontribusi melalui submission cafe baru dan review

---

## 3. CORE FEATURES (MVP)

### 3.1 Homepage & Search

#### 3.1.1 Main Search Interface
**Priority: HIGH**

**Komponen:**
- Search bar dengan 2 opsi input lokasi:
  - Auto-detect lokasi via GPS (default)
  - Manual input alamat/kota (menggunakan Nominatim Geocoding API - OpenStreetMap)
- Radius pencarian: Fixed 5km dari lokasi
- Call-to-action: "Cari Cafe Ramah Anak"

**User Flow:**
```
Landing → Input Lokasi (GPS/Manual) → [Optional] Apply Filter → View Results on Map/List
```

#### 3.1.2 Filter Fasilitas
**Priority: HIGH**

**Filter Options (Multiple selection):**
- ☐ Playground (Prioritas tinggi)
- ☐ Mini Zoo (Prioritas tinggi)
- ☐ Highchair
- ☐ Mainan

**Behavior:**
- Filter dapat dikombinasikan (AND logic)
- Hasil real-time update saat filter diubah
- Tampilkan jumlah hasil yang ditemukan

---

### 3.2 Map View (MapLibre GL JS)

#### 3.2.1 Interactive Map
**Priority: HIGH**

**Spesifikasi:**
- Library: **MapLibre GL JS** (open-source, no API limits)
- Tile Provider: **OpenStreetMap** (via Maptiler free tier atau self-hosted tiles)
- Tampilkan:
  - Custom markers untuk lokasi cafe yang memenuhi kriteria
  - Custom marker lokasi user saat ini (warna/icon berbeda)
  - Circle overlay untuk radius 5km dari lokasi user
- Map controls:
  - Zoom in/out
  - Re-center ke lokasi user
  - Full screen mode
  - Rotation control

**MapLibre Advantages:**
- ✅ No API key required untuk basic usage
- ✅ No quota limits
- ✅ Open-source & free
- ✅ Lightweight & fast
- ✅ Support custom styling

#### 3.2.2 Map Marker Interaction
**Behavior:**
- Klik marker → Tampilkan popup:
  - Nama cafe
  - Jarak dari lokasi user
  - Fasilitas available (icon)
  - Rating (jika ada)
  - Button "Lihat Detail"

**Marker Clustering:**
- Untuk performa, gunakan supercluster untuk group markers yang berdekatan
- Show count pada cluster
- Expand on click

---

### 3.3 Search Results

#### 3.3.1 List View
**Priority: HIGH**

**Card Information (per cafe):**
- Foto cafe (1 foto utama)
- Nama cafe
- Jarak dari lokasi user (e.g., "2.3 km")
- Fasilitas tersedia (icon visual)
- Rating rata-rata (⭐ 4.5/5.0)
- Jumlah review (e.g., "12 reviews")
- Button "Lihat Detail" & "Navigasi"

**Sorting:**
- Default: Jarak terdekat (ascending)
- No other sorting options for MVP

**Display:**
- Card layout responsive
- 10 results per page dengan pagination

---

### 3.4 Cafe Detail Page

#### 3.4.1 Information Section
**Priority: HIGH**

**Data Ditampilkan:**
- Nama cafe
- Alamat lengkap
- Link Google Maps asli (eksternal link untuk navigasi)
- Jarak dari lokasi user
- Fasilitas tersedia (list dengan icon)
- Embed MapLibre map (interactive, single cafe marker)

**Actions:**
- Button "Navigasi via Google Maps" (deep link: `https://www.google.com/maps/dir/?api=1&destination={lat},{lng}`)
- Button "Bookmark" (jika user sudah login)
- Button "Tulis Review"

#### 3.4.2 Reviews & Rating Section
**Priority: MEDIUM**

**Display:**
- Rating rata-rata (besar, prominent)
- Breakdown rating (5★, 4★, 3★, dst dengan bar chart)
- List review terbaru:
  - Nama user (dari Google Account)
  - Rating (bintang)
  - Tanggal review
  - Text review
  - Sort by: Terbaru / Rating tertinggi

**Review Form (untuk logged-in user):**
- Rating: 1-5 bintang (required)
- Text review: textarea (optional, max 500 karakter)
- Button "Submit Review"
- Status: "Menunggu moderasi admin"

---

### 3.5 User Authentication

#### 3.5.1 Login System
**Priority: HIGH**

**Method:**
- Google OAuth login (single option)
- Auto-redirect setelah sukses login

**Protected Actions:**
- Submit cafe baru
- Write review
- Bookmark cafe
- Report invalid information

**Guest User:**
- Dapat browse dan search
- Tidak dapat interact (review, bookmark, submit)

---

### 3.6 Cafe Submission (Crowdsource)

#### 3.6.1 Submit New Cafe Form
**Priority: HIGH**

**Updated Approach (Tanpa Google Places API):**

**Required Fields:**
- **Nama Cafe** (manual input) - wajib
- **Alamat Lengkap** (textarea) - wajib
- **Link Google Maps** (URL) - wajib untuk reference & navigasi
- **Koordinat** - Auto-extract dari Google Maps link ATAU manual input lat/long
- Checklist Fasilitas:
  - ☐ Playground
  - ☐ Mini Zoo
  - ☐ Highchair
  - ☐ Mainan
- Minimal 1 fasilitas harus dipilih

**Alternative untuk Extract Koordinat dari Google Maps URL:**

**Option 1: Regex Parsing (Recommended untuk MVP)**
```
Parse URL patterns:
- https://www.google.com/maps/place/.../@-7.123,110.456,17z/...
- https://maps.app.goo.gl/xxxxx (requires redirect follow)
- Extract latitude & longitude from URL parameters
```

**Option 2: Manual Geocoding**
```
- User paste Google Maps link (untuk reference)
- User copy-paste koordinat dari Google Maps (klik kanan → copy coordinates)
- System validate format lat/long
```

**Option 3: Nominatim Geocoding API (OpenStreetMap)**
```
- User input alamat lengkap
- System hit Nominatim API: https://nominatim.openstreetmap.org/search
- Free, no API key, usage policy: 1 request/second
- Return koordinat + formatted address
```

**Recommended Flow untuk MVP:**
1. User paste link Google Maps (optional, untuk reference)
2. User input nama cafe & alamat lengkap (manual)
3. User bisa:
   - Click "Cari Koordinat Otomatis" (via Nominatim + alamat)
   - ATAU input koordinat manual (dari Google Maps)
4. User checklist fasilitas
5. Submit → Status "Pending Moderasi"
6. Admin verifikasi koordinat di map preview sebelum approve

**Validation:**
- Koordinat harus valid (-90 to 90 latitude, -180 to 180 longitude)
- Cafe belum terdaftar (check by name + proximity)
- Minimal 1 fasilitas dipilih

---

### 3.7 Bookmark / Favorite

#### 3.7.1 Bookmark Feature
**Priority: MEDIUM**

**Functionality:**
- Heart icon di cafe card & detail page
- Toggle on/off
- Saved to user profile

#### 3.7.2 My Bookmarks Page
**Location:** User profile menu

**Display:**
- List semua cafe yang di-bookmark
- Layout sama dengan search results
- Option untuk remove bookmark
- Empty state jika belum ada bookmark

---

### 3.8 Report Invalid Information

#### 3.8.1 Report Form
**Priority: MEDIUM**

**Trigger:** Link "Laporkan info tidak valid" di detail page

**Form Fields:**
- Cafe yang dilaporkan (auto-filled)
- Alasan: Dropdown
  - Cafe sudah tutup
  - Fasilitas tidak sesuai
  - Alamat/koordinat salah
  - Lainnya
- Keterangan tambahan (optional, textarea)

**Flow:**
- Submit → Notifikasi ke admin
- User confirmation: "Laporan Anda telah diterima"

---

### 3.9 Admin Panel

#### 3.9.1 Dashboard
**Priority: HIGH**

**Metrics:**
- Total cafe di database
- Cafe pending moderasi
- Review pending moderasi
- Total registered users
- Laporan pending

#### 3.9.2 Cafe Management
**Features:**
- List semua cafe (tabel)
- **Map Preview:** Admin bisa lihat posisi cafe di MapLibre map sebelum approve
- Status: Active / Pending / Deleted
- Actions:
  - Approve pending submission (after verify koordinat di map)
  - Edit cafe data (termasuk adjust koordinat via drag marker)
  - Delete cafe
  - View submission detail

**Pending Moderation Queue:**
- Prioritas review submission baru
- Show: Submitter name, nama cafe, alamat, koordinat, facilities, submission date
- **Interactive Map Preview** untuk verify lokasi
- Action: Approve / Reject (with reason)

#### 3.9.3 Review Moderation
**Features:**
- List pending reviews
- Show: Reviewer, cafe, rating, text, date
- Action: Approve / Reject
- Filter: Pending / Approved / Rejected

#### 3.9.4 Report Management
**Features:**
- List semua laporan
- Show: Reporter, cafe, reason, description, date
- Action: 
  - Mark as resolved
  - Edit cafe data
  - Delete reported cafe
  - Dismiss report

---

## 4. TECHNICAL REQUIREMENTS

### 4.1 Technology Stack

**Backend:**
- Framework: Laravel 10+ (PHP 8.1+)
- Database: MySQL 8.0+
- Authentication: Laravel Socialite (Google OAuth)

**Frontend:**
- Blade Templates (Laravel native)
- CSS Framework: Tailwind CSS
- JavaScript: Alpine.js / Vanilla JS
- Icons: Lucide Icons / Font Awesome

**Maps & Geocoding:**
- **MapLibre GL JS** v3+ (client-side map rendering)
- **OpenStreetMap Tiles** via:
  - Maptiler Free Tier (100k tile requests/month free) ATAU
  - OpenStreetMap Direct Tiles (free, unlimited, fair use)
- **Nominatim Geocoding API** (OpenStreetMap, free dengan rate limit 1 req/sec)

**Authentication:**
- Google OAuth 2.0 (via Laravel Socialite)

**Hosting Requirements:**
- PHP 8.1+ support
- MySQL database
- SSL certificate (HTTPS required untuk geolocation)
- No special map server requirements (maps render client-side)

---

### 4.2 Database Schema

#### Tables:

**users**
```sql
id, name, email, google_id, avatar, created_at, updated_at
```

**cafes**
```sql
id, name, address, latitude, longitude, google_maps_url, 
status (pending/active/deleted), submitted_by (user_id),
created_at, updated_at, deleted_at

INDEX on (latitude, longitude) for spatial queries
INDEX on (status)
```

**facilities**
```sql
id, name, icon, priority (untuk sorting), created_at
```

**cafe_facilities** (pivot)
```sql
id, cafe_id, facility_id

INDEX on (cafe_id, facility_id)
```

**reviews**
```sql
id, cafe_id, user_id, rating (1-5), review_text, 
status (pending/approved/rejected), created_at, updated_at

INDEX on (cafe_id, status)
INDEX on (user_id)
```

**bookmarks**
```sql
id, user_id, cafe_id, created_at

UNIQUE INDEX on (user_id, cafe_id)
```

**reports**
```sql
id, cafe_id, user_id, reason, description, 
status (pending/resolved/dismissed), created_at, updated_at

INDEX on (status)
INDEX on (cafe_id)
```

---

### 4.3 Key Functionalities

#### 4.3.1 Geolocation & Distance Calculation
- Browser Geolocation API untuk detect user location
- **Haversine formula** untuk calculate distance (implemented server-side)
- Store user coordinates in session untuk consistency

**Haversine SQL Query:**
```sql
SELECT cafes.*, 
  (6371 * acos(
    cos(radians(:user_lat)) * cos(radians(latitude)) 
    * cos(radians(longitude) - radians(:user_lng)) 
    + sin(radians(:user_lat)) * sin(radians(latitude))
  )) AS distance
FROM cafes
WHERE status = 'active'
HAVING distance <= 5
ORDER BY distance ASC
```

#### 4.3.2 MapLibre GL JS Implementation

**Setup:**
```html
<!-- Include MapLibre GL JS -->
<link href='https://unpkg.com/maplibre-gl@3.x/dist/maplibre-gl.css' rel='stylesheet' />
<script src='https://unpkg.com/maplibre-gl@3.x/dist/maplibre-gl.js'></script>
```

**Basic Map Initialization:**
```javascript
const map = new maplibregl.Map({
  container: 'map',
  style: 'https://api.maptiler.com/maps/streets/style.json?key=YOUR_MAPTILER_KEY',
  // OR for free OSM tiles:
  // style: {
  //   version: 8,
  //   sources: {
  //     osm: {
  //       type: 'raster',
  //       tiles: ['https://tile.openstreetmap.org/{z}/{x}/{y}.png'],
  //       tileSize: 256,
  //       attribution: '© OpenStreetMap contributors'
  //     }
  //   },
  //   layers: [{ id: 'osm', type: 'raster', source: 'osm' }]
  // },
  center: [user_lng, user_lat], // [longitude, latitude]
  zoom: 13
});

// Add user location marker
new maplibregl.Marker({ color: '#3B82F6' })
  .setLngLat([user_lng, user_lat])
  .addTo(map);

// Add cafe markers
cafes.forEach(cafe => {
  const marker = new maplibregl.Marker({ color: '#EF4444' })
    .setLngLat([cafe.longitude, cafe.latitude])
    .setPopup(
      new maplibregl.Popup().setHTML(`
        <h3>${cafe.name}</h3>
        <p>${cafe.distance} km</p>
        <a href="/cafe/${cafe.id}">Lihat Detail</a>
      `)
    )
    .addTo(map);
});

// Add 5km radius circle
map.on('load', () => {
  map.addSource('radius', {
    type: 'geojson',
    data: createGeoJSONCircle([user_lng, user_lat], 5)
  });
  map.addLayer({
    id: 'radius-fill',
    type: 'fill',
    source: 'radius',
    paint: {
      'fill-color': '#3B82F6',
      'fill-opacity': 0.1
    }
  });
});
```

#### 4.3.3 Geocoding dengan Nominatim

**API Endpoint:**
```
https://nominatim.openstreetmap.org/search?q={address}&format=json&limit=1
```

**Laravel Implementation:**
```php
use Illuminate\Support\Facades\Http;

public function geocodeAddress($address) {
    $response = Http::withHeaders([
        'User-Agent' => 'CafeRamahAnak/1.0' // Required by Nominatim
    ])->get('https://nominatim.openstreetmap.org/search', [
        'q' => $address,
        'format' => 'json',
        'limit' => 1
    ]);
    
    if ($response->successful() && count($response->json()) > 0) {
        $data = $response->json()[0];
        return [
            'latitude' => $data['lat'],
            'longitude' => $data['lon'],
            'display_name' => $data['display_name']
        ];
    }
    
    return null;
}
```

**Rate Limiting:**
- Nominatim limit: 1 request per second
- Implement Laravel rate limiting middleware
- Cache hasil geocoding untuk alamat yang sama

#### 4.3.4 Extract Koordinat dari Google Maps URL

**Regex Pattern:**
```php
public function extractCoordinatesFromGoogleMapsUrl($url) {
    // Pattern 1: /@latitude,longitude,zoom
    if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+),/', $url, $matches)) {
        return [
            'latitude' => (float) $matches[1],
            'longitude' => (float) $matches[2]
        ];
    }
    
    // Pattern 2: /place/name/@latitude,longitude
    if (preg_match('/place\/[^\/]+\/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
        return [
            'latitude' => (float) $matches[1],
            'longitude' => (float) $matches[2]
        ];
    }
    
    // Pattern 3: ?q=latitude,longitude
    if (preg_match('/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
        return [
            'latitude' => (float) $matches[1],
            'longitude' => (float) $matches[2]
        ];
    }
    
    return null;
}
```

#### 4.3.5 Search & Filter Logic
```sql
-- Base query with distance calculation
SELECT cafes.*, 
  (6371 * acos(cos(radians(:lat)) * cos(radians(latitude)) 
  * cos(radians(longitude) - radians(:lng)) 
  + sin(radians(:lat)) * sin(radians(latitude)))) AS distance
FROM cafes
WHERE status = 'active'
HAVING distance <= 5
ORDER BY distance ASC
```

Apply facility filters via JOIN:
```sql
-- Dengan filter fasilitas (contoh: playground AND mini_zoo)
AND cafes.id IN (
  SELECT cafe_id 
  FROM cafe_facilities 
  WHERE facility_id IN (1, 2)  -- playground, mini_zoo
  GROUP BY cafe_id 
  HAVING COUNT(DISTINCT facility_id) = 2  -- AND logic
)
```

---

## 5. USER FLOWS

### 5.1 Primary User Flow: Search Cafe

```
1. User lands on homepage
2. System auto-detect GPS location (atau user input alamat manual)
3. [If manual] System geocode alamat via Nominatim
4. User optionally applies facility filters
5. User clicks "Cari"
6. System shows results on MapLibre map + list view
7. User clicks cafe marker/card
8. System shows cafe detail page with MapLibre embed
9. User clicks "Navigasi" → External Google Maps app (deep link)
```

### 5.2 Secondary Flow: Submit New Cafe

```
1. User clicks "Tambah Cafe" (di navbar)
2. System checks login → Redirect to Google OAuth if not logged in
3. User fills form:
   - Input nama cafe (manual)
   - Input alamat lengkap (manual)
   - Paste Google Maps link (optional)
   - Option A: Click "Cari Koordinat Otomatis" (Nominatim geocoding)
   - Option B: Manual input lat/long (copy dari Google Maps)
4. System validates koordinat
5. System shows map preview dengan marker (via MapLibre)
6. User confirms lokasi benar
7. User checks facilities
8. User submits form
9. System saves with status "pending"
10. Admin reviews in admin panel with MapLibre map preview
11. Admin adjusts koordinat jika perlu (drag marker)
12. Admin approves → Cafe visible to public
```

### 5.3 Tertiary Flow: Write Review

```
1. User on cafe detail page
2. User clicks "Tulis Review"
3. System checks login → Redirect if needed
4. User selects rating (1-5 stars)
5. User writes review text (optional)
6. User submits
7. System saves with status "pending"
8. Admin approves
9. Review appears on cafe detail page
```

---

## 6. UI/UX REQUIREMENTS

### 6.1 Design Principles
- **Mobile-first responsive** (walaupun prioritas desktop)
- Clean, minimalist interface
- Family-friendly color scheme (soft, welcoming)
- Clear call-to-actions
- Fast loading times
- Smooth map interactions (MapLibre native performance)

### 6.2 Key Pages Wireframe Priority

**High Priority:**
1. Homepage with search
2. Search results (MapLibre map + list)
3. Cafe detail page (with MapLibre embed)
4. Submit cafe form (with map preview)
5. Admin dashboard (with map preview for moderation)

**Medium Priority:**
6. User profile / bookmarks
7. Review form
8. Report form

### 6.3 Map Styling Recommendations

**Maptiler Free Tier (Recommended):**
- Pre-styled maps (streets, outdoor, satellite)
- 100,000 tile requests/month free
- Fast CDN
- Easy setup dengan API key

**OpenStreetMap Direct (Fully Free):**
- No API key required
- Unlimited tile requests (fair use)
- Basic styling
- Community-run infrastructure

---

## 7. LAUNCH STRATEGY (MVP)

### 7.1 Pre-Launch (Day 1-2)
- Setup Laravel project + database
- Implement Google OAuth login
- Create basic UI templates (Blade + Tailwind)
- Setup MapLibre GL JS + choose tile provider (Maptiler vs OSM direct)

### 7.2 Development (Day 3-5)
- Core search & filter functionality
- MapLibre map integration (search results + detail page)
- Cafe submission form dengan:
  - Nominatim geocoding
  - Google Maps URL parsing
  - Map preview
- Admin moderation dengan map preview
- Review system

### 7.3 Data Seeding (Day 5-6)
- Admin manually add 10 cafes di Yogyakarta & Solo
- For each cafe:
  - Find di Google Maps
  - Copy koordinat (klik kanan → copy)
  - Input via admin panel submission form
  - Verify lokasi di map preview
- Verify data quality

### 7.4 Testing & Launch (Day 6-7)
- User acceptance testing:
  - Test geolocation di berbagai device
  - Test map rendering & performance
  - Test search & filter
  - Test submission flow
- Bug fixes
- Performance optimization (map tile loading)
- Soft launch ke komunitas lokal Yogyakarta & Solo

---

## 8. SUCCESS METRICS & KPIs

### 8.1 MVP Success Criteria
- ✅ 10+ cafes in database (Yogyakarta & Solo)
- ✅ Functional search with GPS & filters
- ✅ MapLibre map rendering dengan smooth performance
- ✅ User can submit & review cafes
- ✅ Admin moderation working with map preview
- ✅ No map API quota issues (unlimited MapLibre + OSM tiles)

### 8.2 Post-Launch Metrics (Week 1-4)
- **User Acquisition:** Number of registered users
- **Engagement:** 
  - Search queries per user
  - Cafe detail page views
  - Average session duration
  - Map interactions (zoom, pan, marker clicks)
- **Content Growth:**
  - User-submitted cafes
  - Reviews submitted
  - Bookmark activity
- **Quality:**
  - Report rate (should be low)
  - Moderation response time
  - Data accuracy (coordinate precision)
- **Technical:**
  - Map load time (target: <2s)
  - Tile load failures (target: <1%)

---

## 9. FUTURE ROADMAP (Post-MVP)

### Phase 2 (Month 2-3):
- Mobile app (React Native / Flutter) dengan MapLibre SDK
- Additional filters (harga, menu, parking)
- Photo upload dari user
- Cafe owner verification & claim
- Offline map caching untuk mobile

### Phase 3 (Month 4-6):
- Ekspansi nasional (Jakarta, Surabaya, Bandung, dll)
- Social features (playdate planning, community forum)
- Premium listing untuk cafe owners
- Partnership dengan cafe chains
- Custom map styles (light/dark mode, colorblind-friendly)

### Phase 4 (Month 7+):
- Advanced spatial features:
  - Route planning (multi-cafe trip)
  - Heatmap view (density cafe ramah anak)
  - Isochrone map (cafes within X minutes travel time)
- Community-contributed map data improvements
- Integration dengan OpenStreetMap untuk contribute back

---

## 10. RISKS & MITIGATION

| Risk | Impact | Mitigation |
|------|--------|------------|
| ~~Google Maps API quota limit~~ | ~~High~~ | ✅ SOLVED: MapLibre + OSM = No quota limits |
| Nominatim rate limiting (1 req/sec) | Medium | Cache results, implement queue system, batch geocoding |
| Inaccurate user-submitted coordinates | High | Mandatory map preview, admin verification, report feature |
| MapLibre tile loading slow/fails | Medium | Use Maptiler CDN (fast), fallback to OSM direct, implement retry logic |
| Low user submission quality | Medium | Clear guidelines, admin moderation, tutorial tooltips |
| Data accuracy issues | High | Report feature, regular admin audit, coordinate verification |
| Slow adoption rate | Medium | Focus on Yogyakarta & Solo first, community marketing |
| Technical delays (1 week deadline) | High | Use Laravel Breeze starter, MapLibre pre-built examples, reduce scope if needed |
| Geocoding fails untuk alamat Indonesia | Medium | Multiple fallback: Nominatim → manual coordinate input → Google Maps URL parsing |

---

## 11. APPENDIX

### 11.1 API Requirements & Costs

**Free APIs (No Cost):**
- ✅ MapLibre GL JS (client-side library, free)
- ✅ OpenStreetMap Tiles (free, unlimited fair use)
- ✅ Nominatim Geocoding (free, 1 req/sec limit)
- ✅ Google OAuth 2.0 (free)

**Optional Paid (for better UX):**
- Maptiler Free Tier: 100k tile requests/month free
  - Upgrade: $49/month for 500k requests
- Alternative geocoding services jika Nominatim terlalu lambat:
  - LocationIQ: 10k requests/day free
  - Geoapify: 3k requests/day free

**Google Maps (Only for navigation deep link):**
- No API key needed untuk deep link: `https://www.google.com/maps/dir/?api=1&destination={lat},{lng}`

### 11.2 External Dependencies
- HTTPS hosting (required untuk geolocation)
- Email service (untuk notifikasi admin)
- Cloud storage (untuk future photo uploads)
- **CDN untuk MapLibre library** (gunakan unpkg.com atau jsDelivr)

### 11.3 MapLibre Resources
- Documentation: https://maplibre.org/maplibre-gl-js/docs/
- Style Specification: https://maplibre.org/maplibre-style-spec/
- Examples: https://maplibre.org/maplibre-gl-js/docs/examples/
- Community: https://github.com/maplibre/maplibre-gl-js

### 11.4 OpenStreetMap Tile Servers
**Primary (Recommended):**
- Maptiler: `https://api.maptiler.com/maps/streets/style.json?key=YOUR_KEY`

**Fallback (Free, Unlimited):**
- OSM Direct: `https://tile.openstreetmap.org/{z}/{x}/{y}.png`
- Usage Policy: https://operations.osmfoundation.org/policies/tiles/

**Alternative Free Providers:**
- Stamen Terrain: `https://tiles.stadiamaps.com/tiles/stamen_terrain/{z}/{x}/{y}.png`
- CartoDB: `https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png`

### 11.5 Sample MapLibre Map Styles

**Simple Street Map (No API Key):**
```javascript
style: {
  version: 8,
  sources: {
    osm: {
      type: 'raster',
      tiles: ['https://tile.openstreetmap.org/{z}/{x}/{y}.png'],
      tileSize: 256,
      attribution: '© OpenStreetMap contributors'
    }
  },
  layers: [
    {
      id: 'osm',
      type: 'raster',
      source: 'osm',
      minzoom: 0,
      maxzoom: 19
    }
  ]
}
```

**Maptiler Streets (Requires Free API Key):**
```javascript
style: 'https://api.maptiler.com/maps/streets/style.json?key=YOUR_MAPTILER_KEY'
```

---

## 12. IMPLEMENTATION CHECKLIST

### Backend (Laravel)
- [ ] Setup Laravel 10 project
- [ ] Configure MySQL database
- [ ] Create migrations untuk semua tables
- [ ] Setup Laravel Socialite (Google OAuth)
- [ ] Implement Haversine distance calculation
- [ ] Create Nominatim geocoding service class
- [ ] Create Google Maps URL parser class
- [ ] Build search & filter logic
- [ ] Implement CRUD untuk cafes, reviews, bookmarks, reports
- [ ] Create admin middleware & dashboard
- [ ] Setup rate limiting untuk Nominatim API

### Frontend (Blade + MapLibre)
- [ ] Setup Tailwind CSS
- [ ] Create homepage with search form
- [ ] Integrate browser Geolocation API
- [ ] Implement MapLibre GL JS map component
- [ ] Create cafe markers dengan custom icons
- [ ] Add popups untuk cafe info
- [ ] Implement 5km radius circle overlay
- [ ] Create search results list view
- [ ] Build cafe detail page dengan MapLibre embed
- [ ] Create cafe submission form dengan map preview
- [ ] Build admin moderation interface dengan map preview
- [ ] Implement review & rating UI
- [ ] Create bookmark functionality
- [ ] Build report form

### Testing
- [ ] Test geolocation di berbagai browser
- [ ] Test MapLibre map rendering & performance
- [ ] Test Nominatim geocoding
- [ ] Test Google Maps URL parsing
- [ ] Test search & filter accuracy
- [ ] Test submission flow end-to-end
- [ ] Test admin moderation workflow
- [ ] Test responsive design (mobile & desktop)
- [ ] Load testing (100+ cafes on map)

### Deployment
- [ ] Configure production environment
- [ ] Setup SSL certificate
- [ ] Configure Google OAuth production credentials
- [ ] Setup email notifications
- [ ] Configure Maptiler API key (if using)
- [ ] Setup database backups
- [ ] Configure error logging & monitoring
- [ ] Optimize asset loading (MapLibre, tiles)
- [ ] Setup CDN untuk static assets

---

## 13. DETAILED TECHNICAL IMPLEMENTATION

### 13.1 Laravel Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── CafeController.php
│   │   ├── SearchController.php
│   │   ├── ReviewController.php
│   │   ├── BookmarkController.php
│   │   ├── ReportController.php
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── CafeModerationController.php
│   │       └── ReviewModerationController.php
│   └── Middleware/
│       └── IsAdmin.php
├── Models/
│   ├── User.php
│   ├── Cafe.php
│   ├── Facility.php
│   ├── Review.php
│   ├── Bookmark.php
│   └── Report.php
├── Services/
│   ├── GeocodingService.php
│   ├── DistanceCalculator.php
│   └── GoogleMapsParser.php
└── Repositories/
    └── CafeRepository.php

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php
│   │   └── admin.blade.php
│   ├── home.blade.php
│   ├── search/
│   │   └── results.blade.php
│   ├── cafes/
│   │   ├── show.blade.php
│   │   └── create.blade.php
│   ├── profile/
│   │   └── bookmarks.blade.php
│   └── admin/
│       ├── dashboard.blade.php
│       ├── cafes/
│       │   └── moderation.blade.php
│       └── reviews/
│           └── moderation.blade.php
└── js/
    ├── app.js
    └── map.js

routes/
├── web.php
└── admin.php
```

### 13.2 Database Migrations

**Create Users Table (Laravel default + modifications):**
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('google_id')->unique();
    $table->string('avatar')->nullable();
    $table->boolean('is_admin')->default(false);
    $table->timestamps();
});
```

**Create Facilities Table:**
```php
Schema::create('facilities', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('icon')->nullable();
    $table->integer('priority')->default(0);
    $table->timestamps();
});

// Seed data
DB::table('facilities')->insert([
    ['name' => 'Playground', 'icon' => 'playground.svg', 'priority' => 1],
    ['name' => 'Mini Zoo', 'icon' => 'zoo.svg', 'priority' => 2],
    ['name' => 'Highchair', 'icon' => 'highchair.svg', 'priority' => 3],
    ['name' => 'Mainan', 'icon' => 'toys.svg', 'priority' => 4],
]);
```

**Create Cafes Table:**
```php
Schema::create('cafes', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('address');
    $table->decimal('latitude', 10, 7);
    $table->decimal('longitude', 10, 7);
    $table->string('google_maps_url')->nullable();
    $table->enum('status', ['pending', 'active', 'deleted'])->default('pending');
    $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
    $table->timestamps();
    $table->softDeletes();
    
    $table->index(['latitude', 'longitude']);
    $table->index('status');
});
```

**Create Cafe_Facilities Pivot Table:**
```php
Schema::create('cafe_facilities', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cafe_id')->constrained()->onDelete('cascade');
    $table->foreignId('facility_id')->constrained()->onDelete('cascade');
    $table->timestamps();
    
    $table->unique(['cafe_id', 'facility_id']);
});
```

**Create Reviews Table:**
```php
Schema::create('reviews', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cafe_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->integer('rating')->unsigned()->check('rating >= 1 AND rating <= 5');
    $table->text('review_text')->nullable();
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->timestamps();
    
    $table->index(['cafe_id', 'status']);
    $table->index('user_id');
});
```

**Create Bookmarks Table:**
```php
Schema::create('bookmarks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('cafe_id')->constrained()->onDelete('cascade');
    $table->timestamps();
    
    $table->unique(['user_id', 'cafe_id']);
});
```

**Create Reports Table:**
```php
Schema::create('reports', function (Blueprint $table) {
    $table->id();
    $table->foreignId('cafe_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->enum('reason', ['closed', 'wrong_facility', 'wrong_location', 'other']);
    $table->text('description')->nullable();
    $table->enum('status', ['pending', 'resolved', 'dismissed'])->default('pending');
    $table->timestamps();
    
    $table->index('status');
    $table->index('cafe_id');
});
```

### 13.3 Core Services Implementation

**GeocodingService.php:**
```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GeocodingService
{
    private const NOMINATIM_URL = 'https://nominatim.openstreetmap.org/search';
    private const CACHE_TTL = 86400; // 24 hours
    
    public function geocode(string $address): ?array
    {
        $cacheKey = 'geocode:' . md5($address);
        
        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($address) {
            sleep(1); // Nominatim rate limit: 1 req/sec
            
            $response = Http::withHeaders([
                'User-Agent' => 'CafeRamahAnak/1.0 (contact@example.com)'
            ])->get(self::NOMINATIM_URL, [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
                'countrycodes' => 'id' // Indonesia only
            ]);
            
            if ($response->successful() && count($response->json()) > 0) {
                $data = $response->json()[0];
                return [
                    'latitude' => (float) $data['lat'],
                    'longitude' => (float) $data['lon'],
                    'display_name' => $data['display_name']
                ];
            }
            
            return null;
        });
    }
}
```

**GoogleMapsParser.php:**
```php
<?php

namespace App\Services;

class GoogleMapsParser
{
    public function extractCoordinates(string $url): ?array
    {
        // Pattern 1: /@latitude,longitude,zoom
        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+),/', $url, $matches)) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2]
            ];
        }
        
        // Pattern 2: /place/name/@latitude,longitude
        if (preg_match('/place\/[^\/]+\/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2]
            ];
        }
        
        // Pattern 3: ?q=latitude,longitude
        if (preg_match('/[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $matches)) {
            return [
                'latitude' => (float) $matches[1],
                'longitude' => (float) $matches[2]
            ];
        }
        
        return null;
    }
    
    public function validateCoordinates(float $latitude, float $longitude): bool
    {
        return $latitude >= -90 && $latitude <= 90 
            && $longitude >= -180 && $longitude <= 180;
    }
}
```

**DistanceCalculator.php:**
```php
<?php

namespace App\Services;

class DistanceCalculator
{
    private const EARTH_RADIUS_KM = 6371;
    
    public function haversineDistance(
        float $lat1, 
        float $lon1, 
        float $lat2, 
        float $lon2
    ): float {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return self::EARTH_RADIUS_KM * $c;
    }
}
```

### 13.4 Key Controller Methods

**SearchController.php:**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Services\DistanceCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id'
        ]);
        
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $facilities = $request->facilities ?? [];
        $radius = 5; // km
        
        $query = DB::table('cafes')
            ->select(
                'cafes.*',
                DB::raw("(6371 * acos(
                    cos(radians($latitude)) * cos(radians(latitude)) 
                    * cos(radians(longitude) - radians($longitude)) 
                    + sin(radians($latitude)) * sin(radians(latitude))
                )) AS distance")
            )
            ->where('status', 'active')
            ->having('distance', '<=', $radius);
        
        // Apply facility filters
        if (!empty($facilities)) {
            $query->whereIn('cafes.id', function($q) use ($facilities) {
                $q->select('cafe_id')
                    ->from('cafe_facilities')
                    ->whereIn('facility_id', $facilities)
                    ->groupBy('cafe_id')
                    ->havingRaw('COUNT(DISTINCT facility_id) = ?', [count($facilities)]);
            });
        }
        
        $cafes = $query->orderBy('distance')->paginate(10);
        
        return view('search.results', compact('cafes', 'latitude', 'longitude'));
    }
}
```

**CafeController.php (Submission):**
```php
<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Services\GeocodingService;
use App\Services\GoogleMapsParser;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    public function __construct(
        private GeocodingService $geocoding,
        private GoogleMapsParser $mapsParser
    ) {}
    
    public function create()
    {
        return view('cafes.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'google_maps_url' => 'nullable|url',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'facilities' => 'required|array|min:1',
            'facilities.*' => 'exists:facilities,id'
        ]);
        
        // Create cafe
        $cafe = Cafe::create([
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'google_maps_url' => $request->google_maps_url,
            'status' => 'pending',
            'submitted_by' => auth()->id()
        ]);
        
        // Attach facilities
        $cafe->facilities()->attach($request->facilities);
        
        return redirect()->route('home')
            ->with('success', 'Cafe berhasil disubmit! Menunggu verifikasi admin.');
    }
    
    public function geocodeAddress(Request $request)
    {
        $request->validate([
            'address' => 'required|string'
        ]);
        
        $result = $this->geocoding->geocode($request->address);
        
        return response()->json($result ?? ['error' => 'Geocoding failed']);
    }
    
    public function parseGoogleMapsUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);
        
        $result = $this->mapsParser->extractCoordinates($request->url);
        
        return response()->json($result ?? ['error' => 'Cannot extract coordinates']);
    }
}
```

### 13.5 Frontend MapLibre Implementation

**resources/js/map.js:**
```javascript
import maplibregl from 'maplibre-gl';

export class CafeMap {
    constructor(containerId, options = {}) {
        this.container = containerId;
        this.options = {
            style: options.style || {
                version: 8,
                sources: {
                    osm: {
                        type: 'raster',
                        tiles: ['https://tile.openstreetmap.org/{z}/{x}/{y}.png'],
                        tileSize: 256,
                        attribution: '© OpenStreetMap contributors'
                    }
                },
                layers: [
                    {
                        id: 'osm',
                        type: 'raster',
                        source: 'osm',
                        minzoom: 0,
                        maxzoom: 19
                    }
                ]
            },
            center: options.center || [110.3695, -7.7956], // Yogyakarta
            zoom: options.zoom || 13
        };
        
        this.map = null;
        this.markers = [];
    }
    
    init() {
        this.map = new maplibregl.Map({
            container: this.container,
            style: this.options.style,
            center: this.options.center,
            zoom: this.options.zoom
        });
        
        this.map.addControl(new maplibregl.NavigationControl());
        this.map.addControl(new maplibregl.FullscreenControl());
        
        return this;
    }
    
    addUserMarker(lng, lat) {
        new maplibregl.Marker({ color: '#3B82F6' })
            .setLngLat([lng, lat])
            .setPopup(new maplibregl.Popup().setHTML('<p>Lokasi Anda</p>'))
            .addTo(this.map);
        
        return this;
    }
    
    addCafeMarkers(cafes) {
        cafes.forEach(cafe => {
            const marker = new maplibregl.Marker({ color: '#EF4444' })
                .setLngLat([cafe.longitude, cafe.latitude])
                .setPopup(
                    new maplibregl.Popup().setHTML(`
                        <div class="p-2">
                            <h3 class="font-bold">${cafe.name}</h3>
                            <p class="text-sm">${cafe.distance} km</p>
                            <a href="/cafe/${cafe.id}" class="text-blue-600 text-sm">
                                Lihat Detail
                            </a>
                        </div>
                    `)
                )
                .addTo(this.map);
            
            this.markers.push(marker);
        });
        
        return this;
    }
    
    addRadiusCircle(lng, lat, radiusKm) {
        this.map.on('load', () => {
            const circleGeoJSON = this.createCircle([lng, lat], radiusKm);
            
            this.map.addSource('radius', {
                type: 'geojson',
                data: circleGeoJSON
            });
            
            this.map.addLayer({
                id: 'radius-fill',
                type: 'fill',
                source: 'radius',
                paint: {
                    'fill-color': '#3B82F6',
                    'fill-opacity': 0.1
                }
            });
            
            this.map.addLayer({
                id: 'radius-line',
                type: 'line',
                source: 'radius',
                paint: {
                    'line-color': '#3B82F6',
                    'line-width': 2,
                    'line-opacity': 0.5
                }
            });
        });
        
        return this;
    }
    
    createCircle(center, radiusKm, points = 64) {
        const coords = {
            latitude: center[1],
            longitude: center[0]
        };
        
        const km = radiusKm;
        const ret = [];
        const distanceX = km / (111.320 * Math.cos(coords.latitude * Math.PI / 180));
        const distanceY = km / 110.574;
        
        for (let i = 0; i < points; i++) {
            const theta = (i / points) * (2 * Math.PI);
            const x = distanceX * Math.cos(theta);
            const y = distanceY * Math.sin(theta);
            
            ret.push([coords.longitude + x, coords.latitude + y]);
        }
        ret.push(ret[0]);
        
        return {
            type: 'FeatureCollection',
            features: [{
                type: 'Feature',
                geometry: {
                    type: 'Polygon',
                    coordinates: [ret]
                }
            }]
        };
    }
    
    fitBounds(coordinates) {
        const bounds = coordinates.reduce((bounds, coord) => {
            return bounds.extend(coord);
        }, new maplibregl.LngLatBounds(coordinates[0], coordinates[0]));
        
        this.map.fitBounds(bounds, {
            padding: 50
        });
        
        return this;
    }
}
```

**Usage in Blade Template:**
```html
<!-- resources/views/search/results.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Map Section -->
        <div class="lg:sticky lg:top-4 h-[600px]">
            <div id="map" class="w-full h-full rounded-lg shadow-lg"></div>
        </div>
        
        <!-- Results List -->
        <div>
            <h2 class="text-2xl font-bold mb-4">
                Ditemukan {{ $cafes->total() }} cafe
            </h2>
            
            @foreach($cafes as $cafe)
            <div class="bg-white rounded-lg shadow p-4 mb-4">
                <h3 class="font-bold text-lg">{{ $cafe->name }}</h3>
                <p class="text-gray-600 text-sm">{{ $cafe->address }}</p>
                <p class="text-blue-600 font-semibold">{{ number_format($cafe->distance, 1) }} km</p>
                
                <div class="flex gap-2 mt-2">
                    @foreach($cafe->facilities as $facility)
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">
                        {{ $facility->name }}
                    </span>
                    @endforeach
                </div>
                
                <a href="{{ route('cafes.show', $cafe->id) }}" 
                   class="mt-3 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Lihat Detail
                </a>
            </div>
            @endforeach
            
            {{ $cafes->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script type="module">
    import { CafeMap } from '/js/map.js';
    
    const cafes = @json($cafes->items());
    const userLat = {{ $latitude }};
    const userLng = {{ $longitude }};
    
    const map = new CafeMap('map', {
        center: [userLng, userLat],
        zoom: 13
    });
    
    map.init()
       .addUserMarker(userLng, userLat)
       .addCafeMarkers(cafes)
       .addRadiusCircle(userLng, userLat, 5);
</script>
@endpush
@endsection
```

---

## 14. SECURITY CONSIDERATIONS

### 14.1 Authentication & Authorization
- ✅ Google OAuth only (no password storage)
- ✅ Admin role check via middleware
- ✅ CSRF protection (Laravel default)
- ✅ Rate limiting on submission endpoints

### 14.2 Data Validation
- ✅ Validate all user inputs
- ✅ Sanitize HTML in reviews
- ✅ Coordinate bounds checking
- ✅ URL validation for Google Maps links

### 14.3 API Rate Limiting
```php
// routes/web.php
Route::middleware(['throttle:geocode'])->group(function () {
    Route::post('/geocode', [CafeController::class, 'geocodeAddress']);
});

// app/Providers/RouteServiceProvider.php
RateLimiter::for('geocode', function (Request $request) {
    return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
});
```

### 14.4 XSS Prevention
```php
// Always escape user content in Blade
{{ $cafe->name }} // Auto-escaped
{!! $trustedHtml !!} // Only for trusted content
```

---

## 15. PERFORMANCE OPTIMIZATION

### 15.1 Database Indexing
- Spatial index on (latitude, longitude)
- Index on status column
- Composite indexes for common queries

### 15.2 Caching Strategy
```php
// Cache geocoding results (24 hours)
Cache::remember('geocode:' . $address, 86400, fn() => ...);

// Cache cafe counts
Cache::remember('cafe_count', 3600, fn() => Cafe::active()->count());

// Cache facilities list
Cache::rememberForever('facilities', fn() => Facility::all());
```

### 15.3 Eager Loading
```php
// Avoid N+1 queries
$cafes = Cafe::with(['facilities', 'reviews'])
    ->where('status', 'active')
    ->get();
```

### 15.4 Asset Optimization
```javascript
// Lazy load MapLibre only when needed
const loadMap = async () => {
    const maplibregl = await import('maplibre-gl');
    // Initialize map
};
```

---

## 16. MONITORING & ANALYTICS

### 16.1 Key Metrics to Track
- Page load time
- Map render time
- Search query performance
- Geocoding success rate
- User registration conversion
- Cafe submission rate
- Review approval time

### 16.2 Error Logging
```php
// Log geocoding failures
Log::channel('geocoding')->warning('Geocoding failed', [
    'address' => $address,
    'user_id' => auth()->id()
]);

// Log map tile failures
Log::channel('maps')->error('Map tile load failed', [
    'tile_url' => $url,
    'error' => $error
]);
```

### 16.3 User Analytics (Optional)
- Google Analytics 4
- Track: searches, cafe views, submissions, bookmarks
- Heatmap of popular areas

---

## APPROVAL & SIGN-OFF

**Product Owner:** [Nama Anda]  
**Target Launch Date:** [7 hari dari sekarang]  
**Version:** MVP 1.0 (Complete - MapLibre Implementation)

**Key Changes from Previous Version:**
- ✅ Replaced Google Maps API dengan MapLibre GL JS (no quota limits)
- ✅ Use OpenStreetMap tiles (free, unlimited)
- ✅ Use Nominatim for geocoding (free, with rate limit)
- ✅ Parse Google Maps URLs untuk extract koordinat
- ✅ Added map preview di submission & admin forms
- ✅ Zero cost untuk map implementation
- ✅ Complete implementation checklist
- ✅ Detailed technical specifications
- ✅ Security & performance guidelines

---

**Document Status:** ✅ Ready for Development  
**Last Updated:** 1 Januari 2026  
**Major Update:** Complete PRD with Full Technical Implementation Gu