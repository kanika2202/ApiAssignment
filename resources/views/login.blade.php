<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ចូលប្រើប្រាស់ - Miss Sunflower</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Kantumruy Pro', sans-serif; 
            background-color: #FFFBEB; 
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-orange-100 w-full max-w-md mx-4">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">🌻 Miss Sunflower</h1>
            <p class="text-gray-500 text-sm mt-2">សូមស្វាគមន៍! សូមបញ្ចូលព័ត៌មានដើម្បីចូលប្រើប្រាស់។</p>
        </div>

        <form action="/login" method="POST" class="space-y-5">
            
            @csrf  <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">អ៊ីមែល ឬ លេខទូរសព្ទ</label>
                <input type="text" name="identity" placeholder="បញ្ចូលអ៊ីមែលរបស់អ្នក" required 
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 focus:outline-none transition-all">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">លេខសម្ងាត់</label>
                <input type="password" name="password" placeholder="បញ្ចូលលេខសម្ងាត់" required 
                    class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 focus:outline-none transition-all">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-gray-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-yellow-500 focus:ring-yellow-400"> ចងចាំខ្ញុំ
                </label>
                <a href="#" class="text-orange-500 hover:underline">ភ្លេចលេខសម្ងាត់?</a>
            </div>

            <button type="Submit" 
                class="w-full bg-[#FFC107] hover:bg-[#e6af06] text-white font-bold py-3 rounded-xl shadow-md transition duration-200 mt-2">
                Login
            </button>
        </form>

        <div class="text-center mt-8 pt-6 border-t border-gray-50">
            <p class="text-sm text-gray-600">
                មិនទាន់មានគណនីមែនទេ? 
                <a href="/register" class="text-orange-500 font-bold hover:underline ml-1">ចុះឈ្មោះឥឡូវនេះ</a>
            </p>
        </div>
    </div>

</body>
</html>