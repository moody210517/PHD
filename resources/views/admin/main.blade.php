<!DOCTYPE html>
<html>

<head>
    @include('admin.common.head') 
    @yield('css')    
</head>

<body class="layout-column">

        @include('admin.common.menu')                

        <div id="main" class="layout-row flex">
            <!-- ############ LAYOUT START-->
            <!-- ############ Aside START-->                     
            @include('admin.common.slide')            
           
            <div id="content" class="flex ">
                
                @yield('content')

            </div>
            <!-- ############ Content END-->
            <!-- ############ LAYOUT END-->
        </div>

    @include('admin.common.footer-scripts')

    @yield('script')

  <!-- endbuild -->
</body>
</html>
