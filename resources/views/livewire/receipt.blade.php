<div>
     <div class="flex justify-end">
            <button type="button"
            wire:click = "openCreateReceipt"  
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Create Receipt</button>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"> 
        @if (session()->has('success'))
            <div class="flex items-center p-4  text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800 mb-1" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                  <span class="font-medium">Success alert! </span> {{ session('success') }}
                </div>
              </div>
              @endif
              @if (session()->has('error'))
              <div class="flex items-center p-4 text-sm text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 dark:border-yellow-800 mb-1" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                  <span class="font-medium">Warning alert! </span>{{ session('error') }}
                </div>
              </div>
              @endif
            <div class="p-6 text-gray-900 dark:text-gray-100">
                   @foreach ($receipt as $index => $pland)
                    <div wire:key="items-{{ $index }}" class="wrapper relative ">
                        <div x-data="{ isOpen: false }" @click="isOpen = !isOpen" class="tab px-5 py-2 border-2   
                            bg-slate-100 shadow-lg relative mb-4 rounded-md cursor-pointer">
                            <div 
                                class="flex justify-between items-center font-semibold text-lg after:absolute after:right-5 after:text-2xl after:text-gray-400 hover:after:text-gray-950 peer-checked:after:transform peer-checked:after:rotate-45">
                                <div class="flex">
                                    <h2 class="w-8 h-8 bg-sky-300 text-white flex justify-center items-center rounded-sm mr-3">{{ $index + 1 }}</h2>
                                    <h3>{{ $pland->rec_no}} {{ $pland->customer->cust_name_th ?? null}} {{ strtoupper($pland->rec_payment_type)}} 
                                        WH: {{$pland->receiptdetail->sum('whpay') ?? 0}}</h3>
                                    <h3 class="ml-1"></h3>
                                </div>
                                <div class="flex">
                                     <button wire:click.stop="exportEngPdf({{ $pland->id }})"  class="text-white bg-green-500 hover:bg-green-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       PDF ENG
                                    </button>
                                    <button wire:click.stop="exportPdf({{ $pland->id }})"  class="text-white bg-green-500 hover:bg-green-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       PDF TH
                                    </button>
                                    {{-- <button wire:click.stop="openEditInvoice({{ $pland->id }})"  class="text-white bg-green-500 hover:bg-green-700  font-medium rounded-lg text-sm px-3 py-1.5 me-2 mb-2">
                                       EDIT 
                                    </button> --}}
                                </div>
                            </div>
                            {{-- Accordion content --}}
                            <div x-show="isOpen" class="answer justify-center mt-5 h-full mr-9"> 
                                <div  @click.stop class="overflow-x-auto"> 
                                <table  class="m-6 w-full overflow-x-auto  text-sm text-left rtl:text-right text-gray-500 ">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">
                                                No.
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invoice Number
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Product Name
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                               Product Code 
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd Amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd vat percent
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd vat amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd whtax percent
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Invd whtax amount
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Paid amount 
                                            </th>
                                        </tr>
                                    </thead>
                                     @foreach ($pland->receiptdetail as $listitem)
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                                {{ $loop->iteration }}
                                            </th>
                                            
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                                {{ $listitem->invoicedetail->invoiceheader->inv_no}}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_product_name}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_product_code }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_amt}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_vat_percent}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{$listitem->invoicedetail->invd_vat_amt}}
                                            </td>
                                            
                                            <td class="px-6 py-4">
                                                {{$listitem->invoicedetail->invd_wh_tax_percent}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->invoicedetail->invd_wh_tax_amt}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ $listitem->rec_pay}}
                                            </td>
                                        </tr>   
                                    @endforeach 
                                </table>
                                 </div>
                            </div>
                            {{-- End Accordion content --}}
                        </div>    
                    </div>
                @endforeach
                    
            </div>
    </div>




     @if($showCreateReceipt)
    <div class="fixed inset-0 bg-gray-300 opacity-40"  wire:click="closeCreateReceipt"></div>
    <form wire:submit.prevent="" class="flex flex-col justify-between bg-white rounded m-auto fixed inset-0" :style="{ 'max-height': '800px', 'max-width' : '1500px' }">
        <div class="bg-blue-700 text-white w-full px-4 py-3 flex items-center justify-between border-b border-gray-300">
            <div class="text-xl font-bold">Create Receipt</div>
            <button wire:click="closeCreateReceipt" type="button" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="bg-gray-100 w-full flex justify-between p-4">
            <div class="flex">
                <div class="w-48">
                    <label for="vdate" class="text-xs">Receipt date</label>
                    <input id="vdate" wire:model="receiptDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('receiptDate') 
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
                          @error('customerCode') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                         @enderror
                </div>
                <div class="flex content-center ml-5 border border-slate-500 bg-white rounded">
                    <div class="flex items-center pl-5">
                        <input id="default-radio-1" type="radio" value="cash" wire:model.live="paymentType"  name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cash</label>
                    </div>
                    <div class="flex items-center ml-5">
                        <input id="default-radio-2" type="radio" value="tran" wire:model.live="paymentType" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Transfer money</label>
                    </div>
                     <div class="flex items-center ml-5 pr-5">
                        <input id="default-radio-3" type="radio" value="cheq" wire:model.live="paymentType" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cheque</label>
                    </div>
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
                            <th scope="col" class="px-2 py-3">Percent Wh</th>
                            <th scope="col" class="px-2 py-3">Wh Tax</th>
                            <th scope="col" class="px-2 py-3">Net Amt</th>
                            <th scope="col" class="px-2 py-3">Paid Amt</th>
                            <th scope="col" class="px-2 py-3">Pay</th>
                            <th scope="col" class="px-2 py-3">Wh Pay</th>
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
                                        <input wire:model="invoiceDetails.{{ $index }}.perwh" 
                                        type="number" 
                                        class="w-14 p-2 border border-gray-300 text-xs rounded" 
                                        disabled />     
                                    </td>
                                     <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.whtax" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right" 
                                         disabled
                                         />
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
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right" disabled/>     
                                    </td>
                                    <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.paid" 
                                        wire:change="updateInvoiceDetails({{ $index}},'paid')"
                                        type="number" 
                                        step="0.01" 
                                        class="w-full p-2 border border-gray-300 text-xs rounded text-right"/>     
                                    </td>
                                      <td scope="row" class="px-2 py-4 font-medium text-gray-900 ">
                                        <input wire:model="invoiceDetails.{{ $index }}.whpay" 
                                        wire:change="updateInvoiceDetails({{ $index}},'whpay')"
                                        type="number" 
                                        step="0.01" 
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
            <div class="flex">
                <div class="w-48">
                    <label  class="text-xs">Cheque Bank</label>
                    <input  
                    wire:model="cheque.bank"  class="w-full p-2 border border-gray-300 text-sm rounded" 
                    wire:change="updateCheque('bank')"
                    /> 

                    @error('cheque.bank') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">Branch</label>
                    <input id="vdate" wire:model="cheque.branch"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.branch') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">NO.</label>
                    <input id="vdate" wire:model="cheque.no"  class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.no') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
                <div class="w-48 ml-5">
                    <label for="vdate" class="text-xs">Date</label>
                    <input id="vdate" wire:model="cheque.chequeDate" type="date" class="w-full p-2 border border-gray-300 text-sm rounded" /> 
                    @error('cheque.chequeDate') 
                        <span class="text-red-500 text-xs">{{ $message }}</span> 
                    @enderror 
                </div>
            </div>
        </div>
        
        <div class="w-48 ml-5">
            <label for="vdate" class="text-xs">Total Amount</label>
            <input id="vdate" wire:model.live="sumCheque"  class="w-full p-2 border border-gray-300 text-sm rounded text-right" 
            type="number"
            step="0.01"
            disabled /> 
        </div>
         <div class="w-48 ml-5">
            <label for="vdate" class="text-xs">Wh amount</label>
            <input id="vdate" wire:model.live="sumWh"  class="w-full p-2 border border-gray-300 text-sm rounded text-right" 
            type="number"
            step="0.01"
            disabled /> 
        </div>

        <div class="content-center ">
        <button  
        wire:click="createReceipt"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
        Save
        </button>
        </div>
    </div>
</form>
</div>
@endif 
</div>
