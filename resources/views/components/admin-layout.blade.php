<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Giftancy Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen flex">

        {{-- Sidebar --}}
        <aside class="w-64 bg-gray-900 text-white min-h-screen">

            <div class="px-6 py-5 border-b border-gray-700">
                <h1 class="text-2xl font-bold">Giftancy</h1>
                <p class="text-xs text-gray-400 mt-1">Admin Panel</p>
            </div>

            <nav class="p-4 space-y-1">

                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    📊 Dashboard
                </a>

                <div class="pt-4 pb-2 px-4 text-xs uppercase text-gray-500">
                    Catalog
                </div>

                <a href="{{ route('categories.index') }}"
   class="block px-4 py-3 rounded-lg hover:bg-gray-800">
    📂 Categories
</a>

            <a href="{{ route('attributes.index') }}"
   class="block px-4 py-3 rounded-lg hover:bg-gray-800">

    🏷 Attributes

</a>

<a href="{{ route('attribute-values.index') }}"
   class="block px-4 py-3 rounded-lg hover:bg-gray-800">
    🏷 Attribute Values
</a>

                <a href="{{ route('products.index') }}"
   class="block px-4 py-3 rounded-lg hover:bg-gray-800">
    📦 Products
</a>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    ⭐ Reviews
                </a>

                <div class="pt-4 pb-2 px-4 text-xs uppercase text-gray-500">
                    Sales
                </div>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    🛒 Orders
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    ↩️ Returns
                </a>

                <div class="pt-4 pb-2 px-4 text-xs uppercase text-gray-500">
                    Customers
                </div>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    👥 Customers
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    👤 Customer Groups
                </a>

                <div class="pt-4 pb-2 px-4 text-xs uppercase text-gray-500">
                    Marketing
                </div>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    🎟 Coupons
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    🎁 Gift Offers
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    📧 Email Campaigns
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    💬 WhatsApp Campaigns
                </a>

                <div class="pt-4 pb-2 px-4 text-xs uppercase text-gray-500">
                    Growth
                </div>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    🤝 Affiliate
                </a>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    📈 Reports
                </a>

                <div class="pt-4 pb-2 px-4 text-xs uppercase text-gray-500">
                    System
                </div>

                <a href="#" class="block px-4 py-3 rounded-lg hover:bg-gray-800">
                    ⚙️ Settings
                </a>

            </nav>
        </aside>


        <div class="flex-1 min-w-0">

            <header class="bg-white border-b border-gray-200">
                <div class="h-16 px-6 flex items-center justify-between">

                    <h2 class="text-lg font-semibold">
                        {{ $pageTitle ?? 'Dashboard' }}
                    </h2>

                    <div class="flex items-center gap-5">

                        <span class="text-gray-500">🔔</span>

                        <div class="text-right">
                            <p class="text-sm font-medium">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                Administrator
                            </p>
                        </div>

                    </div>

                </div>
            </header>


            <main class="p-6">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>
</html>