@php
    $user = filament()->auth()->user();
@endphp
<x-filament::section>
<div class="flex items-center gap-x-3 pt-5">
            <div class="flex-1">
                <h2
                    class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                >
                Number of candidates: {{ $candidatesCount }}
                </h2>

               
            </div>

    </div>

        <div class="flex items-center gap-x-3">
           

           <div class="flex-1">
               <h2
                   class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
               >
           Welcome  {{ filament()->getUserName($user) }}
               </h2>

               <p class="text-sm text-gray-500 dark:text-gray-400">
                  
               </p>
           </div>

           
       </div>




</x-filament::section>