@php
    use App\Helpers\ViteModalHelper;
    $modalAssets = App\Helpers\ViteModalHelper::getModalAssets();
@endphp 
<script>
    // js modal phải có hàm 
    //htht window.initRoleDetailModal = initRoleDetailModal; cho  modal role_detail --> initRoleDetailModal

    window.viteAssets = {
        @foreach($modalAssets as $name => $path)
            '{{ $name }}': '{{ Vite::asset($path) }}',
        @endforeach
    };
</script>