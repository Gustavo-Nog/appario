<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
/**
 * Notification é a classe base para notificações no Laravel
 * MailMessage é uma classe que facilita a construção de e-mails para notificações
 */

class UsuarioResetPasswordNotification extends Notification
{
    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $nomeUsuario = $notifiable->pessoa ? $notifiable->pessoa->nome : '';
        $url = url(route('usuarios.resetar', [
            'token' => $this->token,
            'email' => $notifiable->email
        ], false));

        /**
         * subject() define o assunto do e-mail, mostrado na caixa de entrada do destinatário
         * line() adiciona uma linha de texto ao corpo do e-mail
         * action() adiciona um botão de ação ao e-mail, com o texto do botão e a URL para a qual o botão deve redirecionar
         * 
         */

        return (new MailMessage)
            ->subject('Redefinição de Senha - AppArio')
            ->line('Olá ' . $nomeUsuario . ',')
            ->line('Você está recebendo este e-mail porque solicitou a redefinição de senha para sua conta.')
            ->action('Redefinir Senha', $url)
            ->line('Se você não solicitou isso, nenhuma ação é necessária.');
    }
}