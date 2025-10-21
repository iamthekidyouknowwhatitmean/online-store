<?php

namespace App\Jobs;

use App\Exports\OrdersExport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Order;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Support\Facades\Http;

class SendOrderToTelegramJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $orderId) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::find($this->orderId);

        $binaryExcel = Excel::raw(new OrdersExport($order), ExcelFormat::XLSX);
        $filename = 'order_' . $order->id . '_' . now()->format('Ymd_His') . '.xlsx';

        $botToken = config('services.telegram.telegram_bot_token');
        $chatId = config('services.telegram.telegram_chat_id');

        Http::asMultipart()
            ->attach('document', $binaryExcel, $filename)
            ->post("https://api.telegram.org/bot{$botToken}/sendDocument", [
                'chat_id' => $chatId,
                'caption' => "🧾 Новый заказ #{$order->id}\n💰 Сумма: {$order->total_amount}",
            ]);
    }
}
