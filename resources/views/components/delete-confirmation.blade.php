@props(['route', 'title' => 'Are you sure?', 'text' => 'This action cannot be undone.'])

<form action="{{ $route }}" method="POST" class="inline" id="delete-form-{{ md5($route) }}">
    @csrf
    @method('DELETE')
    <button type="button" 
            onclick="confirmDelete('{{ md5($route) }}', '{{ $title }}', '{{ $text }}')"
            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
        {{ $slot }}
    </button>
</form>

@push('scripts')
<script>
function confirmDelete(formId, title, text) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + formId).submit();
        }
    });
}
</script>
@endpush 