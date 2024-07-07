<div>
     <div class="flex justify-end">
            <button type="button"
            wire:click = ""  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Create Receipt</button>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> 
            <div class="p-6 text-gray-900 dark:text-gray-100">
                  
            </div>
    </div>




     {{-- @if($showCreateInvoice) --}}
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click=""></div>
    <form wire:submit.prevent="" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" :style="{ 'max-height': '800px', 'max-width' : '1500px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Receipt</div>
            <button wire:click="closeCreateInvoice" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
                <div class="w-48">
                    <label for="vdate" class="text-xs">Receipt date</label>
                    <input id="vdate" wire:model="" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
              
                <div class="w-80 ml-5">
                    <label for="customercode" class="text-xs">Customer code</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "customercode" wire:model.live="customerCode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option>Select Customer</option>
                        @foreach ($this->customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->cust_code}} : {{$customer->cust_name_th}}</option>
                        @endforeach
                        </select>
                          @error('') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div>
               
                 <div class="w-48 ml-5">
                    <label for="rental" class="text-xs">Contact</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "rental" wire:model.live=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">Select Contact</option>
                             {{-- @if (!is_null($customerCode))
                            @foreach ( $customerrents as $rental )
                                <option value="{{ $rental->id}}">{{ $rental->custr_contract_no}} : {{ $rental->custr_unit }}</option>
                            @endforeach 
                            @endif --}}
                        </select>
                    @error('') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div> 
                <div class="w-48 ml-5">
                    <label for="duedate" class="text-xs">Due Date</label>
                    <input id="duedate" wire:model="" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
            </div>
        </div> 
        <div class="flex-grow bg-white w-full flex flex-col items-center justify-start overflow-y-auto">
            <div>
                {{-- @if($duplicateInput)
                <h3 class="text-red-500 text-xs">There is a duplicate input value in issue field.</h3>
                @endif --}}
                @if (!is_null($invoiceDetails))
                <table class="mt-4 max-w-8xl text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Invoice number</th>
                            <th scope="col" class="px-2 py-3">Contract</th>
                            <th scope="col" class="px-2 py-3">Product code</th>
                            <th scope="col" class="px-2 py-3">Product name</th>
                            <th scope="col" class="px-2 py-3">Net Amt</th>
                            <th scope="col" class="px-2 py-3">Paid Amount</th>
                            <th scope="col" class="px-2 py-3">Paid</th>
                            <th scope="col" class="px-2 py-3">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoiceDetails as $index => $row)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.invdnumber" type="text" class="w-24 p-2 border border-gray-300 rounded text-xs"  disabled/>
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.contact" type="text" class="w-24 p-2 border border-gray-300 rounded text-xs"  disabled/>
                                    </td>
                                   
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.procode" type="text" class="w-20 p-2 border border-gray-300 text-xs rounded" disabled  />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.proname" type="text" class="w-48 p-2 border border-gray-300 text-xs rounded" disabled/>
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.netamt" 
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right" 
                                         disabled
                                         />
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.receiptamt" 
                                        type="number" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right" disabled/>     
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.receiptamt" 
                                        type="number" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right"/>     
                                    </td>
                                
                                <td class="px-6 py-4">
                                    <button type="button" wire:click="removeItem({{ $index }})" class="text-red-500 focus:outline-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div> 
         
        </div>
   
    <div class="bg-gray-100 w-full flex justify-between p-4">
        <div class="flex">
        {{-- <button type="button" wire:click="" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5">Clear</button>
            <form>   
                <input class="ml-2 block w-full text-sm text-slate-500
                file:mr-4 file:py-2.5 file:px-5 file:rounded-md
                file:border-0 file:text-sm file:font-semibold
                file:bg-pink-200 file:text-pink-700
                hover:file:bg-pink-300" type="file" wire:model="">
                <button type="button" wire:click="" class="text-white bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:outline-none focus:ring-slate-300 font-medium rounded-lg text-sm px-5 py-2.5">Import</button>
            </form> 
            <button type="button" wire:click="" class="ml-2 text-white bg-orange-400 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-orange-200 font-medium rounded-lg text-sm px-5 py-2.5">Check</button> --}}
        </div>
        
        <div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Create Invoice</button>
        </div>
    </div>
</form>
</div>
{{-- @endif  --}}
</div>
