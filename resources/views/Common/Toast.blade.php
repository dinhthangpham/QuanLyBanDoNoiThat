<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">
    <link rel="stylesheet" href="/Common/Toast.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
        function toast({
            title='',
            message='',
            type='info',
            duration=3000
        }){
            const main=document.getElementById('toast');
            const disappear= duration+1000;
                // dis bởi vì khi chạy animation fadeOut có thêm 1s để chạy r sau đó ms  delay số giây để ẩn
            if(main)
            {
                const timeOut= setTimeout(function()
                {
                    main.removeChild(toast);
                },disappear);
                
                const toast=document.createElement("div");
                toast.onclick=function(e)
                {
                    if(e.target.closest('.toast__close')){
                        main.removeChild(toast);
                        clearTimeout(timeOut);
                    }
                };


                const icons={
                    success:'fas fa-check-circle',
                    info:'fas fa-info-circle',
                    error:'fas fa-exclamation-circle',
                }
                const icon= icons[type];
                toast.classList.add('toast', `toast--${type}`);
                const delay= (duration/1000).toFixed(2);
                toast.style.animation=`slideInLeft ease .5s, fadeOut linear 1s ${delay}s forwards`;
                toast.innerHTML=`
                <div class="toast__icon">
                    <i class="${icon}"></i>
                </div>
                <div class="toast__body">
                    <p class="toast__title">${title}</p>
                    <p class="toast__msg">${message}</p>
                </div>
                 <div class="toast__close">
                    <i class="fas fa-times"></i>
                 </div>
                `;
                main.appendChild(toast);
                
                
            }
        }
        function checkToast(elememt) {
            var message ='is required';
            if(elememt!=null){
                showSuccessToast(elememt+message);
            }
            else{
                showErrorToast(elememt+message);
            }
        }
        function showSuccessToast(message_send)
        {
            toast({
            title:'Success ',
            message:message_send,
            type:'success',
            duration:3000
        })
        }
        function showErrorToast(message_send)
        {
            toast({
            title:'Error ',
            message:message_send,
            type:'error',
            duration:3000
        })
        }
    </script>
    <div>
        <!-- Success -->
        <div id="toast"></div>  
        @if ($errors->any())
                @foreach ($errors->all() as $error)
                <script>
                    showErrorToast('{{$error }}');
                </script>  
                @endforeach      
        @endif

        @if (Session::has('error'))
        <script>
            showErrorToast('{{Session::get('error'); }}');
        </script>     
        @endif 

        @if (Session::has('success'))
        <script>
            showSuccessToast('{{Session::get('success'); }}');

        </script>   
        @endif
    </div>

    
</body>
</html>