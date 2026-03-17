<?php
/**
 * ═════════════════════════════════════════════════════════════════════
 * MODÈLES REQUIS POUR LES DASHBOARDS
 * 
 * Structure de relations attendues par les Controllers
 * À adapter selon votre schéma de base de données existant
 * ═════════════════════════════════════════════════════════════════════
 */

// ──────────────────────────────────────────────────────────────────────
// 1️⃣ USER MODEL (Modèle de base pour tous les utilisateurs)
// ──────────────────────────────────────────────────────────────────────

namespace App\Models;

class User extends Model
{
    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'phone',
        'first_name',
        'last_name'
    ];

    // ── Relations polymorphes ──
    // Un utilisateur peut être un Admin, un Enseignant ou un Parent
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Déterminer le rôle
    public function getRole()
    {
        if ($this->teacher_id) return 'teacher';
        if ($this->parent_id) return 'parent';
        if ($this->student_id) return 'student';
        return 'admin';  // Par défaut
    }
}

// ──────────────────────────────────────────────────────────────────────
// 2️⃣ TEACHER MODEL (Enseignant)
// ──────────────────────────────────────────────────────────────────────

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'hire_date',
        'qualification',
        'department'
    ];

    // ── Relation avec User ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Relation : Enseignant → Classes (plusieurs classes) ──
    public function classes()
    {
        return $this->hasMany(Schedule::class)
            ->distinct('class_id')
            ->with('schoolClass');
    }

    // ── Relation : Enseignant → Élèves (via classes) ──
    public function students()
    {
        return Student::whereHas('enrollments', function ($q) {
            $q->whereIn('class_id', $this->classes()->pluck('class_id'));
        });
    }

    // ── Relation : Enseignant → Horaires ──
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    // ── Relation : Enseignant → Notes ──
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // ── Relation : Enseignant → Absences (créées par l'enseignant) ──
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}

// ──────────────────────────────────────────────────────────────────────
// 3️⃣ STUDENT MODEL (Élève)
// ──────────────────────────────────────────────────────────────────────

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'registration_number',
        'gender',
        'address',
        'phone',
        'email',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ── Relation avec User ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Relation : Élève → Inscriptions (classe) ──
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // ── Relation : Élève → Notes ──
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // ── Relation : Élève → Absences ──
    public function absences()
    {
        return $this->hasMany(Attendance::class)
            ->where('is_present', false);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // ── Relation : Élève → Parents ──
    public function parents()
    {
        return $this->belongsToMany(Parents::class, 'parent_student');
    }

    // ── Relation : Élève → Paiements ──
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Accesseur pour la classe actuelle
    public function getCurrentClass()
    {
        return $this->enrollments()
            ->whereHas('schoolClass', function ($q) {
                // Optionnel : filtrer par année scolaire active
                $q->whereHas('schoolYear', function ($q2) {
                    $q2->where('is_active', true);
                });
            })
            ->first()?->schoolClass;
    }
}

// ──────────────────────────────────────────────────────────────────────
// 4️⃣ PARENTS MODEL (Parent/Tuteur)
// ──────────────────────────────────────────────────────────────────────

class Parents extends Model
{
    protected $table = 'parents';
    
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'occupation',
        'address'
    ];

    // ── Relation avec User ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Relation : Parent → Élèves (enfants) ──
    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student');
    }

    // ── Relation : Parent → Messages (reçus des enseignants) ──
    public function messages()
    {
        return $this->hasMany(Message::class, 'parent_id');
    }
}

// ──────────────────────────────────────────────────────────────────────
// 5️⃣ CLASSES MODEL (Classe scolaire)
// ──────────────────────────────────────────────────────────────────────

class Classes extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
        'level',
        'capacity',
        'school_year_id'
    ];

    // ── Relation : Classe → Year ──
    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }

    // ── Relation : Classe → Élèves (inscriptions) ──
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return Student::whereHas('enrollments', function ($q) {
            $q->where('class_id', $this->id);
        });
    }

    // ── Relation : Classe → Horaires ──
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}

// ──────────────────────────────────────────────────────────────────────
// 6️⃣ ENROLLMENT MODEL (Inscription - Lien Élève/Classe)
// ──────────────────────────────────────────────────────────────────────

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'school_year_id',
        'enrollment_date',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}

// ──────────────────────────────────────────────────────────────────────
// 7️⃣ SCHEDULE MODEL (Emploi du temps)
// ──────────────────────────────────────────────────────────────────────

class Schedule extends Model
{
    protected $fillable = [
        'teacher_id',
        'class_id',
        'subject_id',
        'day_of_week',      // 'Lundi', 'Mardi', etc.
        'start_time',       // 'HH:MM:SS'
        'end_time',         // 'HH:MM:SS'
        'room_number'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}

// ──────────────────────────────────────────────────────────────────────
// 8️⃣ GRADE MODEL (Notes)
// ──────────────────────────────────────────────────────────────────────

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'class_id',
        'value',            // Note (0-20)
        'term',             // 'T1', 'T2', 'T3'
        'school_year_id',
        'grading_date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}

// ──────────────────────────────────────────────────────────────────────
// 9️⃣ ATTENDANCE MODEL (Absences/Présences)
// ──────────────────────────────────────────────────────────────────────

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'class_id',
        'attendance_date',
        'is_present',
        'reason',           // Motif d'absence si applicable
        'created_by'        // ID de l'enseignant qui a marqué l'absence
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'is_present' => 'boolean'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}

// ──────────────────────────────────────────────────────────────────────
// 🔟 PAYMENT MODEL (Paiements)
// ──────────────────────────────────────────────────────────────────────

class Payment extends Model
{
    protected $fillable = [
        'student_id',
        'label',            // Description du paiement
        'amount',           // Montant
        'status',           // 'paid', 'pending', 'overdue'
        'due_date',
        'payment_date',
        'school_year_id'
    ];

    protected $casts = [
        'due_date' => 'date',
        'payment_date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}

// ──────────────────────────────────────────────────────────────────────
// 🔸 SUBJECT MODEL (Matières)
// ──────────────────────────────────────────────────────────────────────

class Subject extends Model
{
    protected $fillable = [
        'subject_name',
        'code',
        'description'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}

// ──────────────────────────────────────────────────────────────────────
// 🔹 SCHOOLYEAR MODEL (Année scolaire)
// ──────────────────────────────────────────────────────────────────────

class SchoolYear extends Model
{
    protected $table = 'school_years';

    protected $fillable = [
        'year',             // ex: '2025-2026'
        'start_date',
        'end_date',
        'is_active'         // true si année en cours
    ];

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}

// ──────────────────────────────────────────────────────────────────────
// 🔸 MESSAGE MODEL (Messagerie Parent/Enseignant) — OPTIONNEL
// ──────────────────────────────────────────────────────────────────────

class Message extends Model
{
    protected $fillable = [
        'teacher_id',
        'parent_id',
        'student_id',
        'subject',
        'content',
        'read_at'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function parent()
    {
        return $this->belongsTo(Parents::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

// ──────────────────────────────────────────────────────────────────────
// CHECKLIST DE VÉRIFICATION
// ──────────────────────────────────────────────────────────────────────

/*
✓ User a les relations : teacher(), parent(), student()
✓ Teacher a les relations : classes(), schedules(), grades(), attendances()
✓ Student a les relations : enrollments(), grades(), absences(), parents(), payments()
✓ Parents a la relation : students()
✓ Classes a les relations : enrollments(), schedules()
✓ Enrollment lie Student et Classes
✓ Schedule lie Teacher, Class et Subject
✓ Grade lie Student, Subject et Teacher
✓ Attendance lie Student, Teacher et Class
✓ Payment lie Student et SchoolYear
✓ Subject contient les libellés de matières
✓ SchoolYear marque l'année scolaire active (is_active)

Si une relation manque, les dashboards afficheront des erreurs!
*/
