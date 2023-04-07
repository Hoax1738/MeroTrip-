<style>
    .red{
        color:red;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>

{{-- <div x-data="{count:''}" >
 <input x-model="count" type="text">
 <span x-text="count.length" :class="(count.length)>10?'red':''"></span>
</div>     --}}

{{-- <div x-data={open:false}>
    <button @click="open=true">DropDown</button><br>
    <span x-show="open" @click.away="open=false">DropDown Contents</span>
</div> --}}


<input type="text" x-data x-init="

new Pikaday({ field: $el })

"  >

