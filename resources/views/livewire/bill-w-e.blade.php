<div>
     <div class="flex justify-end">
            <button type="button"
            wire:click = "openImport"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Import</button>
    </div>
   <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="flex mt-4 justify-between">
        <div class="flex ">
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
           <div class="flex mx-5 items-center">
              @if (!$bills->isEmpty())
                    <button type="button"
                        wire:click="openGenInvoice"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3 me-2 mb-2 ml-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        generate invoice
                </button>
                @endif
           </div>
       
    </div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
             @if (!$bills->isEmpty())
             <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                @if ($typeQuery == "WA" || $typeQuery == "EC")
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
                @else
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
                              Open Time 
                            </th>
                            <th scope="col" class="px-6 py-3">
                               Close Time 
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
                                {{ $bill->bill_open}}
                            </td> 
                            <td class="px-6 py-4">
                                {{ $bill->bill_close}}
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
                @endif 
            </div>
            @endif
        </div>
    </div>
    {{-- Importmodal --}}
    @if($showImportModal)
        <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeImport"></div>
        <form wire:submit.prevent="bill" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" 
        :style="{ 'max-height': '400px', 'max-width' : '500px' }">
            <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
                <div class="text-xl font-bold">Import Bill</div>
                <button wire:click="closeImport" type="button" class="focus:outline-none">
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
    @if ($showGenerateInvoice)
    <div class="fixed inset-0 p-4 flex flex-wrap justify-center items-center w-full h-full z-[1000] before:fixed before:inset-0 before:w-full before:h-full before:bg-[rgba(0,0,0,0.5)] overflow-auto font-[sans-serif]">
 <div class="fixed inset-0 bg-gray-300 opacity-40" wire:click="closeGenInvoice"></div>
   <div class="w-full max-w-md bg-white shadow-lg rounded-md p-6 relative">
     <svg wire:click="closeGenInvoice" xmlns="http://www.w3.org/2000/svg"
       class="w-3.5 cursor-pointer shrink-0 fill-black hover:fill-red-500 float-right" viewBox="0 0 320.591 320.591">
       <path
         d="M30.391 318.583a30.37 30.37 0 0 1-21.56-7.288c-11.774-11.844-11.774-30.973 0-42.817L266.643 10.665c12.246-11.459 31.462-10.822 42.921 1.424 10.362 11.074 10.966 28.095 1.414 39.875L51.647 311.295a30.366 30.366 0 0 1-21.256 7.288z"
         data-original="#000000"></path>
       <path
         d="M287.9 318.583a30.37 30.37 0 0 1-21.257-8.806L8.83 51.963C-2.078 39.225-.595 20.055 12.143 9.146c11.369-9.736 28.136-9.736 39.504 0l259.331 257.813c12.243 11.462 12.876 30.679 1.414 42.922-.456.487-.927.958-1.414 1.414a30.368 30.368 0 0 1-23.078 7.288z"
         data-original="#000000"></path>
     </svg>
     <div class="my-8 text-center flex align-middle justify-center">
        <svg width="149px" height="149px" viewBox="0 0 512.00 512.00" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#22c55e;} .st1{fill:none;stroke:#22c55e;stroke-width:32;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;} </style> <g id="Layer_1"></g> <g id="Layer_2"> <g> <path class="st0" d="M256,43.5C138.64,43.5,43.5,138.64,43.5,256S138.64,468.5,256,468.5S468.5,373.36,468.5,256 S373.36,43.5,256,43.5z M378.81,222.92L249.88,351.86c-7.95,7.95-18.52,12.33-29.76,12.33s-21.81-4.38-29.76-12.33l-57.17-57.17 c-8.3-8.3-12.87-19.35-12.87-31.11s4.57-22.81,12.87-31.11c8.31-8.31,19.36-12.89,31.11-12.89s22.8,4.58,31.11,12.89l24.71,24.7 l96.47-96.47c8.31-8.31,19.36-12.89,31.11-12.89c11.75,0,22.8,4.58,31.11,12.89c8.3,8.3,12.87,19.35,12.87,31.11 S387.11,214.62,378.81,222.92z"></path> </g> </g> </g></svg>
     </div> 
    <h4 class="text-xl font-semibold text-center">Do You want to generate invoice</h4>
     <div class="flex flex-col space-y-2">
       <button wire:click="genInvoice" type="button"
         class="px-6 py-2.5 rounded-md text-white text-sm font-semibold border-none outline-none bg-green-500 hover:bg-green-600 active:bg-green-500">Generate Invoice</button>
       <button wire:click="closeGenInvoice" type="button"
         class="px-6 py-2.5 rounded-md text-black text-sm font-semibold border-none outline-none bg-gray-200 hover:bg-gray-300 active:bg-gray-200">Cancel</button>
     </div>
   </div>
 </div>
  @endif
</div>
