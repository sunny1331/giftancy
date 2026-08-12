<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Giftancy Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">
                <h1 class="text-3xl font-bold mb-2">
                    Welcome to Giftancy 🚀
                </h1>

                <p class="text-gray-600">
                    Laravel Backend is working successfully.
                </p>

                <hr class="my-6">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <div class="bg-blue-100 rounded-lg p-5">
                        <h3 class="text-lg font-bold">Products</h3>
                        <p class="text-3xl mt-2">0</p>
                    </div>

                    <div class="bg-green-100 rounded-lg p-5">
                        <h3 class="text-lg font-bold">Categories</h3>
                        <p class="text-3xl mt-2">0</p>
                    </div>

                    <div class="bg-yellow-100 rounded-lg p-5">
                        <h3 class="text-lg font-bold">Orders</h3>
                        <p class="text-3xl mt-2">0</p>
                    </div>

                    <div class="bg-red-100 rounded-lg p-5">
                        <h3 class="text-lg font-bold">Users</h3>
                        <p class="text-3xl mt-2">1</p>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>