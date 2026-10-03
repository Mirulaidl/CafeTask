# Cafe menu redesign — Laravel Blade files

Copy `resources/` into your Laravel project (overwrite):

- resources/css/app.css                      -> warm theme + .frost-card, .btn-*, .input, badges
- resources/views/layouts/app.blade.php      -> layout (adds Fraunces font)
- resources/views/layouts/navigation.blade.php -> mobile-friendly nav (uses Alpine, already in Breeze)
- resources/views/components/status-badge.blade.php -> <x-status-badge :status="$i->status" />
- resources/views/menu/index.blade.php, menu/show.blade.php
- resources/views/admin/search.blade.php, admin/edit.blade.php
- resources/views/auth/login.blade.php

Put index/show/search/edit in the folders your controllers already use
(e.g. if your controller returns view('menu.index'), keep them in views/menu/).

Then run:  npm run build   (or npm run dev)

Notes:
- Uses the same variables/routes as your originals: $items, $categories, $item,
  $meals, $existing, menu.index, menu.show, admin.search/store/edit/update/destroy/export.
- Category filter is now clickable chips; pagination keeps the search with withQueryString().
- Images: the `/preview` suffix was removed for bigger card images. Add it back if you want smaller thumbs.
- Navigation no longer links to `dashboard`; add it back if you use that route.
- Uses Tailwind arbitrary values (e.g. bg-[#c2603a]) — works with Breeze's Tailwind setup, no extra libraries.
