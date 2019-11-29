<!-- build:js assets/js/site.min.js -->
  <!-- jQuery -->


  <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>  
  <script src="{{ asset('assets/toastr/js/toastr.js') }}" ></script>

  <!-- Bootstrap -->
  <script src="{{ asset('libs/popper.js/dist/umd/popper.min.js') }}"></script>
  <script src=" {{asset('libs/bootstrap/dist/js/bootstrap.min.js')}}" ></script>
  
  <!-- ajax page -->
  <!-- <script src="{{ asset('libs/pace-progress/pace.min.js') }}"></script>
  <script src="{{ asset('libs/pjax/pjax.js') }}"></script>
  <script src="{{ asset('assets/js/ajax.js')}}"></script> -->
  <!-- lazyload plugin -->
  
  <script src="{{ asset('assets/js/lazyload.config.js') }}"></script>
  <script src="{{ asset('assets/js/lazyload.js') }}"></script>  
  <script src="{{ asset('assets/js/plugin.js') }}" ></script>
  
  <!-- theme -->
  <script src="{{ asset('assets/js/theme.js') }}" ></script>
  <script src="{{ asset('assets/js/custom.js') }}" ></script>
  <script src="{{ asset('assets/js/steps.js') }}" ></script>
  <script src="{{ asset('assets/js/common.js') }}" ></script>
  <script src="{{ asset('assets/js/officeMessage.js') }}" ></script>
  


  @if(isset($error_msg))
    <script>
      @if($error_msg != "")
      toastr.error('{{$error_msg}}');
      @endif      
    </script>
  @endif


