@extends('user.layout.master')
@section('body')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">স্টক রিপোর্ট</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
              
              <div class="md:col-span-3">
                <label for="ponno_setup_id">পন্য :</label>
                <select name="ponno_setup_id" id="ponno_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="0" selected>সকল</option>
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

              <div class="md:col-span-2 ">
                  <label for="entry_date">তারিখ :</label>
                  <input type="text" name="entry_date" id="entry_date" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" min="01-01-2020" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                  @if($errors->has('entry_date'))
                  <span class="text-sm text-red-600">{{ $errors->first('entry_date') }} </span>
                  @endif
                </div>
      
              <div class="md:col-span-5 text-right">
                <div class="inline-flex items-end">
                  <button type="button" id="search" onclick="searchStockReport();" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সার্চ</button>
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

</div>

<script>

  function searchStockReport()
  {
    var ponno_setup_id = $('#ponno_setup_id').val();
    var entry_date = $('#entry_date').val();

    if(ponno_setup_id != "")
    {
      $.ajax({
      type : 'POST',
      url : '{{route("stock_report.search")}}',
      data :  {
        ponno_setup_id : ponno_setup_id,
        entry_date : entry_date
        
      },
      success : function(response)
      {
          var left = (screen.width - 800) / 2;
          var top = (screen.height - 700) / 4;

          var myWindow = window.open('','_blank',
          'resizable=yes, width=' + '800'
          + ', height=' + '700' + ', top='
          + top + ', left=' + left);
        
          myWindow.document.write(response.viewContent);

              
        },
          error: function(xhr, status, error) {
          console.error(error);
        }
    })
    }
    else
    {
      swal('দয়া করে ধরণ সিলেক্ট করুন');
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

  
</script>


@endsection