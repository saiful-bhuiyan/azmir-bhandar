@extends('user.layout.master')
@section('body')

<form action="{{ isset($data) ? route('ponno_sales_entry.update',$data->id) : '' }}" id="form_data" method="POST">
@csrf
@method('PUT')
  <div class=" p-6 bg-gray-100 flex ">
    <div class="container max-w-screen-lg mx-auto">
      <div>

        <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
            <div class="text-gray-600 mb-2 text-center">
              <p class="font-medium text-lg">পন্য বিক্রয় এডমিন</p>
            </div>


            <div class="lg:col-span-2">
              <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                <div class="md:col-span-4">
                  <label for="purchase_id">গ্রহণ সংখ্যা / পন্যের নাম / সাইজ / মার্কা / গ্রহনের ধরণ:</label>
                  <select name="purchase_id" id="purchase_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="getPurchaseDetail();" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($stock)
                    @foreach($stock as $v)
                    <option value="{{$v->purchase_id}}" {{ isset($data) && $data->ponno_purchase_entry->id == $v->purchase_id ? 'selected <script>getPurchaseDetail() </script>' : '' }} >{{$v->ponno_purchase_entry->id}} / {{$v->ponno_purchase_entry->quantity}} / {{$v->ponno_purchase_entry->ponno_setup->ponno_name}} /
                       {{$v->ponno_purchase_entry->ponno_size_setup->ponno_size}} / {{$v->ponno_purchase_entry->ponno_marka_setup->ponno_marka}} /
                        @if($v->ponno_purchase_entry->purchase_type == 1) নিজ খরিদ @else কমিশন @endif</option>
                    @endforeach
                    @endif
                  </select>
                  @if($errors->has('purchase_id'))
                  <span class="text-sm text-red-600">{{ $errors->first('purchase_id') }} </span>
                  @endif
                </div>

                <div class="md:col-span-5">
                  <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                    <div class="md:col-span-2">
                      <label for="mohajon_setup_id">এরিয়া / ঠিকানা / মহাজনের নাম :</label>
                      <input type="text" id="mohajon_setup_id" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="ponno_name">পন্যের নাম :</label>
                      <input type="text" id="ponno_name" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="size">সাইজ :</label>
                      <input type="text" id="size" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="marka">মার্কা :</label>
                      <input type="text" id="marka" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="gari_no">গাড়ি নং :</label>
                      <input type="text" id="gari_no" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="purchase_qty">গ্রহন সংখ্যা :</label>
                      <input type="text" id="purchase_qty" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="purchase_weight">ওজন :</label>
                      <input type="text" id="purchase_weight" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="read_rate">নেট দর :</label>
                      <input type="text" id="read_rate" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="read_sales_qty">বিক্রিত সংখ্যা :</label>
                      <input type="text" id="read_sales_qty" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="read_sales_weight">বিক্রিত ওজন :</label>
                      <input type="text" id="read_sales_weight" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="read_current_qty">মজুদ সংখ্যা :</label>
                      <input type="text" name="read_current_qty" id="read_current_qty" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                    <div class="md:col-span-1">
                      <label for="read_current_weight">মজুদ ওজন :</label>
                      <input type="text" name="read_current_weight" id="read_current_weight" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                    </div>

                  </div>
                </div>
                <!-- End report -->

                <div class="md:col-span-1">
                  <label for="sales_qty">বিক্রয় সংখ্যা :</label>
                  <input type="number" step="any" name="sales_qty" id="sales_qty" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->sales_qty : '' }}" required/>
                  @if($errors->has('sales_qty'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_qty') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="sales_weight">বিক্রয় ওজন :</label>
                  <input type="number" step="any" name="sales_weight" id="sales_weight" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->sales_weight : '' }}" onkeyup=" sumTotalSale();" required/>
                  @if($errors->has('sales_weight'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_weight') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="sales_rate">বিক্রয় দর :</label>
                  <input type="number" step="any" name="sales_rate" id="sales_rate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->sales_rate : '' }}" onkeyup=" sumTotalSale();" required/>
                  @if($errors->has('sales_rate'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_rate') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="read_taka">মোট টাকা :</label>
                  <input type="text" id="read_taka" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                </div>

                <div class="md:col-span-1">
                  <label for="kreta_commission">ক্রেতা কমিশন :</label>
                  <input type="text" id="kreta_commission" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value=""  />
                  <input type="hidden" id="kreta_com_per_kg" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="{{ isset($data) ? $data->ponno_purchase_entry->ponno_setup->kreta_commission_setup->commission_amount : ''}}" readonly />
                </div>

                <div class="md:col-span-1">
                  <label for="labour">লেবার :</label>
                  <input type="number" step="any" name="labour" id="labour" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->labour : '' }}" onkeyup=" sumTotalSale();"/>
                  @if($errors->has('labour'))
                  <span class="text-sm text-red-600">{{ $errors->first('labour') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="other">অন্যান্য খরচ :</label>
                  <input type="number" step="any" name="other" id="other" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->other : '' }}" onkeyup="return sumTotalSale();"/>
                  @if($errors->has('other'))
                  <span class="text-sm text-red-600">{{ $errors->first('other') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="read_total_taka">সর্বমোট টাকা :</label>
                  <input type="text" id="read_total_taka" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                </div>

                @if(isset($data))
                <div class="md:col-span-5 text-right">
                  <div class="inline-flex items-end">
                    <button type="submit" id="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">আপডেট</button>
                  </div>
                </div>
                @endif
                </form>

                <div class="md:col-span-5 p-1">
                <hr>
                </div>

                <!--------------------- Sales Info Form ------------------------->
                
                <div class="md:col-span-1">
                <form action="{{route('ponno_sales_entry.info_update',$sales_info->id)}}" id="final_data" method="POST">
                  @csrf

                  <label for="sales_type">বিক্রির ধরণ :</label>
                  <select name="sales_type" id="sales_type" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getSalesType()" required>
                      <option value="1" {{ isset($sales_info) && $sales_info->sales_type == 1 ? 'selected' : '' }}>নগদ</option>
                      <option value="2" {{ isset($sales_info) && $sales_info->sales_type == 2 ? 'selected' : '' }}>বাকী</option>
                  </select>
                  @if($errors->has('sales_type'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_type') }} </span>
                  @endif
                </div>

                <!-- For Nogod Select -->

                <div class="md:col-span-1 cash_sale">
                  <label for="cash_kreta_address">ঠিকানা :</label>
                  <input type="text" name="cash_kreta_address" id="cash_kreta_address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($sales_info) ? $sales_info->cash_kreta_address : '' }}" onkeyup="return totalWithDiscount();" />
                  @if($errors->has('cash_kreta_address'))
                  <span class="text-sm text-red-600">{{ $errors->first('cash_kreta_address') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1 cash_sale">
                  <label for="cash_kreta_name">ক্রেতার নাম :</label>
                  <input type="text" name="cash_kreta_name" id="cash_kreta_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($sales_info) ? $sales_info->cash_kreta_name : '' }}" onkeyup="return totalWithDiscount();" />
                  @if($errors->has('cash_kreta_name'))
                  <span class="text-sm text-red-600">{{ $errors->first('cash_kreta_name') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1 cash_sale">
                  <label for="cash_kreta_mobile">মোবাইল নাম্বার :</label>
                  <input type="text" name="cash_kreta_mobile" id="cash_kreta_mobile" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($sales_info) ? $sales_info->cash_kreta_mobile : '' }}" onkeyup="return totalWithDiscount();" />
                  @if($errors->has('cash_kreta_mobile'))
                  <span class="text-sm text-red-600">{{ $errors->first('cash_kreta_mobile') }} </span>
                  @endif
                </div>

                <!-- End nogod Select -->

                <div class="md:col-span-1 due_sale">
                  <label for="area">এরিয়া :</label>
                  <select name="area" id="area" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getkretaAddressByArea();" required>
                      <option value="" selected>সিলেক্ট</option>
                      @if($kreta_area)
                      @foreach($kreta_area as $v)
                      <option value="{{$v->area}}" {{ isset($sales_info->kreta_setup_id) && $sales_info->kreta_setup->area == $v->area ? 'selected' : '' }}>{{$v->area}}</option>
                      @endforeach
                      @endif
                  </select>
                  @if($errors->has('area'))
                  <span class="text-sm text-red-600">{{ $errors->first('area') }} </span>
                  @endif
                </div>

                <div class="md:col-span-2 due_sale">
                  <label for="address">ঠিকানা :</label>
                  <select name="address" id="address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getKretaNameByAddress();" required>
                      <option value="{{ isset($sales_info->kreta_setup_id) ? $sales_info->kreta_setup->address : '' }}" selected>{{ isset($sales_info->kreta_setup_id) ? $sales_info->kreta_setup->address : '' }}</option>
                  </select>
                  @if($errors->has('address'))
                  <span class="text-sm text-red-600">{{ $errors->first('address') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1 due_sale">
                  <label for="kreta_setup_id">ক্রেতার নাম :</label>
                  <select name="kreta_setup_id" id="kreta_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getAmountByKreta();" required>
                      <option value="{{ isset($sales_info->kreta_setup_id) ? $sales_info->kreta_setup->id : '' }}" selected>{{ isset($sales_info->kreta_setup_id) ? $sales_info->kreta_setup->name : '' }}</option>
                  </select>
                  @if($errors->has('kreta_setup_id'))
                  <span class="text-sm text-red-600">{{ $errors->first('kreta_setup_id') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1 due_sale">
                  <label for="old_amount">সাবেক পাওনা :</label>
                  <input type="text" id="old_amount" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                </div>

                <div class="md:col-span-1">
                  <label for="current_amount">বর্তমান পাওনা :</label>
                  <input type="text" id="current_amount" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                </div>

                <div class="md:col-span-1">
                  <label for="discount">ছাড় :</label>
                  <input type="number" step="any" name="discount" id="discount" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($sales_info) ? $sales_info->discount : '' }}" onkeyup="return totalWithDiscount();"/>
                  @if($errors->has('discount'))
                  <span class="text-sm text-red-600">{{ $errors->first('discount') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="all_total_taka">মোট টাকা :</label>
                  <input type="text" id="all_total_taka" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="{{ isset($sales_info) ? $sales_info->total_taka : '' }}" readonly />
                </div>

                <div class="md:col-span-1">
                  <label for="marfot_id">মারফত :</label>
                  <select name="marfot_id" id="marfot_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                      <option value="" selected>সিলেক্ট</option>
                      @if($marfot)
                      @foreach($marfot as $v)
                      <option value="{{$v->id}}"  {{ isset($sales_info) && $sales_info->marfot_id == $v->id ? 'selected' : '' }}>{{$v->marfot_name}}</option>
                      @endforeach
                      @endif
                  </select>
                  @if($errors->has('marfot_id'))
                  <span class="text-sm text-red-600">{{ $errors->first('marfot_id') }} </span>
                  @endif
                </div>

                <div class="md:col-span-2 ">
                  <label for="entry_date">তারিখ :</label>
                  <input type="text" name="entry_date" id="entry_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="{{ isset($sales_info) ? date('d-m-Y',strtotime($sales_info->entry_date)) : '' }}" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                  @if($errors->has('entry_date'))
                  <span class="text-sm text-red-600">{{ $errors->first('entry_date') }} </span>
                  @endif
                </div>

                
                <div class="md:col-span-5 text-right">
                  <div class="inline-flex items-end">
                    <button type="button" id="final_button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">ক্রেতা আপডেট</button>
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
          <tr>
            <th>
              নং
            </th>
            <th scope="col" class="px-2 py-3 whitespace-nowrap">
              এরিয়া / ঠিকানা
            </th>
            <th scope="col" class="px-2 py-3">
              মহাজনের নাম
            </th>
            <th scope="col" class="px-2 py-3">
              পন্যের নাম
            </th>
            <th scope="col" class="px-2 py-3">
              সাইজ
            </th>
            <th scope="col" class="px-2 py-3">
              মার্কা
            </th>
            <th scope="col" class="px-2 py-3">
              গ্রহন সংখ্যা
            </th>
            <th scope="col" class="px-2 py-3">
              বিক্রয় সংখ্যা
            </th>
            <th scope="col" class="px-2 py-3">
              ওজন
            </th>
            <th scope="col" class="px-2 py-3">
              দর
            </th>
            <th scope="col" class="px-2 py-3">
              মোট টাকা
            </th>
            <th scope="col" class="px-2 py-3">
              একশন
            </th>
          </tr>
        </thead>
        <tbody id="table_body">
        @php
        $count = 1;
        $total_sale = 0;
        $total_sale_qty = 0;
        $total_sale_weight = 0;
        $total_kreta_commission = 0;
        $labour = 0;
        $other = 0;
        $countRow = count($sales_entry);
        $total = 0;
        @endphp

        @if($countRow > 0)
          @foreach($sales_entry as $s)
            @php
            $total_sale += $s->sales_weight * $s->sales_rate;
            $total_sale_qty += $s->sales_qty;
            $total_sale_weight += $s->sales_weight;
            $total_kreta_commission +=  $s->kreta_commission;
            $labour += $s->labour;
            $other += $s->other;
            @endphp
            <tr class="border border-collapse">
                <td class="px-2 py-3">{{$count++}}</td>
                <td class="px-2 py-3">{{$s->ponno_purchase_entry->mohajon_setup->area}}/{{$s->ponno_purchase_entry->mohajon_setup->address}}</td>
                <td class="px-2 py-3">{{$s->ponno_purchase_entry->mohajon_setup->name}}</td>
                <td class="px-2 py-3">{{$s->ponno_purchase_entry->ponno_setup->ponno_name}}</td>
                <td class="px-2 py-3">{{$s->ponno_purchase_entry->ponno_size_setup->ponno_size}}</td>
                <td class="px-2 py-3">{{$s->ponno_purchase_entry->ponno_marka_setup->ponno_marka}}</td>
                <td class="px-2 py-3">{{$s->ponno_purchase_entry->quantity}}</td>
                <td class="px-2 py-3">{{$s->sales_qty}}</td>
                <td class="px-2 py-3">{{$s->sales_weight}}</td>
                <td class="px-2 py-3">{{$s->sales_rate}}</td>
                <td class="px-2 py-3">{{$s->sales_weight * $s->sales_rate}}</td>
                <td>
                  <div class="flex gap-x-2">
                  <a href="{{route('ponno_sales_entry.edit', $s->id)}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ইডিট</a>

                  <form method="get" action="{{url('ponno_sales_entry_delete',$s->id)}}" id="deleteForm">
                    @csrf
                    @method('DELETE')
                      <button onclick="return confirmation();" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" type="submit">
                      ডিলিট</button>
                  </form>
                  
                  </div>
                </td>
                @php
                $total += $s->total_taka;
                @endphp
            </tr>
            @endforeach
            <tr class="border border-collapse odd:bg-white even:bg-gray-100">
                <td colspan="10" class="px-2 py-3 text-base font-bold text-red-600 text-center">মোট টাকা : </td>
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
    $('#rate_div').hide();
    $('#taka_div').hide();
    $('#total_taka_div').hide();
    $('#avg_div').hide();

    $('.due_sale').hide();  

    function getPurchaseType() {
      if ($('#purchase_type').val() == 1) {
        $('#rate_div').show();
        $('#taka_div').show();
        $('#total_taka_div').show();
        $('#avg_div').show();
      } else {
        $('#rate_div').hide();
        $('#taka_div').hide();
        $('#total_taka_div').hide();
        $('#avg_div').hide();
      }
    }

    function getSalesType() {
      if ($('#sales_type').val() == 2) {
        $('.due_sale').show();
        $('.cash_sale').hide();
      } else {
        $('.due_sale').hide();
        $('.cash_sale').show();

      }
    }

    
   function totalWithDiscount()
   {
    var current_amount = parseFloat($('#current_amount').val() || 0);
    var discount = parseFloat($('#discount').val() || 0);
    var all_total_taka = 0;
    if(discount > 0)
    {
       all_total_taka = current_amount - discount;
      $('#all_total_taka').val(all_total_taka);
    }
    else
    {
      $('#all_total_taka').val(current_amount);
    }
   }




    function getPurchaseDetail()
    {
      var purchase_id = $('#purchase_id').val();

      if(purchase_id != "")
      {
        $.ajax({
        type :  'POST',
        url : '{{url("getPurchaseDetail")}}',
        data : {
          purchase_id : purchase_id,
        },
        success : function(response)
        {
          var purchase_data = $.parseJSON(response);
          $('#mohajon_setup_id').val(purchase_data.mohajon_area +' / '+ purchase_data.mohajon_address +' / '+ purchase_data.mohajon_name);
          $('#ponno_name').val(purchase_data.ponno_name);
          $('#size').val(purchase_data.ponno_size);
          $('#marka').val(purchase_data.ponno_marka);
          $('#gari_no').val(purchase_data.gari_no);
          $('#purchase_qty').val(purchase_data.purchase_qty);
          $('#purchase_weight').val(purchase_data.purchase_weight);
          $('#read_rate').val(purchase_data.read_rate);
          $('#read_sales_qty').val(purchase_data.read_sales_qty);
          $('#read_sales_weight').val(purchase_data.read_sales_weight);
          $('#read_current_qty').val(purchase_data.read_current_qty);
          $('#read_current_weight').val(purchase_data.read_current_weight);
          $('#kreta_com_per_kg').val(purchase_data.kreta_com_per_kg);
        }
      })
      }
      
   }

   function getkretaAddressByArea()
    {
        var area = $('#area').val();

        if(area != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getkretaAddressByArea")}}',
                data : {
                    area : area,
                },
                success:function(response)
                {
                    $('#address').html(response);
                }

            });
        }
    }

   function getKretaNameByAddress()
    {
        var address = $('#address').val();

        if(address != "")
        {
            $.ajax({
                type : 'POST',
                url : '{{url("getKretaNameByAddress")}}',
                data : {
                    address : address,
                },
                success:function(response)
                {
                    $('#kreta_setup_id').html(response);
                }

            });
        }
    }


    function sumTotalSale()
    {
      var sales_weight = parseFloat($('#sales_weight').val() || 0);
      var sales_rate = parseFloat($('#sales_rate').val() || 0);
      var labour = parseFloat($('#labour').val() || 0);
      var other = parseFloat($('#other').val() || 0);
      var kreta_com_per_kg = parseFloat($('#kreta_com_per_kg').val() || 0);

      if(sales_weight > 0  && sales_rate > 0)
      {
        var total = sales_weight *  sales_rate;
        var kreta_com = sales_weight * kreta_com_per_kg;
        var num_kreta_com = parseFloat(kreta_com);
        var all_total = total + labour + other +num_kreta_com;
        $('#read_taka').val(total.toFixed(2));
        $('#kreta_commission').val(kreta_com.toFixed(2));
        $('#read_total_taka').val(all_total.toFixed(2));
      }
      else
      {
        $('#read_taka').val("");
        $('#read_total_taka').val("");
      }

    }

    function getAmountByKreta()
    {
      var purchase_id  = $('#purchase_id').val();
      var kreta_setup_id  = $('#kreta_setup_id').val();
      var sales_type  = $('#sales_type').val();

      if(sales_type == 1)
      {
        $.ajax({
          type : 'GET',
          url : '{{url("getAmountByKreta")}}',
 
          success : function(response)
          {
            var amount = $.parseJSON(response);

            $('#current_amount').val(amount.current_amount);
          }
        });
        
      }
      else
      {
        if(purchase_id > 0 && kreta_setup_id > 0)
        {
          $.ajax({
            type : 'GET',
            url : '{{url("getAmountByKreta")}}',
      
            success : function(response)
            {
              var amount = $.parseJSON(response);

              $('#old_amount').val(amount.old_amount);
              $('#current_amount').val(amount.current_amount);
            }
          });
        }
      }
      
    }

    $( function() {
      $( "#entry_date" ).datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        maxDate: new Date(),
      });
    } );

    getAmountByKreta();

    $('#save').on('submit', function(e) {

      $('#save').text('অপেক্ষা করুন ...');

      $('#save').attr("disabled", "disabled");

    });

    $('#final_button').on('click', function(e) {

      $('#final_button').text('অপেক্ষা করুন ...');

      $('#final_button').attr("disabled", "disabled");

      $('#final_data').submit();

    });
    
  </script>

<script>
    $(document).ready(function(){
      getPurchaseDetail();
      sumTotalSale();
      totalWithDiscount();
    })
</script>
  @endsection