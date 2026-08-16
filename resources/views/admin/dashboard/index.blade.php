<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold">
            Giftancy Admin Dashboard
        </h2>
    </x-slot>

    <div class="p-6">
        <h1 class="text-3xl font-bold">
            Welcome {{ auth()->user()->name }}
        </h1>

        <p class="mt-3 text-gray-600">
            Giftancy Admin Panel is ready 🚀
        </p>
    </div>
</x-app-layout>