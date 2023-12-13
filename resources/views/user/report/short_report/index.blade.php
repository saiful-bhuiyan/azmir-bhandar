@extends('user.layout.master')
@section('body')

<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">ব্যাংক/আমানত/হাওলাত/অন্যান্য সর্ট রিপোর্ট</p>
          </div>
          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6">
              
              <div class="md:col-span-2">
                <label for="report_id">রিপোর্টের নাম :</label>
                <select name="report_id" id="report_id" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                    <option value="" selected>সিলেক্ট</option>
                    <option value="1" >ব্যাংক রিপোর্ট</option>
                    <option value="2" >আমানত রিপোর্ট</option>
                    <option value="3" >হাওলাত রিপোর্ট</option>
                    <option value="4" >অন্যান্য রিপোর্ট</option>
                </select>
                @if($errors->has('report_id'))
                <span class="text-sm text-red-600">{{ $errors->first('report_id') }} </span>
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
    var report_id = $('#report_id').val();
    if(report_id != "")
    {
      $.ajax({
      type : 'POST',
      url : "{{route('short_report.search')}}",
      data :  {
        report_id : report_id,
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
      swal("দয়া করে রিপোর্টের নাম সিলেক্ট করুন")
    }
    
  }

  

</script>


@endsection