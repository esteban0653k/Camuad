<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage; // <--- Importa esto para los correos

class StockLowNotification extends Notification
{
    use Queueable;

    protected $stock;

    public function __construct($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Define los canales por donde se enviará la alerta (Base de datos y Correo).
     */
    public function via($notifiable): array
    {
        return ['database', 'mail']; // <--- Añadimos 'mail' aquí
    }

    /**
     * Configuración del correo electrónico que recibirá el usuario.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('¡Alerta de Stock Bajo!')
                    ->greeting('Hola, ' . $notifiable->nombre)
                    ->line("El producto con SKU: {$this->stock->producto} ha alcanzado un nivel crítico de inventario.")
                    ->line("Cantidad actual: {$this->stock->cantidad}")
                    ->line("Stock mínimo permitido: {$this->stock->cantidad_min_stock}")
                    ->action('Ver Inventario', url('/stock')) // Enlace opcional a tu vista
                    ->line('Por favor, realiza un reabastecimiento pronto.');
    }

    /**
     * Datos que se guardarán en formato JSON dentro de la tabla 'notifications' de la base de datos.
     */
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