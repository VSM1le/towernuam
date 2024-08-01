<div>
     <div class="flex justify-end">
            <button type="button"
            wire:click = "openImport"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Import</button>
    </div>
   <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex mt-4">
           <div class="w-48 ml-5">
                <label for="datefrom" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Bill Month</label>
                <input id="datefrom" wire:model.live="monthYear" type="month" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
           </div>
           <div class="w-48 ml-5">
              <label for="customercode" class="text-xs block uppercase tracking-wide text-gray-700 font-bold">Bill type</label>
                <label class="w-40 text-sm font-medium text-gray-900"></label>
                    <select id= "customercode" wire:model.live="typeQuery"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    <option value="WA">Water Bill</option>
                    <option value="EC">Electric Bill</option>
                    <option value="OT">OT Air Bill</option>
                </select>
           </div>
    </div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
             <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                              Invoice Date 
                            </th>
                            <th scope="col" class="px-6 py-3">
                              Invoice Duedate 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Contract No.
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Unit 
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Meter No. 
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Previous Time 
                            </th>
                            <th scope="col" class="px-6 py-3">
                               This Time 
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Rate
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bills as $bill)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                               {{ $bill->invoice_date }} 
                            </th>
                            <td class="px-6 py-4">
                                {{ $bill->due_date}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bill->contract_no }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bill->unit }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bill->meter }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bill->p_time }}
                            </td> 
                            <td class="px-6 py-4">
                                {{ $bill->t_time }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $bill->price_unit }}
                            </td>
                            {{-- <td class="px-6 py-4">
                                <button wire:click="openEditCustomer({{$customer->id}})" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                            </td> --}}
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Importmodal --}}
    @if($showImportModal)
        <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeEditCustomer"></div>
        <form wire:submit.prevent="bill" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
        :style="{ 'max-height': '400px', 'max-width' : '500px' }">
            <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
                <div class="text-xl font-bold">Import Bill</div>
                <button wire:click="closeEditCustomer" type="button" class="focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
              <div class="m-3 ml-5 ">
                    <label  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bill type</label>
                        <label class="w-52 text-sm font-medium text-gray-900"></label>
                        <select wire:model="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-60 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="EC">Electric Fee</option>
                            <option value="WA">Water Fee</option>
                            <option value="OT">OT Air Fee</option>
                        </select>
                </div> 
              <div class=" mt-6  ">
              <input class="ml-2 block text-sm w-60 text-slate-500
                file:mr-4 file:py-2.5 file:px-5 file:rounded-md
                file:border-0 file:text-sm file:font-semibold
                file:bg-pink-200 file:text-pink-700
                hover:file:bg-pink-300" type="file" wire:model="csvFile">  
                @error('csvFile') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                @enderror 
                </div>
            </div>
            <div class="bg-gray-100 w-full flex justify-between p-4">
                <div class="flex">
                </div>
                <div>
                 <button type="submit" 
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Import</button>
                </div>
            </div>
        </form>
        </div>
    @endif 
</div>
