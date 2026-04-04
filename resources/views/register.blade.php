<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ចុះឈ្មោះ - Miss Sunflower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Kantumruy Pro', sans-serif; background-color: #FFFBEB; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen py-10">

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-orange-100 w-full max-w-md mx-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🌻 Login</h1>
            <p class="text-gray-500 text-sm mt-2">បង្កើតគណនីថ្មីដើម្បីចាប់ផ្តើមទិញទំនិញ</p>
        </div>

        <form action="/register" method="POST" class="space-y-4">
            @csrf <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">ឈ្មោះពេញ</label>
                <input type="text" name="name" placeholder="បញ្ចូលឈ្មោះរបស់អ្នក" required 
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">អ៊ីមែល</label>
                <input type="email" name="email" placeholder="example@gmail.com" required 
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">លេខសម្ងាត់</label>
                <input type="password" name="password" placeholder="យ៉ាងតិច ៨ ខ្ទង់" required 
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">បញ្ជាក់លេខសម្ងាត់</label>
                <input type="password" name="password_confirmation" placeholder="បញ្ចូលលេខសម្ងាត់ម្តងទៀត" required 
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:outline-none">
            </div>

            <button type="submit" 
                class="w-full bg-[#FFC107] hover:bg-[#e6af06] text-white font-bold py-3 rounded-xl shadow-md transition duration-200 mt-4">
                បង្កើតគណនី
            </button>
        </form>

        <div class="text-center mt-6 pt-6 border-t border-gray-50">
            <p class="text-sm text-gray-600">
                មានគណនីរួចហើយមែនទេ? 
                <a href="/login" class="text-orange-500 font-bold hover:underline ml-1">ចូលប្រើប្រាស់</a>
            </p>
        </div>
    </div>

</body>
</html>