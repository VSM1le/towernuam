<div>
     <div class="flex justify-end">
            <button type="button"
            wire:click = "openCreateCustomer"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Create Invoice</button>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                               Cust code 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Th Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Eng Name 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                TaxId
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Address 1 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Address 2
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer )
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$customer->cust_code}}
                            </th>
                            <td class="px-6 py-4">
                               {{ $customer->cust_name_th}} 
                            </td>
                            <td class="px-6 py-4">
                               {{$customer->cust_name_en}} 
                            </td>
                            <td class="px-6 py-4">
                                {{ $customer->cust_taxid}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $customer->cust_address_th1}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $customer->cust_address_th2}}
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="openEditCustomer({{$customer->id}})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                            </td>
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
             <div class="m-3">
                    {{ $customers->links() }}
                </div>
        </div>
    </div>

    @if($showCreateCustomer)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreateCustomer"></div>
    <form wire:submit.prevent="createCustomer" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
     :style="{ 'max-height': '700px', 'max-width' : '600px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Customer</div>
            <button wire:click="closeCreateCustomer" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div class="flex justify-start w-full">
                <div class="m-3 ml-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer Code</label>
                    <input wire:model="custCode" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="A0000" required />
                </div>
                <div class="m-3">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tax Id</label>
                    <input wire:model="taxId" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
                <div class="m-3 mr-5">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer Type</label>
                        <label class="w-52 text-sm font-medium text-gray-900"></label>
                        <select wire:model="customerType"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Company</option>
                            <option value="1">Government</option>
                            <option value="3">Person</option>
                        </select>
                </div>
            </div>
            <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Th Name</label>
                    <input wire:model="thName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
             <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Eng Name</label>
                    <input wire:model="enName" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
             <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address 1</label>
                    <input placeholder="Address line 1" wire:model="address1"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                </div>
            </div>
             <div class="flex justify-start w-full">
                <div class="m-3 w-full mx-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address 2</label>
                    <input placeholder="Address line 2" wire:model="address2"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                </div>
            </div>
            <div class="flex justify-start">
                <div class="m-3 w-full ml-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zip Code</label>
                    <input wire:model="zipCode" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="m-3 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Branch</label>
                    <input wire:model="branch" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                <div class="m-3 w-full mr-5">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit Cost</label>
                    <input type="number" placeholder="6.5" wire:model="unitCost" step="0.1" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
             <div class="flex justify-start w-full">
                 <div class="m-3 ml-5">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cal vat</label>
                        <label class="w-52 text-sm font-medium text-gray-900"></label>
                        <select wire:model="calVat"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                </div>
                 <div class="m-3">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wh tax</label>
                        <label class="w-52 text-sm font-medium text-gray-900"></label>
                        <select wire:model="whTax"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                </div>
                <div class="m-3 mr-5">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Auto inv</label>
                        <label class="w-52 text-sm font-medium text-gray-900"></label>
                        <select wire:model="autoInv"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                           <option value="Y">Yes</option>
                            <option value="N">No</option> 
                        </select>
                </div>
            </div>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
            </div>
            <div>
            <button type="submit" 
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
            </div>
        </div>
    </form>
    </div>
    @endif 

{{-- editmodal --}}
    @if($showEditCustomer)
        <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditCustomer"></div>
        <form wire:submit.prevent="editCustomer" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
        :style="{ 'max-height': '700px', 'max-width' : '600px' }">
            <div class="bg-yellow-500 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
                <div class="text-xl font-bold">Edit Customer</div>
                <button wire:click="closeEditCustomer" type="button" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
                <div class="flex justify-start w-full">
                    <div class="m-3 ml-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer Code</label>
                        <input wire:model="custCode" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="A0000" required />
                    </div>
                    <div class="m-3">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tax Id</label>
                        <input wire:model="taxId" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    </div>
                    <div class="m-3 mr-5">
                        <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer Type</label>
                            <label class="w-52 text-sm font-medium text-gray-900"></label>
                            <select wire:model="customerType"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Company</option>
                                <option value="1">Government</option>
                                <option value="3">Person</option>
                            </select>
                    </div>
                </div>
                <div class="flex justify-start w-full">
                    <div class="m-3 w-full mx-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Th Name</label>
                        <input wire:model="thName" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    </div>
                </div>
                <div class="flex justify-start w-full">
                    <div class="m-3 w-full mx-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Eng Name</label>
                        <input wire:model="enName" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    </div>
                </div>
                <div class="flex justify-start w-full">
                    <div class="m-3 w-full mx-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address 1</label>
                        <input placeholder="Address line 1" wire:model="address1"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                    </div>
                </div>
                <div class="flex justify-start w-full">
                    <div class="m-3 w-full mx-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address 2</label>
                        <input placeholder="Address line 2" wire:model="address2"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    </div>
                </div>
                <div class="flex justify-start">
                    <div class="m-3 w-full ml-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Zip Code</label>
                        <input wire:model="zipCode" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div class="m-3 w-full">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Branch</label>
                        <input wire:model="branch" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                    <div class="m-3 w-full mr-5">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unit Cost</label>
                        <input type="number" placeholder="6.5" wire:model="unitCost" step="0.1" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                </div>
                <div class="flex justify-start w-full">
                    <div class="m-3 ml-5">
                        <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cal vat</label>
                            <label class="w-52 text-sm font-medium text-gray-900"></label>
                            <select wire:model="calVat"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                    </div>
                    <div class="m-3">
                        <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wh tax</label>
                            <label class="w-52 text-sm font-medium text-gray-900"></label>
                            <select wire:model="whTax"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="Y">Yes</option>
                                <option value="N">No</option>
                            </select>
                    </div>
                    <div class="m-3 mr-5">
                        <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Auto inv</label>
                            <label class="w-52 text-sm font-medium text-gray-900"></label>
                            <select wire:model="autoInv"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-40 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="Y">Yes</option>
                                <option value="N">No</option> 
                            </select>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 w-full flex justify-between p-4">
                <div class="flex">
                </div>
                <div>
                 <button type="submit" 
        class="text-white bg-yellow-500 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">Save</button>
                </div>
            </div>
        </form>
        </div>
    @endif 
</div>
