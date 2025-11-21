<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Fitur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        
        <div class="bg-white rounded-lg shadow-lg p-6">
            
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-plus-circle text-green-600 mr-2"></i>
                    Tambah Fitur Assessment
                </h1>
                <a href="{{ route('dashboard') }}" 
                   class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>

            <form action="{{ route('fitur.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        No Assessment <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="no_assessment" 
                           placeholder="Contoh: 1234567908-23-09" 
                           class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ old('no_assessment') }}" 
                           required>
                    @error('no_assessment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <textarea name="judul" 
                              placeholder="Contoh: PERMINTAAN FITUR UNTUK MENAMBAH DISKON DI KASIR" 
                              rows="3"
                              class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              required>{{ old('judul') }}</textarea>
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Target UAT
                        </label>
                        <input type="date" 
                               name="target_uat" 
                               class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('target_uat') }}">
                        @error('target_uat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Target Due Date (Rilis)
                        </label>
                        <input type="date" 
                               name="target_due_date" 
                               class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ old('target_due_date') }}">
                        @error('target_due_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Link
                    </label>
                    <input type="url" 
                           name="link" 
                           placeholder="https://example.com" 
                           class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           value="{{ old('link') }}">
                    @error('link')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <a href="{{ route('dashboard') }}" 
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-300">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                        <i class="fas fa-save mr-2"></i>
                        Simpan
                    </button>
                </div>
            </form>

        </div>

    </div>

</body>
</html>
