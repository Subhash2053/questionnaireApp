<x-mail::message>
Hi {{$user?$user->name:""}}
 
Please submit the exam
 
<x-mail::button :url="$url">
Open Exam
</x-mail::button>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>