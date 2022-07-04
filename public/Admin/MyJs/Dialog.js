const modalContainer= document.querySelector('.js_modal')
const modal=document.querySelector('#modal-Cart');
        function OpenModal(){
            var showMore=document.getElementById('btnOnline')
            var modal=document.getElementById('modal-Cart');
            modal.style.display='flex';
            
        }
        function closeModal()
        {
            var modal=document.getElementById('modal-Cart');
            modal.style.display='none';
        }
        modalContainer.addEventListener('click',function(event){
            event.stopPropagation()
        })
        modal.addEventListener('click',closeModal)