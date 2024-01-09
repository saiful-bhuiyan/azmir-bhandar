@extends('user.layout.master')
@section('body')


<form action="{{route('arod_chotha.store')}}" id="form_data" method="POST">
  @csrf

  <div class="flex p-6 bg-gray-100 ">
    <div class="container max-w-screen-lg mx-auto">
      <div>
        <div class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8">
          <div class="grid grid-cols-1 gap-4 pt-4 text-sm text-left gap-y-2 md:grid-cols-5">
            <div class="md:col-span-3">
              <p class="text-lg font-bold text-red-600">পন্য গ্রহণ ইনভোয়েস : {{$purchase->id}}</p>
            </div>
            <div class="md:col-span-2">
              <p class="text-lg font-bold text-red-600">তারিখ : {{$purchase->entry_date}}</p>
            </div>
            <div class="md:col-span-5">
              <p class="text-lg font-bold text-red-600">মহাজনের নাম : {{$purchase->mohajon_setup->name}}</p>
            </div>
            <div class="md:col-span-3">
              <p class="text-lg font-bold text-red-600">ঠিকানা : {{$purchase->mohajon_setup->address}}</p>
            </div>
            <div class="md:col-span-2">
              <p class="text-lg font-bold text-red-600">এরিয়া : {{$purchase->mohajon_setup->area}}</p>
            </div>
            <div class="md:col-span-3">
              <p class="text-lg font-bold text-red-600">মোবাইল নাম্বার : {{$purchase->mohajon_setup->mobile}}</p>
            </div>
          </div>
          <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3 my-4">
            <div class="mb-2 text-center text-gray-600">
              <p class="text-2xl font-medium">আড়ত চৌথা এন্ট্রি</p>
            </div>

            <div class="lg:col-span-2">

              <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-5">

                <div class="md:col-span-1" hidden>
                  <label for="purchase_id">পন্য গ্রহণ ইনভয়েস :</label>
                  <input type="number" step="any" name="purchase_id" id="purchase_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{$purchase->id}}" readonly required />
                  @if($errors->has('purchase_id'))
                  <span class="text-sm text-red-600">{{ $errors->first('purchase_id') }} </span>
                  @endif
                </div>



                <div class="md:col-span-1">
                  <label for="sales_qty">বিক্রয় সংখ্যা :</label>
                  <input type="number" step="any" name="sales_qty" id="sales_qty" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" required />
                  @if($errors->has('sales_qty'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_qty') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="sales_weight">বিক্রয় ওজন :</label>
                  <input type="number" step="any" name="sales_weight" id="sales_weight" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup=" sumTotalSale();" required />
                  @if($errors->has('sales_weight'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_weight') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="sales_rate">বিক্রয় দর :</label>
                  <input type="number" step="any" name="sales_rate" id="sales_rate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup=" sumTotalSale();" required />
                  @if($errors->has('sales_rate'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_rate') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="read_taka">মোট টাকা :</label>
                  <input type="text" id="read_taka" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                </div>

                <div class="text-right md:col-span-1">
                  <br>
                  <div class="inline-flex items-end p-1">
                    <button type="submit" id="save" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">সেভ</button>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</form>

<div class="flex p-6 bg-gray-100" id="table_form">
  @if($purchase)

  <div class="container mx-auto max-w-screen ">
    <div class="p-4 px-4 mb-6 text-center bg-white rounded shadow-lg md:p-8">
      <span class="p-1 text-white bg-blue-600">আড়ত চৌথা</span>
      <h1 class="pt-4 text-3xl font-bold text-red-600">নিউ আজমীর ভান্ডার</h1>
      <p class="text-lg font-bold text-blue-600">হলুদ,মরিচ,বাদাম,পেঁয়াজ,রসুন,আদা এবং যাবতীয় কাচা মালের আড়ত</p>
      <p class="text-lg font-bold text-red-600">সাথী মার্কেট ইসলামপুর রোড,ফেনী</p>
      <div class="flex justify-center pt-1 space-x-4 divide-x-2 divide-red-600 item-center">
        <div class="text-center ">
          <p class="text-red-600">জাহিদুল ইসলাম নাহিদ</p>
          <p class="text-blue-600">01839398051</p>
        </div>
        <div class="pl-4 text-center">
          <p class="text-red-600">ওমর ফয়সাল মজুমদার</p>
          <p class="text-blue-600">01843875890</p>
        </div>
      </div>
      <div class="grid grid-cols-1 gap-4 pt-4 text-sm text-left gap-y-2 md:grid-cols-5">
        <div class="md:col-span-3">
          <p class="text-lg font-bold text-red-600">চৌথা/ইনভোয়েস নং : {{$purchase->id}}</p>
        </div>
        <div class="md:col-span-2">
          <p class="text-lg font-bold text-red-600">তারিখ : {{$purchase->entry_date}}</p>
        </div>
        <div class="md:col-span-5">
          <p class="text-lg font-bold text-red-600">মহাজনের নাম : {{$purchase->mohajon_setup->name}}</p>
        </div>
        <div class="md:col-span-3">
          <p class="text-lg font-bold text-red-600">ঠিকানা : {{$purchase->mohajon_setup->address}}</p>
        </div>
        <div class="md:col-span-2">
          <p class="text-lg font-bold text-red-600">এরিয়া : {{$purchase->mohajon_setup->area}}</p>
        </div>
        <div class="md:col-span-3">
          <p class="text-lg font-bold text-red-600">মোবাইল নাম্বার : {{$purchase->mohajon_setup->mobile}}</p>
        </div>
      </div>
      <div class="flex">
        <div class="relative w-2/3 mb-6 bg-red-100">
          <table class="w-full text-sm text-center border border-collapse border-slate-500">
            <thead class="text-xs text-gray-700">
              <tr>
                <th scope="col" class="border border-slate-500">নং</th>
                <th scope="col" class="border border-slate-500">দর</th>
                <th scope="col" class="border border-slate-500">সংখ্যা</th>
                <th scope="col" class="border border-slate-500">ওজন</th>
                <th scope="col" class="border border-slate-500">মোট টাকা</th>
                <th scope="col" class="border border-slate-500">একশন</th>
              </tr>
            </thead>
            <tbody>
              @php
              $count = 1;
              $total_sale = 0;
              $total_sale_qty = 0;
              $total_sale_weight = 0;
              $nogod_sale = 0;
              $orginal_sale = 0;
              $orginal_sale_qty = 0;
              $orginal_sale_weight = 0;
              @endphp

              @foreach($sales as $s)
              @php
              $orginal_sale += $s->sales_weight * $s->sales_rate;
              $orginal_sale_qty += $s->sales_qty;
              $orginal_sale_weight += $s->sales_weight;
              @endphp
              @endforeach


              @foreach($arod_chotha as $s)

              @php
              $total_sale += $s->sales_weight * $s->sales_rate;
              $total_sale_qty += $s->sales_qty;
              $total_sale_weight += $s->sales_weight;
              @endphp
              <tr>
                <td class="border border-slate-500">{{$count++}}</td>
                <td class="border border-slate-500">{{$s->sales_rate}}</td>
                <td class="border border-slate-500">{{$s->sales_qty}}</td>
                <td class="border border-slate-500">{{$s->sales_weight}}</td>
                <td class="border border-slate-500">{{$s->sales_weight * $s->sales_rate}}</td>
                <td class="border border-slate-500">
                <form method="post" action="{{route('arod_chotha.destroy',$s->id)}}" id="deleteForm">
                    @csrf
                    @method('DELETE')
                        <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" type="submit">
                        ডিলিট</button>
                    </form>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot class="">
              <tr>
                <td colspan="2" class="font-bold border border-slate-500">সর্বমোট বিক্রি : </td>
                <td class="font-bold border border-slate-500">{{$total_sale_qty}}</td>
                <td class="font-bold border border-slate-500">{{$total_sale_weight}}</td>
                <td class="font-bold border border-slate-500">{{$total_sale}}</td>
                <td class="font-bold border border-slate-500"></td>
              </tr>
              <tr>
            </tfoot>
          </table>
        </div>
        <div class="relative w-1/3 mb-6 overflow-x-auto bg-white">
          <div class="font-bold">
            <div class="bg-blue-600">
              <p class="text-white">পন্যের বিবরনী</p>
            </div>
            <div class="text-left bg-sky-200">
              <p class="p-1 text-xs text-gray-800">বস্তার ব্যবধান : {{$orginal_sale_qty - $total_sale_qty}}</p>
              <p class="p-1 text-xs text-gray-800">ওজনের ব্যবধান : {{$orginal_sale_weight - $total_sale_weight}}</p>
              <p class="p-1 text-xs text-gray-800">টাকার ব্যবধান : {{$orginal_sale - $total_sale}}</p>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>

  @endif

</div>

<!-- Cost Entry Update -->

<form action="{{route('arod_chotha.update',$purchase->id)}}" id="form_data" method="POST">
  @csrf
  @method('PUT')
  <div class="flex p-6 bg-gray-100 ">
    <div class="container max-w-screen-lg mx-auto">
      <div>
        <div class="p-4 px-4 mb-6 bg-white rounded shadow-lg md:p-8">
          <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 lg:grid-cols-3 my-4">
            <div class="mb-2 text-center text-gray-600">
              <p class="text-2xl font-medium">পন্য গ্রহণ খরচ আপডেট</p>
            </div>

            <div class="lg:col-span-2">

              <div class="grid grid-cols-1 gap-4 text-sm gap-y-2 md:grid-cols-5">

                <div class="md:col-span-1">
                  <label for="labour_cost">লেবার :</label>
                  <input type="number" step="any" step="any" name="labour_cost" id="labour_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="@if($arod_chotha_info){{ $arod_chotha_info->labour_cost }}@endif" onkeyup="return getTotalTaka()" />
                  @if($errors->has('labour_cost'))
                  <span class="text-sm text-red-600">{{ $errors->first('labour_cost') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="other_cost">অন্যান্য খরচ :</label>
                  <input type="number" step="any" name="other_cost" id="other_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="@if($arod_chotha_info){{ $arod_chotha_info->other_cost }}@endif" onkeyup="return getTotalTaka()" />
                  @if($errors->has('other_cost'))
                  <span class="text-sm text-red-600">{{ $errors->first('other_cost') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="truck_cost">ট্রাক ভাড়া :</label>
                  <input type="number" step="any" name="truck_cost" id="truck_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="@if($arod_chotha_info){{ $arod_chotha_info->truck_cost }}@endif" onkeyup="return getTotalTaka()" />
                  @if($errors->has('truck_cost'))
                  <span class="text-sm text-red-600">{{ $errors->first('truck_cost') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="van_cost">ভ্যান ভাড়া :</label>
                  <input type="number" step="any" name="van_cost" id="van_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="@if($arod_chotha_info){{ $arod_chotha_info->van_cost }}@endif" onkeyup="return getTotalTaka()" />
                  @if($errors->has('van_cost'))
                  <span class="text-sm text-red-600">{{ $errors->first('van_cost') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="tohori_cost">তহরী :</label>
                  <input type="number" step="any" name="tohori_cost" id="tohori_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="@if($arod_chotha_info){{ $arod_chotha_info->tohori_cost }}@endif" onkeyup="return getTotalTaka()" />
                  @if($errors->has('tohori_cost'))
                  <span class="text-sm text-red-600">{{ $errors->first('tohori_cost') }} </span>
                  @endif
                </div>

                <div class="md:col-span-2">
                  <label for="mohajon_commission">মহাজন কমিশন (প্রতি কেজি):</label>
                  <input type="number" step="any" name="mohajon_commission" id="mohajon_commission" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{$purchase->mohajon_commission}}"  />
                  @if($errors->has('mohajon_commission'))
                  <span class="text-sm text-red-600">{{ $errors->first('mohajon_commission') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1" id="total_taka_div">
                  <label for="total_cost">সর্বমোট টাকা :</label>
                  <input type="text" id="total_cost" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly/>
                </div>

                <div class="md:col-span-2 ">
                <label for="entry_date">তারিখ :</label>
                <input type="text" name="entry_date" id="entry_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="{{ isset($arod_chotha_info) ? date('d-m-Y',strtotime($arod_chotha_info->entry_date)) : '' }}"  placeholder="তারিখ সিলেক্ট করুন" onkeypress="return false;" required/>
                @if($errors->has('entry_date'))
                <span class="text-sm text-red-600">{{ $errors->first('entry_date') }} </span>
                @endif
              </div>

                <div class="text-right md:col-span-5">
                  <br>
                  <div class="inline-flex items-end p-1">
                    <button type="submit" id="update" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">সেভ</button>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

</form>

<script>

  $('#save').on('submit',function(e){

  $('#save').text('অপেক্ষা করুন ...');
  $('#save').attr("disabled", "disabled");

  });

  $('#update').on('submit',function(e){

  $('#update').text('অপেক্ষা করুন ...');
  $('#update').attr("disabled", "disabled");

  });

  function sumTotalSale() {
    var sales_weight = parseFloat($('#sales_weight').val() || 0);
    var sales_rate = parseFloat($('#sales_rate').val() || 0);

    if (sales_weight > 0 && sales_rate > 0) {
      var total = sales_weight * sales_rate;
      $('#read_taka').val(total.toFixed(2));
    } else {
      $('#read_taka').val("");
    }

  }

    function getTotalTaka()
    {
      var labour_cost = parseFloat($('#labour_cost').val()) || 0;
      var other_cost = parseFloat($('#other_cost').val()) || 0;
      var truck_cost = parseFloat($('#truck_cost').val()) || 0;
      var van_cost = parseFloat($('#van_cost').val()) || 0;
      var tohori_cost = parseFloat($('#tohori_cost').val()) || 0;

      var all_total = labour_cost + other_cost + truck_cost + van_cost + tohori_cost ;
      $('#total_cost').val(all_total.toFixed(2));
      
    }

    $( function() {
      $( "#entry_date" ).datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        maxDate: new Date(),
      });
    } );

</script>

<script>
  @if(session('invoice'))
    var left = (screen.width - 800) / 2;
    var top = (screen.height - 700) / 4;

    var url = "{{route('arod_chotha.memo',session('invoice') )}}";

    var myWindow = window.open(url, url,
        'resizable=yes, width=' + '800' +
        ', height=' + '700' + ', top=' +
        top + ', left=' + left);
  @endif
    </script>

@endsection