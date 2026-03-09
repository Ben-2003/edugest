<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;

class PaymentController extends Controller
{
    /**
     * Affiche la liste de tous les paiements
     * avec statistiques globales en haut de page
     */
    public function index()
    {
        // Chargement des paiements avec l'élève associé
        $payments = Payment::with('student')
                           ->latest('payment_date')
                           ->paginate(15);

        // Statistiques financières globales
        // Les valeurs exactes en base sont : 'payé', 'en attente', 'annulé'
        $totalPaye       = Payment::where('status', 'payé')->sum('amount');
        $totalAttente    = Payment::where('status', 'en attente')->sum('amount');
        $totalAnnule     = Payment::where('status', 'annulé')->sum('amount');
        $nombrePaiements = Payment::count();

        return view('admin.payments.index', compact(
            'payments', 'totalPaye', 'totalAttente', 'totalAnnule', 'nombrePaiements'
        ));
    }

    /**
     * Affiche le formulaire d'ajout d'un paiement
     */
    public function create()
    {
        // Liste des élèves pour le select
        $students = Student::orderBy('last_name')->get();

        return view('admin.payments.create', compact('students'));
    }

    /**
     * Enregistre un nouveau paiement
     */
    public function store(Request $request)
    {
        // Validation des champs obligatoires
        // Les valeurs autorisées correspondent exactement à celles de la BDD
        // Attention : 'en attente' avec espace (pas underscore)
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'payment_date' => 'required|date',
            'amount'       => 'required|numeric|min:0',
            'status'       => 'required|in:payé,en attente,annulé',
            'description'  => 'nullable|string|max:255',
        ]);

        Payment::create($request->all());

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Paiement enregistré avec succès !');
    }

    /**
     * Affiche le détail d'un paiement
     */
    public function show(Payment $payment)
    {
        $payment->load('student');

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Affiche le formulaire de modification
     */
    public function edit(Payment $payment)
    {
        $students = Student::orderBy('last_name')->get();

        return view('admin.payments.edit', compact('payment', 'students'));
    }

    /**
     * Met à jour un paiement existant
     */
    public function update(Request $request, Payment $payment)
    {
        // Validation identique au store
        // Attention : 'en attente' avec espace (pas underscore)
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'payment_date' => 'required|date',
            'amount'       => 'required|numeric|min:0',
            'status'       => 'required|in:payé,en attente,annulé',
            'description'  => 'nullable|string|max:255',
        ]);

        $payment->update($request->all());

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Paiement modifié avec succès !');
    }

    /**
     * Supprime un paiement
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Paiement supprimé avec succès !');
    }
}