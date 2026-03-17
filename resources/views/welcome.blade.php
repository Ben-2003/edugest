<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EduGest — Gestion Scolaire</title>
  <meta name="description" content="EduGest - Système de gestion scolaire pour école primaire">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Poppins:wght@300;400;500;600;700&family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- AOS Animation -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <style>
    :root {
      --color-default: #212529;
      --color-primary: #e82d2d; /* rouge école */
      --color-secondary: #f5a623;
      --color-bg: #f8f9fa;
    }

    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Open Sans', sans-serif; color:var(--color-default); }

    /* ── HEADER ── */
    .header { background:#fff; box-shadow:0 2px 20px rgba(0,0,0,0.08); padding:15px 0; position:sticky; top:0; z-index:100; }
    .header .logo h1 { font-size:26px; font-weight:700; color:var(--color-primary); font-family:'Poppins',sans-serif; margin:0; }
    .header .logo span { color:#333; }
    .navmenu ul { list-style:none; display:flex; align-items:center; gap:32px; margin:0; padding:0; }
    .navmenu a { text-decoration:none; color:#333; font-size:15px; font-weight:500; font-family:'Poppins',sans-serif; transition:color 0.2s; }
    .navmenu a:hover, .navmenu a.active { color:var(--color-primary); }
    .btn-getstarted { background:var(--color-primary); color:white !important; padding:10px 24px; border-radius:6px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; font-family:'Poppins',sans-serif; }
    .btn-getstarted:hover { background:#c42424; transform:translateY(-1px); }

    /* ── HERO ── */
    .hero { background:linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height:100vh; display:flex; align-items:center; position:relative; overflow:hidden; }
    .hero::before { content:''; position:absolute; inset:0; background:url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1920&q=80') center/cover; opacity:0.15; }
    .hero .container { position:relative; z-index:1; }
    .hero h2 { font-size:52px; font-weight:700; color:white; line-height:1.2; font-family:'Poppins',sans-serif; }
    .hero h2 span { color:var(--color-secondary); }
    .hero p { font-size:18px; color:rgba(255,255,255,0.8); margin:20px 0 32px; max-width:560px; }
    .btn-hero-primary { background:var(--color-primary); color:white; padding:14px 32px; border-radius:8px; font-size:16px; font-weight:600; text-decoration:none; transition:all 0.2s; display:inline-flex; align-items:center; gap:8px; }
    .btn-hero-primary:hover { background:#c42424; color:white; transform:translateY(-2px); box-shadow:0 8px 24px rgba(232,45,45,0.4); }
    .btn-hero-secondary { background:rgba(255,255,255,0.1); color:white; border:2px solid rgba(255,255,255,0.3); padding:14px 32px; border-radius:8px; font-size:16px; font-weight:600; text-decoration:none; transition:all 0.2s; display:inline-flex; align-items:center; gap:8px; backdrop-filter:blur(10px); }
    .btn-hero-secondary:hover { background:rgba(255,255,255,0.2); color:white; }

    /* Hero cards flottantes */
    .hero-stats { display:flex; gap:20px; margin-top:48px; flex-wrap:wrap; }
    .hero-stat { background:rgba(255,255,255,0.1); backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,0.2); border-radius:12px; padding:16px 24px; text-align:center; color:white; }
    .hero-stat .number { font-size:28px; font-weight:700; color:var(--color-secondary); }
    .hero-stat .label { font-size:12px; opacity:0.8; margin-top:4px; }

    /* ── COUNTS ── */
    .counts { background:#f8f9fa; padding:60px 0; }
    .stats-item { background:white; border-radius:12px; padding:30px 20px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.06); }
    .stats-item span { font-size:48px; font-weight:700; color:var(--color-primary); display:block; font-family:'Poppins',sans-serif; }
    .stats-item p { font-size:14px; color:#666; margin:8px 0 0; font-weight:500; }

    /* ── ABOUT ── */
    .about { padding:80px 0; }
    .about .content h3 { font-size:32px; font-weight:700; color:#1a1a2e; font-family:'Poppins',sans-serif; margin-bottom:16px; }
    .about .content p { color:#666; line-height:1.8; }
    .about .content ul { list-style:none; padding:0; margin:20px 0; }
    .about .content ul li { display:flex; align-items:flex-start; gap:10px; margin-bottom:12px; color:#555; font-size:15px; }
    .about .content ul li i { color:var(--color-primary); font-size:18px; flex-shrink:0; margin-top:2px; }
    .about img { border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,0.12); }

    /* ── FEATURES ── */
    .features { background:#f8f9fa; padding:80px 0; }
    .section-title { text-align:center; margin-bottom:48px; }
    .section-title h2 { font-size:36px; font-weight:700; color:#1a1a2e; font-family:'Poppins',sans-serif; }
    .section-title p { color:#666; font-size:16px; margin-top:12px; }
    .feature-card { background:white; border-radius:16px; padding:32px 24px; text-align:center; box-shadow:0 4px 20px rgba(0,0,0,0.06); height:100%; transition:all 0.3s; }
    .feature-card:hover { transform:translateY(-8px); box-shadow:0 16px 40px rgba(0,0,0,0.12); }
    .feature-icon { width:64px; height:64px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:28px; margin:0 auto 20px; }
    .feature-icon.red    { background:rgba(232,45,45,0.1); color:var(--color-primary); }
    .feature-icon.blue   { background:rgba(59,130,246,0.1); color:#3b82f6; }
    .feature-icon.green  { background:rgba(16,185,129,0.1); color:#10b981; }
    .feature-icon.orange { background:rgba(245,158,11,0.1); color:#f59e0b; }
    .feature-icon.purple { background:rgba(139,92,246,0.1); color:#8b5cf6; }
    .feature-icon.pink   { background:rgba(236,72,153,0.1); color:#ec4899; }
    .feature-card h4 { font-size:18px; font-weight:600; color:#1a1a2e; margin-bottom:12px; font-family:'Poppins',sans-serif; }
    .feature-card p { color:#666; font-size:14px; line-height:1.7; }

    /* ── ROLES ── */
    .roles { padding:80px 0; }
    .role-card { border-radius:16px; padding:40px 32px; color:white; position:relative; overflow:hidden; }
    .role-card.admin   { background:linear-gradient(135deg,#6c63ff,#5a52d5); }
    .role-card.teacher { background:linear-gradient(135deg,#10b981,#059669); }
    .role-card.parent  { background:linear-gradient(135deg,#3b82f6,#2563eb); }
    .role-card h3 { font-size:24px; font-weight:700; font-family:'Poppins',sans-serif; margin-bottom:12px; }
    .role-card p { opacity:0.85; font-size:14px; line-height:1.7; margin-bottom:20px; }
    .role-card ul { list-style:none; padding:0; }
    .role-card ul li { display:flex; align-items:center; gap:8px; font-size:14px; margin-bottom:8px; opacity:0.9; }
    .role-card ul li i { font-size:16px; }
    .role-card .btn-role { display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.2); color:white; border:1px solid rgba(255,255,255,0.3); padding:10px 20px; border-radius:8px; font-size:14px; font-weight:600; text-decoration:none; transition:all 0.2s; margin-top:20px; backdrop-filter:blur(10px); }
    .role-card .btn-role:hover { background:rgba(255,255,255,0.3); color:white; }

    /* ── CTA ── */
    .cta { background:linear-gradient(135deg,#1a1a2e,#0f3460); padding:80px 0; text-align:center; }
    .cta h2 { font-size:40px; font-weight:700; color:white; font-family:'Poppins',sans-serif; margin-bottom:16px; }
    .cta p { color:rgba(255,255,255,0.8); font-size:18px; margin-bottom:32px; }

    /* ── FOOTER ── */
    .footer { background:#1a1a2e; padding:40px 0; text-align:center; }
    .footer p { color:rgba(255,255,255,0.5); font-size:14px; margin:0; }
    .footer span { color:var(--color-primary); }

    /* ── Mobile ── */
    @media(max-width:768px) {
      .hero h2 { font-size:32px; }
      .navmenu { display:none; }
      .hero-stats { gap:12px; }
    }
  </style>
</head>

<body>

  <!-- ══ HEADER ══ -->
  <header class="header">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="/" class="logo d-flex align-items-center gap-2 text-decoration-none">
        <i class="bi bi-mortarboard-fill" style="font-size:28px; color:#e82d2d;"></i>
        <h1>Edu<span>Gest</span></h1>
      </a>

      <nav class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Accueil</a></li>
          <li><a href="#about">À propos</a></li>
          <li><a href="#features">Fonctionnalités</a></li>
          <li><a href="#roles">Espaces</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>

      <a href="{{ route('login') }}" class="btn-getstarted">
        <i class="bi bi-box-arrow-in-right"></i> Se connecter
      </a>
    </div>
  </header>

  <!-- ══ HERO ══ -->
  <section id="hero" class="hero">
    <div class="container">
      <div class="row align-items-center" style="min-height:90vh;">
        <div class="col-lg-7">
          <h2 data-aos="fade-up" data-aos-delay="100">
            Gérez votre école<br><span>simplement et efficacement</span>
          </h2>
          <p data-aos="fade-up" data-aos-delay="200">
            EduGest est une plateforme complète de gestion scolaire pour les écoles primaires. 
            Élèves, enseignants, notes, absences et paiements — tout en un seul endroit.
          </p>
          <div class="d-flex gap-3 flex-wrap" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('login') }}" class="btn-hero-primary">
              <i class="bi bi-box-arrow-in-right"></i> Accéder à la plateforme
            </a>
            <a href="#about" class="btn-hero-secondary">
              <i class="bi bi-info-circle"></i> En savoir plus
            </a>
          </div>

          <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
            <div class="hero-stat">
              <div class="number">3</div>
              <div class="label">Espaces dédiés</div>
            </div>
            <div class="hero-stat">
              <div class="number">11</div>
              <div class="label">Modules de gestion</div>
            </div>
            <div class="hero-stat">
              <div class="number">100%</div>
              <div class="label">Sécurisé</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ STATS ══ -->
  <section class="counts">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="stats-item">
            <span>{{ \App\Models\Student::count() }}</span>
            <p><i class="bi bi-people"></i> Élèves inscrits</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="stats-item">
            <span>{{ \App\Models\Teacher::count() }}</span>
            <p><i class="bi bi-person-badge"></i> Enseignants</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="stats-item">
            <span>{{ \App\Models\Classes::count() }}</span>
            <p><i class="bi bi-door-open"></i> Classes</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="stats-item">
            <span>{{ \App\Models\Subject::count() }}</span>
            <p><i class="bi bi-book"></i> Matières</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ ABOUT ══ -->
  <section id="about" class="about">
    <div class="container">
      <div class="row gy-4 align-items-center">
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&q=80"
               class="img-fluid" alt="École primaire" style="border-radius:16px;">
        </div>
        <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="200">
          <h3>Une gestion scolaire moderne et centralisée</h3>
          <p class="fst-italic" style="color:#888; margin-bottom:20px;">
            EduGest simplifie le quotidien des administrations, enseignants et parents d'élèves.
          </p>
          <ul>
            <li>
              <i class="bi bi-check-circle-fill"></i>
              <span>Suivi en temps réel des notes et des absences de chaque élève.</span>
            </li>
            <li>
              <i class="bi bi-check-circle-fill"></i>
              <span>Gestion complète des paiements et bulletins scolaires.</span>
            </li>
            <li>
              <i class="bi bi-check-circle-fill"></i>
              <span>Accès sécurisé pour chaque rôle — admin, enseignant et parent.</span>
            </li>
            <li>
              <i class="bi bi-check-circle-fill"></i>
              <span>Interface moderne, rapide et facile à prendre en main.</span>
            </li>
          </ul>
          <a href="{{ route('login') }}" class="btn-hero-primary d-inline-flex mt-3">
            <i class="bi bi-box-arrow-in-right"></i> Commencer maintenant
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ FEATURES ══ -->
  <section id="features" class="features">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Tout ce dont vous avez besoin</h2>
        <p>Une suite complète d'outils pour gérer votre école au quotidien</p>
      </div>
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-card">
            <div class="feature-icon red"><i class="bi bi-people-fill"></i></div>
            <h4>Gestion des élèves</h4>
            <p>Enregistrez et suivez tous vos élèves avec leurs informations complètes et leur historique scolaire.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
          <div class="feature-card">
            <div class="feature-icon blue"><i class="bi bi-star-fill"></i></div>
            <h4>Notes & Bulletins</h4>
            <p>Saisie des notes par trimestre, calcul automatique des moyennes et génération de bulletins.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-card">
            <div class="feature-icon green"><i class="bi bi-calendar-check-fill"></i></div>
            <h4>Suivi des absences</h4>
            <p>Appel quotidien, suivi des présences et absences avec historique détaillé par élève.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
          <div class="feature-card">
            <div class="feature-icon orange"><i class="bi bi-cash-stack"></i></div>
            <h4>Paiements scolaires</h4>
            <p>Suivi des paiements de scolarité avec statuts et statistiques financières en temps réel.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-card">
            <div class="feature-icon purple"><i class="bi bi-clock-fill"></i></div>
            <h4>Emploi du temps</h4>
            <p>Planification et visualisation des créneaux horaires par classe et par enseignant.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="350">
          <div class="feature-card">
            <div class="feature-icon pink"><i class="bi bi-shield-lock-fill"></i></div>
            <h4>Accès sécurisé</h4>
            <p>Trois espaces distincts et sécurisés — Admin, Enseignant et Parent — avec authentification.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ══ ROLES ══ -->
  <section id="roles" class="roles">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Trois espaces dédiés</h2>
        <p>Chaque utilisateur accède à son espace personnalisé selon son rôle</p>
      </div>
      <div class="row gy-4">

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="role-card admin">
            <i class="bi bi-shield-fill" style="font-size:40px; opacity:0.3; position:absolute; top:20px; right:20px;"></i>
            <h3><i class="bi bi-gear-fill"></i> Administrateur</h3>
            <p>Contrôle total de la plateforme et supervision de tous les modules.</p>
            <ul>
              <li><i class="bi bi-check-circle-fill"></i> Gestion des élèves et enseignants</li>
              <li><i class="bi bi-check-circle-fill"></i> Suivi des paiements</li>
              <li><i class="bi bi-check-circle-fill"></i> Configuration des classes</li>
              <li><i class="bi bi-check-circle-fill"></i> Bulletins et rapports</li>
            </ul>
            <a href="{{ route('login') }}" class="btn-role">
              <i class="bi bi-box-arrow-in-right"></i> Espace Admin
            </a>
          </div>
        </div>

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
          <div class="role-card teacher">
            <i class="bi bi-person-fill" style="font-size:40px; opacity:0.3; position:absolute; top:20px; right:20px;"></i>
            <h3><i class="bi bi-person-badge-fill"></i> Enseignant</h3>
            <p>Saisie des notes et gestion des absences pour ses classes assignées.</p>
            <ul>
              <li><i class="bi bi-check-circle-fill"></i> Saisie des notes par trimestre</li>
              <li><i class="bi bi-check-circle-fill"></i> Appel et suivi des absences</li>
              <li><i class="bi bi-check-circle-fill"></i> Consulter son emploi du temps</li>
              <li><i class="bi bi-check-circle-fill"></i> Tableau de bord personnalisé</li>
            </ul>
            <a href="{{ route('login') }}" class="btn-role">
              <i class="bi bi-box-arrow-in-right"></i> Espace Enseignant
            </a>
          </div>
        </div>

        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
          <div class="role-card parent">
            <i class="bi bi-house-fill" style="font-size:40px; opacity:0.3; position:absolute; top:20px; right:20px;"></i>
            <h3><i class="bi bi-people-fill"></i> Parent</h3>
            <p>Consultation en temps réel des résultats et du suivi de son enfant.</p>
            <ul>
              <li><i class="bi bi-check-circle-fill"></i> Notes et moyennes de l'enfant</li>
              <li><i class="bi bi-check-circle-fill"></i> Suivi des absences</li>
              <li><i class="bi bi-check-circle-fill"></i> Bulletins scolaires</li>
              <li><i class="bi bi-check-circle-fill"></i> Plusieurs enfants supportés</li>
            </ul>
            <a href="{{ route('login') }}" class="btn-role">
              <i class="bi bi-box-arrow-in-right"></i> Espace Parent
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ══ CTA ══ -->
  <section class="cta" id="contact">
    <div class="container" data-aos="fade-up">
      <h2>Prêt à moderniser votre école ?</h2>
      <p>Connectez-vous dès maintenant et découvrez toutes les fonctionnalités d'EduGest.</p>
      <a href="{{ route('login') }}" class="btn-hero-primary" style="font-size:18px; padding:16px 40px;">
        <i class="bi bi-box-arrow-in-right"></i> Se connecter à EduGest
      </a>
    </div>
  </section>

  <!-- ══ FOOTER ══ -->
  <footer class="footer">
    <div class="container">
      <p>© {{ date('Y') }} <span>EduGest</span> — Système de gestion scolaire. Tous droits réservés.</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- AOS Animation -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 600, easing: 'ease-in-out', once: true });

    /* Smooth scroll pour les liens d'ancre */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth' });
      });
    });
  </script>

</body>
</html>