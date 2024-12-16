<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatus extends Mailable
{
    use Queueable, SerializesModels;
    public $order, $orderDetail;
    /**
     * Create a new message instance.
     */
    public function __construct($order, $orderDetail)
    {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
    }


    public function build()
    {
        return $this->view('email.order_status')
            ->with([
                'customerName' => $this->order->first_name . ' ' . $this->order->last_name,
                'orderNumber' => $this->order->code ?? 'ABCZYZ',
                'orderItems' => $this->order->orderDetails,
                'totalAmount' => $this->order->total_price,
                'status' => $this->order->status,
            ])
            ->subject('Trạng thái đơn hàng');
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Trạng thái đơn hàng đã được thay đổi',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
