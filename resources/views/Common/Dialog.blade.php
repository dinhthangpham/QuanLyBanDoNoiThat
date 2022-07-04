<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/Admin/Mycss/Dialog.css">
</head>
<body>

      <div id="modal-Cart">
        <div class="Cart-Online_title">
            @yield('title_dialog')
            <i class="fa-solid fa-x" id="closeModal" onclick="closeModal()"></i>
            </div>
        <div class="Cart-Online js_modal">
        
                <br>
                <div class="Cart-Online_content">
                    {{-- <div id="alert" >
                        
                    </div> --}}
                @yield('content_dialog')
        </div>
        </div>
        
    </div> 
    <script src="/Admin/MyJs/Dialog.js"></script>
</body>
</html>