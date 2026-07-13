@props(['name' => '', 'on' => false])
<label class="inline-flex items-center cursor-pointer">
    <input type="checkbox" name="{{ $name }}" value="1" @checked($on) class="peer sr-only">
    <span class="w-[38px] h-[22px] rounded-full bg-linesoft peer-checked:bg-ksuccess relative transition-colors duration-150 inline-block">
        <span class="absolute top-[2px] left-[2px] w-[18px] h-[18px] rounded-full bg-white transition-transform duration-150 peer-checked:translate-x-4 shadow-sm"></span>
    </span>
</label>
