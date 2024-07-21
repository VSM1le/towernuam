<div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
             <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Customer Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Custumer Contact 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Customer Unit 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Area sqm
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Rental fee 
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Service fee 
                            </th>
                             <th scope="col" class="px-6 py-3">
                                Begin - End 
                            </th>
                             <th scope="col" class="px-6 py-3">
                                Year
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentals as $rental)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$rental->customer->cust_code}}
                            </th>
                            <td class="px-6 py-4">
                               {{ $rental->custr_contract_no}} 
                            </td>
                            <td class="px-6 py-4">
                               {{$rental->custr_unit }} 
                            </td>
                            <td class="px-6 py-4">
                                {{ $rental->custr_area_sqm }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rental->custr_rental_fee }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rental->custr_service_fee }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rental->custr_begin_date2}} - {{$rental->custr_end_date2}}
                            </td>
                            <td class="px-6 py-4">
                                {{ $rental->custr_contract_year }}
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                            </td>
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>    
        </div>
    </div>
</div>
