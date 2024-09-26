<?php

namespace App\Mail;

use App\Sampling;
use App\SamplingPoint;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaMuestra extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SamplingPoint $sp, Sampling $sa, User $us, User $usSent, $reservoir_name, $note,$sampling_point,$dominant,$color_alert, $alert, $alertName, $parametersVerified, $parametersTransitionVerifiedToSend, $showTransition)
    {
        $this->samplingPoint = $sp;
        $this->sampling = $sa;
        $this->user = $us;
        $this->userSent = $usSent;
        $this->reservoir_name = $reservoir_name;
        $this->note = $note;
        $this->sampling_point = $sampling_point;
        $this->dominant = $dominant;
        $this->color_alert = $color_alert;
        $this->alert = $alert;
        $this->alertName = $alertName;
        $this->parametersVerified = $parametersVerified;
        $this->parametersTransitionVerifiedToSend = $parametersTransitionVerifiedToSend;
        $this->showTransition = $showTransition;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Notificación Alerta ".$this->alertName.": Nuevo muestreo en el embalse ".$this->reservoir_name)
            ->markdown("emails.added_sampling_notification_mail")
            ->with('samplingPoint', $this->samplingPoint)
            ->with('sampling', $this->sampling)
            ->with('user', $this->user)
            ->with('userSent', $this->userSent)
            ->with('note', $this->note)
            ->with('sampling_point', $this->sampling_point)
            ->with('dominant', $this->dominant)
            ->with('color_alert', $this->color_alert)
            ->with('alert', $this->alert)
            ->with('alertName', $this->alertName)
            ->with('parametersVerified', $this->parametersVerified)
            ->with('parametersTransitionVerifiedToSend', $this->parametersTransitionVerifiedToSend)
            ->with('showTransition', $this->showTransition);
    }
}
