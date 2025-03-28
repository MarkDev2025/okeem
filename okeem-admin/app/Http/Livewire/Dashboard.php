<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Etablissement;
use App\Models\Enfant;
use App\Models\Tuteur;
use App\Models\Okeemien;
use App\Models\Facture;
use App\Models\Transmission;
use App\Models\Presence;
use Livewire\Attributes\Layout;

class Dashboard extends Component
{
    public $totalEnfants;
    public $totalTuteurs;
    public $totalOkeemiens;
    public $totalEtablissements;
    public $enfantsPresents;
    public $facturesNonPayees;
    public $dernieresTransmissions;

    public function mount()
    {
        $this->totalEnfants = Enfant::count();
        $this->totalTuteurs = Tuteur::count();
        $this->totalOkeemiens = Okeemien::count();
        $this->totalEtablissements = Etablissement::count();
        $this->enfantsPresents = Presence::whereDate('date', today())->count();
        $this->facturesNonPayees = Facture::where('statut', '!=', 'payee')->count();
        $this->dernieresTransmissions = Transmission::latest()->take(5)->get();
    }

    #[Layout('layouts.app', ['title' => 'Dashboard'])]
    public function render()
    {
        return view('livewire.dashboard');
    }
}
