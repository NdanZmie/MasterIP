{{-- MODAL DELETE --}}
<div id="deleteModal" class="fixed inset-0 hidden items-center justify-center z-[9999]">

    <div class="absolute inset-0 bg-black/50" onclick="closeDeleteModal()"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white w-full max-w-md rounded-xl shadow-lg p-6">

            <h3 class="text-lg font-bold mb-4 text-red-600">Konfirmasi Hapus</h3>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <input type="password" id="deletePassword" 
                    placeholder="Masukkan Password"
                    class="input mb-4" required>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-300 rounded">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded">
                        Hapus
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>