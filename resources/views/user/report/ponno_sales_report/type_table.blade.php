@if($sales)
<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr class="border border-collapse">
        <th scope="col" class="px-6 py-3">
            ইনভয়েস
        </th>
        @if($sales_type == 3)
        <th scope="col" class="px-6 py-3">
            ধরণ
        </th>
        @endif
        @if($sales_type == 2)
        <th scope="col" class="px-6 py-3">
            এরিয়া
        </th>
        @endif
        <th scope="col" class="px-6 py-3">
            ঠিকানা
        </th>
        <th scope="col" class="px-6 py-3">
            ক্রেতার নাম
        </th>
        <th scope="col" class="px-6 py-3">
            ডিসকাউন্ট
        </th>
        <th scope="col" class="px-6 py-3">
            মারফত
        </th>
        <th scope="col" class="px-6 py-3">
            মোট টাকা
        </th>
        <th scope="col" class="px-6 py-3">
            তারিখ
        </th>
    </tr>
</thead>
<tbody id="table_body">
    @foreach($sales as $s)
    <tr class="border border-collapse">
        <td class="px-6 py-3"><a href="{{route('ponno_sales_report.memo',$s->id)}}"></a>{{$s->id}}</td>
        @if($sales_type == 3)
        <td class="px-6 py-3">{{$s->sales_type}}</td>
        @endif
        @if($sales_type == 2)
        <td class="px-6 py-3">{{$s->kreta_setup->area}}</td>
        <td class="px-6 py-3">{{$s->kreta_setup->address}}</td>
        <td class="px-6 py-3">{{$s->kreta_setup->name}}</td>
        @endif
        @else
        <td class="px-6 py-3">{{$s->cash_kreta_address}}</td>
        <td class="px-6 py-3">{{$s->cash_kreta_name}}</td>
        @endif
        <td class="px-6 py-3">{{$s->discount}}</td>
        <td class="px-6 py-3">{{$s->marfot}}</td>
        @php
        $total_taka = ($s->ponno_sales_entry->sales_weight * $s->ponno_sales_entry->sales_weight) + $s->other + $s->labour + $s->kreta_commission;
        @endphp
        <td class="px-6 py-3">{{$total_taka}}</td>
        <td class="px-6 py-3">{{$s->entry_date}}</td>
    </tr>
    @endforeach
</tbody>

@endif