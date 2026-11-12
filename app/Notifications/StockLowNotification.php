<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StockLowNotification extends Notification
{
    use Queueable;

    protected $stock;

    public function __construct($stock)
    {
        $this->stock = $stock;
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('¡Alerta de Stock Bajo!')
                    ->greeting('Hola, ' . $notifiable->nombre)
                    ->line("El producto con SKU: {$this->stock->producto} ha alcanzado un nivel crítico de inventario.")
                    ->line("Cantidad actual: {$this->stock->cantidad}")
                    ->line("Stock mínimo permitido: {$this->stock->cantidad_min_stock}")
                    ->action('Ver Inventario', url('/stock'))
                    ->line('Por favor, realiza un reabastecimiento pronto.');
    }

    public function toArray($notifiable): array
    {
        return [
            'id_compra' => $this->stock->id_compra,
            'producto_sku' => $this->stock->producto,
            'cantidad' => $this->stock->cantidad,
            'cantidad_min_stock' => $this->stock->cantidad_min_stock,
            'mensaje' => "¡Alerta! El producto {$this->stock->producto} tiene un stock bajo.",
        ];
    }
}