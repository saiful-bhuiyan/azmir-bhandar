@extends('user.layout.master')
@section('body')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">ব্যাংক লেজার</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
              
            <div class="md:col-span-3">
                <label for="bank_setup_id">ব্যাংক তথ্য :</label>
                <select name="bank_setup_id" id="bank_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($bank_setup)
                    @foreach($bank_setup as $b)
                    <option value="{{$b->id}}">{{$b->shakha}}/{{$b->bank_name}}/{{$b->account_name}}/{{$b->account_no}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('bank_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('bank_setup_id') }} </span>
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
      
              <div class="md:col-span-6 text-right">
                <div class="inline-flex items-end">
                  <button type="button" id="search" onclick="search();" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সার্চ</button>
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

function search()
  {
    var bank_setup_id = $('#bank_setup_id').val();
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();

    $.ajax({
      type : 'POST',
      url : "{{route('bank_ledger.search')}}",
      data :  {
        bank_setup_id : bank_setup_id,
        date_from : date_from,
        date_to : date_to
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