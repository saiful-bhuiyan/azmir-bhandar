@extends('user.layout.master')
@section('body')

<form action="{{ isset($data) ? route('ponno_purchase_entry.ponno_purchase_update',$data->id) : '' }}" id="form_data" method="POST">
@csrf

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">পন্য গ্রহণ এডমিন</p>
          </div>
          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">

              <div class="md:col-span-1">
                <label for="purchase_type">ধরণ :</label>
                <select name="purchase_type" id="purchase_type" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" onchange="return getPurchaseType()" required>
                    <option value="" selected>সিলেক্ট</option>
                    <option value="1" {{ isset($data) && $data->purchase_type == 1 ? 'selected' : '' }}>নিজ খরিদ</option>
                    <option value="2" {{ isset($data) && $data->purchase_type == 2 ? 'selected' : '' }}>কমিশন</option>
                </select>
                @if($errors->has('purchase_type'))
                <span class="text-sm text-red-600">{{ $errors->first('purchase_type') }} </span>
                @endif
              </div>

              <div class="md:col-span-4">
                <label for="mohajon_setup_id">এরিয়া / ঠিকানা / মহাজনের নাম :</label>
                <select name="mohajon_setup_id" id="mohajon_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($mohajon_setup)
                    @foreach($mohajon_setup as $v)
                    <option value="{{$v->id}}" {{ isset($data) && $data->mohajon_setup->id == $v->id ? 'selected' : '' }}>{{$v->area}} / {{$v->address}} / {{$v->name}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('mohajon_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('mohajon_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="ponno_setup_id">পন্যের নাম :</label>
                <select name="ponno_setup_id" id="ponno_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($ponno_setup)
                    @foreach($ponno_setup as $v)
                    <option value="{{$v->id}}" {{ isset($data) && $data->ponno_setup->id == $v->id ? 'selected' : '' }}>{{$v->ponno_name}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('ponno_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('ponno_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="size_id">সাইজ :</label>
                <select name="size_id" id="size_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($ponno_size_setup)
                    @foreach($ponno_size_setup as $v)
                    <option value="{{$v->id}}" {{ isset($data) && $data->ponno_size_setup->id == $v->id ? 'selected' : '' }}>{{$v->ponno_size}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('size_id'))
                <span class="text-sm text-red-600">{{ $errors->first('size_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="marka_id">মার্কা :</label>
                <select name="marka_id" id="marka_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($ponno_marka_setup)
                    @foreach($ponno_marka_setup as $v)
                    <option value="{{$v->id}}" {{ isset($data) && $data->ponno_marka_setup->id == $v->id ? 'selected' : '' }}>{{$v->ponno_marka}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('marka_id'))
                <span class="text-sm text-red-600">{{ $errors->first('marka_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="gari_no">গাড়ি নং :</label>
                <input type="text" name="gari_no" id="gari_no" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->gari_no : '' }}" required/>
                @if($errors->has('gari_no'))
                <span class="text-sm text-red-600">{{ $errors->first('gari_no') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="quantity">সংখ্যা :</label>
                <input type="number" step="any" name="quantity" id="quantity" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->quantity : '' }}" onkeyup="return getTotalTaka();" required/>
                @if($errors->has('quantity'))
                <span class="text-sm text-red-600">{{ $errors->first('quantity') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="weight">ওজন :</label>
                <input type="number" step="any" name="weight" id="weight" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->weight : '' }}" onkeyup="return getTotalTaka();" required/>
                @if($errors->has('weight'))
                <span class="text-sm text-red-600">{{ $errors->first('weight') }} </span>
                @endif
              </div>

              <div class="md:col-span-1" id="rate_div">
                <label for="rate">দর :</label>
                <input type="number" step="any" name="rate" id="rate" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->rate : '' }}" onkeyup="return getTotalTaka();"/>
                @if($errors->has('rate'))
                <span class="text-sm text-red-600">{{ $errors->first('rate') }} </span>
                @endif
              </div>

              <div class="md:col-span-2" id="taka_div">
                <label for="taka">মোট টাকা :</label>
                <input type="text" id="taka" class="h-10 mt-1 border-none rounded px-4 w-full bg-gray-200" value="" readonly/>
              </div>

              <div class="md:col-span-1">
                <label for="labour_cost">লেবার :</label>
                <input type="number" step="any" step="any" name="labour_cost" id="labour_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->labour_cost : '' }}" onkeyup="return getTotalTaka()"/>
                @if($errors->has('labour_cost'))
                <span class="text-sm text-red-600">{{ $errors->first('labour_cost') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="other_cost">অন্যান্য খরচ :</label>
                <input type="number" step="any" name="other_cost" id="other_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->other_cost : '' }}" onkeyup="return getTotalTaka()"/>
                @if($errors->has('other_cost'))
                <span class="text-sm text-red-600">{{ $errors->first('other_cost') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="truck_cost">ট্রাক ভাড়া :</label>
                <input type="number" step="any" name="truck_cost" id="truck_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->truck_cost : '' }}" onkeyup="return getTotalTaka()"/>
                @if($errors->has('truck_cost'))
                <span class="text-sm text-red-600">{{ $errors->first('truck_cost') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="van_cost">ভ্যান ভাড়া :</label>
                <input type="number" step="any" name="van_cost" id="van_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->van_cost : '' }}" onkeyup="return getTotalTaka()"/>
                @if($errors->has('van_cost'))
                <span class="text-sm text-red-600">{{ $errors->first('van_cost') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="tohori_cost">তহরী :</label>
                <input type="number" step="any" name="tohori_cost" id="tohori_cost" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="{{ isset($data) ? $data->tohori_cost : '' }}" onkeyup="return getTotalTaka()"/>
                @if($errors->has('tohori_cost'))
                <span class="text-sm text-red-600">{{ $errors->first('tohori_cost') }} </span>
                @endif
              </div>

              <div class="md:col-span-2" id="total_taka_div">
                <label for="total_taka">সর্বমোট টাকা :</label>
                <input type="text" id="total_taka" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly/>
              </div>

              <div class="md:col-span-2" id="avg_div">
                <label for="avg">মুল্য (প্রতি কেজি) :</label>
                <input type="text" id="avg" class="h-10 border-none mt-1 rounded px-4 w-full bg-gray-200" value="" readonly/>
              </div>

              <div class="md:col-span-2 ">
                <label for="entry_date">গ্রহনের তারিখ :</label>
                <input type="text" name="entry_date" id="entry_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="{{ isset($data) ? date('d-m-Y',strtotime($data->entry_date)) : '' }}" autocomplete="off" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('entry_date'))
                <span class="text-sm text-red-600">{{ $errors->first('entry_date') }} </span>
                @endif
              </div>

              <div class="md:col-span-2 ">
                <label for="cost_date">পন্য খরচের তারিখ :</label>
                <input type="text" name="cost_date" id="cost_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="{{ isset($data) ? date('d-m-Y',strtotime($data->cost_date)) : '' }}" autocomplete="off" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('cost_date'))
                <span class="text-sm text-red-600">{{ $errors->first('cost_date') }} </span>
                @endif
              </div>
      
              @if(isset($data))
              <div class="md:col-span-5 text-right">
                <div class="inline-flex items-end">
                  <button type="submit" id="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">আপডেট</button>
                </div>
              </div>
              @endif

            </div>
          </div>
       
        </div>
      </div>
    </div>
  </div>
</div>

</form>


<div class="mb-4">

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

<div class="w-full mx-auto p-4 relative overflow-x-auto shadow-lg sm:rounded-lg bg-white mb-12">
  <p class="text-lg text-gray-700 uppercase px-6 py-3 font-bold text-center barlow">এড কার্ট</p>
  <table id="" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 data-table purchase_table">
  <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th>
                নং
            </th>
            <th>
                ইনভোয়েস
            </th>
            <th scope="col" class="px-6 py-3 whitespace-nowrap">
                মহাজন ইনফরমেশন
            </th>
            <th scope="col" class="px-6 py-3">
                ধরণ
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
                গাড়ি নং
            </th>
            <th scope="col" class="px-6 py-3">
                সংখ্যা
            </th>
            <th scope="col" class="px-6 py-3">
                ওজন
            </th>
            <th scope="col" class="px-6 py-3">
                দর
            </th>
            <th scope="col" class="px-6 py-3">
                মোট খরচ
            </th>
            <th scope="col" class="px-6 py-3">
                মোট টাকা
            </th>
            <th scope="col" class="px-2 py-3">
                তারিখ
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
</div>


<script type="text/javascript">

@if( isset($data) && $data->purchase_type == 2)
    $('#rate_div').hide();
    $('#taka_div').hide();
    $('#total_taka_div').hide();
    $('#avg_div').hide();
@endif
    function getPurchaseType()
    {
      if($('#purchase_type').val() == 1)
      {
        $('#rate_div').show();
        $('#taka_div').show();
        $('#total_taka_div').show();
        $('#avg_div').show();
      }
      else
      {
        $('#rate_div').hide();
        $('#taka_div').hide();
        $('#total_taka_div').hide();
        $('#avg_div').hide();
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
            ajax: "{{ route('ponno_purchase_entry.admin') }}",
            columns: [
                {data: 'sl', name: 'sl'},
                {data: 'invoice', name: 'invoice'},
                {data: 'mohajon', name: 'mohajon'},
                {data: 'purchase_type', name: 'purchase_type'},
                {data: 'ponno_name', name: 'ponno_name'},
                {data: 'ponno_size', name: 'ponno_size'},
                {data: 'ponno_marka', name: 'ponno_marka'},
                {data: 'gari_no', name: 'gari_no'},
                {data: 'quantity', name: 'quantity'},
                {data: 'weight', name: 'weight'},
                {data: 'rate', name: 'rate'},
                {data: 'total_cost', name: 'total_cost'},
                {data: 'total_taka', name: 'total_taka'},
                {data: 'entry_date', name: 'entry_date'},
                {data: 'action', name: 'action' , orderable: "false", searchable: "false"},
            
            ]
        });

        });
    }

    loadCurrentData();

    function getTotalTaka()
    {
      var weight = parseFloat($('#weight').val());
      var rate = parseFloat($('#rate').val());

      var labour_cost = parseFloat($('#labour_cost').val()) || 0;
      var other_cost = parseFloat($('#other_cost').val()) || 0;
      var truck_cost = parseFloat($('#truck_cost').val()) || 0;
      var van_cost = parseFloat($('#van_cost').val()) || 0;
      var tohori_cost = parseFloat($('#tohori_cost').val()) || 0;

      if($('#weight').val() != "" && $('#rate').val() != "")
      {
        var total = weight * rate;
        
        $('#taka').val(total.toFixed(2));

        var all_total = labour_cost + other_cost + truck_cost + van_cost + tohori_cost + total;
        $('#total_taka').val(all_total.toFixed(2));

        var avg = all_total / weight;
        $('#avg').val(avg.toFixed(2));
      }
      else
      {
        $('#taka').val("");
        $('#total_taka').val("");
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

    $( function() {
      $( "#cost_date" ).datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        maxDate: new Date(),
      });
    } );

    $('#save').on('submit',function(e){

      $('#save').text('অপেক্ষা করুন ...');
      $('#save').attr("disabled", "disabled");

    });
    
  </script>
@endsection