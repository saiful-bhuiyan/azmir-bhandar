@if($sales)
<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr class="border border-collapse">
        <th scope="col" class="px-6 py-3">
            ইনভয়েস
        </th>
        <th scope="col" class="px-6 py-3">
            ধরণ
        </th>
        <th scope="col" class="px-6 py-3">
            ঠিকানা
        </th>
        <th scope="col" class="px-6 py-3">
            ক্রেতার নাম
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
        <td class="px-6 py-3 font-bold text-blue-700"><a href="{{route('ponno_sales_report.memo',$s->id)}}">{{$s->id}}</a></td>
        <td class="px-6 py-3">@if($s->sales_type == 1) নগদ @elseif($s->sales_type == 2) বাকি @endif</td>
        @if($s->sales_type == 2)
        <td class="px-6 py-3">{{$s->kreta_setup->address}}</td>
        <td class="px-6 py-3">{{$s->kreta_setup->name}}</td>
        @else
        <td class="px-6 py-3">{{$s->cash_kreta_address}}</td>
        <td class="px-6 py-3">{{$s->cash_kreta_name}}</td>
        @endif
        <td class="px-6 py-3">{{$s->marfot}}</td>
        @php

        $total_taka = 0;
        $entry = DB::table('ponno_sales_entries')->where('sales_invoice',$s->id)->get();
        foreach($entry as $v)
        {
            $total_taka += ($v->sales_weight * $v->sales_rate) + $v->other + $v->labour + $v->kreta_commission - $s->discount;
        }
        @endphp
        <td class="px-6 py-3">{{$total_taka}}</td>
        <td class="px-6 py-3">{{$s->entry_date}}</td>
    </tr>
    @endforeach
</tbody>

@endif