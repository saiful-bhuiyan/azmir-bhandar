@extends('user.layout.master')
@section('body')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">পন্য বিক্রয় রিপোর্ট</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
              
              <div class="md:col-span-1">
                <label for="sales_type">বিক্রির ধরণ :</label>
                <select name="sales_type" id="sales_type" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="3" selected>সকল</option>
                    <option value="1">নগদ</option>
                    <option value="2">বাকি</option>
                </select>
                @if($errors->has('sales_type'))
                <span class="text-sm text-red-600">{{ $errors->first('sales_type') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="ponno_setup_id">পন্যের নাম :</label>
                <select name="ponno_setup_id" id="ponno_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($ponno_setup)
                    @foreach($ponno_setup as $v)
                    <option value="{{$v->id}}">{{$v->ponno_name}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('ponno_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('ponno_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="date_from">তারিখ শুরু :</label>
                <input type="text" name="date_from" id="date_from" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" min="01-01-2020" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('date_from'))
                <span class="text-sm text-red-600">{{ $errors->first('date_from') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="date_to">তারিখ শেষ :</label>
                <input type="text" name="date_to" id="date_to" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" min="01-01-2020" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('date_to'))
                <span class="text-sm text-red-600">{{ $errors->first('date_to') }} </span>
                @endif
              </div>
      
              <div class="md:col-span-5 text-right">
                <div class="inline-flex items-end">
                  <button type="button" id="search" onclick="searchSalesReport();" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সার্চ</button>
                </div>
              </div>

            </div>
          </div>
       
        </div>
      </div>
    </div>
  </div>
</div>




<div class="mb-4">

<div class="relative overflow-x-auto  sm:rounded-lg">

<div class="xl:w-10/12 lg:w-11/12 w-full mx-auto p-4 relative overflow-x-auto shadow-lg sm:rounded-lg bg-white pb-6">
  <p class="text-lg text-gray-700 uppercase px-6 py-3 font-bold text-center barlow">পন্য বিক্রয় রিপোর্ট</p>
  <table id="sales_table" class="w-full text-sm text-left text-gray-500 data-table">
  
    </table>

</div>

</div>

<script>

  function searchSalesReport()
  {
    var sales_type = $('#sales_type').val();
    var ponno_setup_id = $('#ponno_setup_id').val();
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();

    $.ajax({
      type : 'POST',
      url : '{{url('searchSalesReport')}}',
      data :  {
        sales_type : sales_type,
        ponno_setup_id : ponno_setup_id,
        date_from : date_from,
        date_to : date_to
      },
      success : function(response)
      {
          // console.log(response)
           $('#sales_table').html(response);
      }
    })
  }

  $( function() {
    $( "#date_from" ).datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      maxDate: new Date(),
    });

    $( "#date_to" ).datepicker({
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true,
      maxDate: new Date(),
      onSelect: function() {
          if($("#date_from").val() > $("#date_to").val()){
            swal("সঠিক তারিখ ইনপুট করুন");
            $("#date_to").val("");
          }
        }
    });
  } );
</script>


@endsection