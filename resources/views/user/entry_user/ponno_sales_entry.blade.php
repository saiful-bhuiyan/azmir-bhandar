@extends('user.layout.master')
@section('body')

<form action="{{route('ponno_sales_entry.store')}}" id="form_data" method="POST">
  @csrf

  <div class=" p-6 bg-gray-100 flex ">
    <div class="container max-w-screen-lg mx-auto">
      <div>

        <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
          <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
            <div class="text-gray-600 mb-2 text-center">
              <p class="font-medium text-lg">পন্য বিক্রয়</p>
            </div>


            <div class="lg:col-span-2">
              <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

                <div class="md:col-span-4">
                  <label for="purchase_id">গ্রহণ সংখ্যা / পন্যের নাম / সাইজ / মার্কা / গ্রহনের ধরণ:</label>
                  <select name="purchase_id" id="purchase_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="getPurchaseDetail();" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($stock)
                    @foreach($stock as $v)
                    <option value="{{$v->purchase_id}}">ই - {{$v->purchase_id}} / @if($v->ponno_purchase_entry->purchase_type == 2){{$v->ponno_purchase_entry->mohajon_setup->name}}@else AB মার্কা @endif / {{$v->ponno_purchase_entry->quantity}} / {{$v->ponno_purchase_entry->ponno_setup->ponno_name}} /
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
                  <input type="number" step="any" name="sales_qty" id="sales_qty" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" required/>
                  @if($errors->has('sales_qty'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_qty') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="sales_weight">বিক্রয় ওজন :</label>
                  <input type="number" step="any" name="sales_weight" id="sales_weight" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup=" sumCommissionAmount();" required/>
                  @if($errors->has('sales_weight'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_weight') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="sales_rate">বিক্রয় দর :</label>
                  <input type="number" step="any" name="sales_rate" id="sales_rate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup=" sumTotalSale();" required/>
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
                  <input type="text" id="kreta_commission" name="kreta_commission" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup=" sumTotalSale();" />
                  <input type="hidden" id="kreta_com_per_kg" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                </div>

                <div class="md:col-span-1">
                  <label for="labour">লেবার :</label>
                  <input type="number" step="any" name="labour" id="labour" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup=" sumTotalSale();"/>
                  @if($errors->has('labour'))
                  <span class="text-sm text-red-600">{{ $errors->first('labour') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="other">অন্যান্য খরচ :</label>
                  <input type="number" step="any" name="other" id="other" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup="return sumTotalSale();"/>
                  @if($errors->has('other'))
                  <span class="text-sm text-red-600">{{ $errors->first('other') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="read_total_taka">সর্বমোট টাকা :</label>
                  <input type="text" id="read_total_taka" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                </div>

                <div class="md:col-span-5 text-right">
                  <div class="inline-flex items-end">
                    <button type="submit" id="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সেভ</button>
                  </div>
                </div>

                </form>

                <div class="md:col-span-5 p-1">
                <hr>
                </div>
                
                <div class="md:col-span-1">
                <form action="{{url('storePonnoSales')}}" id="final_data" method="POST">
                  @csrf

                  <label for="sales_type">বিক্রির ধরণ :</label>
                  <select name="sales_type" id="sales_type" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getSalesType()" required>
                      <option value="1" selected>নগদ</option>
                      <option value="2">বাকী</option>
                  </select>
                  @if($errors->has('sales_type'))
                  <span class="text-sm text-red-600">{{ $errors->first('sales_type') }} </span>
                  @endif
                </div>

                <!-- For Nogod Select -->

                <div class="md:col-span-1 cash_sale">
                  <label for="cash_kreta_address">ঠিকানা :</label>
                  <input type="text" name="cash_kreta_address" id="cash_kreta_address" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup="return totalWithDiscount();" />
                  @if($errors->has('cash_kreta_address'))
                  <span class="text-sm text-red-600">{{ $errors->first('cash_kreta_address') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1 cash_sale">
                  <label for="cash_kreta_name">ক্রেতার নাম :</label>
                  <input type="text" name="cash_kreta_name" id="cash_kreta_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup="return totalWithDiscount();" />
                  @if($errors->has('cash_kreta_name'))
                  <span class="text-sm text-red-600">{{ $errors->first('cash_kreta_name') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1 cash_sale">
                  <label for="cash_kreta_mobile">মোবাইল নাম্বার :</label>
                  <input type="text" name="cash_kreta_mobile" id="cash_kreta_mobile" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup="return totalWithDiscount();" />
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
                      <option value="{{$v->area}}">{{$v->area}}</option>
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
                      <option value="" selected>সিলেক্ট</option>
                  </select>
                  @if($errors->has('address'))
                  <span class="text-sm text-red-600">{{ $errors->first('address') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1 due_sale">
                  <label for="kreta_setup_id">ক্রেতার নাম :</label>
                  <select name="kreta_setup_id" id="kreta_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getAmountByKreta();" required>
                      <option value="" selected>সিলেক্ট</option>
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

                <div class="md:col-span-1" hidden>
                  <label for="current_amount_old">বর্তমান পাওনা :</label>
                  <input type="text" id="current_amount_old" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly  />
                </div>

                <div class="md:col-span-1">
                  <label for="discount">ছাড় :</label>
                  <input type="number" step="any" name="discount" id="discount" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" onkeyup="return totalWithDiscount();"/>
                  @if($errors->has('discount'))
                  <span class="text-sm text-red-600">{{ $errors->first('discount') }} </span>
                  @endif
                </div>

                <div class="md:col-span-1">
                  <label for="all_total_taka">মোট টাকা :</label>
                  <input type="text" id="all_total_taka" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly />
                </div>

                <div class="md:col-span-1">
                  <label for="marfot_id">মারফত :</label>
                  <select name="marfot_id" id="marfot_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                      <option value="" selected>সিলেক্ট</option>
                      @if($marfot)
                      @foreach($marfot as $v)
                      <option value="{{$v->id}}">{{$v->marfot_name}}</option>
                      @endforeach
                      @endif
                  </select>
                  @if($errors->has('marfot_id'))
                  <span class="text-sm text-red-600">{{ $errors->first('marfot_id') }} </span>
                  @endif
                </div>

                <div class="md:col-span-5 text-right">
                  <div class="inline-flex items-end">
                    <button type="button" id="final_button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">বিক্রি করুন</button>
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
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
              এরিয়া / ঠিকানা
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
              গ্রহণ সংখ্যা
            </th>
            <th scope="col" class="px-6 py-3">
              বিক্রয় সংখ্যা
            </th>
            <th scope="col" class="px-6 py-3">
              ওজন
            </th>
            <th scope="col" class="px-6 py-3">
              মোট টাকা
            </th>
            <th scope="col" class="px-6 py-3">
              একশন
            </th>
          </tr>
        </thead>
        <tbody id="table_body">

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
    var old_amount = parseFloat($('#old_amount').val() || 0);
    var current_amount = parseFloat($('#current_amount').val() || 0);
    var discount = parseFloat($('#discount').val() || 0);
    var all_total_taka = 0;
    if(discount > 0)
    {
       all_total_taka = current_amount - discount;
       all_total_taka += old_amount; 
      $('#all_total_taka').val(all_total_taka.toFixed(2));
    }
    else
    {
      $('#all_total_taka').val(current_amount.toFixed(2));
    }
   }



    function loadCurrentData()
    {
      $(function () {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            "language": {
              "emptyTable": "ডাটা পাওয়া যায়নি",
              "search": "সার্চ করুন : ",
              "info":  "",
              "infoEmpty":   "",
              "infoFiltered":   "",
              "lengthMenu":     "_MENU_টি এন্ট্রি দেখুন",
              "loadingRecords": "লোড হচ্ছে...",
              "zeroRecords":    "রেকর্ড পাওয়া যায়নি",
              "paginate": {
                  "first":      "প্রথম",
                  "last":       "শেষ",
                  "next":       "পরবর্তি",
                  "previous":   "পুর্বে"
              },
            },
            ajax: "{{ route('ponno_sales_entry.index') }}",
            columns: [
                {data: 'sl', name: 'sl'},
                {data: 'mohajon_address', name: 'mohajon_address'},
                {data: 'mohajon_name', name: 'mohajon_name'},
                {data: 'ponno_name', name: 'ponno_name'},
                {data: 'size', name: 'size'},
                {data: 'marka', name: 'marka'},
                {data: 'purchase_qty', name: 'purchase_qty'},
                {data: 'sales_qty', name: 'sales_qty'},
                {data: 'sales_weight', name: 'sales_weight'},
                {data: 'total_taka', name: 'total_taka'},
                {data: 'action', name: 'action' , orderable: "false", searchable: "false"},

            ]
        });

        });
    }

    loadCurrentData();

    function getPurchaseDetail()
    {
      var purchase_id = $('#purchase_id').val();

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
      var kreta_commission = parseFloat($('#kreta_commission').val() || 0);
      var current_amount = parseFloat($('#current_amount_old').val() || 0);

      if(sales_weight > 0  && sales_rate > 0)
      {
        var total = sales_weight *  sales_rate;
        var num_kreta_com = parseFloat(kreta_commission);
        var all_total = total + labour + other +num_kreta_com;
        $('#read_taka').val(total.toFixed(2));
        $('#read_total_taka').val(all_total.toFixed(2));
        $('#current_amount').val((all_total + current_amount).toFixed(2));
      }
      else
      {
        $('#read_taka').val("");
        $('#read_total_taka').val("");
      }

    }

    function sumCommissionAmount()
    {
      var sales_weight = parseFloat($('#sales_weight').val() || 0);
      var kreta_com_per_kg = parseFloat($('#kreta_com_per_kg').val() || 0);
      if(sales_weight > 0)
      {
        var kreta_com = sales_weight * kreta_com_per_kg;
        var num_kreta_com = parseFloat(kreta_com);
        $('#kreta_commission').val(kreta_com.toFixed(2));
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
          url : '{{url("getAmountByKreta")}}/0',
 
          success : function(response)
          {
            var amount = $.parseJSON(response);

            $('#current_amount_old').val(amount.current_amount.toFixed(2));
            $('#current_amount').val(amount.current_amount.toFixed(2));
            $('#all_total_taka').val((amount.old_amount + amount.current_amount).toFixed(2));
          }
        });
        
      }
      else
      {
        if( kreta_setup_id != "")
        {
          $.ajax({
            type : 'GET',
            url : '{{url("getAmountByKreta")}}/'+kreta_setup_id,
      
            success : function(response)
            {
              var amount = $.parseJSON(response);

              $('#old_amount').val(amount.old_amount.toFixed(2));
              $('#current_amount').val(amount.current_amount.toFixed(2));
              $('#all_total_taka').val((amount.old_amount + amount.current_amount).toFixed(2));
            }
          });
        }
      }
      
    }

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
    @if(session('invoice'))
    var left = (screen.width - 800) / 2;
    var top = (screen.height - 700) / 4;

    var url = "{{route('ponno_sales_report.memo',session('invoice') )}}";

    var myWindow = window.open(url, url,
        'resizable=yes, width=' + '400' +
        ', height=' + '700' + ', top=' +
        top + ', left=' + left);
  @endif
</script>
  @endsection