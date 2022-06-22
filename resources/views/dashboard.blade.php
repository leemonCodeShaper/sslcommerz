<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="post"
                          action="{{ route('payment.order') }}">
                        <div class="form-group">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="productName">Product
                                Name</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="text" name="productName">
                        </div>
                        <div class="form-group">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="customerName">Customer
                                Name</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="text" name="customerName">
                        </div>
                        <div class="form-group">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="customerEmail">Customer
                                Email</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="email" name="customerEmail">
                        </div>
                        <div class="form-group">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="productPrice">Product
                                Price</label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                type="number" name="productPrice">
                        </div>
                        <input  type="submit" value="checkout">
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
