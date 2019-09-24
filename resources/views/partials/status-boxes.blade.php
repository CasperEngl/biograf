@if (session('status.success'))
<status-box
    v-cloak
    box-type="success"
    class="bg-green-400 text-white"
    :timeout="5000"
>
    {{ session('status.success') }}
</status-box>
@endif

@if (session('status.error'))
<status-box
    v-cloak
    box-type="failure"
    class="bg-red-400 text-white"
    :timeout="5000"
>
    {{ session('status.error') }}
</status-box>
@endif

@if (session('status.info'))
<status-box
    v-cloak
    box-type="info"
    class="bg-blue-400 text-white"
    :timeout="5000"
>
    {{ session('status.info') }}
</status-box>
@endif
