<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<div class="text-3xl font-bold flex justify-center p-10 border-2">
    Asynchronous FORM
</div>
<div class="flex justify-evenly">
    <div class="w-full border-r-2">
        <div class="px-8 mt-5 mx-5 mb-48">
            <div class="text-2xl flex justify-center font-semibold mb-5">Edit Data</div>
            <div>
                <form id="AsyncForm" method="POST">
                    @csrf
                    <div class="my-5">
                        <p class=" text-lg ">Name</p>
                        <input id="namee" name="namee" type="text" class="border-[1px] px-4 py-2 w-full rounded-lg text-[#555555] border-[#b3b3b3]" value="">
                        <p id="nameeValid" class="hidden text-red-500 ">Name can only contain alphabet characters </p>
                        <p id="nameeValid2" class="hidden text-red-500 ">Max 100 characters</p>
                    </div>
                    <div class="my-5">
                        <p class=" text-lg ">Email</p>
                        <input id="email" name="email" type="text" class="border-[1px] px-4 py-2 w-full rounded-lg text-[#555555] border-[#b3b3b3]" value="">
                        <p id="emailValid" class="hidden text-red-500 ">Not a valid email format</p>
                        <p id="emailValid2" class="hidden text-red-500 ">Max 50 characters </p>
                    </div>
                    <div>
                        <p class=" text-lg ">Message</p>
                        <textarea name="bio" id="bio" class="border-[1px] px-4 py-2 w-full text-[#555555] rounded-lg border-[#b3b3b3]"></textarea>
                    </div>
    
                    <div class="border-b-[1px] mb-5 mt-8"></div>
                    <div class="flex justify-end mb-5">
                        <button id="save" type="submit" class="bg-gray-500 cursor-not-allowed text-white font-semibold py-2 px-4 rounded">
                            Save Changes
                        </button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <div class="w-[80%] mt-5 px-36">
        <div class="shadow-md border-[1px] rounded-lg px-4 py-4 text-lg ">
            <div class="flex justify-center">
                <div id="loading" class="hidden border-l-4 border-green-500 rounded-full w-9 h-9 animate-spin"></div>
            </div>
            
            <div id="view">
                <div class="flex justify-center text-2xl mb-3 font-semibold">View Data</div>
                <div class="flex justify-center text-lg py-[2px] ">
                    <div class="font-semibold">Name&nbsp;:&nbsp;</div>
                    <div id="username" >{{ $user->name }}</div>
                </div>
                <div class="flex justify-center text-lg py-[2px]">
                    <div class="font-semibold">E-mail&nbsp;:&nbsp;</div>
                    <div id="useremail" >{{ $user->email }}</div>
                </div>
                <div class="flex justify-center text-lg py-[2px]">
                    <div class=" font-semibold">Message&nbsp;:&nbsp;</div>
                    <div id="usermassage">{{ $user->message }}</div>
                </div>
            </div>

        </div>
        
    </div>
</div>

<script>
    //asynchronous
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('#AsyncForm');
        const username = document.getElementById('username');
        const useremail = document.getElementById('useremail');
        const usermassage = document.getElementById('usermassage');
        const loading = document.getElementById('loading');
        const view = document.getElementById('view');
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            loading.style.display = 'block';
            view.style.display = 'none';
            const formData = new FormData(form);

            try {
                const response = await fetch('/woi', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (response.ok) {
                const data = await response.json();
                username.textContent = data.name;
                useremail.textContent = data.email;
                usermassage.textContent = data.message;
            } else {
                console.error('data gagal diambil :(');
            } 
            } catch (error) {
                console.error('ERRORR');
            }
            finally {
                loading.style.display = 'none';
                view.style.display = 'block';
            }
        });
    });

    //regex
    const save = document.getElementById('save');
    let emailSubmit = false;
    let nameeSubmit = false;
    let bioSubmit = false;
    save.disabled = true;
    email.addEventListener('input', function(){
        let regex = /^.+@[\w!#$%&'*+-/=?^`{|}~\.]+\.[a-z]{2,4}$/;
        const email = document.getElementById('email');
        const emailValid = document.getElementById('emailValid');
        const emailValid2 = document.getElementById('emailValid2');
        let value = email.value;
        if (value.length <= 50 && regex.test(value)) {
            emailValid.classList.add('hidden');
            emailValid2.classList.add('hidden');
            email.classList.add('border-green-500');
            email.classList.remove('border-red-500');
            email.classList.remove('border-[#b3b3b3]');
            emailSubmit = true;
        } else {
            emailSubmit = false;
            email.classList.add('border-red-500');
            email.classList.remove('border-green-500');
            email.classList.remove('border-[#b3b3b3]');
            if (value.length >= 50) {
                emailValid2.classList.remove('hidden');
            } else if (!regex.test(value)) {
                emailValid.classList.remove('hidden');
            }
        }
        savee();
    });

    namee.addEventListener('input', function(){
        let regex = /^[a-zA-Z ]+$/;
        const namee = document.getElementById('namee');
        const nameeValid = document.getElementById('nameeValid');
        let value = namee.value;
        if (value.length <= 100 && regex.test(value)) {
            nameeValid.classList.add('hidden');
            nameeValid2.classList.add('hidden');
            namee.classList.add('border-green-500');
            namee.classList.remove('border-red-500');
            namee.classList.remove('border-[#b3b3b3]');
            nameeSubmit = true;
        } else {
            nameeSubmit = false;
            namee.classList.add('border-red-500');
            namee.classList.remove('border-green-500');
            namee.classList.remove('border-[#b3b3b3]');
            if (value.length >= 100) {
                nameeValid2.classList.remove('hidden');
            } else if (!regex.test(value)) {
                nameeValid.classList.remove('hidden');
            }
        }
        savee();
    });

    function savee(){
        if(nameeSubmit && emailSubmit){
            save.disabled = false;
            save.classList.remove('cursor-not-allowed');
            save.classList.add('bg-blue-500');
            save.classList.remove('bg-gray-500');
            save.classList.add('hover:bg-blue-700');
            save.classList.add('active:bg-blue-800');
        }
        else{
            save.disabled = true;
            save.classList.add('cursor-not-allowed');
            save.classList.remove('bg-blue-500');
            save.classList.add('bg-gray-500');
            save.classList.remove('hover:bg-blue-700');
            save.classList.remove('active:bg-blue-800');
        }
    };
</script>
</body>
</html>
