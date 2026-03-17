# 📋 Intégration du Thème Pluto dans EduGest

## 📌 Vue d'ensemble

Le thème **Pluto** (admin dashboard template) a été intégré dans les trois dashboards principaux de l'application EduGest :
- **Dashboard Admin** : `resources/views/admin/dashboard.blade.php`
- **Dashboard Enseignant** : `resources/views/teacher/dashboard.blade.php`
- **Dashboard Parent** : `resources/views/parent/dashboard.blade.php`

---

## 📦 Structure des fichiers modifiés

### 1. **Admin Dashboard** (`resources/views/admin/dashboard.blade.php`)
**Contenu intégré :**
- 5 cartes statistiques : Élèves, Enseignants, Classes, Matières, Inscriptions
- Graphique en barres (Chart.js) : Élèves par classe
- Derniers élèves ajoutés (activité récente)
- Liste des classes avec effectifs
- Boutons de raccourci rapide :
  - Ajouter un élève
  - Ajouter un enseignant
  - Inscrire un élève
  - Créer une classe

**Variables attendues du Controller :**
```php
$totalStudents       // Nombre total d'élèves
$totalTeachers       // Nombre total d'enseignants
$totalClasses        // Nombre de classes
$totalSubjects       // Nombre de matières
$totalEnrollments    // Nombre d'inscriptions
$recentStudents      // Collection de 5 derniers élèves (avec created_at)
$classes             // Collection des classes (avec enrollments)
$chartLabels         // Array de noms de classes pour le graphique
$chartData           // Array du nb d'élèves par classe
$currentYear         // Année scolaire actuelle
```

---

### 2. **Teacher Dashboard** (`resources/views/teacher/dashboard.blade.php`)
**Contenu intégré :**
- Bannière de bienvenue personnalisée
- 4 cartes statistiques : Mes classes, Mes élèves, Notes saisies, Absences
- Liste des classes assignées
- Emploi du temps de la semaine
- Boutons d'accès rapide :
  - Saisir une note
  - Faire l'appel
  - Voir toutes mes notes
  - Mon emploi du temps

**Variables attendues du Controller :**
```php
$teacher             // Objet Teacher connecté
$mesClasses          // Collection des classes de l'enseignant
$totalEleves         // Nombre total d'élèves de cet enseignant
$totalNotes          // Nombre de notes saisies
$totalAbsences       // Nombre d'absences enregistrées
$monEmploiDuTemps    // Array de horaires par jour
// $monEmploiDuTemps['Lundi'][] -> {start_time, end_time, subject, schoolClass}
```

---

### 3. **Parent Dashboard** (`resources/views/parent/dashboard.blade.php`)
**Contenu intégré :**
- Onglets pour sélectionner l'enfant
- 3 cartes statistiques : Classe, Moyenne générale, Absences
- Bulletin de notes (par trimestre)
- Emploi du temps de l'enfant
- Absences récentes
- Messages des enseignants
- Statut des paiements

**Variables attendues du Controller :**
```php
$mesEnfants          // Collection des enfants du parent
$enfantActuel        // Enfant actuellement sélectionné
$moyenneGenerale     // Moyenne générale (ex: 14.5)
$totalAbsences       // Nombre d'absences
$notesPar Trimestre  // Array des notes groupées par trimestre
$emploiDuTemps       // Array de horaires par jour
$absencesRecentes    // Collection des 5 dernières absences
$messagesRecents     // Collection des 5 derniers messages
$paiements           // Collection des paiements (avec status: paid/pending/overdue)
```

---

## 🎨 Styles intégrés

### Palette de couleurs (variables CSS)
```css
--bg: #0f1117              /* Fond principal */
--surface: #1a1d27         /* Fond des cartes */
--surface2: #22263a        /* Fond des inputs */
--border: rgba(255,255,255,0.07)  /* Bordures */
--text: #f0f0f5            /* Texte principal */
--muted: #7a7f9a           /* Texte secondaire */
--accent: #6c63ff          /* Violet principal */
--accent2: #00d4aa         /* Vert */
--accent3: #ff6b6b         /* Rouge */
```

### Classes CSS disponibles
- `.stat-card` : Cartes statistiques
- `.card` : Cartes génériques
- `.card-header` / `.card-body` : Sections de cartes
- `.stats-grid` : Grille de statistiques
- `.main-grid` : Grille principale
- `.section-grid` : Grille secondaire
- `.button-primary` : Boutons primaires

---

## 📁 Assets du thème

Les fichiers CSS, JS et images du thème ont été copiés vers :
```
public/css/theme/         ← Fichiers CSS
public/js/theme/          ← Fichiers JavaScript
public/images/theme/      ← Images et icônes
public/fonts/theme/       ← Polices personnalisées
```

### Dépendances externes requises
- **Chart.js** (v3.9.1) : Pour les graphiques en barres
- **Font Awesome** (v6.4.0) : Pour les icônes
- **Google Fonts** : DM Sans, DM Serif Display

---

## 🚀 Instructions pour l'utilisation

### 1. Créer les Controllers

Pour chaque dashboard, créez un controller qui retourne les variables nécessaires :

**AdminDashboardController.php**
```php
namespace App\Http\Controllers;

use App\Models\{Student, Teacher, Classes, Subject, Enrollment};
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $currentYear = SchoolYear::where('is_active', true)->first()?->year ?? date('Y');
        
        return view('admin.dashboard', [
            'totalStudents' => Student::count(),
            'totalTeachers' => Teacher::count(),
            'totalClasses' => Classes::count(),
            'totalSubjects' => Subject::count(),
            'totalEnrollments' => Enrollment::count(),
            'recentStudents' => Student::latest()->take(5)->get(),
            'classes' => Classes::with('enrollments')->get(),
            'chartLabels' => Classes::pluck('class_name')->toArray(),
            'chartData' => Classes::withCount('enrollments')->pluck('enrollments_count')->toArray(),
            'currentYear' => $currentYear,
        ]);
    }
}
```

**TeacherDashboardController.php**
```php
public function index()
{
    $teacher = auth()->user();
    
    return view('teacher.dashboard', [
        'teacher' => $teacher,
        'mesClasses' => $teacher->classes,  // Relation many-to-many
        'totalEleves' => $teacher->students->count(),
        'totalNotes' => Grade::where('teacher_id', $teacher->id)->count(),
        'totalAbsences' => Attendance::where('teacher_id', $teacher->id)->where('is_present', false)->count(),
        'monEmploiDuTemps' => $this->getScheduleByDay($teacher),
    ]);
}
```

**ParentDashboardController.php**
```php
public function index()
{
    $parent = auth()->user();
    $enfantActuel = $parent->students->first();
    
    if (request('child')) {
        $enfantActuel = $parent->students->find(request('child'));
    }
    
    return view('parent.dashboard', [
        'mesEnfants' => $parent->students,
        'enfantActuel' => $enfantActuel,
        'moyenneGenerale' => $this->getMoyenne($enfantActuel),
        'totalAbsences' => $enfantActuel->absences()->count(),
        'notesPar Trimestre' => $this->getNotesByTerm($enfantActuel),
        'emploiDuTemps' => $this->getScheduleByDay($enfantActuel),
        'absencesRecentes' => $enfantActuel->absences()->latest()->take(5)->get(),
        'messagesRecents' => $enfantActuel->messages()->latest()->take(5)->get(),
        'paiements' => Payment::where('student_id', $enfantActuel->id)->get(),
    ]);
}
```

### 2. Ajouter les routes

```php
// routes/web.php

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
});
```

### 3. Lancer l'application

```bash
php artisan serve
```

Accédez aux dashboards via :
- Admin : `http://localhost:8000/admin/dashboard`
- Enseignant : `http://localhost:8000/teacher/dashboard`
- Parent : `http://localhost:8000/parent/dashboard`

---

## 🔧 Personnalisation

### Modifier les couleurs
Éditez les variables CSS dans le bloc `@section('styles')` de chaque dashboard :

```css
--accent: #6c63ff;       /* Changer en votre couleur */
--accent2: #00d4aa;
--accent3: #ff6b6b;
```

### Ajouter de nouvelles cartes
Dupliquez la structure `.stat-card` et mettez à jour le contenu.

### Modifier les graphiques
Éditez l'objet `Chart` en bas de chaque page (options, type, couleurs, etc.)

---

## ✅ Checklist d'intégration

- [x] Intégration des styles Pluto
- [x] Adaptation pour 3 rôles différents
- [x] Copie des assets (CSS, JS, images)
- [x] Variables dynamiques supportées
- [x] Documentation complète
- [ ] Création des Controllers (à faire)
- [ ] Ajout des routes (à faire)
- [ ] Liaison des modèles pour les relations (à faire)
- [ ] Tests d'affichage (à faire)

---

## 📞 Support

Pour toute question sur l'intégration du thème, consultez :
- Documentation du thème Pluto : `public/theme/`
- Modèles EduGest : `app/Models/`
- Layout principal : `resources/views/layouts/`

---

**Date d'intégration :** 13 Mars 2026  
**Thème :** Pluto Responsive Admin Dashboard  
**Compatibilité :** Laravel 10+, PHP 8.1+
