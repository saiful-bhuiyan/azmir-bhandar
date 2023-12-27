@extends('user.layout.master')
@section('body')


<div class=" p-6 bg-gray-100 flex ">
  <div class="container max-w-screen-lg mx-auto">
    <div>

      <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600 mb-2 text-center">
            <p class="font-medium text-lg">পন্য বিক্রয় এডমিন</p>
          </div>
          
          <div class="lg:col-span-2">
            <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-6 ">

              <div class="md:col-span-6 mx-auto">
                <div class="md:col-span-2 ">
                <label for="invoice">ইনভোয়েস :</label>
                  <input type="number" step="any" name="invoice" id="invoice" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" required/>
                  @if($errors->has('invoice'))
                  <span class="text-sm text-red-600">{{ $errors->first('invoice') }} </span>
                  @endif
                </div>
              </div>
      
              <div class="md:col-span-6 text-center mt-2">
                <div class="inline-flex items-end">
                  <button type="button" onclick="getSalesUpdateAdmin()"  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">সার্চ</a>
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
.
</div>

<script>
  function getSalesUpdateAdmin()
  {
    var invoice = $('#invoice').val();
     if(invoice != "")
        {
          $.ajax({
            type : 'GET',
            url : '{{url("ponno_sales_entry_update_admin")}}/'+invoice,
            success : function(response)
            {
              if(response == 404)
              {
                swal('ইনভোয়েস পাওয়া যায়নি');
              }else{
                var left = (screen.width - 800) / 2;
                var top = (screen.height - 700) / 4;

                var myWindow = window.open('','_blank',
                'resizable=yes, width=' + '800'
                + ', height=' + '700' + ', top='
                + top + ', left=' + left);
              
                myWindow.document.write(response.viewContent);
              }
              

                  
            },
          });
        }
        else
        {
          swal("দয়া করে ইনভয়েস ইনপুট করুন")
        }
  }
 
</script>
  @endsection