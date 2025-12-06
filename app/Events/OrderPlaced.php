<?php

namespace App\Events;

use App\Models\Order; // Pastikan model Order diimpor
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Broadcast ke channel private 'orders'
        // Hanya Admin yang terautentikasi (melalui routes/channels.php) yang akan mendengar
        return new PrivateChannel('orders');
    }
    
    /**
     * Data yang akan dikirim ke channel.
     * Metode ini opsional, tetapi disarankan untuk mengirim data yang ringkas.
     */
    public function broadcastWith()
    {
        // Kirim data yang dibutuhkan Admin
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'nama_pelanggan' => $this->order->nama_pelanggan,
            'total' => number_format($this->order->total, 0, ',', '.'),
            'timestamp' => $this->order->created_at->toDateTimeString(),
        ];
    }
}