<x-admin-layout>

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">
            Welcome, {{ auth()->user()->name }} 👋
        </h1>

        <p class="text-gray-500 mt-1">
            Here's what's happening with your Giftancy store today.
        </p>
    </div>


    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-xl border p-6">
            <p class="text-sm text-gray-500">Total Orders</p>
            <p class="text-3xl font-bold mt-2">0</p>
            <p class="text-xs text-gray-400 mt-2">
                No orders yet
            </p>
        </div>

        <div class="bg-white rounded-xl border p-6">
            <p class="text-sm text-gray-500">Revenue</p>
            <p class="text-3xl font-bold mt-2">₹0</p>
            <p class="text-xs text-gray-400 mt-2">
                Current revenue
            </p>
        </div>

        <div class="bg-white rounded-xl border p-6">
            <p class="text-sm text-gray-500">Customers</p>
            <p class="text-3xl font-bold mt-2">0</p>
            <p class="text-xs text-gray-400 mt-2">
                Registered customers
            </p>
        </div>

        <div class="bg-white rounded-xl border p-6">
            <p class="text-sm text-gray-500">Products</p>
            <p class="text-3xl font-bold mt-2">0</p>
            <p class="text-xs text-gray-400 mt-2">
                Active products
            </p>
        </div>

    </div>


    {{-- Recent Orders --}}
    <div class="bg-white rounded-xl border mt-6">

        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">
                Recent Orders
            </h2>
        </div>

        <div class="p-10 text-center text-gray-500">
            No orders available yet.
        </div>

    </div>

</x-admin-layout>