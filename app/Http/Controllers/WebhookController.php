<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Verifikasi signature jika diperlukan
        $signature = $request->header('X-Hub-Signature');
        // Optional: verify the signature here

        // Proses payload
        $payload = $request->all();
        
        // Log payload or perform actions based on the webhook event
        \Log::info('Webhook received:', $payload);

        return response()->json(['status' => 'success']);
    }
}
