@if($purchase)
@php
$count = 1;
@endphp
<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
    <tr class="border border-collapse">
        <th scope="col" class="px-6 py-3">
            নং
        </th>
        <th scope="col" class="px-6 py-3">
            এরিয়া
        </th>
        <th scope="col" class="px-6 py-3">
            ঠিকানা
        </th>
        <th scope="col" class="px-6 py-3">
            মহাজনের নাম
        </th>
        <th scope="col" class="px-6 py-3">
            পন্যের নাম
        </th>
        <th scope="col" class="px-6 py-3">
            সাইজ
        </th>
        <th scope="col" class="px-6 py-3">
            মার্কা
        </th>
        <th scope="col" class="px-6 py-3">
            সংখ্যা
        </th>
        <th scope="col" class="px-6 py-3">
            ওজন
        </th>
        @if($purchase_type == 1)
        <th scope="col" class="px-6 py-3">
            দর
        </th>
        @endif
        <th scope="col" class="px-6 py-3">
            মোট টাকা
        </th>
    </tr>
</thead>
<tbody id="table_body">
    @foreach($purchase as $p)
    <tr class="border border-collapse">
        <td class="px-6 py-3 text-blue-700"><a href="{{route('ponno_purchase_report.memo',$p->id)}}">{{$count++}}</a></td>
        <td class="px-6 py-3">{{$p->mohajon_setup->area}}</td>
        <td class="px-6 py-3">{{$p->mohajon_setup->address}}</td>
        <td class="px-6 py-3">{{$p->mohajon_setup->name}}</td>
        <td class="px-6 py-3">{{$p->ponno_setup->ponno_name}}</td>
        <td class="px-6 py-3">{{$p->ponno_size_setup->ponno_size}}</td>
        <td class="px-6 py-3">{{$p->ponno_marka_setup->ponno_marka}}</td>
        @if($purchase_type == 1)
            @php
            $total_taka = ($p->weight * $p->rate) + $p->labour_cost + $p->other_cost + $p->truck_cost + $p->van_cost +$p->tohori_cost;
            @endphp
        @else
            @php
            $total_taka = "-";
            @endphp
        @endif
        <td class="px-6 py-3">{{$p->quantity}}</td>
        <td class="px-6 py-3">{{$p->weight}}</td>
        @if($purchase_type == 1)
        <td class="px-6 py-3">{{$p->rate}}</td>
        @endif
        <td class="px-6 py-3">{{$total_taka}}</td>
    </tr>
    @endforeach
</tbody>

@endif