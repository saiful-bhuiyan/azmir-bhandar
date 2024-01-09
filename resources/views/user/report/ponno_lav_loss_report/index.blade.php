@extends('user.layout.master')
@section('body')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">পন্যের লাভ লস রিপোর্ট</p>
          </div>

          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
              
              <div class="md:col-span-1">
                <label for="type">মহাজন/পন্য প্রতি :</label>
                <select name="type" id="type" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    <option value="1">পন্য প্রতি</option>
                    <option value="2">মহাজন প্রতি</option>
                </select>
                @if($errors->has('type'))
                <span class="text-sm text-red-600">{{ $errors->first('type') }} </span>
                @endif
              </div>

              <div class="md:col-span-2 mohajon_div">
                <label for="mohajon_setup_id">মহাজন :</label>
                <select name="mohajon_setup_id" id="mohajon_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    @if($mohajon_setup)
                    @foreach($mohajon_setup as $b)
                    <option value="{{$b->id}}">{{$b->name}} / {{$b->address}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('mohajon_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('mohajon_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-2 ponno_div">
                <label for="ponno_setup_id">পন্যের নাম :</label>
                <select name="ponno_setup_id" id="ponno_setup_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="0" selected>সকল</option>
                    @if($ponno_setup)
                    @foreach($ponno_setup as $b)
                    <option value="{{$b->id}}">{{$b->ponno_name}}</option>
                    @endforeach
                    @endif
                </select>
                @if($errors->has('ponno_setup_id'))
                <span class="text-sm text-red-600">{{ $errors->first('ponno_setup_id') }} </span>
                @endif
              </div>

              <div class="md:col-span-1">
                <label for="purchase_type">ধরণ :</label>
                <select name="purchase_type" id="purchase_type" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="0" selected>সকল</option>
                    <option value="1">নিজ খরিদ</option>
                    <option value="2">কমিশন</option>
                </select>
                @if($errors->has('purchase_type'))
                <span class="text-sm text-red-600">{{ $errors->first('purchase_type') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="date_from">তারিখ শুরু :</label>
                <input datepicker datepicker-format="dd-mm-yyyy" type="text" name="date_from" id="date_from" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" min="01-01-2020" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('date_from'))
                <span class="text-sm text-red-600">{{ $errors->first('date_from') }} </span>
                @endif
              </div>

              <div class="md:col-span-2">
                <label for="date_to">তারিখ শেষ :</label>
                <input datepicker datepicker-format="dd-mm-yyyy" type="text" name="date_to" id="date_to" class="h-10 border mt-1 rounded px-4 w-full bg-gray-100" value="" min="01-01-2020" readonly placeholder="তারিখ সিলেক্ট করুন" required/>
                @if($errors->has('date_to'))
                <span class="text-sm text-red-600">{{ $errors->first('date_to') }} </span>
                @endif
              </div>
      
              <div class="md:col-span-5 text-right">
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
  $(document).ready(function(){
    $('.ponno_div').hide();
    $('.mohajon_div').hide();
  })
  $('#type').change(function(){
    var type = this.value;
    if(type == 1){
      $('.ponno_div').show();
      $('.mohajon_div').hide();
    }
    else
    {
      $('.ponno_div').hide();
      $('.mohajon_div').show();
    }
  })


  function search()
  {
    var ponno_setup_id = $('#ponno_setup_id').val();
    var mohajon_setup_id = $('#mohajon_setup_id').val();
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();
    var type = $('#type').val();
    var purchase_type = $('#purchase_type').val();
    if(date_from != "" && date_to != "" && type != "" && purchase_type != "")
    {
      if(type == 1)
      {
        $.ajax({
      type : 'POST',
      url : '{{route("ponno_lav_loss_report.search")}}',
      data :  {
        ponno_setup_id : ponno_setup_id,
        mohajon_setup_id : mohajon_setup_id,
        date_from : date_from,
        date_to : date_to,
        type : type,
        purchase_type : purchase_type
      },
      success : function(response)
      {
        var left = (screen.width - 1000) / 2;
        var top = (screen.height - 700) / 4;

        var myWindow = window.open('','_blank',
        'resizable=yes, width=' + '1000'
        + ', height=' + '700' + ', top='
        + top + ', left=' + left);
      
        myWindow.document.write(response.viewContent);

            
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
      })
      }
      else if(type == 2)
      {
        $.ajax({
      type : 'POST',
      url : '{{route("ponno_lav_loss_report.search")}}',
      data :  {
        ponno_setup_id : ponno_setup_id,
        mohajon_setup_id : mohajon_setup_id,
        date_from : date_from,
        date_to : date_to,
        type : type,
        purchase_type : purchase_type,
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
        swal('মহাজন অথবা পন্য প্রতি সিলেক্ট করুন')
      }
      
    }
    else
    {
      swal('সঠিক তথ্য ইনপুট করুন')
    }
    
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