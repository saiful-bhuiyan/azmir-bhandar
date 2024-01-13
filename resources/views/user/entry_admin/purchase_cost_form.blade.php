@extends('user.layout.master')
@section('body')
@if($purchase)
<form action="{{ isset($data) ? route('ponno_purchase_cost_entry.update',$data->id) : '' }}" id="form_data" method="POST">
@csrf
@method('PUT')
  <div class=" p-6 bg-gray-100 flex ">
    <div class="container max-w-screen-lg mx-auto">
      <div>

        <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
            <div class="text-gray-600 mb-2 text-center">
              <p class="font-medium text-lg">পন্যের খরচ এন্ট্রি এডমিন</p>
            </div>

            <div class="lg:col-span-2">
                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                    <div class="md:col-span-5">
                    <label for="purchase_id">গ্রহণ সংখ্যা / পন্যের নাম / সাইজ / মার্কা / গ্রহনের ধরণ:</label>
                    <select name="purchase_id" id="purchase_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-200" required>
                        @if($purchase)
                        <option value="{{$purchase->id}}">ই - {{$purchase->id}} / @if($purchase->purchase_type == 2){{$purchase->mohajon_setup->name}}@else AB মার্কা @endif / {{$purchase->quantity}} / {{$purchase->ponno_setup->ponno_name}} /
                        {{$purchase->ponno_size_setup->ponno_size}} / {{$purchase->ponno_marka_setup->ponno_marka}} /
                            @if($purchase->purchase_type == 1) নিজ খরিদ @else কমিশন @endif</option>
                        @endif
                    </select>
                    @if($errors->has('purchase_id'))
                    <span class="text-sm text-red-600">{{ $errors->first('purchase_id') }} </span>
                    @endif
                    </div>

                    <div class="md:col-span-1">
                        <label for="cost_name">খরচের নাম :</label>
                        <select name="cost_name" id="cost_name" class="w-full h-10 px-4 mt-1 border rounded bg-gray-50" required>
                            <option value="" selected>সিলেক্ট</option>
                            <option value="1" {{ isset($data) && $data->cost_name == 1 ? 'selected' : '' }}>লেবার</option>
                            <option value="2" {{ isset($data) && $data->cost_name == 2 ? 'selected' : '' }}>অন্যান্য</option>
                            <option value="3" {{ isset($data) && $data->cost_name == 3 ? 'selected' : '' }}>ট্রাক ভাড়া</option>
                            <option value="4" {{ isset($data) && $data->cost_name == 4 ? 'selected' : '' }}>ভ্যান ভাড়া</option>
                            <option value="5" {{ isset($data) && $data->cost_name == 5 ? 'selected' : '' }}>তহরী</option>
                        </select>
                    @if($errors->has('cost_name'))
                    <span class="text-sm text-red-600">{{ $errors->first('cost_name') }} </span>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <label for="taka">টাকা :</label>
                    <input type="text" name="taka" id="taka" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->taka : '' }}" required/>
                    @if($errors->has('taka'))
                    <span class="text-sm text-red-600">{{ $errors->first('taka') }} </span>
                    @endif
                </div>

                <div class="md:col-span-2 ">
                  <label for="entry_date">তারিখ :</label>
                  <input type="text" name="entry_date" id="entry_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="{{ isset($data) ? date('d-m-Y',strtotime($data->entry_date)) : '' }}" autocomplete="off" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                  @if($errors->has('entry_date'))
                  <span class="text-sm text-red-600">{{ $errors->first('entry_date') }} </span>
                  @endif
                </div>

        
                <div class="md:col-span-5 text-right">
                  <div class="inline-flex items-end">
                    <button type="submit" id="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">আপডেট</button>
                  </div>
                </div>
                
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




<div class="mb-4">

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    <div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto shadow-lg sm:rounded-lg bg-white mb-6">
      <p class="text-lg text-gray-700 uppercase px-6 py-3 font-bold text-center barlow">এড কার্ট</p>
      <table id="" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 data-table purchase_table">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr class="border border-collapse">
            <th>
              ক্রমিক
            </th>
            <th scope="col" class="px-2 py-3">
              তারিখ
            </th>
            <th scope="col" class="px-2 py-3">
              খরচের নাম
            </th>
            <th scope="col" class="px-2 py-3">
              টাকা
            </th>
            <th scope="col" class="px-2 py-3">
              একশন
            </th>
          </tr>
        </thead>
        <tbody id="table_body">
        @php
        $count = 1;
        $countRow = count($cost_entry);
        $total = 0;
        $cost_name = '';
        @endphp

        @if($countRow > 0)
          @foreach($cost_entry as $v)
            @php
            if($v->cost_name == 1){
                $cost_name = 'লেবার খরচ';
            }else if($v->cost_name == 2){
                $cost_name = 'অন্যান্য খরচ';
            }else if($v->cost_name == 3){
                $cost_name = 'ট্রাক খরচ';
            }else if($v->cost_name == 4){
                $cost_name = 'ভ্যান খরচ';
            }else if($v->cost_name == 5){
                $cost_name = 'তহরী খরচ';
            }
            @endphp
            <tr class="border border-collapse">
               
                <td class="px-2 py-3">{{$count++}}</td>
                <td class="px-2 py-3">{{ date('d-m-Y', strtotime($v->entry_date)) }}</td>
                <td class="px-2 py-3">{{$cost_name}}</td>
                <td class="px-2 py-3">{{$v->taka}}</td>
                <td>
                  <div class="flex gap-x-2">
                  <a href="{{route('ponno_purchase_cost_entry.edit', $v->id)}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                  <form method="post" action="{{route('ponno_purchase_cost_entry.destroy',$v->id)}}" id="deleteForm">
                  @csrf
                  @method('DELETE')
                      <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                      ডিলিট</button>
                  </form>
                  
                  </div>
                </td>
                @php
                $total += $v->taka;
                @endphp
            </tr>
            @endforeach
            <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                <td colspan="3" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
                <td class="px-2 py-3 text-base font-bold text-red-600 text-left">{{$total}}</td>
                <td class="px-2 py-3 text-base font-bold text-red-600 text-left"></td>
            </tr>
          @else
          <tr class="border border-collapse">
              <td colspan="12" class="px-6 py-3 text-center">রেকর্ড পাওয়া যায়নি</td>
          </tr>
          @endif
        </tbody>
      </table>

    </div>

  </div>


  <script type="text/javascript">
    $('#save').on('submit',function(e){

    $('#save').text('অপেক্ষা করুন ...');
    $('#save').attr("disabled", "disabled");

    });

    $( function() {
      $( "#entry_date" ).datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        maxDate: new Date(),
      });
    } );
   </script>
@else
    <script type="text/javascript">
      swal('ইনভোয়েস পাওয়া যায়নি')
        window.close();
    </script>
@endif
  @endsection