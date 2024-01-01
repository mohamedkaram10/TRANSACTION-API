<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-2">
                <a class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">All Transactions</a>
            </div>
            <div class="m-2 p-2 bg-slate-100 rounded">
                <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                    <form action="{{ route('admin.transactions.store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="sm:col-span-6">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <div class="mt-1">
                                <input required type="number" id="amount" name="amount"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer
                                Name</label>
                            <div class="mt-1">
                                <input required type="text" id="customer_name" name="customer_name"
                                    class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <label for="due_on" class="block text-sm font-medium text-gray-700">Due on</label>
                            <div class="mt-1">
                                <input type="datetime-local" required id="due_on" name="due_on"
                                    class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                            </div>
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <label for="vat" class="block text-sm font-medium text-gray-700">VAT</label>
                            <div class="mt-1">
                                <input required type="number" id="vat" name="vat"
                                    class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />
                            </div>
                        </div>
                        <div class="sm:col-span-6 pt-5">
                            <label for="Is_vat_inclusive" class="block text-sm font-medium text-gray-700">Is VAT
                                inclusive</label>
                            <div class="mt-1">

                                <input type="checkbox" value="1" id="Is_vat_inclusive" name="Is_vat_inclusive" class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" />

                                {{-- <input name="Is_vat_inclusive"
                                    {{ isset($label['Is_vat_inclusive']) && $label['Is_vat_inclusive'] == 1 ? 'checked' : '' }} value="1"
                                    id="Is_vat_inclusive" type="checkbox" class="switch-input" /> --}}

                            </div>
                        </div>
                        <div class="mt-6 p-4">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white">Store</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>
