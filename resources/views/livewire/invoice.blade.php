<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                   test
                </div>
            </div>
        </div>
    </div>


      {{-- Create modal --}}
    {{-- @if($showCreateModal) --}}
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click=""></div>
    <form wire:submit.prevent="" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" :style="{ 'max-height': '800px', 'max-width' : '1500px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Invoice</div>
            <button wire:click="" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
                <div class="w-48">
                    <label for="vdate" class="text-xs">Invoice date</label>
                    <input id="vdate" wire:model="invoiceDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" required /> 
                    {{-- @error('duedate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror  --}}
                </div>
                <div class="w-48 ml-5">
                    <label for="psgroup" class="text-xs">Ps Group</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "pagroup" wire:model.live="psGroup"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option>Select Group</option>
                            @foreach ( $this->psgroups as $psgroup )
                                <option value="{{ $psgroup->id}}">{{ $psgroup->ps_group }}</option>
                            @endforeach
                        </select>
                    {{-- @error('car') 
                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror  --}}
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
                          @error('customerCode') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div>
               
                 <div class="w-48 ml-5">
                    <label for="rental" class="text-xs">Contact</label>
                        <label class="w-40 text-sm font-medium text-gray-900"></label>
                        <select id= "rental" wire:model="rental"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="">Select Contact</option>
                             @if (!is_null($customerCode))
                            @foreach ( $customerrents as $rental )
                                <option value="{{ $rental->id}}">{{ $rental->custr_contract_no}} : {{ $rental->custr_unit }}</option>
                            @endforeach 
                            @endif
                        </select>
                    @error('rental') 
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
                            <th scope="col" class="px-6 py-3">Service Code</th>
                            <th scope="col" class="px-6 py-3">Product/Services</th>
                            <th scope="col" class="px-6 py-3">AMT</th>
                            <th scope="col" class="px-6 py-3">VAT</th>
                            <th scope="col" class="px-6 py-3">VAT AMT</th>
                            <th scope="col" class="px-6 py-3">WH TAX</th>
                            <th scope="col" class="px-6 py-3">WH TAX AMT</th>
                            <th scope="col" class="px-6 py-3">Net AMT</th>
                            <th scope="col" class="px-6 py-3">REMARK</th>
                            <th scope="col" class="px-6 py-3">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($itemDetails as $rowIndex => $row) --}}
                        {{-- <tr>
                            <td class="px-6" >
                                @error('itemDetails.' . $rowIndex . '.customer') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror 
                            </td>
                            <td class="px-6" >
                                @error('itemDetails.' . $rowIndex . '.issue') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror 
                            </td>
                            <td class="px-6" >
                                @error('itemDetails.' . $rowIndex . '.po') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror 
                            </td>
                            <td class="px-6" >
                                @error('itemDetails.' . $rowIndex . '.pr') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror 
                            </td>
                            <td class="px-6" >
                                @error('itemDetails.' . $rowIndex . '.outpart') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror 
                            </td>
                            <td class="px-6" >
                                @error('itemDetails.' . $rowIndex . '.quantity') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror 
                            </td>
                            <td class="px-6" >
                                @error('itemDetails.' . $rowIndex . '.body') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror 
                            </td>
                            <td class="px-6" >
                                @error('itemDetails.' . $rowIndex . '.ship_to') 
                                    <span class="text-red-500 text-xs">{{ $message }}</span> 
                                @enderror 
                            </td>
                        </tr> --}}
                        @foreach ($invoiceDetails as $index => $row)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model.live="invoiceDetails.{{ $index }}.pscode" type="text" class="w-24 p-2 border border-gray-300 rounded text-xs"  disabled/>
                                    </td>
                                   
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model.live="invoiceDetails.{{ $index }}.psname" type="text" class="w-48 p-2 border border-gray-300 text-xs rounded" disabled  />
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.amt" 
                                        wire:change="updateInvoiceDetail({{ $index }}, 'amt', $event.target.value)" 
                                        type="number" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded"  />
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.vat" 
                                        wire:change="updateInvoiceDetail({{ $index }}, 'vat', $event.target.value)" 
                                        type="number" 
                                        class="w-14 p-2 border border-gray-300 text-xs rounded" />     
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.vatamt" type="number" class="w-full p-2 border border-gray-300 text-xs rounded" disabled />
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.whvat" 
                                        wire:change="updateInvoiceDetail({{ $index }}, 'whvat', $event.target.value)"
                                        type="number" 
                                        class="w-14 p-2 border border-gray-300 text-xs rounded" />     
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.whtaxamt" type="number" class="w-full p-2 border border-gray-300 text-xs rounded" disabled />     
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.netamt" type="number" class="w-full p-2 border border-gray-300 text-xs rounded" disabled />     
                                    </td>
                                     <td scope="row" class="px-6 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.remark" type="text" class="w-full p-2 border border-gray-300 text-xs rounded" />     
                                    </td>
                                
                                <td class="px-6 py-4">
                                    <button type="button" wire:click="" class="text-red-500 focus:outline-none">
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
            <div class="w-80 mt-4">
                <label class="w-40 text-sm font-medium text-gray-900"></label>
                <select id= "customercode" wire:model.live="service"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    <option value="">Select Customer</option>
                    @foreach ($this->productservices as $productservice)
                        <option value="{{$productservice->id}}">{{$productservice->ps_code}} : {{$productservice->ps_name_th}}</option>
                    @endforeach
                </select>
            </div>  
            <div class="mt-4">
                <button type="button" wire:click='addline' class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Dark</button>
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
