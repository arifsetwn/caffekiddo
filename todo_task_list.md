# TODO.md - AI Agent Task List
## Website Direktori Cafe Ramah Anak (PlayBites/KiddoCafe/TinySpot)

**Project Timeline:** 7 Days  
**Status:** 🔴 Not Started  
**Last Updated:** 1 Januari 2026

---

## 🎯 PHASE 1: PROJECT SETUP (Day 1)

### ✅ Task 1.1: Laravel Project Initialization
**Priority:** HIGH  
**Estimated Time:** 2 hours

- [X] Create new Laravel 10 project
  ```bash
  composer create-project laravel/laravel cafekiddo
  ```
- [X] Configure `.env` file (database, app name, timezone)
- [X] Set timezone to Asia/Jakarta
- [X] Install Laravel Breeze for authentication scaffolding
  ```bash
  composer require laravel/breeze --dev
  php artisan breeze:install blade
  ```
- [X] Install Tailwind CSS dependencies
  ```bash
  npm install
  npm run dev
  ```
- [X] Setup Git repository
  ```bash
  git init
  git add .
  git commit -m "Initial Laravel setup"
  ```

**Deliverable:** Working Laravel installation with Breeze authentication

---

### ✅ Task 1.2: Database Setup
**Priority:** HIGH  
**Estimated Time:** 1 hour

- [X] Create MySQL database `cafe_kiddo`
- [X] Update `.env` with database credentials
- [X] Test database connection
  ```bash
  php artisan migrate
  ```
- [X] Create `.env.example` backup

**Deliverable:** Database connected and ready

---

### ✅ Task 1.3: Install Required Packages
**Priority:** HIGH  
**Estimated Time:** 1 hour

- [X] Install Laravel Socialite for Google OAuth
  ```bash
  composer require laravel/socialite
  ```
- [X] Install Guzzle HTTP client (if not included)
  ```bash
  composer require guzzlehttp/guzzle
  ```
- [X] Setup Google OAuth credentials in `.env`
  ```
  GOOGLE_CLIENT_ID=
  GOOGLE_CLIENT_SECRET=
  GOOGLE_REDIRECT_URI=
  ```
- [X] Add MapLibre GL JS to package.json (or use CDN)

**Deliverable:** All dependencies installed

---

### ✅ Task 1.4: Create Project Structure
**Priority:** MEDIUM  
**Estimated Time:** 1 hour

- [X] Create Controllers:
  ```bash
  php artisan make:controller HomeController
  php artisan make:controller CafeController
  php artisan make:controller SearchController
  php artisan make:controller ReviewController
  php artisan make:controller BookmarkController
  php artisan make:controller ReportController
  php artisan make:controller Admin/DashboardController
  php artisan make:controller Admin/CafeModerationController
  php artisan make:controller Admin/ReviewModerationController
  ```
- [X] Create Models:
  ```bash
  php artisan make:model Cafe -m
  php artisan make:model Facility -m
  php artisan make:model Review -m
  php artisan make:model Bookmark -m
  php artisan make:model Report -m
  ```
- [X] Create Services folder:
  ```bash
  mkdir app/Services
  touch app/Services/GeocodingService.php
  touch app/Services/GoogleMapsParser.php
  touch app/Services/DistanceCalculator.php
  ```
- [X] Create Middleware:
  ```bash
  php artisan make:middleware IsAdmin
  ```

**Deliverable:** Complete folder structure

---

## 🗄️ PHASE 2: DATABASE & MODELS (Day 2)

### ✅ Task 2.1: Create Database Migrations
**Priority:** HIGH  
**Estimated Time:** 2 hours

- [X] Modify users migration to add:
  - `google_id` (string, unique)
  - `avatar` (string, nullable)
  - `is_admin` (boolean, default false)

- [X] Create facilities migration with seeder data:
  - Playground
  - Mini Zoo
  - Highchair
  - Mainan

- [X] Create cafes migration:
  - name, address, latitude, longitude
  - google_maps_url, status (pending/active/deleted)
  - submitted_by (foreign key to users)
  - Add indexes on (latitude, longitude) and status

- [X] Create cafe_facilities pivot migration

- [X] Create reviews migration:
  - cafe_id, user_id, rating (1-5)
  - review_text, status (pending/approved/rejected)
  - Add indexes

- [X] Create bookmarks migration:
  - user_id, cafe_id
  - Unique constraint on (user_id, cafe_id)

- [X] Create reports migration:
  - cafe_id, user_id, reason, description
  - status (pending/resolved/dismissed)

- [X] Run migrations:
  ```bash
  php artisan migrate
  ```

**Deliverable:** All database tables created with proper relationships

---

### ✅ Task 2.2: Setup Model Relationships
**Priority:** HIGH  
**Estimated Time:** 1.5 hours

- [X] **User Model:**
  - hasMany reviews
  - hasMany bookmarks
  - hasMany submitted_cafes (cafes)
  - hasMany reports

- [X] **Cafe Model:**
  - belongsTo submitter (User)
  - belongsToMany facilities
  - hasMany reviews
  - hasMany bookmarks
  - hasMany reports
  - Add scope for active cafes
  - Add accessor for average rating

- [X] **Facility Model:**
  - belongsToMany cafes

- [X] **Review Model:**
  - belongsTo cafe
  - belongsTo user
  - Add scope for approved reviews

- [X] **Bookmark Model:**
  - belongsTo user
  - belongsTo cafe

- [X] **Report Model:**
  - belongsTo cafe
  - belongsTo user

**Deliverable:** All model relationships working

---

### ✅ Task 2.3: Create Database Seeders
**Priority:** MEDIUM  
**Estimated Time:** 1 hour

- [X] Create FacilitySeeder:
  ```bash
  php artisan make:seeder FacilitySeeder
  ```
  - Seed 4 facilities (Playground, Mini Zoo, Highchair, Mainan)

- [X] Create AdminUserSeeder:
  ```bash
  php artisan make:seeder AdminUserSeeder
  ```
  - Create admin user with is_admin = true

- [X] Create TestCafeSeeder (optional for development):
  - Create 5 test cafes in Yogyakarta
  - Create 5 test cafes in Solo

- [X] Run seeders:
  ```bash
  php artisan db:seed
  ```

**Deliverable:** Database populated with initial data

---

## 🔐 PHASE 3: AUTHENTICATION (Day 2-3)

### ✅ Task 3.1: Setup Google OAuth
**Priority:** HIGH  
**Estimated Time:** 2 hours

- [ ] Configure Google OAuth in `config/services.php`:
  ```php
  'google' => [
      'client_id' => env('GOOGLE_CLIENT_ID'),
      'client_secret' => env('GOOGLE_CLIENT_SECRET'),
      'redirect' => env('GOOGLE_REDIRECT_URI'),
  ]
  ```

- [ ] Create GoogleAuthController:
  ```bash
  php artisan make:controller Auth/GoogleAuthController
  ```

- [ ] Implement redirect method
- [ ] Implement callback method
- [ ] Handle user creation/update
- [ ] Store user session

- [ ] Add routes in `routes/web.php`:
  ```php
  Route::get('auth/google', [GoogleAuthController::class, 'redirect']);
  Route::get('auth/google/callback', [GoogleAuthController::class, 'callback']);
  ```

- [ ] Update login page to show "Login with Google" button

**Deliverable:** Working Google OAuth authentication

---

### ✅ Task 3.2: Create Admin Middleware
**Priority:** HIGH  
**Estimated Time:** 30 minutes

- [ ] Implement IsAdmin middleware check:
  ```php
  if (!auth()->user()->is_admin) {
      abort(403);
  }
  ```

- [ ] Register middleware in `app/Http/Kernel.php`

- [ ] Create admin route group in `routes/web.php`:
  ```php
  Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
      // Admin routes here
  });
  ```

**Deliverable:** Admin access control working

---

## 🛠️ PHASE 4: CORE SERVICES (Day 3)

### ✅ Task 4.1: Build GeocodingService
**Priority:** HIGH  
**Estimated Time:** 1.5 hours

- [ ] Create GeocodingService class
- [ ] Implement geocode() method using Nominatim API
- [ ] Add User-Agent header (required by Nominatim)
- [ ] Implement 1 second rate limiting
- [ ] Add caching layer (24 hours TTL)
- [ ] Add error handling
- [ ] Filter results by Indonesia only (countrycodes=id)

- [ ] Test geocoding with sample addresses:
  - "Malioboro, Yogyakarta"
  - "Jalan Solo, Surakarta"

**Deliverable:** Working geocoding service with caching

---

### ✅ Task 4.2: Build GoogleMapsParser
**Priority:** HIGH  
**Estimated Time:** 1 hour

- [ ] Create GoogleMapsParser class
- [ ] Implement extractCoordinates() method
- [ ] Support multiple URL patterns:
  - `/@latitude,longitude,zoom`
  - `/place/name/@latitude,longitude`
  - `?q=latitude,longitude`
- [ ] Implement validateCoordinates() method
- [ ] Add error handling for invalid URLs

- [ ] Test with sample Google Maps URLs:
  - Long URL format
  - Short URL format (goo.gl)

**Deliverable:** Working Google Maps URL parser

---

### ✅ Task 4.3: Build DistanceCalculator
**Priority:** HIGH  
**Estimated Time:** 45 minutes

- [ ] Create DistanceCalculator class
- [ ] Implement Haversine formula calculation
- [ ] Add method haversineDistance(lat1, lon1, lat2, lon2)
- [ ] Return distance in kilometers

- [ ] Test with known coordinates:
  - Yogyakarta to Solo (~65km)
  - Two nearby locations (<1km)

**Deliverable:** Accurate distance calculation

---

## 🔍 PHASE 5: SEARCH & FILTER (Day 3-4)

### ✅ Task 5.1: Build Homepage with Search
**Priority:** HIGH  
**Estimated Time:** 2 hours

- [ ] Create HomeController index method
- [ ] Create homepage view (resources/views/home.blade.php)
- [ ] Add hero section with app name and tagline
- [ ] Implement geolocation detection:
  ```javascript
  navigator.geolocation.getCurrentPosition(success, error)
  ```
- [ ] Add manual address input field
- [ ] Add "Detect My Location" button
- [ ] Add facility filter checkboxes (Playground, Mini Zoo, Highchair, Mainan)
- [ ] Add "Cari Cafe" submit button
- [ ] Style with Tailwind CSS

**Deliverable:** Functional homepage with search form

---

### ✅ Task 5.2: Build Search Logic
**Priority:** HIGH  
**Estimated Time:** 3 hours

- [ ] Create SearchController
- [ ] Implement search() method with validation:
  - latitude (required, numeric, -90 to 90)
  - longitude (required, numeric, -180 to 180)
  - facilities (optional, array)

- [ ] Implement Haversine distance SQL query
- [ ] Filter by 5km radius
- [ ] Filter by status = 'active'
- [ ] Apply facility filters (AND logic)
- [ ] Order by distance (nearest first)
- [ ] Add pagination (10 results per page)

- [ ] Create search results view
- [ ] Handle no results scenario

**Deliverable:** Working search with distance calculation

---

### ✅ Task 5.3: Build Search Results Page
**Priority:** HIGH  
**Estimated Time:** 2.5 hours

- [ ] Create results view (resources/views/search/results.blade.php)
- [ ] Split layout: Map (left) | List (right) on desktop
- [ ] Stack layout on mobile

**Map Section:**
- [ ] Add MapLibre map container (600px height)
- [ ] Initialize map centered on user location
- [ ] Add user location marker (blue)
- [ ] Add cafe markers (red)
- [ ] Add 5km radius circle overlay
- [ ] Add marker popups with cafe info

**List Section:**
- [ ] Display result count
- [ ] Create cafe cards with:
  - Cafe name
  - Address
  - Distance (formatted: "2.3 km")
  - Facility icons
  - Rating (if available)
  - "Lihat Detail" button
  - "Navigasi" button (Google Maps deep link)
- [ ] Add pagination

**Deliverable:** Complete search results page with map

---

## 📍 PHASE 6: CAFE DETAILS & SUBMISSION (Day 4-5)

### ✅ Task 6.1: Build Cafe Detail Page
**Priority:** HIGH  
**Estimated Time:** 2.5 hours

- [ ] Create CafeController show() method
- [ ] Load cafe with relationships (facilities, reviews, bookmarks)
- [ ] Calculate average rating
- [ ] Create detail view (resources/views/cafes/show.blade.php)

**Page Sections:**
- [ ] Cafe header (name, address, distance)
- [ ] Embedded MapLibre map (single marker)
- [ ] Facilities list with icons
- [ ] "Navigasi via Google Maps" button
- [ ] "Bookmark" button (if logged in)
- [ ] "Tulis Review" button (if logged in)
- [ ] "Laporkan Info Tidak Valid" link

- [ ] Reviews section:
  - Average rating (large display)
  - Rating breakdown (5★ to 1★ with bars)
  - List of approved reviews
  - Sort options (Terbaru / Rating Tertinggi)

**Deliverable:** Complete cafe detail page

---

### ✅ Task 6.2: Build Cafe Submission Form
**Priority:** HIGH  
**Estimated Time:** 3 hours

- [ ] Create route (protected by auth middleware)
- [ ] Create CafeController create() method
- [ ] Create submission view (resources/views/cafes/create.blade.php)

**Form Fields:**
- [ ] Nama Cafe (text input, required)
- [ ] Alamat Lengkap (textarea, required)
- [ ] Link Google Maps (URL input, optional)
- [ ] Koordinat section with 3 options:
  - Button: "Parse dari Google Maps Link"
  - Button: "Cari Koordinat Otomatis" (Nominatim)
  - Manual input: Latitude & Longitude fields
- [ ] Facility checkboxes (min 1 required)
- [ ] Map preview (shows marker after coordinates set)

**JavaScript Logic:**
- [ ] Implement parseGoogleMapsUrl() AJAX call
- [ ] Implement geocodeAddress() AJAX call
- [ ] Update map preview when coordinates change
- [ ] Enable draggable marker for fine-tuning

- [ ] Implement CafeController store() method:
  - Validate all inputs
  - Check duplicate cafes (by name + proximity)
  - Save with status 'pending'
  - Attach facilities
  - Redirect with success message

**Deliverable:** Working cafe submission form with map preview

---

### ✅ Task 6.3: Build Review System
**Priority:** MEDIUM  
**Estimated Time:** 2 hours

- [ ] Create ReviewController
- [ ] Add review form on cafe detail page (for logged-in users)

**Form Fields:**
- [ ] Star rating selector (1-5 stars, required)
- [ ] Review text (textarea, optional, max 500 chars)
- [ ] Submit button

- [ ] Implement store() method:
  - Validate rating (1-5)
  - Validate text length
  - Check if user already reviewed this cafe
  - Save with status 'pending'
  - Show confirmation message

- [ ] Display pending status to user
- [ ] Only show approved reviews on detail page

**Deliverable:** Working review submission system

---

## 🔖 PHASE 7: BOOKMARKS & REPORTS (Day 5)

### ✅ Task 7.1: Build Bookmark Feature
**Priority:** MEDIUM  
**Estimated Time:** 1.5 hours

- [ ] Create BookmarkController
- [ ] Add heart icon to cafe cards and detail page
- [ ] Implement toggle() method:
  - Check if bookmark exists
  - If exists: delete bookmark
  - If not exists: create bookmark
  - Return JSON response for AJAX

- [ ] Add JavaScript:
  - Handle heart icon click
  - Toggle icon state (filled/outline)
  - Update UI without page reload

- [ ] Create bookmarks page (resources/views/profile/bookmarks.blade.php):
  - List all bookmarked cafes
  - Same layout as search results
  - Add "Remove" button
  - Handle empty state

- [ ] Add "My Bookmarks" link to navigation

**Deliverable:** Working bookmark system with user page

---

### ✅ Task 7.2: Build Report System
**Priority:** MEDIUM  
**Estimated Time:** 1.5 hours

- [ ] Create ReportController
- [ ] Add "Laporkan Info Tidak Valid" link on cafe detail page
- [ ] Create report modal/form with fields:
  - Cafe name (auto-filled, readonly)
  - Reason dropdown:
    - Cafe sudah tutup
    - Fasilitas tidak sesuai
    - Alamat/koordinat salah
    - Lainnya
  - Keterangan tambahan (textarea, optional)

- [ ] Implement store() method:
  - Validate reason selection
  - Save report with status 'pending'
  - Send notification to admin (optional: email)
  - Show confirmation to user

**Deliverable:** Working report system

---

## 👑 PHASE 8: ADMIN PANEL (Day 5-6)

### ✅ Task 8.1: Build Admin Dashboard
**Priority:** HIGH  
**Estimated Time:** 2 hours

- [ ] Create Admin/DashboardController
- [ ] Create admin layout (resources/views/layouts/admin.blade.php)
- [ ] Create dashboard view (resources/views/admin/dashboard.blade.php)

**Dashboard Widgets:**
- [ ] Total cafes (active count)
- [ ] Pending cafe submissions (count)
- [ ] Pending reviews (count)
- [ ] Total registered users (count)
- [ ] Pending reports (count)

- [ ] Add quick links to moderation pages
- [ ] Style with Tailwind CSS (admin theme)

**Deliverable:** Admin dashboard with metrics

---

### ✅ Task 8.2: Build Cafe Moderation
**Priority:** HIGH  
**Estimated Time:** 3 hours

- [ ] Create Admin/CafeModerationController
- [ ] Create moderation view (resources/views/admin/cafes/moderation.blade.php)

**Pending Queue Table:**
- [ ] Columns: Submitter, Nama Cafe, Alamat, Koordinat, Facilities, Tanggal Submit
- [ ] Add "View Details" button for each submission

**Detail Modal/Page:**
- [ ] Show all submitted data
- [ ] **Map preview** with marker at submitted coordinates
- [ ] Option to drag marker to adjust location
- [ ] Edit form to correct data if needed
- [ ] Approve button (change status to 'active')
- [ ] Reject button with reason field

- [ ] Implement approve() method:
  - Update coordinates if adjusted
  - Change status to 'active'
  - Redirect back to queue

- [ ] Implement reject() method:
  - Change status to 'deleted'
  - Store rejection reason
  - Optional: notify submitter

**All Cafes Table:**
- [ ] List all cafes (active + pending + deleted)
- [ ] Filter by status
- [ ] Search by name
- [ ] Actions: Edit, Delete, View

**Deliverable:** Complete cafe moderation system

---

### ✅ Task 8.3: Build Review Moderation
**Priority:** MEDIUM  
**Estimated Time:** 1.5 hours

- [ ] Create Admin/ReviewModerationController
- [ ] Create moderation view (resources/views/admin/reviews/moderation.blade.php)

**Pending Reviews Table:**
- [ ] Columns: Reviewer Name, Cafe, Rating, Review Text, Date
- [ ] Actions: Approve, Reject

- [ ] Implement approve() method:
  - Change status to 'approved'
  - Review appears on cafe detail page

- [ ] Implement reject() method:
  - Change status to 'rejected'
  - Optional: add reason

**Filter Options:**
- [ ] Show: All / Pending / Approved / Rejected

**Deliverable:** Working review moderation

---

### ✅ Task 8.4: Build Report Management
**Priority:** MEDIUM  
**Estimated Time:** 1.5 hours

- [ ] Create Admin/ReportController
- [ ] Create management view (resources/views/admin/reports/index.blade.php)

**Reports Table:**
- [ ] Columns: Reporter, Cafe, Reason, Description, Status, Date
- [ ] Click to expand full details

**Actions:**
- [ ] "View Cafe" button (link to cafe detail)
- [ ] "Edit Cafe" button (if coordinates/info wrong)
- [ ] "Delete Cafe" button (if cafe closed)
- [ ] "Mark as Resolved" button
- [ ] "Dismiss Report" button

- [ ] Implement action methods

**Deliverable:** Complete report management

---

## 🗺️ PHASE 9: MAPLIBRE INTEGRATION (Day 6)

### ✅ Task 9.1: Setup MapLibre Assets
**Priority:** HIGH  
**Estimated Time:** 1 hour

- [ ] Choose tile provider:
  - Option A: Maptiler (register for free API key, 100k requests/month)
  - Option B: OpenStreetMap direct (no key needed)

- [ ] Add MapLibre CSS to layout:
  ```html
  <link href="https://unpkg.com/maplibre-gl@3/dist/maplibre-gl.css" rel="stylesheet" />
  ```

- [ ] Add MapLibre JS to layout:
  ```html
  <script src="https://unpkg.com/maplibre-gl@3/dist/maplibre-gl.js"></script>
  ```

- [ ] Create map.js in resources/js/
- [ ] Create CafeMap class with methods:
  - init()
  - addUserMarker()
  - addCafeMarkers()
  - addRadiusCircle()
  - fitBounds()

**Deliverable:** MapLibre ready to use across app

---

### ✅ Task 9.2: Integrate Maps in Search Results
**Priority:** HIGH  
**Estimated Time:** 2 hours

- [ ] Add map container to search results page
- [ ] Pass cafe data to JavaScript as JSON
- [ ] Initialize map on page load
- [ ] Add user location marker (blue)
- [ ] Add cafe markers (red) with data from backend
- [ ] Implement marker clustering (if >20 cafes)
- [ ] Add popups to markers:
  - Cafe name
  - Distance
  - "Lihat Detail" link
- [ ] Add 5km radius circle overlay
- [ ] Sync map with list (hover/click interactions)

**Deliverable:** Interactive map on search results

---

### ✅ Task 9.3: Integrate Maps in Detail Page
**Priority:** MEDIUM  
**Estimated Time:** 1 hour

- [ ] Add map container to cafe detail page
- [ ] Initialize map centered on cafe
- [ ] Add single cafe marker
- [ ] Higher zoom level (15-16)
- [ ] Add cafe info popup
- [ ] Make map responsive

**Deliverable:** Map on cafe detail page

---

### ✅ Task 9.4: Integrate Maps in Submission Form
**Priority:** HIGH  
**Estimated Time:** 1.5 hours

- [ ] Add map preview container in submission form
- [ ] Initialize map (default center: Yogyakarta)
- [ ] Update map when coordinates are set (parse/geocode/manual)
- [ ] Add draggable marker
- [ ] Update latitude/longitude fields when marker dragged
- [ ] Add zoom controls
- [ ] Show loading state during geocoding

**Deliverable:** Interactive map preview in submission

---

### ✅ Task 9.5: Integrate Maps in Admin Moderation
**Priority:** HIGH  
**Estimated Time:** 1.5 hours

- [ ] Add map preview in cafe moderation page
- [ ] Show submitted cafe location
- [ ] Make marker draggable for admin to adjust
- [ ] Update hidden coordinate fields on drag
- [ ] Add "Reset to Original" button
- [ ] Highlight if coordinates were adjusted

**Deliverable:** Map tools for admin moderation

---

## 🎨 PHASE 10: UI/UX POLISH (Day 6-7)

### ✅ Task 10.1: Design Consistency
**Priority:** MEDIUM  
**Estimated Time:** 2 hours

- [ ] Choose color scheme:
  - Primary color (e.g., blue/green for family-friendly)
  - Secondary color
  - Accent color for CTAs
- [ ] Apply consistent spacing (Tailwind spacing scale)
- [ ] Consistent button styles across app
- [ ] Consistent card designs
- [ ] Add hover effects
- [ ] Add loading spinners for async actions
- [ ] Add transition animations

**Deliverable:** Consistent UI across all pages

---

### ✅ Task 10.2: Responsive Design
**Priority:** HIGH  
**Estimated Time:** 2.5 hours

- [ ] Test all pages on mobile (375px width)
- [ ] Fix map/list layout on mobile (stack vertically)
- [ ] Make navigation mobile-friendly (hamburger menu)
- [ ] Test forms on mobile
- [ ] Fix map controls on mobile
- [ ] Test geolocation on mobile browser
- [ ] Ensure touch-friendly buttons (min 44x44px)

**Deliverable:** Fully responsive website

---

### ✅ Task 10.3: Error Handling & Validation
**Priority:** HIGH  
**Estimated Time:** 2 hours

- [ ] Add client-side validation messages
- [ ] Add server-side validation error displays
- [ ] Handle geolocation errors gracefully
- [ ] Handle geocoding failures with fallback
- [ ] Handle map loading errors
- [ ] Add 404 page
- [ ] Add 403 page (unauthorized)
- [ ] Add 500 page (server error)
- [ ] Add empty states (no results, no bookmarks, etc.)

**Deliverable:** Robust error handling

---

### ✅ Task 10.4: Loading States & Feedback
**Priority:** MEDIUM  
**Estimated Time:** 1.5 hours

- [ ] Add loading spinner during search
- [ ] Add loading state for geocoding
- [ ] Add loading state for map tiles
- [ ] Add success toast messages (cafe submitted, review sent, etc.)
- [ ] Add error toast messages
- [ ] Add confirmation dialogs (delete actions)
- [ ] Add progress indicators for multi-step forms

**Deliverable:** Clear user feedback throughout app

---

## ✅ PHASE 11: TESTING & QA (Day 7)

### ✅ Task 11.1: Functional Testing
**Priority:** HIGH  
**Estimated Time:** 2 hours

**User Flow Tests:**
- [ ] Test Google OAuth login flow
- [ ] Test search with GPS detection
- [ ] Test search with manual address input
- [ ] Test facility filters (single & multiple)
- [ ] Test search with no results
- [ ] Test cafe detail page
- [ ] Test cafe submission (all 3 coordinate methods)
- [ ] Test review submission
- [ ] Test bookmark toggle
- [ ] Test report submission

**Admin Flow Tests:**
- [ ] Test admin login
- [ ] Test cafe moderation (approve/reject)
- [ ] Test review moderation
- [ ] Test report management
- [ ] Test cafe editing
- [ ] Test cafe deletion

**Deliverable:** All user flows working correctly

---

### ✅ Task 11.2: Map Testing
**Priority:** HIGH  
**Estimated Time:** 1 hour

- [ ] Test map rendering on different browsers (Chrome, Firefox, Safari)
- [ ] Test map on mobile devices
- [ ] Test marker clustering
- [ ] Test popup interactions
- [ ] Test marker dragging in admin/submission
- [ ] Test radius circle display
- [ ] Test map performance with 50+ markers
- [ ] Test tile loading (check for 404s)

**Deliverable:** Maps working across all devices

---

### ✅ Task 11.3: Data Validation Testing
**Priority:** HIGH  
**Estimated Time:** 1 hour

- [ ] Test coordinate validation (out of bounds)
- [ ] Test duplicate cafe submission
- [ ] Test required field validation
- [ ] Test URL format validation
- [ ] Test rating validation (1-5 only)
- [ ] Test SQL injection attempts (Laravel should protect)
- [ ] Test XSS attempts in review text

**Deliverable:** Secure data validation

---

### ✅ Task 11.4: Performance Testing
**Priority:** MEDIUM  
**Estimated Time:** 1 hour

- [ ] Test page load times
- [ ] Test search query performance
- [ ] Test map rendering time
- [ ] Test with 100+ cafes in database
- [ ] Check for N+1 query issues
- [ ] Test caching (geocoding results)
- [ ] Test rate limiting (Nominatim)

**Deliverable:** Optimized performance

---

## 🌱 PHASE 12: DATA SEEDING & DEPLOYMENT (Day 7)

### ✅ Task 12.1: Seed Initial Cafe Data
**Priority:** HIGH  
**Estimated Time:** 2 hours

**Manual Entry via Admin Panel:**
- [ ] Find 5 cafes in Yogyakarta with kid facilities
- [ ] Find 5 cafes in Solo with kid facilities
- [ ] For each cafe:
  - Get Google Maps link
  - Extract/find coordinates
  - Submit via admin panel
  - Verify location on map
  - Add correct facilities
  - Approve immediately

- [ ] Verify all 10 cafes appear in search results
- [ ] Verify map markers display correctly

**Deliverable:** 10 real cafes in database

---

### ✅ Task 12.2: Deployment Preparation
**Priority:** HIGH  
**Estimated Time:** 2 hours

- [ ] Choose hosting provider:
  - Option A: Shared hosting (Niagahoster, Dewaweb)
  - Option B: VPS (DigitalOcean, Vultr)
  - Option C: Platform (Laravel Forge, Ploi)

- [ ] Setup production environment:
  - [ ] Configure server (PHP 8.1+, MySQL, SSL)
  - [ ] Point domain to server
  - [ ] Setup SSL certificate (Let's Encrypt)

- [ ] Configure production `.env`:
  - [ ] Set APP_ENV=production
  - [ ] Set APP_DEBUG=false
  - [ ] Configure database credentials
  - [ ] Add Google OAuth production credentials
  - [ ] Add Maptiler key (if using)

- [ ] Optimize for production:
  ```bash
  composer install --optimize-autoloader --no-dev
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  npm run build
  ```

- [ ] Setup database on production server
- [ ] Run migrations on production
- [ ] Run seeders (facilities, admin user)

**Deliverable:** App deployed to production

---

### ✅ Task 12.3: Post-Deployment Testing
**Priority:** HIGH  
**Estimated Time:** 1 hour

- [ ] Test production URL loads correctly
- [ ] Test SSL certificate (HTTPS)
- [ ] Test Google OAuth (production callback URL)
- [ ] Test geolocation on HTTPS
- [ ] Test search functionality
- [ ] Test map loading (tiles, markers