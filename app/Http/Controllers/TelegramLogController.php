<?php

namespace App\Http\Controllers;

use App\Models\TelegramLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TelegramLogController extends Controller
{
    /**
     * បង្ហាញបញ្ជី Telegram Logs ទាំងអស់ (List with API)
     * ប្រើសម្រាប់ធ្វើ Report ក្នុង Dashboard Admin
     */
    public function index()
    {
        $logs = TelegramLog::with('order') // Eager load order relationship
                ->orderBy('created_at', 'desc')
                ->get();

        return response()->json([
            'success' => true,
            'message' => 'ទាញយកទិន្នន័យបានជោគជ័យ',
            'data'    => $logs
        ], 200);
    }

    /**
     * បង្កើត Log ថ្មី (Store with API)
     * អាចហៅប្រើនៅពេលបាញ់ Telegram API រួចរាល់
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'message'  => 'required',
            'status'   => 'required|in:Success,Failed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $log = TelegramLog::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'រក្សាទុក Log បានជោគជ័យ',
            'data'    => $log
        ], 201);
    }

    /**
     * បង្ហាញព័ត៌មានលម្អិតនៃ Log មួយ (Detail with API)
     */
    public function show(string $id)
    {
        $log = TelegramLog::with('order')->find($id);

        if (!$log) {
            return response()->json([
                'success' => false,
                'message' => 'រកមិនឃើញទិន្នន័យឡើយ'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $log
        ], 200);
    }

    /**
     * លុប Log ចេញពី Database
     */
    public function destroy(string $id)
    {
        $log = TelegramLog::find($id);

        if (!$log) {
            return response()->json(['message' => 'រកមិនឃើញទិន្នន័យ'], 404);
        }

        $log->delete();

        return response()->json([
            'success' => true,
            'message' => 'លុបទិន្នន័យបានជោគជ័យ'
        ], 200);
    }

    // ចំណាំ៖ Method update ជាទូទៅមិនសូវប្រើសម្រាប់ Logs ទេ ព្រោះ Log មិនគួរកែប្រែបានឡើយ
}